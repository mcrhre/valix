<?php
	include_once("Conexao.class.php");
	
	class AvisoHistoricoDAO{
		
		function insertAvisoHistorico($aviso)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'INSERT INTO tbl_aviso_historico ';
			$sql .= '(usuario, tipo_aviso, data, aviso_email_qtd, aviso_sms_qtd, url_hash, relatorio) ';
			$sql .= ' VALUES ';
			$sql .= '(:usuario, :tipo_aviso, :data, :aviso_email_qtd, :aviso_sms_qtd, :url_hash, :relatorio)';
			
			$usuario = $aviso->getUsuario();
			$tipo_aviso = $aviso->getTipoAviso();
			$data = date("Y-m-d",strtotime(str_replace('/','-', $aviso->getData())));
			$aviso_email = $aviso->getAvisoEmail();
			$aviso_sms = $aviso->getAvisoSMS();
			$relatorio = $aviso->getRelatorio();
			
			$url_hash = $this->gerarURLHash();
			
			if(strlen($url_hash) == 40)
			{				
				try
				{	
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
					$stmt = $conn->prepare($sql);
				
					$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
					$stmt->bindParam(':tipo_aviso', $tipo_aviso, PDO::PARAM_INT);
					$stmt->bindParam(':data', $data, PDO::PARAM_STR);
					$stmt->bindParam(':aviso_email_qtd', $aviso_email, PDO::PARAM_INT);
					$stmt->bindParam(':aviso_sms_qtd', $aviso_sms, PDO::PARAM_INT);
					$stmt->bindParam(':url_hash', $url_hash, PDO::PARAM_STR);
					$stmt->bindParam(':relatorio', $relatorio, PDO::PARAM_STR);
					
					$stmt->execute();
					
					$id_retorno = $conn->lastInsertId();
					
					$conn = null;
					
					return '{"codigo": "18.1.0", "id": "'.$id_retorno.'"}';
				}
				catch(PDOException $e)
				{
					$conn = null;
					
					return '{"codigo": "18.1.1", "mensagem": "Erro Insert"}';
					
					//return $sql . "<br>" . $e->getMessage();
				}
			}
			else
			{
				return $url_hash;
			}
		}
		
		
		function updateAvisoHistorico($aviso)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_aviso_historico SET ';
			$sql .= 'aviso_email_qtd = :aviso_email_qtd, ';
			$sql .= 'aviso_sms_qtd = :aviso_sms_qtd ';
			$sql .= 'WHERE codigo = :codigo';
			
			$codigo = $aviso->getCodigo();
			$aviso_email = $aviso->getAvisoEmail();
			$aviso_sms = $aviso->getAvisoSMS();
			
			try 
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':aviso_email_qtd', $aviso_email, PDO::PARAM_INT);
				$stmt->bindParam(':aviso_sms_qtd', $aviso_sms, PDO::PARAM_INT);
				$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return '{"codigo": "18.2.0", "id": "'.$codigo.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "18.2.1", "mensagem": "Erro Update"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function deleteAvisoHistorico($codigo, $usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'DELETE FROM tbl_aviso_historico ';
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
				
				return '{"codigo": "18.3.0", "id": "'.$codigo.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "18.3.1", "mensagem": "Erro Delete"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function deleteTudoAvisoHistorico($usuario, $tipo_aviso = '', $visualizou = '')
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'DELETE FROM tbl_aviso_historico ';
			$sql .= 'WHERE usuario = :usuario ';
			
			if($tipo_aviso)
			{
				$sql .= 'AND tipo_aviso = :tipo_aviso ';
			}

			if($visualizou)
			{
				$sql .= 'AND visualizou = :visualizou ';
			}
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				if($tipo_aviso)
				{
					$stmt->bindParam(':tipo_aviso', $tipo_aviso, PDO::PARAM_INT);
				}

				if($visualizou)
				{
					$stmt->bindParam(':visualizou', $visualizou, PDO::PARAM_INT);
				}
				
				$stmt->execute();
				
				$conn = null;
				
				return '{"codigo": "18.3.0", "id": "'.$codigo.'"}';
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "18.3.2", "mensagem": "Erro Delete"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectAvisoHistorico($usuario, $tipo_aviso = '', $visualizou = '')
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_aviso_historico ';
			$sql .= 'WHERE usuario = :usuario ';
			
			if($tipo_aviso)
			{
				$sql .= 'AND tipo_aviso = :tipo_aviso ';
			}

			if($visualizou != '')
			{
				$sql .= 'AND visualizou = :visualizou ';
			}

			$sql .= 'ORDER BY data DESC';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				if($tipo_aviso)
				{
					$stmt->bindParam(':tipo_aviso', $tipo_aviso, PDO::PARAM_INT);
				}

				if($visualizou != '')
				{
					$stmt->bindParam(':visualizou', $visualizou, PDO::PARAM_INT);
				}
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "18.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function verificaHistoricoExiste($usuario, $tipo_aviso, $data)
		{			
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_aviso_historico ';
			$sql .= 'WHERE usuario = :usuario ';
			$sql .= 'AND tipo_aviso = :tipo_aviso ';
			$sql .= 'AND data = :data';
			
			$data = date("Y-m-d",strtotime(str_replace('/','-', $data)));
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				$stmt->bindParam(':tipo_aviso', $tipo_aviso, PDO::PARAM_INT);
				$stmt->bindParam(':data', $data, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->rowCount();
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "18.4.2", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
			
		private function gerarURLHash()
		{
			$possibleChars  = 'abcdefghijklmnopqrstuvwxyz';
			$possibleChars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$possibleChars .= '0123456789';
			$possibleChars .= '$!&@?#';

			$url = '';

			for($i = 0; $i < 8; $i++) {
				$rand = rand(0, strlen($possibleChars) - 1);
				$url .= substr($possibleChars, $rand, 1);
			}
			
			$url_hash = sha1($url);
			
			//verifica se existe esse hash no banco
			
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_aviso_historico ';
			$sql .= 'WHERE url_hash = :url_hash ';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':url_hash', $url_hash, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$conn = null;
				
				$rows = $stmt->rowCount();
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "18.4.3", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
			
			if ($rows){
				return $this->gerarURLHash();
			}else{				
				return $url_hash;
			}
		}
		
		function selectURLHash($codigo, $usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT url_hash FROM tbl_aviso_historico ';
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
				
				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
				
				return $rs['url_hash'];
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "18.4.4", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectAvisoHistoricoHash($url_hash)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_aviso_historico ';
			$sql .= 'WHERE url_hash = :url_hash ';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':url_hash', $url_hash, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "18.4.5", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}

		function selectAvisoLeitura($usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_aviso_historico ';
			$sql .= 'WHERE usuario = :usuario ';
			$sql .= 'AND visualizou = 0';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->rowCount();
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "18.4.6", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}

		function updateAvisoLido($url_hash)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_aviso_historico SET ';
			$sql .= 'visualizou = 1 ';
			$sql .= 'WHERE url_hash = :url_hash';
						
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':url_hash', $url_hash, PDO::PARAM_STR);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->rowCount();
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "18.2.2", "mensagem": "Erro Update"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
	}
?>