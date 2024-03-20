<?php 
	header('Content-Type: application/json');

	date_default_timezone_set('America/Sao_Paulo');
	
	include_once('../autoload.php');
	
	Login::verificarLogado();
	
	if ($_POST){
		
		$unidade_medida = New UnidadeMedida();
		
		$unidade_medida->setNome(Funcao::removeAcento(Funcao::normalizarNome($_POST['nome_unidade_medida'])));
		$unidade_medida->setUsuario(Login::codigoUsuario());
		
		$unidade_medida_dao = New UnidadeMedidaDAO();
		
		$rs_unidade_medida = $unidade_medida_dao->insertUnidadeMedida($unidade_medida);

		$resul_json = json_decode($rs_unidade_medida);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			if (preg_match('/erro/i', $resul_json->mensagem))
			{
				Funcao::gravarLog(Login::codigoUsuario(), $rs_unidade_medida, __FILE__, __LINE__, 'erros');
			}
		}
		
		echo $rs_unidade_medida;
	}
?>