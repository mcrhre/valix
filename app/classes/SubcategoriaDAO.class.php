<?php
	include_once("Conexao.class.php");
	
	class SubcategoriaDAO{
		
		function insertSubcategoria($subcategoria)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'INSERT INTO tbl_subcategoria (nome, categoria, usuario) ';
			$sql .= 'VALUES (:nome, :categoria, :usuario)';
			
			$nome = $subcategoria->getNome();
			$categoria = $subcategoria->getCategoria();
			$usuario = $subcategoria->getUsuario();
			
			$conf = $this->verificaSubcategoria($usuario, $nome, $categoria);
			
			if (!$conf)
			{
				try 
				{
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					$stmt = $conn->prepare($sql);
					
					$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
					$stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
					$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
					
					$stmt->execute();
					
					$id_retorno = $conn->lastInsertId();
					
					$conn = null;
					
					return '{"codigo": "4.1.0", "id": "'.$id_retorno.'"}';
				}
				catch(PDOException $e)
				{
					$conn = null;
					
					return '{"codigo": "4.1.1", "mensagem": "Erro Insert"}';
					
					//return $sql . "<br>" . $e->getMessage();
				}
			}
			
			return '{"codigo": "4.1.2", "mensagem": "Existe Insert"}';
		}
		
		function updateSubcategoria($subcategoria)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_subcategoria SET '; 
			$sql .= 'nome = :nome, ';
			$sql .= 'categoria = :categoria ';
			$sql .= 'WHERE codigo = :codigo ';
			$sql .= 'AND usuario = :usuario';
			
			$codigo = $subcategoria->getCodigo();
			$categoria = $subcategoria->getCategoria();
			$nome = $subcategoria->getNome();
			$usuario = $subcategoria->getUsuario();

			$conf = $this->verificaSubcategoria($usuario, $nome, $categoria);
			
			if (!$conf)
			{
				try 
				{
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					$stmt = $conn->prepare($sql);
					
					$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
					$stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
					$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
					$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
					
					$stmt->execute();
					
					$conn = null;
					
					return '{"codigo": "4.2.0", "id": "'.$codigo.'"}';
				}
				catch(PDOException $e)
				{
					$conn = null;
					
					return '{"codigo": "4.2.1", "mensagem": "Erro Update"}';
					
					//return $sql . "<br>" . $e->getMessage();
				}
			}
			
			return '{"codigo": "4.2.2", "mensagem": "Existe Update"}';	
		}
		
		function deleteSubcategoria($codigo, $usuario)
		{
			$conf = 0;
			
			$conn = Conexao::getConexao();
			
			$sql  = 'UPDATE tbl_produto SET ';
			$sql .= 'subcategoria = NULL ';
			$sql .= 'WHERE subcategoria = :codigo ';
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
				
				return '{"codigo": "4.3.1", "mensagem": "Erro Delete"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
			
			if($conf)
			{
				$conn = Conexao::getConexao();
				
				$sql  = 'DELETE FROM tbl_subcategoria ';
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
					
					return '{"codigo": "4.3.0", "id": "'.$codigo.'"}';
				}
				catch(PDOException $e)
				{
					$conn = null;
					
					return '{"codigo": "4.3.2", "mensagem": "Erro Delete"}';
					
					//return $sql . "<br>" . $e->getMessage();
				}
			}
		}
		
		function selectSubcategoria($usuario, $organizar = '', $limite = '')
		{
			$conn = Conexao::getConexao();
			
			$sql_order = '';
			$sql_limit = '';
			
			switch ($organizar) {
				case "Z-A":
					$sql_order = "ORDER BY sc.nome DESC ";
					break;
				case "A-Z":
				default:
					$sql_order = "ORDER BY sc.nome ";
				break;
			}
			
			if(is_array($limite))
			{
				$sql_limit = 'LIMIT '.$limite['inicio']. ', '.$limite['fim'];
			}
			
			$sql  = 'SELECT sc.codigo, sc.nome, c.nome as categoria, c.codigo as categoria_id ';
			$sql .= 'FROM tbl_subcategoria sc ';
			$sql .= 'INNER JOIN tbl_categoria c ';
			$sql .= 'ON sc.categoria = c.codigo ';
			$sql .= 'WHERE c.usuario = :usuario ';
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
				
				return '{"codigo": "4.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectSubcategoriaId($codigo, $usuario, $organizar = '')
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_subcategoria ';
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
				
				return '{"codigo": "4.4.2", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function selectCategoriaId($categoria, $usuario)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_subcategoria ';
			$sql .= 'WHERE categoria = :categoria ';
			$sql .= 'AND usuario = :usuario';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetchAll();
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "4.4.4", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		function pesquisaSubcategoria($usuario, $tipo_pesquisa, $pesquisa, $organizar = '', $limite = '')
		{
			$conn = Conexao::getConexao();
			
			$pesquisa .= '%';
			
			$sql_order = '';
			$sql_pesquisa = '';
			$sql_limit = '';
			
			switch ($organizar) {
				case "Z-A":
					$sql_order = "ORDER BY sc.nome DESC ";
					break;
				case "A-Z":
				default:
					$sql_order = "ORDER BY sc.nome ";
				break;
			}
			
			switch ($tipo_pesquisa) {
				case "categoria":					
					$sql_pesquisa = "AND c.nome like :$tipo_pesquisa ";
					break;
				case "subcategoria":
					$sql_pesquisa = "AND sc.nome like :$tipo_pesquisa ";
					break;
			}
			
			if(is_array($limite))
			{
				$sql_limit = 'LIMIT '.$limite['inicio']. ', '.$limite['fim'];
			}
			
			$sql  = 'SELECT sc.codigo, sc.nome, c.nome as categoria, c.codigo as categoria_id ';
			$sql .= 'FROM tbl_subcategoria sc ';
			$sql .= 'INNER JOIN tbl_categoria c ';
			$sql .= 'ON sc.categoria = c.codigo ';
			$sql .= 'WHERE c.usuario = :usuario ';
			$sql .= $sql_pesquisa;
			$sql .= $sql_order;
			$sql .= $sql_limit;
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(":$tipo_pesquisa", $pesquisa, PDO::PARAM_STR);
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetchAll();
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "4.4.3", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
		
		private function verificaSubcategoria($usuario, $nome, $categoria)
		{
			$conn = Conexao::getConexao();
			
			$sql  = 'SELECT * FROM tbl_subcategoria ';
			$sql .= 'WHERE nome = :nome ';
			$sql .= 'AND categoria = :categoria ';
			$sql .= 'AND usuario = :usuario';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
				$stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
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
		
		public function totalSubcategoria($usuario, $pesquisa = '')
		{
			$conn = Conexao::getConexao();
			
			$sql_like = '';
			
			if($pesquisa)
			{
				$pesquisa .= '%';
				$sql_like = 'AND nome like :nome';
			}	
			
			$sql  = 'SELECT * FROM tbl_subcategoria ';
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
				
				return '{"codigo": "4.4.5", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
	}
?>