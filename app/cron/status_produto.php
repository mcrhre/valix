<?php	
	include_once('../autoload.php');
	
	$status_produto = New StatusProduto();
	
	$rs_status_produto = $status_produto->verificaStatus();
	
	$resul_json = json_decode($rs_status_produto);
	
	//verifica se deu algum erro
	if (array_key_exists('id', $resul_json))
	{
		echo $rs_status_produto;
	}
	else
	{
		Funcao::gravarLog(0, $rs_status_produto, __FILE__, __LINE__, 'erros');
		echo $rs_status_produto;
	}
?>
