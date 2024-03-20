<?php
	include_once("Conexao.class.php");
	
	class UsuarioConfigDAO{
		
		function insertUsuarioConfig($usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'INSERT INTO tbl_usuario_config (usuario) VALUES (:usuario)';
			
			try 
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$id_retorno = $conn->lastInsertId();
				
				$conn = null;
				
				return '{"codigo": "9.1.0", "id": "'.$id_retorno.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "9.1.1", "mensagem": "Erro Insert"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function updateUsuarioConfig($usr)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_usuario_config SET ';
			$sql .= 'aviso_validade = :aviso_validade, ';
			$sql .= 'tipo_aviso_validade = :tipo_aviso_validade, ';
			$sql .= 'aviso_vencido = :aviso_vencido, ';
			$sql .= 'tipo_aviso_vencido = :tipo_aviso_vencido, ';
			$sql .= 'aviso_periodo = :aviso_periodo, ';
			$sql .= 'tipo_aviso_periodo = :tipo_aviso_periodo, ';
			$sql .= 'receber_sms_periodo = :receber_sms_periodo, ';
			$sql .= 'receber_email_periodo = :receber_email_periodo, ';
			$sql .= 'receber_sms_validade = :receber_sms_validade, ';
			$sql .= 'receber_email_validade = :receber_email_validade, ';
			$sql .= 'receber_aviso_periodo = :receber_aviso_periodo ';
			$sql .= 'WHERE usuario = :usuario';
			
			$aviso_validade = $usr->getAvisoValidade();
			$aviso_vencido = $usr->getAvisoVencido();
			$aviso_periodo = $usr->getAvisoPeriodo();
			$tipo_aviso_validade = $usr->getTipoAvisoValidade();
			$tipo_aviso_vencido = $usr->getTipoAvisoVencido();
			$tipo_aviso_periodo = $usr->getTipoAvisoPeriodo();
			$receber_sms_periodo = ($usr->getReceberSmsPeriodo() == '' ? 0 : $usr->getReceberSmsPeriodo());
			$receber_email_periodo = ($usr->getReceberEmailPeriodo() == '' ? 0 : $usr->getReceberEmailPeriodo());
			$receber_sms_validade = ($usr->getReceberSmsValidade() == '' ? 0 : $usr->getReceberSmsValidade());
			$receber_email_validade = ($usr->getReceberEmailValidade() == '' ? 0 : $usr->getReceberEmailValidade());
			$receber_aviso_periodo = ($usr->getReceberAvisoPeriodo() == '' ? 0 : $usr->getReceberAvisoPeriodo());
			
			$usuario = $usr->getUsuario();
			
			try 
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':aviso_validade', $aviso_validade, PDO::PARAM_INT);
				$stmt->bindParam(':aviso_vencido', $aviso_vencido, PDO::PARAM_INT);
				$stmt->bindParam(':aviso_periodo', $aviso_periodo, PDO::PARAM_INT);
				$stmt->bindParam(':tipo_aviso_validade', $tipo_aviso_validade, PDO::PARAM_INT);
				$stmt->bindParam(':tipo_aviso_vencido', $tipo_aviso_vencido, PDO::PARAM_INT);
				$stmt->bindParam(':tipo_aviso_periodo', $tipo_aviso_periodo, PDO::PARAM_INT);
				$stmt->bindParam(':receber_sms_periodo', $receber_sms_periodo, PDO::PARAM_INT);
				$stmt->bindParam(':receber_email_periodo', $receber_email_periodo, PDO::PARAM_INT);
				$stmt->bindParam(':receber_sms_validade', $receber_sms_validade, PDO::PARAM_INT);
				$stmt->bindParam(':receber_email_validade', $receber_email_validade, PDO::PARAM_INT);
				$stmt->bindParam(':receber_aviso_periodo', $receber_aviso_periodo, PDO::PARAM_INT);
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return '{"codigo": "9.2.0", "id": "'.$usuario.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "9.2.1", "mensagem": "Erro Update"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function deleteUsuarioConfig($usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql = 'DELETE FROM tbl_usuario_config WHERE usuario = :usuario';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return '{"codigo": "9.3.0", "id": "'.$usuario.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "9.3.1", "mensagem": "Erro Delete"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectUsuarioConfig($usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_usuario_config ';
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
				
				return '{"codigo": "9.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
	}
?>