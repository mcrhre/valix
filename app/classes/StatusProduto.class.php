<?php		
	include_once("Conexao.class.php");

	class StatusProduto{

		function verificaStatus()
		{
			$conn = Conexao::getConexao();

			$sql  = 'UPDATE tbl_produto ';
			$sql .= 'SET status = 0 ';
			$sql .= 'WHERE codigo ';
			$sql .= 'IN(SELECT produto ';
			$sql .= 'FROM tbl_aviso_produto ';
			$sql .= 'WHERE CURDATE() >= data_aviso_final)';

			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		

				$stmt = $conn->query($sql);

				$conn = null;

				return '{"codigo": "23.2.0", "id": "0"}';
			}
			catch(PDOException $e)
			{
				$conn = null;

				return '{"codigo": "23.2.1", "mensagem": "Erro Update"}';

				//return $sql . "<br>" . $e->getMessage();
			}		
		}	
	}
?>