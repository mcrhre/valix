<?php
	include_once("Conexao.class.php");
	
	class AvisoPeriodicoDAO{
		
		function insertAvisoPeriodico($aviso)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'INSERT INTO tbl_aviso_periodico ';
			$sql .= '(usuario, data_aviso_ultimo, data_aviso_proximo) ';
			$sql .= ' VALUES ';
			$sql .= '(:usuario, :data_aviso_ultimo, :data_aviso_proximo)';
			
			$usuario = $aviso->getUsuario();
			$data_aviso_ultimo = $aviso->getDataAvisoUltimo();
			$data_aviso_proximo = $aviso->getDataAvisoProximo();
			
			try
			{	
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
				$stmt = $conn->prepare($sql);
			
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				$stmt->bindParam(':data_aviso_ultimo', $data_aviso_ultimo, PDO::PARAM_STR);
				$stmt->bindParam(':data_aviso_proximo', $data_aviso_proximo, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$id_retorno = $conn->lastInsertId();
				
				$conn = null;
				
				return '{"codigo": "21.1.0", "id": "'.$id_retorno.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "21.1.1", "mensagem": "Erro Insert"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function updateAvisoPeriodico($aviso)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_aviso_periodico SET '; 
			$sql .= 'data_aviso_ultimo = :data_aviso_ultimo, ';
			$sql .= 'data_aviso_proximo = :data_aviso_proximo ';
			$sql .= 'WHERE usuario = :usuario';
			
			$usuario = $aviso->getUsuario();
			$data_aviso_ultimo = $aviso->getDataAvisoUltimo();
			$data_aviso_proximo = $aviso->getDataAvisoProximo();
			
			try 
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				$stmt->bindParam(':data_aviso_ultimo', $data_aviso_ultimo, PDO::PARAM_STR);
				$stmt->bindParam(':data_aviso_proximo', $data_aviso_proximo, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$conn = null;
				
				return '{"codigo": "21.2.0", "id": "'.$usuario.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "21.2.1", "mensagem": "Erro Update"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectAvisoPeriodico($usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_aviso_periodico ';
			$sql .= 'WHERE usuario = :usuario';
			
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
				
				return '{"codigo": "21.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
	}
?>