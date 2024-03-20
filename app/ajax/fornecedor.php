<?php
	date_default_timezone_set('America/Sao_Paulo');

	include_once('../autoload.php');

	Login::verificarLogado();
	
	$obj_fornecedor = new FornecedorDAO();
	$res_fornecedor = $obj_fornecedor->selectFornecedor(Login::codigoUsuario());

	if(is_string($res_fornecedor))
	{
		$resul_json = json_decode($res_fornecedor);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_fornecedor, __FILE__, __LINE__, 'erros');
		}
	}
	
	//echo '<pre>';
	//print_r($res_subcategoria);
	
	echo json_encode($res_fornecedor);
?>