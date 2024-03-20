<?php
	include_once("Conexao.class.php");
	
	class UsuarioTelefoneDAO{
		
		function insertUsuarioTelefone($usr)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'INSERT INTO tbl_usuario_telefone (telefone, usuario) VALUES (:telefone, :usuario)';
			
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare($sql);
			
			$telefones = $usr->getTelefone();
			$usuario = $usr->getUsuario();
			
			foreach($telefones as $telefone)
			{
				$conf = $this->verificaUsuarioTelefone($usuario, $telefone);
				
				if (!$conf)
				{
					try
					{						
						$stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
						$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
						
						$stmt->execute();
						
						$conn = null;
					}
					catch(PDOException $e)
					{
						$conn = null;
						
						return '{"codigo": "11.1.1", "mensagem": "Erro Insert"}';
						
						//return $sql . "<br>" . $e->getMessage();
					}
				}
				else
				{
					return '{"codigo": "11.1.2", "mensagem": "Existe Insert"}';
				}	
			}	
			
			return '{"codigo": "11.1.0", "id": "'.$usuario.'"}';
		}
		
		function updateUsuarioTelefone($usr)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_usuario_telefone SET '; 
			$sql .= 'telefone = :telefone ';
			$sql .= 'WHERE codigo = :codigo ';
			$sql .= 'AND usuario = :usuario';
			
			$codigo = $usr->getCodigo();
			$telefone = $usr->getTelefone();
			$usuario = $usr->getUsuario();
			
			$conf = $this->verificaUsuarioTelefone($usuario, $telefone);
				
			if (!$conf)
			{
				try 
				{
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					$stmt = $conn->prepare($sql);
					
					$stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
					$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
					$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
					
					$stmt->execute();
					
					$conn = null;
					
					return '{"codigo": "11.2.0", "id": "'.$codigo.'"}';
				}
				catch(PDOException $e)
				{
					$conn = null;
					
					return '{"codigo": "11.2.1", "mensagem": "Erro Update"}';
					
					//return $sql . "<br>" . $e->getMessage();
				}
			}

			return '{"codigo": "11.2.2", "mensagem": "Existe Update"}';
		}
		
		function deleteUsuarioTelefone($usuario, $codigo = '')
		{
			$conn = Conexao::getConexao();
		
			$sql_codigo = '';
			
			if($codigo){
				$sql_codigo = 'AND codigo = :codigo';
			}
			
			$sql  = 'DELETE FROM tbl_usuario_telefone ';
			$sql .= 'WHERE usuario = :usuario ';
			$sql .= $sql_codigo;
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				if($sql_codigo)
				$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				if($codigo){
					return '{"codigo": "11.3.0", "id": "'.$codigo.'"}';
				}else{
					return '{"codigo": "11.3.0", "id": "'.$usuario.'"}';
				}	
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "11.3.1", "mensagem": "Erro Delete"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectUsuarioTelefone($usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_usuario_telefone ';
			$sql .= 'WHERE usuario = :usuario ';
			
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
				
				return '{"codigo": "11.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		private function verificaUsuarioTelefone($usuario, $telefone)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_usuario_telefone ';
			$sql .= 'WHERE telefone = :telefone ';
			$sql .= 'AND usuario = :usuario';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->rowCount();
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return 2;
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
	}
?>