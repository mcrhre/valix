<?php 
	header('Content-Type: application/json');

	date_default_timezone_set('America/Sao_Paulo');
	
	include_once('../autoload.php');
	
	Login::verificarLogado();
	
	if ($_POST){
		
		$marca = New Marca();
		
		$marca->setCodigo($_POST['codigo_marca']);
		$marca->setNome(Funcao::removeAcento(Funcao::normalizarNome($_POST['nome_marca'])));
		$marca->setUsuario(Login::codigoUsuario());
		
		$marca_dao = New MarcaDAO();
		
		$rs_marca = $marca_dao->updateMarca($marca);

		$resul_json = json_decode($rs_marca);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			if (preg_match('/erro/i', $resul_json->mensagem))
			{
				Funcao::gravarLog(Login::codigoUsuario(), $rs_marca, __FILE__, __LINE__, 'erros');
			}
		}
		
		echo $rs_marca;
	}
?>