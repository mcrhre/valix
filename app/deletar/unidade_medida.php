<?php 
	date_default_timezone_set('America/Sao_Paulo');

	include_once('../autoload.php');

	Login::verificarLogado();
	
	$codigo = (empty($_GET['id']) ? exit : $_GET['id']);
	
	$unidade_medida_dao = New UnidadeMedidaDAO();
	
	$rs_unidade_medida = $unidade_medida_dao->deleteUnidadeMedida($codigo, Login::codigoUsuario());

	$resul_json = json_decode($rs_unidade_medida);

	//verifica se deu algum erro
	if (array_key_exists('mensagem', $resul_json))
	{
		Funcao::gravarLog(Login::codigoUsuario(), $rs_unidade_medida, __FILE__, __LINE__, 'erros');
	}
	
	echo $rs_unidade_medida;
?>