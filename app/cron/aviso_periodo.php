<?php
	date_default_timezone_set('America/Sao_Paulo');
	
	include_once('../autoload.php');

	$aviso_periodo = New AvisoPeriodo();
	
	$rs_aviso_periodo = $aviso_periodo->verificaPeriodo();

	//verifica se tem produtos cadastrados ou/e vencidos no periodo configurado
	if(count($rs_aviso_periodo))
	{	
		//verifica se deu algum erro
		if (@array_key_exists('usuarios', $rs_aviso_periodo))
		{
			//echo '<pre>';
			//print_r($rs_aviso_periodo);
			//exit;

			foreach ($rs_aviso_periodo['usuarios'] as $cod_usuario => $produtos)
			{
				//verifica configuracao de envio de sms e email
				$usuario_config_dao = New UsuarioConfigDAO();
				$rs_usuario_config = $usuario_config_dao->selectUsuarioConfig($cod_usuario);

				if(count($produtos['produtos']['cadastrados']) != 0 || count($produtos['produtos']['vencidos']) != 0)
				{
					if($rs_usuario_config['receber_aviso_periodo'])
					{
						//verifica se historico ja existe
						$aviso_historico_dao = New AvisoHistoricoDAO();
						$rs_aviso_historico = $aviso_historico_dao->verificaHistoricoExiste($cod_usuario, 2, date('d/m/Y'));

						$aviso_periodico_dao = New AvisoPeriodicoDAO();	
						$rs_aviso_periodico = $aviso_periodico_dao->selectAvisoPeriodico($cod_usuario);

						if($rs_aviso_historico == 0)
						{
							$email_qtd = 0;
							$sms_qtd = 0;
							$relatorio = json_encode(array('produtos' => $produtos['produtos']));

							$aviso_historico = New AvisoHistorico();
							$aviso_historico->setUsuario($cod_usuario);
							$aviso_historico->setTipoAviso(2);
							$aviso_historico->setData(date('d/m/Y'));
							$aviso_historico->setAvisoEmail($email_qtd);
							$aviso_historico->setAvisoSMS($sms_qtd);
							$aviso_historico->setRelatorio($relatorio);

							$rs_aviso_historico = $aviso_historico_dao->insertAvisoHistorico($aviso_historico);

							$resul_json = json_decode($rs_aviso_historico);

							//verifica se deu algum erro
							if (array_key_exists('id', $resul_json))
							{	
								$id_aviso_historico = $resul_json->id;
								$url_hash = $aviso_historico_dao->selectURLHash($id_aviso_historico, $cod_usuario);

								if($rs_usuario_config['receber_email_periodo'])
								{
									$usuario_email_dao = new UsuarioEmailDAO();
									$rs_usuario_email = $usuario_email_dao->selectUsuarioEmail($cod_usuario);
									
									if(count($rs_usuario_email))
									{						
										foreach ($rs_usuario_email as $valor)
										{
											$assunto = 'Aviso Periodico - Valix';
											
											$corpo = '
												<center>
													Clique no link para visualizar o relatório:
													<br /><br />
													<a href="http://valix.com.br/app/listar/relatorio_periodo.php?hs='.$url_hash.'" target="_blank" class="botao">
														Visualizar Relatório
													</a><br /><br />
													<span style="font-size:10px;">Gerado em: '.date('d/m/Y').'</span>
												</center>
											';
											
											$envio = Mailer::send_mail($assunto, $corpo, @$valor['email'], "Cliente");
											
											if($envio)
											{
												//echo 'Email Enviado: '.@$valor['email'];
												$email_qtd++;
											}
											else
											{
												$msg_json = '{"codigo": "22.5.1", "mensagem": "Email nao enviado", "email": "'. @$valor['email'] .'"}';
												
												Funcao::gravarLog($cod_usuario, $msg_json, __FILE__, __LINE__, 'erros');
												
												//echo 'Email nao enviado: '.@$valor['email'].'<br />';
											}
							
											//echo '<br />';
										}

										$aviso_historico->setAvisoEmail($email_qtd);
									}
								}

								if($rs_usuario_config['receber_sms_periodo'])
								{						
									$usuario_telefone_dao = new UsuarioTelefoneDAO();
									$rs_usuario_telefone = $usuario_telefone_dao->selectUsuarioTelefone($cod_usuario);
									
									if(count($rs_usuario_telefone))
									{							
										foreach ($rs_usuario_telefone as $valor)
										{
											//dispara envios
											//echo 'SMS ';
											//echo $url_hash;
											//echo '<br>';

											//$msg_json = '{"codigo": "22.5.2", "mensagem": "SMS nao enviado", "telefone": "'. @$valor['telefone'] .'"}';
										
											//Funcao::gravarLog($cod_usuario, $msg_json, __FILE__, __LINE__, 'erros');
							
											//echo $msg_json.'<br />';							

											$sms_qtd++;
										}

										$aviso_historico->setAvisoSMS($sms_qtd);
									}
								}

								$aviso_historico->setCodigo($id_aviso_historico);
						
								//update
								$rs_aviso_historico = $aviso_historico_dao->updateAvisoHistorico($aviso_historico);
								$resul_json = json_decode($rs_aviso_historico);

								//verifica se deu algum erro
								if (array_key_exists('id', $resul_json))
								{						
									//calcula tempo de aviso de periodico
									switch ($rs_usuario_config['tipo_aviso_periodo']) {
										case 1:
											//dia
											$tipo = ' day';
											break;
										case 2:
											//mes
											$tipo = ' month';
											break;
										case 3:
											//ano
										   $tipo = ' year';
											break;
									}
									
									$data_aviso_ultimo = $rs_aviso_periodico['data_aviso_proximo'];
									
									$data_qtd_periodo = "+".$rs_usuario_config['aviso_periodo'].$tipo;
									
									$data_aviso_proximo = date('Y-m-d', strtotime($data_qtd_periodo, strtotime($data_aviso_ultimo)));
									
									$aviso_periodico = New AvisoPeriodico();
				
									$aviso_periodico->setUsuario($cod_usuario);
									$aviso_periodico->setDataAvisoUltimo($data_aviso_ultimo);
									$aviso_periodico->setDataAvisoProximo($data_aviso_proximo);
					
									$rs_aviso_periodico = $aviso_periodico_dao->updateAvisoPeriodico($aviso_periodico);
									
									$resul_json = json_decode($rs_aviso_periodico);

									//verifica se deu algum erro
									if (array_key_exists('id', $resul_json))
									{									
										$msg_json = '{"codigo": "22.1.0", "mensagem": "Enviado com sucesso"}';
									
										Funcao::gravarLog($cod_usuario, $msg_json, __FILE__, '', 'envios');
										
										echo $msg_json.'<br />';
									}
									else
									{	
										Funcao::gravarLog($cod_usuario, $rs_aviso_periodico, __FILE__, __LINE__, 'erros');
										
										echo $rs_aviso_periodico.'<br />';
									}												
								}
								else
								{	
									Funcao::gravarLog($cod_usuario, $rs_aviso_historico, __FILE__, __LINE__, 'erros');
									
									echo $rs_aviso_historico.'<br />';
								}
							}
							else
							{
								Funcao::gravarLog($cod_usuario, $rs_aviso_historico, __FILE__, __LINE__, 'erros');
								
								echo $rs_aviso_historico.'<br />';
							}
						}
						else if (is_numeric($rs_aviso_historico))
						{
							echo "Nao ha relatorios novos para este usuario ($cod_usuario) <br/>";
						}
						else
						{
							Funcao::gravarLog($cod_usuario, $rs_aviso_historico, __FILE__, __LINE__, 'erros');
							
							echo $rs_aviso_historico.'<br />';
						}
					}	
				}
				elseif ($rs_usuario_config['receber_aviso_periodo'])
				{
					$aviso_periodico_dao = New AvisoPeriodicoDAO();	
					$rs_aviso_periodico = $aviso_periodico_dao->selectAvisoPeriodico($cod_usuario);

					//calcula data em dias
					$data_inicial = new DateTime($rs_aviso_periodico['data_aviso_ultimo']);
					$data_final = new DateTime($rs_aviso_periodico['data_aviso_proximo']);

					$intervalo = $data_inicial->diff($data_final);

					$dias = $intervalo->days;

					if($rs_usuario_config['receber_email_periodo'])
					{
						$usuario_email_dao = new UsuarioEmailDAO();
						$rs_usuario_email = $usuario_email_dao->selectUsuarioEmail($cod_usuario);
						
						if(count($rs_usuario_email))
						{						
							foreach ($rs_usuario_email as $valor)
							{
								$assunto = 'Aviso Periodico - Valix';
								
								$corpo = '
									<center>
										Não houve nenhuma alteração no período de '.$dias.' dias.
										<br /><br />
										<span style="font-size:10px;">Gerado em: '.date('d/m/Y').'</span>
									</center>
								';
								
								$envio = Mailer::send_mail($assunto, $corpo, @$valor['email'], "Cliente");
								
								if(!$envio)
								{
									$msg_json = '{"codigo": "22.5.1", "mensagem": "Email nao enviado", "email": "'. @$valor['email'] .'"}';
									
									Funcao::gravarLog($cod_usuario, $msg_json, __FILE__, __LINE__, 'erros');
									
									//echo 'Email nao enviado: '.@$valor['email'].'<br />';
								}
							}
						}
					}

					if($rs_usuario_config['receber_sms_periodo'])
					{						
						$usuario_telefone_dao = new UsuarioTelefoneDAO();
						$rs_usuario_telefone = $usuario_telefone_dao->selectUsuarioTelefone($cod_usuario);
						
						if(count($rs_usuario_telefone))
						{							
							foreach ($rs_usuario_telefone as $valor)
							{
								//dispara envios
								//echo 'SMS ';
								//echo $url_hash;
								//echo '<br>';

								//$msg_json = '{"codigo": "22.5.2", "mensagem": "SMS nao enviado", "telefone": "'. @$valor['telefone'] .'"}';
										
								//Funcao::gravarLog($cod_usuario, $msg_json, __FILE__, __LINE__, 'erros');
							
								//echo $msg_json.'<br />';			

							}
						}
					}

					//calcula tempo de aviso de periodico
					switch ($rs_usuario_config['tipo_aviso_periodo']) {
						case 1:
							//dia
							$tipo = ' day';
							break;
						case 2:
							//mes
							$tipo = ' month';
							break;
						case 3:
							//ano
						   $tipo = ' year';
							break;
					}
					
					$data_aviso_ultimo = $rs_aviso_periodico['data_aviso_proximo'];
					
					$data_qtd_periodo = "+".$rs_usuario_config['aviso_periodo'].$tipo;
					
					$data_aviso_proximo = date('Y-m-d', strtotime($data_qtd_periodo, strtotime($data_aviso_ultimo)));
					
					$aviso_periodico = New AvisoPeriodico();

					$aviso_periodico->setUsuario($cod_usuario);
					$aviso_periodico->setDataAvisoUltimo($data_aviso_ultimo);
					$aviso_periodico->setDataAvisoProximo($data_aviso_proximo);
	
					$rs_aviso_periodico = $aviso_periodico_dao->updateAvisoPeriodico($aviso_periodico);
					
					$resul_json = json_decode($rs_aviso_periodico);

					//verifica se deu algum erro
					if (array_key_exists('id', $resul_json))
					{
						$msg_json = '{"codigo": "22.1.0", "mensagem": "Enviado com sucesso"}';
					
						Funcao::gravarLog($cod_usuario, $msg_json, __FILE__, '', 'envios');
						
						echo $msg_json.'<br />';		
						
					}
					else
					{
						Funcao::gravarLog($cod_usuario, $rs_aviso_periodico, __FILE__, __LINE__, 'erros');
						
						echo $rs_aviso_periodico.'<br />';
					}
				}
			}
		}
		else
		{
			Funcao::gravarLog($cod_usuario, $rs_aviso_periodo, __FILE__, __LINE__, 'erros');
			
			echo $rs_aviso_periodo;
		}
	}
	else
	{
		echo "Nao ha relatorios novos!";
	}
?>