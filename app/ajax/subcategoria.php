<?php
	date_default_timezone_set('America/Sao_Paulo');

	include_once('../autoload.php');

	Login::verificarLogado();
	
	$codigo = (empty($_GET['id_categoria']) ? exit : addslashes($_GET['id_categoria']));
	
	$obj_subcategoria = new SubcategoriaDAO();
	$res_subcategoria = $obj_subcategoria->selectCategoriaId($codigo, Login::codigoUsuario());

	if(is_string($res_subcategoria))
	{
		$resul_json = json_decode($res_subcategoria);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_subcategoria, __FILE__, __LINE__, 'erros');
		}
	}
	
	//echo '<pre>';
	//print_r($res_subcategoria);
	
	echo json_encode($res_subcategoria);
?>