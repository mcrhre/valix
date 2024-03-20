<?php
	date_default_timezone_set('America/Sao_Paulo');

	include_once('../autoload.php');

	Login::verificarLogado();
	
	$obj_unidade_medida = new UnidadeMedidaDAO();
	$res_unidade_medida = $obj_unidade_medida->selectUnidadeMedida(Login::codigoUsuario());

	if(is_string($res_unidade_medida))
	{
		$resul_json = json_decode($res_unidade_medida);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_unidade_medida, __FILE__, __LINE__, 'erros');
		}
	}
	
	//echo '<pre>';
	//print_r($res_unidade_medida);
	
	echo json_encode($res_unidade_medida);
?>