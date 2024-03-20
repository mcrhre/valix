<?php
	include_once("Conexao.class.php");
	include_once("Funcao.class.php");
	
	class UsuarioDAO{
		
		function insertUsuario($usr)
		{
			$conn = Conexao::getConexao();
						
			$conf = $this->verificaUsuarioExiste($usr->getUsuario());
			
			if (!$conf)
			{
				$sql  = 'INSERT INTO tbl_usuario (usuario, senha) VALUES (:usuario, :senha)';
				
				$usuario = $usr->getUsuario();
				$senha   = Funcao::criptografarSenha($usr->getSenha());
				
				try 
				{
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					$stmt = $conn->prepare($sql);
					
					$stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
					$stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
					
					$stmt->execute();
					
					$id_retorno = $conn->lastInsertId();
					
					$conn = null;
					
					return '{"codigo": "7.1.0", "id": "'.$id_retorno.'"}';
				}
				catch(PDOException $e)
				{
					$conn = null;
					
					return '{"codigo": "7.1.1", "mensagem": "Erro Insert"}';
					
					//return $sql . "<br>" . $e->getMessage();
				}
			}

			return '{"codigo": "7.1.2", "mensagem": "Existe Insert"}';
		}
		
		function updateUsuario($usr, $param)
		{
			$conn = Conexao::getConexao();
			
			$conf = $this->verificaUsuarioExiste($usr->getUsuario());
			
			if (!$conf)
			{
				$sql = 'UPDATE tbl_usuario SET ';

				if($param == 1){
					$sql .= 'senha = :senha ';		
				}else{
					$sql .= 'usuario = :usuario ';
				}
			
				$sql .= 'WHERE codigo = :codigo';

				$codigo  = $usr->getCodigo();
				
				if($param == 1){
					$senha = Funcao::criptografarSenha($usr->getSenha());
				}else{
					$usuario = $usr->getUsuario();
				}
				
				try
				{
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					$stmt = $conn->prepare($sql);	
					
					if($param == 1){
						$stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
					}else{
						$stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
					}
					
					$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
					
					$stmt->execute();
					
					$conn = null;
					
					return '{"codigo": "7.2.0", "id": "'.$codigo.'"}';
				}
				catch(PDOException $e)
				{
					$conn = null;
					
					return '{"codigo": "7.2.1", "mensagem": "Erro Update"}';
					
					//return $sql . "<br>" . $e->getMessage();
				}
			}

			return '{"codigo": "7.2.2", "mensagem": "Existe Update"}';	
		}
		
		function deleteUsuario($codigo)
		{
			$conn = Conexao::getConexao();
			
			$sql = 'DELETE FROM tbl_usuario WHERE codigo = :codigo';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return '{"codigo": "7.3.0", "id": "'.$codigo.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "7.3.1", "mensagem": "Erro Delete"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function verificaUsuario($usuario, $senha)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_usuario ';
			$sql .= 'WHERE usuario = :usuario ';
			$sql .= 'AND senha = :senha';
			
			$senha = Funcao::criptografarSenha($senha);
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
				$stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "7.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function verificaUsuarioExiste($usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_usuario ';
			$sql .= 'WHERE usuario = :usuario';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "7.4.2", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
	}
?>