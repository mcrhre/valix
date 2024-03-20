<?php
	include_once("Conexao.class.php");
	
	class ProdutoDAO{
		
		function insertProduto($produto)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'INSERT INTO tbl_produto ';
			$sql .= '(nome, marca, categoria, subcategoria, descricao, quantidade, unidade_medida, preco_custo, ';
			$sql .= 'un_med_custo, fator, fornecedor, localizacao, lote, data_cadastro, data_validade, status, usuario)';
			$sql .= ' VALUES ';
			$sql .= '(:nome, :marca, :categoria, :subcategoria, :descricao, :quantidade, :unidade_medida, :preco_custo, '; 
			$sql .= ':un_med_custo, :fator, :fornecedor, :localizacao, :lote, :data_cadastro, :data_validade, :status, :usuario)';
			
			$nome = $produto->getNome();
			$marca = ($produto->getMarca() == '0' ? null : $produto->getMarca());
			$categoria = ($produto->getCategoria() == '0' ? null : $produto->getCategoria());
			$subcategoria = ($produto->getSubcategoria() == '0' ? null : $produto->getSubcategoria());
			$descricao = ($produto->getDescricao() == '' ? null : $produto->getDescricao());
			$quantidade = ($produto->getQuantidade() == '' ? null : $produto->getQuantidade());
			$unidade_medida = ($produto->getUnidadeMedida() == '0' ? null : $produto->getUnidadeMedida());
			$preco_custo = ($produto->getPrecoCusto() == '' ? null : $produto->getPrecoCusto());
			$unidade_medida_custo = ($produto->getUnMedidaCusto() == '0' ? null : $produto->getUnMedidaCusto());
			$fator = ($produto->getFator() == '' ? null : $produto->getFator());
			$fornecedor = ($produto->getFornecedor() == '0' ? null : $produto->getFornecedor());
			$localizacao = ($produto->getLocalizacao() == '' ? null : $produto->getLocalizacao());
			$lote = ($produto->getLote() == '' ? null : $produto->getLote());
			$data_cadastro = date("Y-m-d",strtotime(str_replace('/','-', $produto->getDataCadastro())));
			$data_validade = date("Y-m-d",strtotime(str_replace('/','-', $produto->getDataValidade())));
			$status = ($produto->getStatus() == '' ? 0 : $produto->getStatus());
			$usuario = $produto->getUsuario();
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
				$stmt->bindParam(':marca', $marca, PDO::PARAM_INT);
				$stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
				$stmt->bindParam(':subcategoria', $subcategoria, PDO::PARAM_INT);
				$stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
				$stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
				$stmt->bindParam(':unidade_medida', $unidade_medida, PDO::PARAM_INT);
				$stmt->bindParam(':preco_custo', $preco_custo, PDO::PARAM_STR);
				$stmt->bindParam(':un_med_custo', $unidade_medida_custo, PDO::PARAM_STR);
				$stmt->bindParam(':fator', $fator, PDO::PARAM_INT);
				$stmt->bindParam(':fornecedor', $fornecedor, PDO::PARAM_INT);
				$stmt->bindParam(':localizacao', $localizacao, PDO::PARAM_STR);
				$stmt->bindParam(':lote', $lote, PDO::PARAM_STR);
				$stmt->bindParam(':data_cadastro', $data_cadastro, PDO::PARAM_STR);
				$stmt->bindParam(':data_validade', $data_validade, PDO::PARAM_STR);
				$stmt->bindParam(':status', $status, PDO::PARAM_INT);
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$id_retorno = $conn->lastInsertId();
				
				$conn = null;
				
				return '{"codigo": "1.1.0", "id": "'.$id_retorno.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "1.1.1", "mensagem": "Erro Insert"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function updateProduto($produto)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_produto SET '; 
			$sql .= 'nome = :nome, ';
			$sql .= 'marca = :marca, ';
			$sql .= 'categoria = :categoria, ';
			$sql .= 'subcategoria = :subcategoria, ';
			$sql .= 'descricao = :descricao, ';
			$sql .= 'quantidade = :quantidade, ';
			$sql .= 'unidade_medida = :unidade_medida, ';
			$sql .= 'preco_custo = :preco_custo, ';
			$sql .= 'un_med_custo = :un_med_custo, ';
			$sql .= 'fator = :fator, ';
			$sql .= 'fornecedor = :fornecedor, ';
			$sql .= 'localizacao = :localizacao, ';
			$sql .= 'lote = :lote, ';
			$sql .= 'data_validade = :data_validade, ';
			$sql .= 'status = :status ';
			$sql .= 'WHERE codigo = :codigo ';
			$sql .= 'AND usuario = :usuario';
			
			$nome = $produto->getNome();
			$marca = ($produto->getMarca() == '0' ? null : $produto->getMarca());
			$categoria = ($produto->getCategoria() == '0' ? null : $produto->getCategoria());
			$subcategoria = ($produto->getSubcategoria() == '0' ? null : $produto->getSubcategoria());
			$descricao = ($produto->getDescricao() == '' ? null : $produto->getDescricao());
			$quantidade = ($produto->getQuantidade() == '' ? null : $produto->getQuantidade());
			$unidade_medida = ($produto->getUnidadeMedida() == '0' ? null : $produto->getUnidadeMedida());
			$preco_custo = ($produto->getPrecoCusto() == '' ? null : $produto->getPrecoCusto());
			$unidade_medida_custo = ($produto->getUnMedidaCusto() == '0' ? null : $produto->getUnMedidaCusto());
			$fator = ($produto->getFator() == '' ? null : $produto->getFator());
			$fornecedor = ($produto->getFornecedor() == '0' ? null : $produto->getFornecedor());
			$localizacao = ($produto->getLocalizacao() == '' ? null : $produto->getLocalizacao());
			$lote = ($produto->getLote() == '' ? null : $produto->getLote());
			$data_validade = date("Y-m-d",strtotime(str_replace('/','-', $produto->getDataValidade())));
			$status = ($produto->getStatus() == '' ? 0 : $produto->getStatus());
			$usuario = $produto->getUsuario();
			$codigo = $produto->getCodigo();
			
			try 
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
				$stmt->bindParam(':marca', $marca, PDO::PARAM_INT);
				$stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
				$stmt->bindParam(':subcategoria', $subcategoria, PDO::PARAM_INT);
				$stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
				$stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
				$stmt->bindParam(':unidade_medida', $unidade_medida, PDO::PARAM_INT);
				$stmt->bindParam(':preco_custo', $preco_custo, PDO::PARAM_STR);
				$stmt->bindParam(':un_med_custo', $unidade_medida_custo, PDO::PARAM_STR);
				$stmt->bindParam(':fator', $fator, PDO::PARAM_INT);
				$stmt->bindParam(':fornecedor', $fornecedor, PDO::PARAM_INT);
				$stmt->bindParam(':localizacao', $localizacao, PDO::PARAM_STR);
				$stmt->bindParam(':lote', $lote, PDO::PARAM_STR);
				$stmt->bindParam(':data_validade', $data_validade, PDO::PARAM_STR);
				$stmt->bindParam(':status', $status, PDO::PARAM_INT);
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);				
				$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return '{"codigo": "1.2.0", "id": "'.$codigo.'"}';
				
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "1.2.1", "mensagem": "Erro Update"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function deleteProduto($codigo, $usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'DELETE FROM tbl_produto ';
			$sql .= 'WHERE codigo = :codigo ';
			$sql .= 'AND usuario = :usuario';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);	
				
				$stmt->execute();
				
				$conn = null;
				
				return '{"codigo": "1.3.0", "id": "'.$codigo.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "1.3.1", "mensagem": "Erro Delete"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectProduto($usuario, $organizar = '', $filtro = '', $intervalo = '', $limite = '')
		{
			$conn = Conexao::getConexao();
			
			$sql_order = '';
			$sql_limit = '';
			$sql_filtro = '';
			$sql_intervalo = '';
			
			switch ($filtro) {
				case "vencidos":
					$sql_filtro = "AND p.data_validade < CURDATE() ";
					break;
				case "validade":
					$sql_filtro = "AND CURDATE() < (SELECT data_aviso_inicial FROM tbl_aviso_produto ap WHERE ap.produto = p.codigo) ";
					break;
				case "proximo":
					$sql_filtro = "AND CURDATE() >= (SELECT data_aviso_inicial FROM tbl_aviso_produto ap WHERE ap.produto = p.codigo) AND CURDATE() < p.data_validade ";
					break;
				case "notificacao":
					$sql_filtro = "AND p.status = 0 ";
					break;	
			}
			
			if(is_array($intervalo))
			{
				$sql_intervalo = "AND p.data_validade BETWEEN '".date("Y-m-d", strtotime(str_replace('/', '-', $intervalo['data_inicial'])))."' AND '".date("Y-m-d", strtotime(str_replace('/', '-', $intervalo['data_final'])))."' ";
			}
			
			switch ($organizar) {
				case "A-Z":
					$sql_order = "ORDER BY p.nome ";
					break;
				case "Z-A":
					$sql_order = "ORDER BY p.nome DESC ";
					break;
				case "data_cadastro":					
					$sql_order = "ORDER BY p.data_cadastro DESC ";
					break;				
				case "data_vencimento":					
				default:
					$sql_order = "ORDER BY p.data_validade ";
					break;
			}
			
			if(is_array($limite))
			{
				$sql_limit = 'LIMIT '.$limite['inicio']. ', '.$limite['fim'];
			}
			
			$sql  = 'SELECT p.codigo, p.nome, m.nome as marca, c.nome as categoria, sc.nome as subcategoria, p.status, p.un_med_custo, ';
			$sql .= 'p.fator, p.quantidade, u.nome as unidade_medida, p.data_validade, p.data_cadastro, p.preco_custo ';
			$sql .= 'FROM tbl_produto p ';
			$sql .= 'LEFT JOIN tbl_marca m ';
			$sql .= 'ON p.marca = m.codigo ';
			$sql .= 'LEFT JOIN tbl_categoria c ';
			$sql .= 'ON p.categoria = c.codigo ';
			$sql .= 'LEFT JOIN tbl_subcategoria sc ';
			$sql .= 'ON p.subcategoria = sc.codigo ';
			$sql .= 'LEFT JOIN tbl_unidade_medida u ';
			$sql .= 'ON p.unidade_medida = u.codigo ';
			$sql .= 'LEFT JOIN tbl_fornecedor f ';
			$sql .= 'ON p.fornecedor = f.codigo ';
			$sql .= "WHERE p.usuario = :usuario ";
			$sql .= $sql_filtro;
			$sql .= $sql_intervalo;
			$sql .= $sql_order;
			$sql .= $sql_limit;

			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "1.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectProdutoId($codigo, $usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_produto ';
			$sql .= 'WHERE codigo = :codigo ';
			$sql .= 'AND usuario = :usuario';

			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "1.4.2", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function pesquisaProduto($usuario, $tipo_pesquisa, $pesquisa, $organizar = '', $filtro = '', $intervalo = '', $limite = '')
		{
			$conn = Conexao::getConexao();
			
			$pesquisa .= '%';
			
			$sql_order = '';
			$sql_pesquisa = '';
			$sql_limit = '';
			$sql_filtro = ''; 
			$sql_intervalo = '';
			
			switch ($filtro) {
				case "vencidos":
					$sql_filtro = "AND p.data_validade < CURDATE() ";
					break;
				case "validade":
					$sql_filtro = "AND CURDATE() < (SELECT data_aviso_inicial FROM tbl_aviso_produto ap WHERE ap.produto = p.codigo) ";
					break;
				case "proximo":
					$sql_filtro = "AND CURDATE() >= (SELECT data_aviso_inicial FROM tbl_aviso_produto ap WHERE ap.produto = p.codigo) AND CURDATE() < p.data_validade ";
					break;
				case "notificacao":
					$sql_filtro = "AND p.status = 0 ";
					break;	
			}
			
			switch ($tipo_pesquisa) {
				case "produto":
					$sql_pesquisa = "AND p.nome like :$tipo_pesquisa ";
					break;
				case "marca":
					$sql_pesquisa = "AND m.nome like :$tipo_pesquisa ";
					break;
				case "categoria":
					$sql_pesquisa = "AND c.nome like :$tipo_pesquisa ";
					break;
				case "subcategoria":
					$sql_pesquisa = "AND sc.nome like :$tipo_pesquisa ";
					break;
				case "unidade_medida":
					$sql_pesquisa = "AND u.nome like :$tipo_pesquisa ";
					break;
				case "fornecedor":
					$sql_pesquisa = "AND f.nome like :$tipo_pesquisa ";
					break;
			}
			
			if(is_array($intervalo))
			{
				$sql_intervalo = "AND p.data_validade BETWEEN '".date("Y-m-d", strtotime(str_replace('/', '-', $intervalo['data_inicial'])))."' AND '".date("Y-m-d", strtotime(str_replace('/', '-', $intervalo['data_final'])))."' ";
			}
			
			switch ($organizar) {
				case "A-Z":
					$sql_order = "ORDER BY p.nome ";
					break;
				case "Z-A":
					$sql_order = "ORDER BY p.nome DESC ";
					break;
				case "data_cadastro":					
					$sql_order = "ORDER BY p.data_cadastro DESC ";
					break;				
				case "data_vencimento":					
				default:
					$sql_order = "ORDER BY p.data_validade ";
					break;
			}
			
			if(is_array($limite))
			{
				$sql_limit = 'LIMIT '.$limite['inicio']. ', '.$limite['fim'];
			}
			
			$sql  = 'SELECT p.codigo, p.nome, m.nome as marca, c.nome as categoria, sc.nome as subcategoria, p.status, p.un_med_custo, ';
			$sql .= 'p.fator, p.quantidade, u.nome as unidade_medida, p.data_validade, p.data_cadastro, p.preco_custo ';
			$sql .= 'FROM tbl_produto p ';
			$sql .= 'LEFT JOIN tbl_marca m ';
			$sql .= 'ON p.marca = m.codigo ';
			$sql .= 'LEFT JOIN tbl_categoria c ';
			$sql .= 'ON p.categoria = c.codigo ';
			$sql .= 'LEFT JOIN tbl_subcategoria sc ';
			$sql .= 'ON p.subcategoria = sc.codigo ';
			$sql .= 'LEFT JOIN tbl_unidade_medida u ';
			$sql .= 'ON p.unidade_medida = u.codigo ';
			$sql .= 'LEFT JOIN tbl_fornecedor f ';
			$sql .= 'ON p.fornecedor = f.codigo ';
			$sql .= "WHERE p.usuario = :usuario ";
			$sql .= $sql_pesquisa;
			$sql .= $sql_filtro;
			$sql .= $sql_intervalo;
			$sql .= $sql_order;
			$sql .= $sql_limit;
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(":$tipo_pesquisa", $pesquisa, PDO::PARAM_STR);
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "1.4.3", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function totalProduto($usuario, $pesquisa = '', $intervalo = '', $filtro = '')
		{
			$conn = Conexao::getConexao();
			
			$sql_pesquisa = '';
			$sql_filtro = '';
			$sql_intervalo = '';
			
			if($pesquisa)
			{
				$pesquisa .= '%';
				$sql_pesquisa = 'AND p.nome like :nome ';
			}	
			
			switch ($filtro) {
				case "vencidos":
					$sql_filtro = "AND p.data_validade < CURDATE() ";
					break;
				case "validade":
					$sql_filtro = "AND CURDATE() < (SELECT data_aviso_inicial FROM tbl_aviso_produto ap WHERE ap.produto = p.codigo) ";
					break;
				case "proximo":
					$sql_filtro = "AND CURDATE() >= (SELECT data_aviso_inicial FROM tbl_aviso_produto ap WHERE ap.produto = p.codigo) AND CURDATE() < p.data_validade ";
					break;
				case "notificacao":
					$sql_filtro = "AND p.status = 0 ";
					break;	
			}
			
			if(is_array($intervalo))
			{
				$sql_intervalo = "AND p.data_validade BETWEEN '".date("Y-m-d", strtotime(str_replace('/', '-', $intervalo['data_inicial'])))."' AND '".date("Y-m-d", strtotime(str_replace('/', '-', $intervalo['data_final'])))."'";
			}
			
			$sql  = 'SELECT * FROM tbl_produto p ';
			$sql .= 'WHERE p.usuario = :usuario ';
			$sql .= $sql_pesquisa;
			$sql .= $sql_filtro;
			$sql .= $sql_intervalo;
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				if($sql_pesquisa)
				$stmt->bindParam(':nome', $pesquisa, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->rowCount();
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "1.4.4", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}

		function menorDataValidade($usuario)
		{
			$conn = Conexao::getConexao();

			$sql = "SELECT min(data_validade) AS menorData FROM tbl_produto WHERE usuario = :usuario";

			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "1.4.5", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}

		function maiorDataValidade($usuario)
		{
			$conn = Conexao::getConexao();

			$sql = "SELECT max(data_validade) AS maiorData FROM tbl_produto WHERE usuario = :usuario";

			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "1.4.6", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}

		function gerarGrafico($usuario){
			$conn = Conexao::getConexao();

			$sql  = "SELECT ";
			$sql .= "(SELECT count(*) FROM tbl_produto p1 WHERE p1.usuario = :usuario AND p1.data_validade < CURDATE() AND p1.status = 1) as 'vencido', ";
			$sql .= "(SELECT count(*) FROM tbl_produto p2 WHERE p2.usuario = :usuario AND CURDATE() < ";
			$sql .= "(SELECT data_aviso_inicial FROM tbl_aviso_produto ap1 WHERE ap1.produto = p2.codigo) AND p2.status = 1) as 'validade', ";
			$sql .= "(SELECT count(*) FROM tbl_produto p3 WHERE p3.usuario = :usuario AND CURDATE() >= ";
			$sql .= "(SELECT data_aviso_inicial FROM tbl_aviso_produto ap2 WHERE ap2.produto = p3.codigo) AND CURDATE() < p3.data_validade AND p3.status = 1) as 'proximo'";
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "1.4.7", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
	}
?>