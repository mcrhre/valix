<?php
	date_default_timezone_set('America/Sao_Paulo');

	include_once('../autoload.php');

	Login::verificarLogado();
	
	$codigo = (empty($_GET['id']) ? exit : $_GET['id']);
	
	$produto_dao = New ProdutoDAO();
	
	$rs_produto = $produto_dao->deleteProduto($codigo, Login::codigoUsuario());

	$resul_json = json_decode($rs_produto);

	//verifica se deu algum erro
	if (array_key_exists('mensagem', $resul_json))
	{
		Funcao::gravarLog(Login::codigoUsuario(), $rs_produto, __FILE__, __LINE__, 'erros');
	}
	
	echo $rs_produto;
?>