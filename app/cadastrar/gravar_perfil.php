<?php
	//aqui sera criado o perfil do usuario com todas as suas configurações
	header('Content-Type: application/json');

	date_default_timezone_set('America/Sao_Paulo');

	die('');

	include_once('../autoload.php');

	$nome  = trim($_POST['nome']);
	$login = trim(strtolower($_POST['email']));
	$senha = trim($_POST['senha']);

	//cria usuario e senha
	$usuario = New Usuario();

	$usuario->setUsuario($login);
	$usuario->setSenha($senha);

	$usuario_dao = New UsuarioDAO();
	
	$resultado = $usuario_dao->insertUsuario($usuario);

	$resul_json = json_decode($resultado);

	//verifica se deu algum erro ou se usuario já existe
	if (array_key_exists('id', $resul_json)){

		$id_usuario = $resul_json->id;

		//cria cadastro do usuario
		$usuario_cadastro = New UsuarioCadastro();		

		$usuario_cadastro->setUsuario($id_usuario);
		$usuario_cadastro->setNome(Funcao::removeAcento(Funcao::normalizarNome($nome)));
		$usuario_cadastro->setEmail($login);
		$usuario_cadastro->setDataCadastro(date('Y-m-d'));

		$usuario_cadastro_dao = New UsuarioCadastroDAO();

		$resultado = $usuario_cadastro_dao->insertUsuarioCadastro($usuario_cadastro);
		$resul_json = json_decode($resultado);

		//verifica se deu algum erro
		if (array_key_exists('id', $resul_json)){

			//configuração avisos
			$usuario_config_dao = New UsuarioConfigDAO();

			$resultado = $usuario_config_dao->insertUsuarioConfig($id_usuario);
			$resul_json = json_decode($resultado);

			//verifica se deu algum erro
			if (array_key_exists('id', $resul_json)){
				
				//configura campos que vão aparecer no relatorio de validade
				$campo_relatorio_dao = new CampoRelConfigDAO();
				
				$resultado = $campo_relatorio_dao->insertCampoRelConfig($id_usuario);
				$resul_json = json_decode($resultado);
				
				//verifica se deu algum erro
				if (array_key_exists('id', $resul_json)){

					//email
					$usuario_email = New UsuarioEmail();

					$usuario_email->setEmail(array($login));
					$usuario_email->setUsuario($id_usuario);

					$usuario_email_dao = New UsuarioEmailDAO();

					$resultado = $usuario_email_dao->insertUsuarioEmail($usuario_email);
					$resul_json = json_decode($resultado);

					//verifica se deu algum erro
					if (array_key_exists('id', $resul_json)){

						//unidade medida
						$unidade_medida = New UnidadeMedida();

						$unidade_medida->setNome('Unidade');
						$unidade_medida->setUsuario($id_usuario);

						$unidade_medida_dao = New UnidadeMedidaDAO();
						
						$resultado = $unidade_medida_dao->insertUnidadeMedida($unidade_medida);
						$resul_json = json_decode($resultado);

						//verifica se deu algum erro
						if (array_key_exists('id', $resul_json)){
							
							//configura aviso periodico (padrao 15 em 15 dias)
							$aviso_periodico = New AvisoPeriodico();
							
							$aviso_periodico->setUsuario($id_usuario);
							$aviso_periodico->setDataAvisoUltimo(date('Y-m-d'));
							$data_aviso_proximo = date('Y-m-d', strtotime("+15 day", strtotime(date('Y-m-d'))));
							$aviso_periodico->setDataAvisoProximo($data_aviso_proximo);
							
							$aviso_periodico_dao = New AvisoPeriodicoDAO();
							
							$resultado = $aviso_periodico_dao->insertAvisoPeriodico($aviso_periodico);
							$resul_json = json_decode($resultado);
							
							//verifica se deu algum erro
							if (array_key_exists('id', $resul_json)){
								
								echo '{"codigo": "12.1.0"}';
								
							}else{

								//exclui usuario
								$usuario_dao = New UsuarioDAO();
								$usuario_dao->deleteUsuario($id_usuario);

								Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');

								echo $resultado;
							}
							
						}else{

							//exclui usuario
							$usuario_dao = New UsuarioDAO();
							$usuario_dao->deleteUsuario($id_usuario);

							Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');

							echo $resultado;
						}

					}else{

						//exclui usuario
						$usuario_dao = New UsuarioDAO();
						$usuario_dao->deleteUsuario($id_usuario);

						Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');

						echo $resultado;
					}
			
				}else{

					//exclui usuario
					$usuario_dao = New UsuarioDAO();
					$usuario_dao->deleteUsuario($id_usuario);

					Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');

					echo $resultado;
				}
				
			}else{

				//exclui usuario
				$usuario_dao = New UsuarioDAO();
				$usuario_dao->deleteUsuario($id_usuario);

				Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');
				
				echo $resultado;
			}

		}else{

			//exclui usuario
			$usuario_dao = New UsuarioDAO();
			$usuario_dao->deleteUsuario($id_usuario);

			Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');

			echo $resultado;
		}

	}else{

		Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');

		echo $resultado;

	}
?>