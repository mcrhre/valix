<?php 
	header('Content-Type: application/json');

	date_default_timezone_set('America/Sao_Paulo');
	
	include_once('../autoload.php');
	
	Login::verificarLogado();
	
	if ($_POST){
		
		$subcategoria = New Subcategoria();
		
		$subcategoria->setNome(Funcao::removeAcento(Funcao::normalizarNome($_POST['nome_subcategoria'])));
		$subcategoria->setCategoria($_POST['categoria_produto']);
		$subcategoria->setUsuario(Login::codigoUsuario());
		
		$subcategoria_dao = New SubcategoriaDAO();
		
		$rs_subcategoria = $subcategoria_dao->insertSubcategoria($subcategoria);

		$resul_json = json_decode($rs_subcategoria);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			if (preg_match('/erro/i', $resul_json->mensagem))
			{
				Funcao::gravarLog(Login::codigoUsuario(), $rs_subcategoria, __FILE__, __LINE__, 'erros');
			}
		}
		
		echo $rs_subcategoria;
	}
?>