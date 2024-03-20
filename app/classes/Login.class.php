<?php
	include_once("Conexao.class.php");
	include_once("Funcao.class.php");

	ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../../project/session'));

	session_start();

	class Login{
		
		public static function verificarLogado()
		{
			if(!isset($_SESSION["id_sessao"]) && $_SESSION["id_sessao"] != session_id()){
				header("Location: dirname(__FILE__)/../../");
			}
		}
		
		public static function Logar($usuario, $senha)
		{
			include_once('UsuarioDAO.class.php');
			
			$obj = new UsuarioDAO();
			$res = $obj->verificaUsuario($usuario, $senha);
			
			if(is_array($res))
			{
				$_SESSION["codigo_usuario"] = $res['codigo'];
				$_SESSION["usuario"] = $res['usuario'];
				$_SESSION["id_sessao"] = session_id();
				
				header("Location: dirname(__FILE__)/../app");
			}
			else
			{
				header("Location: dirname(__FILE__)/../?erro=1");
			}
		}
		
		public static function codigoUsuario()
		{
			return $_SESSION["codigo_usuario"];
		}
		
		public static function Usuario()
		{
			return $_SESSION["usuario"];
		}
		
		public static function Deslogar()
		{
			session_regenerate_id();
			session_destroy();
			//header("Location: http://valix.com.br");
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
	}
?>