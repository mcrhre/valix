<?php
	include_once("Conexao.class.php");
	
	class UsuarioEmailDAO{
		
		function insertUsuarioEmail($usr)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'INSERT INTO tbl_usuario_email (email, usuario) VALUES (:email, :usuario)';
		
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare($sql);
			
			$emails = $usr->getEmail();
			$usuario = $usr->getUsuario();
			
			foreach($emails as $email)
			{
				$conf = $this->verificaUsuarioEmail($usuario, $email);
				
				if (!$conf)
				{
					try
					{
						$stmt->bindParam(':email', $email, PDO::PARAM_STR);
						$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
						
						$stmt->execute();
						
						$conn = null;
					}
					catch(PDOException $e)
					{
						$conn = null;
						
						return '{"codigo": "10.1.1", "mensagem": "Erro Insert"}';
						
						//return $sql . "<br>" . $e->getMessage();
					}
				}
				else
				{
					return '{"codigo": "10.1.2", "mensagem": "Existe Insert"}';
				}				
			}
			
			return '{"codigo": "10.1.0", "id": "'.$usuario.'"}';
		}
		
		function updateUsuarioEmail($usr)
		{
			$conn = Conexao::getConexao();

			$sql  = 'UPDATE tbl_usuario_email SET '; 
			$sql .= 'email = :email ';
			$sql .= 'WHERE codigo = :codigo ';
			$sql .= 'AND usuario = :usuario';
			
			$codigo = $usr->getCodigo();
			$email = $usr->getEmail();
			$usuario = $usr->getUsuario();

			$conf = $this->verificaUsuarioEmail($usuario, $email);
				
			if (!$conf)
			{
				try 
				{
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					$stmt = $conn->prepare($sql);
					
					$stmt->bindParam(':email', $email, PDO::PARAM_STR);
					$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
					$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
					
					$stmt->execute();
					
					$conn = null;
					
					return '{"codigo": "10.2.0", "id": "'.$codigo.'"}';
				}
				catch(PDOException $e)
				{
					$conn = null;
					
					return '{"codigo": "10.2.1", "mensagem": "Erro Update"}';
					
					//return $sql . "<br>" . $e->getMessage();
				}
			}

			return '{"codigo": "10.2.2", "mensagem": "Existe Update"}';
		}
		
		function deleteUsuarioEmail($usuario, $codigo = '')
		{			
			$conn = Conexao::getConexao();
		
			$sql_codigo = '';
			
			if($codigo){
				$sql_codigo = 'AND codigo = :codigo';
			}
			
			$sql  = 'DELETE FROM tbl_usuario_email ';
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
				
				if($codigo)
				{
					return '{"codigo": "10.3.0", "id": "'.$codigo.'"}';
				}
				else
				{
					return '{"codigo": "10.3.0", "id": "'.$usuario.'"}';
				}	
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "10.3.1", "mensagem": "Erro Delete"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectUsuarioEmail($usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_usuario_email ';
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
				
				return '{"codigo": "10.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		private function verificaUsuarioEmail($usuario, $email)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_usuario_email ';
			$sql .= 'WHERE email = :email ';
			$sql .= 'AND usuario = :usuario';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':email', $email, PDO::PARAM_STR);
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