<?php 
	header('Content-Type: application/json');
	
	date_default_timezone_set('America/Sao_Paulo');
	
	include_once('../autoload.php');
	
	Login::verificarLogado();
	
	if ($_POST){
		
		//verifica se existe configuração
		$usuario_config_dao = New UsuarioConfigDAO();
		
		$rs_usr_conf = $usuario_config_dao->selectUsuarioConfig(Login::codigoUsuario());
		
		//verifica se deu algum erro
		if (@array_key_exists('usuario', $rs_usr_conf)){
			
			//configuraçao avisos
			$usuario_config = New UsuarioConfig();
			
			$usuario_config->setAvisoValidade($_POST['aviso_validade']);
			$usuario_config->setAvisoVencido($_POST['aviso_vencido']);
			$usuario_config->setAvisoPeriodo($_POST['aviso_periodo']);
			$usuario_config->setTipoAvisoValidade($_POST['validade_alerta']);
			$usuario_config->setTipoAvisoVencido($_POST['vencido_alerta']);
			$usuario_config->setTipoAvisoPeriodo($_POST['relatorio_alerta']);
			$usuario_config->setReceberSmsPeriodo($_POST['sms_relatorio']);
			$usuario_config->setReceberEmailPeriodo($_POST['email_relatorio']);
			$usuario_config->setReceberSmsValidade($_POST['sms_aviso']);
			$usuario_config->setReceberEmailValidade($_POST['email_aviso']);
			$usuario_config->setReceberAvisoPeriodo(@$_POST['receber_aviso_periodo'] ? 1 : 0);
			$usuario_config->setUsuario(Login::codigoUsuario());
		
			$resultado = $usuario_config_dao->updateUsuarioConfig($usuario_config);

			$resul_json = json_decode($resultado);

			//verifica se deu algum erro
			if (array_key_exists('id', $resul_json)){
				
				//pega emails e telefones
				$emails = array();
				$celulares = array();
				
				for($i = 0; $i <= 4; $i++){
					
					if (isset($_POST['celulares'.$i])){
						$celulares[] =  $_POST['celulares'.$i];
					}
					
					if (isset($_POST['emails'.$i])){
						$emails[] =  $_POST['emails'.$i];
					}
					
				}
				
				//email
				$usuario_email = New UsuarioEmail();
				
				$usuario_email->setEmail($emails);
				$usuario_email->setUsuario(Login::codigoUsuario());
				
				$usuario_email_dao = New UsuarioEmailDAO();
				
				//deleta todos os emails
				$usuario_email_dao->deleteUsuarioEmail(Login::codigoUsuario());
				
				//insere os emails
				$resultado = $usuario_email_dao->insertUsuarioEmail($usuario_email);
				
				$resul_json = json_decode($resultado);

				//verifica se deu algum erro
				if (array_key_exists('id', $resul_json)){

					//telefone
					$usuario_telefone = New UsuarioTelefone();
					
					$usuario_telefone->setTelefone($celulares);
					$usuario_telefone->setUsuario(Login::codigoUsuario());
					
					$usuario_telefone_dao = New UsuarioTelefoneDAO();
					
					//deleta todos os telefones
					$usuario_telefone_dao->deleteUsuarioTelefone(Login::codigoUsuario());
					
					//insere os telefones
					$resultado = $usuario_telefone_dao->insertUsuarioTelefone($usuario_telefone);
					
					$resul_json = json_decode($resultado);
					
					//verifica se deu algum erro
					if (array_key_exists('id', $resul_json)){
						
						$campo_relatorio = new CampoRelConfig();
						
						//configura campos que vão aparecer no relatorio de validade
						$campo_relatorio->setUsuario(Login::codigoUsuario());
						$campo_relatorio->setCMarca(@$_POST['c_marca'] ? 1 : 0);
						$campo_relatorio->setCCategoria(@$_POST['c_categoria'] ? 1 : 0);
						$campo_relatorio->setCSubcategoria(@$_POST['c_subcategoria'] ? 1 : 0);
						$campo_relatorio->setCStatus(@$_POST['c_status'] ? 1 : 0);
						$campo_relatorio->setCPrecoCusto(@$_POST['c_preco_custo'] ? 1 : 0);
						$campo_relatorio->setCQuantidade(@$_POST['c_quantidade'] ? 1 : 0);
						$campo_relatorio->setCDataValidade(@$_POST['c_data_validade'] ? 1 : 0);
						$campo_relatorio->setCDataCadastro(@$_POST['c_data_cadastro'] ? 1 : 0);
						$campo_relatorio->setCFornecedor(@$_POST['c_fornecedor'] ? 1 : 0);
						$campo_relatorio->setCLocalizacao(@$_POST['c_localizacao'] ? 1 : 0);
						$campo_relatorio->setCLote(@$_POST['c_lote'] ? 1 : 0);
						$campo_relatorio->setCDescricao(@$_POST['c_descricao'] ? 1 : 0);
						
						$campo_relatorio_dao = new CampoRelConfigDAO();
						
						$resultado = $campo_relatorio_dao->updateCampoRelConfig($campo_relatorio);
						
						$resul_json = json_decode($resultado);

						//verifica se deu algum erro
						if (array_key_exists('id', $resul_json)){
						
							if (($rs_usr_conf['aviso_validade'] != $_POST['aviso_validade']) || ($rs_usr_conf['tipo_aviso_validade'] != $_POST['validade_alerta']) || 
								($rs_usr_conf['aviso_vencido'] != $_POST['aviso_vencido']) || ($rs_usr_conf['tipo_aviso_vencido'] != $_POST['vencido_alerta'])){
								
								$obj_produto = new ProdutoDAO();
								
								$res_produto = $obj_produto->selectProduto(Login::codigoUsuario());
								
								//calcula tempo de aviso de validade
								switch ($_POST['validade_alerta']) {
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
								
								$data_qtd_validade = "-".$_POST['aviso_validade'].$tipo;
								
								//calcula tempo de aviso de pos validade
								switch ($_POST['vencido_alerta']) {
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

								$data_qtd_vencido = "+".$_POST['aviso_vencido'].$tipo;
								
								$aviso_produto = New AvisoProduto();
								$aviso_produto_dao = New AvisoProdutoDAO();
								
								$aviso_produto->setUsuario(Login::codigoUsuario());
								
								foreach($res_produto as $valor){
									
									$data_validade = date("Y-m-d", strtotime(str_replace('/','-', $valor['data_validade'])));
									
									$data_aviso_inicial = date('Y-m-d', strtotime($data_qtd_validade, strtotime($data_validade)));
									
									$data_aviso_final = date('Y-m-d', strtotime($data_qtd_vencido, strtotime($data_validade)));

									$aviso_produto->setProduto($valor['codigo']);
									$aviso_produto->setDataAvisoInicial($data_aviso_inicial);
									$aviso_produto->setDataAvisoFinal($data_aviso_final);

									$resultado = $aviso_produto_dao->updateAvisoProduto($aviso_produto);
									
									$resul_json = json_decode($resultado);
									
									if (!array_key_exists('id', $resul_json)){
										break;
									}
								}
							}
							
							//verifica se deu algum erro
							if (array_key_exists('id', $resul_json)){

								if (($rs_usr_conf['aviso_periodo'] != $_POST['aviso_periodo']) || ($rs_usr_conf['tipo_aviso_periodo'] != $_POST['relatorio_alerta'])){
									
									//calcula tempo de aviso de periodico
									switch ($_POST['relatorio_alerta']) {
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
									
									$data_aviso_ultimo = date('Y-m-d');
									
									$data_qtd_periodo = "+".$_POST['aviso_periodo'].$tipo;
									
									$data_aviso_proximo = date('Y-m-d', strtotime($data_qtd_periodo, strtotime($data_aviso_ultimo)));
									
									$aviso_periodico = New AvisoPeriodico();
									$aviso_periodico_dao = New AvisoPeriodicoDAO();
				
									$aviso_periodico->setUsuario(Login::codigoUsuario());
									$aviso_periodico->setDataAvisoUltimo($data_aviso_ultimo);
									$aviso_periodico->setDataAvisoProximo($data_aviso_proximo);
					
									$resultado = $aviso_periodico_dao->updateAvisoPeriodico($aviso_periodico);
									
									$resul_json = json_decode($resultado);
									
									//verifica se deu algum erro
									if (array_key_exists('id', $resul_json)){
									
										echo '{"codigo": "15.2.0"}'; 
										
									}else{

										Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');

										echo $resultado;
									}	
								
								}else{
									
									echo '{"codigo": "15.2.0"}'; 
								}

							}else{

								Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');

								echo $resultado;
							}
							
						}else{

							Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');

							echo $resultado;
						}
						
					}else{

						Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');

						echo $resultado;
					}

				}else{

					Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');

					echo $resultado;
				}
				
			}else{

				Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');
				
				echo $resultado;
			}
		
		}else{

			Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');
			
			echo $resultado;
		}
	}
?>