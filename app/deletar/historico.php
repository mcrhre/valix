<?php
	date_default_timezone_set('America/Sao_Paulo');

	include_once('../autoload.php');

	Login::verificarLogado();

	$historico = new AvisoHistoricoDAO;

	if(@$_GET['target'] == 'lidos') $rs_historico = $historico->deleteTudoAvisoHistorico(Login::codigoUsuario(), '', 1);
	if(@$_GET['target'] == 'novos') $rs_historico = $historico->deleteTudoAvisoHistorico(Login::codigoUsuario(), '', 0);
	if(@$_GET['target'] == 'unico') $rs_historico = $historico->deleteAvisoHistorico(@$_GET['id'], Login::codigoUsuario());

	$resul_json = json_decode($rs_historico);

	//verifica se deu algum erro
	if (array_key_exists('mensagem', $resul_json))
	{
		Funcao::gravarLog(Login::codigoUsuario(), $rs_historico, __FILE__, __LINE__, 'erros');
	}
	
	echo $rs_historico;
?>