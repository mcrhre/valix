<?php
	header('Content-Type: application/json');

	date_default_timezone_set('America/Sao_Paulo');
	
	include_once('../autoload.php');
	
	Login::verificarLogado();
	
	if ($_POST){
		
		$fornecedor = New Fornecedor();
		
		$fornecedor->setNome(Funcao::removeAcento(Funcao::normalizarNome($_POST['nome_fornecedor'])));
		$fornecedor->setUsuario(Login::codigoUsuario());
		
		$fornecedor_dao = New FornecedorDAO();
		
		$rs_fornecedor = $fornecedor_dao->insertFornecedor($fornecedor);

		$resul_json = json_decode($rs_fornecedor);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			if (preg_match('/erro/i', $resul_json->mensagem))
			{
				Funcao::gravarLog(Login::codigoUsuario(), $rs_fornecedor, __FILE__, __LINE__, 'erros');
			}
		}
		
		echo $rs_fornecedor;
	}
?>