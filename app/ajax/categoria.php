<?php
	date_default_timezone_set('America/Sao_Paulo');

	include_once('../autoload.php');

	Login::verificarLogado();
	
	$obj_categoria = new CategoriaDAO();
	$res_categoria = $obj_categoria->selectCategoria(Login::codigoUsuario());

	if(is_string($res_categoria))
	{
		$resul_json = json_decode($res_categoria);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_categoria, __FILE__, __LINE__, 'erros');
		}
	}
	
	//echo '<pre>';
	//print_r($res_subcategoria);
	
	echo json_encode($res_categoria);
?>