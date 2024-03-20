<?php
	include_once("Conexao.class.php");
	
	class UsuarioCadastroDAO{
		
		function insertUsuarioCadastro($usr)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'INSERT INTO tbl_usuario_cadastro ';
			$sql .= '(usuario, nome, documento, telefone, celular, email, endereco, numero, ';
			$sql .= 'complemento, cep, bairro, cidade, estado, data_cadastro)';
			$sql .= ' VALUES ';
			$sql .= '(:usuario, :nome, :documento, :telefone, :celular, :email, :endereco, :numero, ';
			$sql .= ':complemento, :cep, :bairro, :cidade, :estado, :data_cadastro)';
	
			$usuario = $usr->getUsuario();
			$nome = $usr->getNome();
			$documento = $usr->getDocumento();
			$telefone = $usr->getTelefone();
			$celular = $usr->getCelular();
			$email = $usr->getEmail();
			$endereco = $usr->getEndereco();
			$numero = $usr->getNumero();
			$complemento = $usr->getComplemento();
			$cep = $usr->getCep();
			$bairro = $usr->getBairro();
			$cidade = $usr->getCidade();
			$estado = $usr->getEstado();
			$data_cadastro = $usr->getDataCadastro();
			
			try 
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
				$stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
				$stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
				$stmt->bindParam(':celular', $celular, PDO::PARAM_STR);
				$stmt->bindParam(':email', $email, PDO::PARAM_STR);
				$stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);
				$stmt->bindParam(':numero', $numero, PDO::PARAM_INT);
				$stmt->bindParam(':complemento', $complemento, PDO::PARAM_STR);
				$stmt->bindParam(':cep', $cep, PDO::PARAM_STR);
				$stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
				$stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
				$stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
				$stmt->bindParam(':data_cadastro', $data_cadastro, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$id_retorno = $conn->lastInsertId();
				
				$conn = null;
				
				return '{"codigo": "8.1.0", "id": "'.$id_retorno.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "8.1.1", "mensagem": "Erro Insert"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function updateUsuarioCadastro($usr)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_usuario_cadastro SET ';
			$sql .= 'nome = :nome, ';
			$sql .= 'documento = :documento, ';
			$sql .= 'telefone = :telefone, ';
			$sql .= 'celular = :celular, ';
			$sql .= 'email = :email, ';
			$sql .= 'endereco = :endereco, ';
			$sql .= 'numero = :numero, ';
			$sql .= 'complemento = :complemento, ';
			$sql .= 'cep = :cep, ';
			$sql .= 'bairro = :bairro, ';
			$sql .= 'cidade = :cidade, ';
			$sql .= 'estado = :estado ';
			$sql .= 'WHERE usuario = :usuario';
			
			$usuario = $usr->getUsuario();
			$nome = $usr->getNome();
			$documento = $usr->getDocumento();
			$telefone = $usr->getTelefone();
			$celular = $usr->getCelular();
			$email = $usr->getEmail();
			$endereco = $usr->getEndereco();
			$numero = $usr->getNumero();
			$complemento = $usr->getComplemento();
			$cep = $usr->getCep();
			$bairro = $usr->getBairro();
			$cidade = $usr->getCidade();
			$estado = $usr->getEstado();
			
			try 
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
				$stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
				$stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
				$stmt->bindParam(':celular', $celular, PDO::PARAM_STR);
				$stmt->bindParam(':email', $email, PDO::PARAM_STR);
				$stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);
				$stmt->bindParam(':numero', $numero, PDO::PARAM_INT);
				$stmt->bindParam(':complemento', $complemento, PDO::PARAM_STR);
				$stmt->bindParam(':cep', $cep, PDO::PARAM_STR);
				$stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
				$stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
				$stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$conn = null;
				
				return '{"codigo": "8.2.0", "id": "'.$usuario.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "8.2.1", "mensagem": "Erro Update"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function deleteUsuarioCadastro($usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql = 'DELETE FROM tbl_usuario_cadastro WHERE usuario = :usuario';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return '{"codigo": "8.3.0", "id": "'.$usuario.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "8.3.1", "mensagem": "Erro Delete"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectUsuarioCadastro($usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_usuario_cadastro ';
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
				
				return '{"codigo": "8.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
	}
?>