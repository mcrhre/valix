<?php 
	date_default_timezone_set('America/Sao_Paulo');

	include_once('../autoload.php');

	Login::verificarLogado();
	
	$codigo = (empty($_GET['id']) ? exit : $_GET['id']);
	
	$marca_dao = New MarcaDAO();

	$rs_marca = $marca_dao->deleteMarca($codigo, Login::codigoUsuario());

	$resul_json = json_decode($rs_marca);

	//verifica se deu algum erro
	if (array_key_exists('mensagem', $resul_json))
	{
		Funcao::gravarLog(Login::codigoUsuario(), $rs_marca, __FILE__, __LINE__, 'erros');
	}
	
	echo $rs_marca;
?>