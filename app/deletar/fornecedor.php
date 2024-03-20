<?php
	date_default_timezone_set('America/Sao_Paulo');

	include_once('../autoload.php');

	Login::verificarLogado();

	$codigo = (empty($_GET['id']) ? exit : $_GET['id']);
	
	$fornecedor_dao = New FornecedorDAO();
	
	$rs_fornecedor = $fornecedor_dao->deleteFornecedor($codigo, Login::codigoUsuario());

	$resul_json = json_decode($rs_fornecedor);

	//verifica se deu algum erro
	if (array_key_exists('mensagem', $resul_json))
	{
		Funcao::gravarLog(Login::codigoUsuario(), $rs_fornecedor, __FILE__, __LINE__, 'erros');
	}
	
	echo $rs_fornecedor;
?>