<?php
	header('Content-Type: application/json');

	date_default_timezone_set('America/Sao_Paulo');
	
	include_once('../autoload.php');
	
	Login::verificarLogado();
	
	if ($_POST){
		
		$categoria = New Categoria();
		
		$categoria->setCodigo($_POST['codigo_categoria']);
		$categoria->setNome(Funcao::removeAcento(Funcao::normalizarNome($_POST['nome_categoria'])));
		$categoria->setUsuario(Login::codigoUsuario());
		
		$categoria_dao = New CategoriaDAO();
		
		$rs_categoria = $categoria_dao->updateCategoria($categoria);

		$resul_json = json_decode($rs_categoria);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			if (preg_match('/erro/i', $resul_json->mensagem))
			{
				Funcao::gravarLog(Login::codigoUsuario(), $rs_categoria, __FILE__, __LINE__, 'erros');
			}
		}
		
		echo $rs_categoria;
	}
?>