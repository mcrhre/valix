<?php 
	if ($_POST){
	
		include_once('app/classes/Login.class.php');
		
		$usuario = addslashes(trim($_POST['usuario']));
		$senha = addslashes(trim($_POST['senha']));
		
		Login::Logar($usuario, $senha);
		
		//Login::verificarLogado();
		//Login::Deslogar();	
	}
?>