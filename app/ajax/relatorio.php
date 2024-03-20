<?php
	date_default_timezone_set('America/Sao_Paulo');

	include_once('../autoload.php');

	Login::verificarLogado();
	
	//header("Content-Type: application/json", true);
	
	//echo '<pre>'; print_r($_POST); exit;
	
	$dados['campos']['marca'] = $_POST['check_marca'];
	$dados['campos']['categoria'] = $_POST['check_categoria'];
	$dados['campos']['subcategoria'] = $_POST['check_subcategoria'];
	$dados['campos']['quantidade'] = $_POST['check_quantidade'];
	$dados['campos']['status'] = $_POST['check_notificacao'];
	$dados['campos']['data_validade'] = $_POST['check_validade'];
	$dados['campos']['data_cadastro'] = $_POST['check_cadastro'];
	$dados['campos']['preco_custo'] = $_POST['check_preco'];
	$dados['campos']['fornecedor'] = $_POST['check_fornecedor'];
	$dados['campos']['localizacao'] = $_POST['check_localizacao'];
	$dados['campos']['lote'] = $_POST['check_lote'];
	$dados['campos']['descricao'] = $_POST['check_descricao'];

	$dados['marca'] = $_POST['marca'];
	$dados['categoria'] = $_POST['categoria'];
	$dados['subcategoria'] = $_POST['subcategoria'];
	$dados['unidade_medida'] = $_POST['unidade_medida'];
	$dados['fornecedor'] = $_POST['fornecedor'];
	$dados['organizar'] = $_POST['organizar'];
	$dados['filtro_produto'] = $_POST['mostrar'];
	$dados['notificacao'] = $_POST['notificacao'];
	
	if ($_POST['filtrar'] == 1){
		
		$dados['intervalo'] = array('tipo_intervalo' => $_POST['tipo_intervalo'], 'data_inicial' => $_POST['inicial_submit'], 'data_final' => $_POST['final_submit']);
	}
	
	//echo '<pre>';
	//print_r($dados); exit;

	$obj_relatorio = new Relatorio();
	$res_relatorio = $obj_relatorio->gerarRelatorio(Login::codigoUsuario(), $dados);

	if(is_string($res_relatorio))
	{
		$resul_json = json_decode($res_relatorio);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_relatorio, __FILE__, __LINE__, 'erros');
		}
	}
	
	//echo '<pre>';
	//print_r($res_relatorio);
	
	echo json_encode($res_relatorio);
?>