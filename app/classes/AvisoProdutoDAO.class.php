<?php
	include_once("Conexao.class.php");
	
	class AvisoProdutoDAO{
		
		function insertAvisoProduto($aviso)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'INSERT INTO tbl_aviso_produto ';
			$sql .= '(usuario, produto, data_aviso_inicial, data_aviso_final) ';
			$sql .= ' VALUES ';
			$sql .= '(:usuario, :produto, :data_aviso_inicial, :data_aviso_final)';
			
			$usuario = $aviso->getUsuario();
			$produto = $aviso->getProduto();
			$data_aviso_inicial = $aviso->getDataAvisoInicial();
			$data_aviso_final = $aviso->getDataAvisoFinal();
			
			try
			{	
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
				$stmt = $conn->prepare($sql);
			
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				$stmt->bindParam(':produto', $produto, PDO::PARAM_INT);
				$stmt->bindParam(':data_aviso_inicial', $data_aviso_inicial, PDO::PARAM_STR);
				$stmt->bindParam(':data_aviso_final', $data_aviso_final, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$id_retorno = $conn->lastInsertId();
				
				$conn = null;
				
				return '{"codigo": "13.1.0", "id": "'.$id_retorno.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "13.1.1", "mensagem": "Erro Insert"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function updateAvisoProduto($aviso)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_aviso_produto SET '; 
			$sql .= 'data_aviso_inicial = :data_aviso_inicial, ';
			$sql .= 'data_aviso_final = :data_aviso_final ';
			$sql .= 'WHERE produto = :produto ';
			$sql .= 'AND usuario = :usuario';
			
			$usuario = $aviso->getUsuario();
			$produto = $aviso->getProduto();
			$data_aviso_inicial = $aviso->getDataAvisoInicial();
			$data_aviso_final = $aviso->getDataAvisoFinal();
			
			try 
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				$stmt->bindParam(':produto', $produto, PDO::PARAM_INT);
				$stmt->bindParam(':data_aviso_inicial', $data_aviso_inicial, PDO::PARAM_STR);
				$stmt->bindParam(':data_aviso_final', $data_aviso_final, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$conn = null;
				
				return '{"codigo": "13.2.0", "id": "'.$codigo.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "13.2.1", "mensagem": "Erro Update"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectAvisoProduto($produto)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_aviso_produto ';
			$sql .= 'WHERE produto = :produto ';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':produto', $produto, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "13.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
	}
?>