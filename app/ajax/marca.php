<?php
	date_default_timezone_set('America/Sao_Paulo');

	include_once('../autoload.php');

	Login::verificarLogado();
	
	$obj_marca = new MarcaDAO();
	$res_marca = $obj_marca->selectMarca(Login::codigoUsuario());

	if(is_string($res_marca))
	{
		$resul_json = json_decode($res_marca);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_marca, __FILE__, __LINE__, 'erros');
		}
	}
	
	//echo '<pre>';
	//print_r($res_subcategoria);
	
	echo json_encode($res_marca);
?>