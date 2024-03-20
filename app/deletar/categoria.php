<?php
	date_default_timezone_set('America/Sao_Paulo');

	include_once('../autoload.php');

	Login::verificarLogado();
	
	$codigo = (empty($_GET['id']) ? exit : $_GET['id']);

	$categoria_dao = New CategoriaDAO();

	$rs_categoria = $categoria_dao->deleteCategoria($codigo, Login::codigoUsuario());

	$resul_json = json_decode($rs_categoria);

	//verifica se deu algum erro
	if (array_key_exists('mensagem', $resul_json))
	{
		Funcao::gravarLog(Login::codigoUsuario(), $rs_categoria, __FILE__, __LINE__, 'erros');
	}
	
	echo $rs_categoria;
?>