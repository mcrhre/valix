<?php 
	date_default_timezone_set('America/Sao_Paulo');

	include_once('../autoload.php');

	Login::verificarLogado();
	
	$codigo = (empty($_GET['id']) ? exit : $_GET['id']);

	$subcategoria_dao = New SubcategoriaDAO();

	$rs_subcategoria = $subcategoria_dao->deleteSubcategoria($codigo, Login::codigoUsuario());

	$resul_json = json_decode($rs_subcategoria);

	//verifica se deu algum erro
	if (array_key_exists('mensagem', $resul_json))
	{
		Funcao::gravarLog(Login::codigoUsuario(), $rs_subcategoria, __FILE__, __LINE__, 'erros');
	}
	
	echo $rs_subcategoria;
?>