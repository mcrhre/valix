<?php 
	header('Content-Type: application/json');

	date_default_timezone_set('America/Sao_Paulo');
	
	include_once('../autoload.php');
	
	Login::verificarLogado();
	
	if ($_POST){
		
		$usuario_dao = New UsuarioDAO();
		$parametro = $_POST['parametro'];		
		$novo_usuario = $_POST['usuario'];		
		$senha_atual = $_POST['atual'];		
		$nova_senha = $_POST['nova'];
		$resultado = $usuario_dao->verificaUsuario(Login::Usuario(), $senha_atual);
		
		//verifica se usuario existe
		if (!empty($resultado)){
			
			//verifica se deu algum erro
			if (@array_key_exists('usuario', $resultado)){
			
				$usuario = New Usuario();
				$usuario->setUsuario($novo_usuario);			
				$usuario->setSenha($nova_senha);			
				$usuario->setCodigo(Login::codigoUsuario());
				$resultado = $usuario_dao->updateUsuario($usuario, $parametro);
				$resul_json = json_decode($resultado);
				
				//verifica se deu algum erro
				if (array_key_exists('id', $resul_json)){

					echo $resultado;

				}else{

					Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');

					echo $resultado;
				}
				
			}else{

				Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');

				echo $resultado;
			}
			
		}else{

			$resultado = '{"codigo": "17.4.1", "mensagem": "Erro Select"}';

			Funcao::gravarLog(Login::codigoUsuario(), $resultado, __FILE__, __LINE__, 'erros');

			echo $resultado;
		}
	}
?>