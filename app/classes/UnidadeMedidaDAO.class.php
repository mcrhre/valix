<?php
	include_once("Conexao.class.php");
	
	class UnidadeMedidaDAO{
		
		function insertUnidadeMedida($tipo_quantidade)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'INSERT INTO tbl_unidade_medida (nome, usuario) VALUES (:nome, :usuario)';
			
			$nome = $tipo_quantidade->getNome();
			$usuario = $tipo_quantidade->getUsuario();
			
			$conf = $this->verificaUnidadeMedida($usuario, $nome);
			
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
					
					return '{"codigo": "5.1.0", "id": "'.$id_retorno.'"}';
				}
				catch(PDOException $e)
				{
					$conn = null;
					
					return '{"codigo": "5.1.1", "mensagem": "Erro Insert"}';
					
					//return $sql . "<br>" . $e->getMessage();
				}
			}
			
			return '{"codigo": "5.1.2", "mensagem": "Existe Insert"}';
		}
		
		function updateUnidadeMedida($unidade_medida)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_unidade_medida SET '; 
			$sql .= 'nome = :nome ';
			$sql .= 'WHERE codigo = :codigo ';
			$sql .= 'AND usuario = :usuario';
			
			$codigo = $unidade_medida->getCodigo();
			$nome = $unidade_medida->getNome();
			$usuario = $unidade_medida->getUsuario();
			
			$conf = $this->verificaUnidadeMedida($usuario, $nome);
			
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
					
					return '{"codigo": "5.2.0", "id": "'.$codigo.'"}';
				}
				catch(PDOException $e)
				{
					$conn = null;
					
					return '{"codigo": "5.2.1", "mensagem": "Erro Update"}';
					
					//return $sql . "<br>" . $e->getMessage();
				}
			}
			
			return '{"codigo": "5.2.2", "mensagem": "Existe Update"}';	
		}
		
		function deleteUnidadeMedida($codigo, $usuario)
		{
			$conf = 0;
			
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_produto SET ';
			$sql .= 'unidade_medida = ';
			$sql .= '(SELECT codigo FROM tbl_unidade_medida ';
			$sql .= "WHERE LOWER(nome) = 'unidade' ";
			$sql .= 'AND usuario = :usuario LIMIT 1) ';
			$sql .= 'WHERE unidade_medida = :codigo ';
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
				
				return '{"codigo": "5.3.1", "mensagem": "Erro Delete"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
			
			if($conf)
			{
				$conn = Conexao::getConexao();
				
				$sql  = 'DELETE FROM tbl_unidade_medida ';
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
					
					return '{"codigo": "5.3.0", "id": "'.$codigo.'"}';
				}
				catch(PDOException $e)
				{
					$conn = null;
					
					return '{"codigo": "5.3.2", "mensagem": "Erro Delete"}';
					
					//return $sql . "<br>" . $e->getMessage();
				}
			}
		}
		
		function selectUnidadeMedida($usuario, $organizar = '', $limite = '', $unidade = 0)
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
			
			$sql  = 'SELECT * FROM tbl_unidade_medida ';
			$sql .= 'WHERE usuario = :usuario ';
			$sql .= ($unidade)? "AND nome <> 'unidade' ": '';
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
				
				return '{"codigo": "5.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectUnidadeMedidaId($codigo, $usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_unidade_medida ';
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
				
				return '{"codigo": "5.4.2", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function pesquisaUnidadeMedida($usuario, $pesquisa, $organizar = '', $limite = '', $unidade = 0)
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
			
			$sql  = 'SELECT * FROM tbl_unidade_medida ';
			$sql .= 'WHERE usuario = :usuario ';
			$sql .= 'AND nome like :nome ';
			$sql .= ($unidade)? "AND nome <> 'unidade' ": '';
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
				
				return '{"codigo": "5.4.3", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		private function verificaUnidadeMedida($usuario, $nome)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_unidade_medida ';
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
		
		public function totalUnidadeMedida($usuario, $pesquisa = '')
		{
			$conn = Conexao::getConexao();
			
			$sql_like = '';
			
			if($pesquisa)
			{
				$pesquisa .= '%';
				$sql_like = 'AND nome like :nome';
			}	
			
			$sql  = 'SELECT * FROM tbl_unidade_medida ';
			$sql .= 'WHERE usuario = :usuario ';
			$sql .= "AND nome <> 'unidade' ";
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
				
				return '{"codigo": "5.4.4", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
	}
?>