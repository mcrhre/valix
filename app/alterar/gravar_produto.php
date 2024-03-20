<?php
	header('Content-Type: application/json');
	
	date_default_timezone_set('America/Sao_Paulo');
	
	include_once('../autoload.php');
	
	Login::verificarLogado();
	
	if ($_POST){
		
		$produto = New Produto();
		
		$produto->setCodigo($_POST['codigo_produto']);
		$produto->setNome(Funcao::removeAcento(Funcao::normalizarNome($_POST['nome_produto'])));
		$produto->setMarca($_POST['marca_produto']);
		$produto->setCategoria($_POST['categoria_produto']);
		$produto->setSubcategoria(@$_POST['subcategoria_produto']);
		$produto->setDescricao($_POST['descricao_produto']);
		$produto->setQuantidade($_POST['quantidade_produto']);
		$produto->setUnidadeMedida($_POST['unidade_medida']);
		$produto->setPrecoCusto($_POST['preco_custo_produto']);
		$produto->setUnMedidaCusto($_POST['unidade_medida_custo']);
		$produto->setFator($_POST['quantidade_fator']);
		$produto->setFornecedor($_POST['fornecedor_produto']);
		$produto->setLocalizacao($_POST['localizacao_produto']);
		$produto->setLote($_POST['lote_produto']);
		$produto->setDataValidade($_POST['validade_produto']);
		$produto->setStatus(@$_POST['notifica']);
		$produto->setDataCadastro(date('d/m/Y'));
		$produto->setUsuario(Login::codigoUsuario());
		
		$produto_dao = New ProdutoDAO();
		
		$resul_produto = $produto_dao->updateProduto($produto);
		
		$resul_json = json_decode($resul_produto);
		
		//verifica se deu algum erro
		if (array_key_exists('id', $resul_json)){
			
			//busca configuração de validade
			
			$data_validade = date("Y-m-d", strtotime(str_replace('/','-', $_POST['validade_produto'])));
			
			$usuario_config_dao = New UsuarioConfigDAO();

			$resul_usr_conf = $usuario_config_dao->selectUsuarioConfig(Login::codigoUsuario());
			
			//calcula tempo de aviso de validade
			switch ($resul_usr_conf['tipo_aviso_validade']) {
				case 1:
					//dia
					$tipo = ' day';
					break;
				case 2:
					//mes
					$tipo = ' month';
					break;
				case 3:
					//ano
				   $tipo = ' year';
					break;
			}
			
			$data_qtd = "-".$resul_usr_conf['aviso_validade'].$tipo;

			$data_aviso_inicial = date('Y-m-d', strtotime($data_qtd, strtotime($data_validade)));
			
			//calcula tempo de aviso de pos validade
			switch ($resul_usr_conf['tipo_aviso_vencido']) {
				case 1:
					//dia
					$tipo = ' day';
					break;
				case 2:
					//mes
					$tipo = ' month';
					break;
				case 3:
					//ano
				   $tipo = ' year';
					break;
			}

			$data_qtd = "+".$resul_usr_conf['aviso_vencido'].$tipo;

			$data_aviso_final = date('Y-m-d', strtotime($data_qtd, strtotime($data_validade)));
			
			//grava datas de aviso ja calculadas

			$aviso_produto = New AvisoProduto();

			$aviso_produto->setProduto($_POST['codigo_produto']);
			$aviso_produto->setUsuario(Login::codigoUsuario());
			$aviso_produto->setDataAvisoInicial($data_aviso_inicial);
			$aviso_produto->setDataAvisoFinal($data_aviso_final);

			$aviso_produto_dao = New AvisoProdutoDAO();

			$resul_aviso = $aviso_produto_dao->updateAvisoProduto($aviso_produto);
			
			$resul_json = json_decode($resul_aviso);
			
			//verifica se deu algum erro
			if (array_key_exists('id', $resul_json)){
				
				echo $resul_produto;
				
			}else{
				
				Funcao::gravarLog(Login::codigoUsuario(), $resul_aviso, __FILE__, __LINE__, 'erros');

				echo $resul_aviso;
				
			}
		
		}else{

			Funcao::gravarLog(Login::codigoUsuario(), $resul_produto, __FILE__, __LINE__, 'erros');
			
			echo $resul_produto;
			
		}
	}
?>