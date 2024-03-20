<?php
	include_once("Conexao.class.php");
	
	class FornecedorDAO{
		
		function insertFornecedor($fornecedor)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'INSERT INTO tbl_fornecedor (nome, usuario) VALUES (:nome, :usuario)';
			
			$nome = $fornecedor->getNome();
			$usuario = $fornecedor->getUsuario();
			
			$conf = $this->verificaFornecedor($usuario, $nome);
			
			if (!$conf)
			{
				try 
				{
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					$stmt = $conn->prepare($sql);
					
					$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
					$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
					
					$stmt->execute();
					
					$id_retorno = $conn->lastInsertId();
					
					$conn = null;
					
					return '{"codigo": "6.1.0", "id": "'.$id_retorno.'"}';
				}
				catch(PDOException $e)
				{
					$conn = null;
					
					return '{"codigo": "6.1.1", "mensagem": "Erro Insert"}';
					
					//return $sql . "<br>" . $e->getMessage();
				}
			}
			
			return '{"codigo": "6.1.2", "mensagem": "Existe Insert"}';
		}
		
		function updateFornecedor($fornecedor)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_fornecedor SET '; 
			$sql .= 'nome = :nome ';
			$sql .= 'WHERE codigo = :codigo ';
			$sql .= 'AND usuario = :usuario';
			
			$codigo = $fornecedor->getCodigo();
			$nome = $fornecedor->getNome();
			$usuario = $fornecedor->getUsuario();

			$conf = $this->verificaFornecedor($usuario, $nome);
			
			if (!$conf)
			{
				try 
				{
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					$stmt = $conn->prepare($sql);
					
					$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
					$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
					$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
					
					$stmt->execute();
					
					$conn = null;
					
					return '{"codigo": "6.2.0", "id": "'.$codigo.'"}';
				}
				catch(PDOException $e)
				{
					$conn = null;
					
					return '{"codigo": "6.2.1", "mensagem": "Erro Update"}';
					
					//return $sql . "<br>" . $e->getMessage();
				}
			}

			return '{"codigo": "6.2.2", "mensagem": "Existe Update"}';	
		}
		
		function deleteFornecedor($codigo, $usuario)
		{
			$conf = 0;
			
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_produto SET ';
			$sql .= 'fornecedor = NULL ';
			$sql .= 'WHERE fornecedor = :codigo ';
			$sql .= 'AND usuario = :usuario';
			
			try 
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				$conf = 1;
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "6.3.1", "mensagem": "Erro Delete"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
			
			if($conf)
			{
				$conn = Conexao::getConexao();
				
				$sql  = 'DELETE FROM tbl_fornecedor ';
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
					
					return '{"codigo": "6.3.0", "id": "'.$codigo.'"}';
				}
				catch(PDOException $e)
				{
					$conn = null;
					
					return '{"codigo": "6.3.2", "mensagem": "Erro Delete"}';
					
					//return $sql . "<br>" . $e->getMessage();
				}
			}
		}
		
		function selectFornecedor($usuario,  $organizar = '', $limite = '')
		{
			$conn = Conexao::getConexao();
			
			$sql_order = '';
			$sql_limit = '';
			
			switch ($organizar) {
				case "Z-A":
					$sql_order = "ORDER BY nome DESC ";
					break;
				case "A-Z":
				default:
					$sql_order = "ORDER BY nome ";
				break;
			}
			
			if(is_array($limite))
			{
				$sql_limit = 'LIMIT '.$limite['inicio']. ', '.$limite['fim'];
			}
			
			$sql  = 'SELECT * FROM tbl_fornecedor ';
			$sql .= 'WHERE usuario = :usuario ';
			$sql .= $sql_order;
			$sql .= $sql_limit;
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetchAll();
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "6.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectFornecedorId($codigo, $usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_fornecedor ';
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
				
				return '{"codigo": "6.4.2", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function pesquisaFornecedor($usuario, $pesquisa,  $organizar = '', $limite = '')
		{
			$conn = Conexao::getConexao();
			
			$pesquisa .= '%';
			
			$sql_order = '';
			$sql_limit = '';
			
			switch ($organizar) {
				case "Z-A":
					$sql_order = "ORDER BY nome DESC ";
					break;
				case "A-Z":
				default:
					$sql_order = "ORDER BY nome ";
				break;
			}
			
			if(is_array($limite))
			{
				$sql_limit = 'LIMIT '.$limite['inicio']. ', '.$limite['fim'];
			}
			
			$sql  = 'SELECT * FROM tbl_fornecedor ';
			$sql .= 'WHERE usuario = :usuario ';
			$sql .= 'AND nome like :nome ';
			$sql .= $sql_order;
			$sql .= $sql_limit;
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				$stmt->bindParam(':nome', $pesquisa, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetchAll();
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "6.4.3", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		private function verificaFornecedor($usuario, $nome)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_fornecedor ';
			$sql .= 'WHERE nome = :nome ';
			$sql .= 'AND usuario = :usuario';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->rowCount();
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return 2;
				
				return $sql . "<br>" . $e->getMessage();
			}
		}
		
		public function totalFornecedor($usuario, $pesquisa = '')
		{
			$conn = Conexao::getConexao();
			
			$sql_like = '';
			
			if($pesquisa)
			{
				$pesquisa .= '%';
				$sql_like = 'AND nome like :nome';
			}	
			
			$sql  = 'SELECT * FROM tbl_fornecedor ';
			$sql .= 'WHERE usuario = :usuario ';
			$sql .= $sql_like;
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				if($sql_like)
				$stmt->bindParam(':nome', $pesquisa, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->rowCount();
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "6.4.4", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
	}
?>