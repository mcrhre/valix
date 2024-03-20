<?php
	include_once("Conexao.class.php");
	
	class CampoRelConfigDAO{
		
		function insertCampoRelConfig($usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'INSERT INTO tbl_campo_rel_config (usuario) VALUES (:usuario)';
			
			try 
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$id_retorno = $conn->lastInsertId();
				
				$conn = null;
				
				return '{"codigo": "20.1.0", "id": "'.$id_retorno.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "20.1.1", "mensagem": "Erro Insert"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function updateCampoRelConfig($campo)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_campo_rel_config SET ';
			$sql .= 'c_marca = :c_marca, ';
			$sql .= 'c_categoria = :c_categoria, ';
			$sql .= 'c_subcategoria = :c_subcategoria, ';
			$sql .= 'c_status = :c_status, ';
			$sql .= 'c_preco_custo = :c_preco_custo, ';
			$sql .= 'c_quantidade = :c_quantidade, ';
			$sql .= 'c_data_validade = :c_data_validade, ';
			$sql .= 'c_data_cadastro = :c_data_cadastro, ';
			$sql .= 'c_fornecedor = :c_fornecedor, ';
			$sql .= 'c_localizacao = :c_localizacao, ';
			$sql .= 'c_lote = :c_lote, ';
			$sql .= 'c_descricao = :c_descricao ';
			$sql .= 'WHERE usuario = :usuario';
			
			$c_marca = ($campo->getCMarca() == '' ? 0 : $campo->getCMarca());
			$c_categoria = ($campo->getCCategoria() == '' ? 0 : $campo->getCCategoria());
			$c_subcategoria = ($campo->getCSubcategoria() == '' ? 0 : $campo->getCSubcategoria());
			$c_status = ($campo->getCStatus() == '' ? 0 : $campo->getCStatus());
			$c_preco_custo = ($campo->getCPrecoCusto() == '' ? 0 : $campo->getCPrecoCusto());
			$c_quantidade = ($campo->getCQuantidade() == '' ? 0 : $campo->getCQuantidade());
			$c_data_validade = ($campo->getCDataValidade() == '' ? 0 : $campo->getCDataValidade());
			$c_data_cadastro = ($campo->getCDataCadastro() == '' ? 0 : $campo->getCDataCadastro());
			$c_fornecedor = ($campo->getCFornecedor() == '' ? 0 : $campo->getCFornecedor());
			$c_localizacao = ($campo->getCLocalizacao() == '' ? 0 : $campo->getCLocalizacao());
			$c_lote = ($campo->getCLote() == '' ? 0 : $campo->getCLote());
			$c_descricao = ($campo->getCDescricao() == '' ? 0 : $campo->getCDescricao());
			
			$usuario = $campo->getUsuario();
		
			try 
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':c_marca', $c_marca, PDO::PARAM_INT);
				$stmt->bindParam(':c_categoria', $c_categoria, PDO::PARAM_INT);
				$stmt->bindParam(':c_subcategoria', $c_subcategoria, PDO::PARAM_INT);
				$stmt->bindParam(':c_status', $c_status, PDO::PARAM_INT);
				$stmt->bindParam(':c_preco_custo', $c_preco_custo, PDO::PARAM_INT);
				$stmt->bindParam(':c_quantidade', $c_quantidade, PDO::PARAM_INT);
				$stmt->bindParam(':c_data_validade', $c_data_validade, PDO::PARAM_INT);
				$stmt->bindParam(':c_data_cadastro', $c_data_cadastro, PDO::PARAM_INT);
				$stmt->bindParam(':c_fornecedor', $c_fornecedor, PDO::PARAM_INT);
				$stmt->bindParam(':c_localizacao', $c_localizacao, PDO::PARAM_INT);
				$stmt->bindParam(':c_lote', $c_lote, PDO::PARAM_INT);
				$stmt->bindParam(':c_descricao', $c_descricao, PDO::PARAM_INT);
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return '{"codigo": "20.2.0", "id": "'.$usuario.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "20.2.1", "mensagem": "Erro Update"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function deleteCampoRelConfig($usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql = 'DELETE FROM tbl_campo_rel_config WHERE usuario = :usuario';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return '{"codigo": "20.3.0", "id": "'.$usuario.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "20.3.1", "mensagem": "Erro Delete"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectCampoRelConfig($usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_campo_rel_config ';
			$sql .= 'WHERE usuario = :usuario ';
			
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
				
				return '{"codigo": "20.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
	}
?>