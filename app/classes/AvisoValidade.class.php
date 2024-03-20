<?php
	include_once("Conexao.class.php");
	
	class AvisoValidade{
		
		function verificaValidade()
		{
			//---------------------------------------------------
			
			$conn = Conexao::getConexao();
			
			$produtos = array();
			
			$sql  = 'SELECT usuario ';
			$sql .= 'FROM tbl_aviso_produto ';
			$sql .= 'WHERE CURDATE() >= data_aviso_inicial ';
			$sql .= 'AND CURDATE() <= data_aviso_final ';
			$sql .= 'GROUP BY usuario';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->query($sql);
				
				$conn = null;
				
				$rs_validade = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "16.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
			
			if(count($rs_validade))
			{				
				foreach($rs_validade as $valor)
				{
					//---------------------------------------------------
					
					$conn = Conexao::getConexao();
					
					$usuario = $valor['usuario'];
					
					$sql  = 'SELECT * FROM tbl_campo_rel_config ';
					$sql .= 'WHERE usuario = :usuario ';
					
					try
					{
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						
						$stmt = $conn->prepare($sql);
						
						$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
						
						$stmt->execute();
						
						$conn = null;
						
						$rs_campo_config = $stmt->fetch(PDO::FETCH_ASSOC);
					}
					catch(PDOException $e)
					{
						$conn = null;
						
						return '{"codigo": "16.4.3", "mensagem": "Erro Select"}';
						
						//return $sql . "<br>" . $e->getMessage();
					}
					
					$sql_campos = 'p.nome, ';
					
					if($rs_campo_config['c_marca']) $sql_campos .= "m.nome as marca, ";
					if($rs_campo_config['c_categoria']) $sql_campos .= "c.nome as categoria, ";
					if($rs_campo_config['c_subcategoria']) $sql_campos .= "sc.nome as subcategoria, ";
					if($rs_campo_config['c_status']) $sql_campos .= "p.status, ";
					if($rs_campo_config['c_preco_custo']) $sql_campos .= "p.un_med_custo, p.preco_custo, ";
					if($rs_campo_config['c_quantidade']) $sql_campos .= "p.fator, p.quantidade, u.nome as unidade_medida, ";
					if($rs_campo_config['c_data_validade']) $sql_campos .= "p.data_validade, ";
					if($rs_campo_config['c_data_cadastro']) $sql_campos .= "p.data_cadastro, ";
					if($rs_campo_config['c_fornecedor']) $sql_campos .= "f.nome as fornecedor, ";
					if($rs_campo_config['c_localizacao']) $sql_campos .= "p.localizacao, ";
					if($rs_campo_config['c_lote']) $sql_campos .= "p.lote, ";
					if($rs_campo_config['c_descricao']) $sql_campos .= "p.descricao, ";
					
					$sql_campos .= substr($sql_campos, 0, -2).' ';
					
					//---------------------------------------------------
					
					$conn = Conexao::getConexao();
				
					$sql  = 'SELECT p.codigo, '.$sql_campos;
					$sql .= 'FROM tbl_produto p ';
					$sql .= 'LEFT JOIN tbl_marca m ';
					$sql .= 'ON p.marca = m.codigo ';
					$sql .= 'LEFT JOIN tbl_categoria c ';
					$sql .= 'ON p.categoria = c.codigo ';
					$sql .= 'LEFT JOIN tbl_subcategoria sc ';
					$sql .= 'ON p.subcategoria = sc.codigo ';
					$sql .= 'LEFT JOIN tbl_unidade_medida u ';
					$sql .= 'ON p.unidade_medida = u.codigo ';
					$sql .= 'LEFT JOIN tbl_fornecedor f ';
					$sql .= 'ON p.fornecedor = f.codigo ';
					$sql .= 'INNER JOIN tbl_aviso_produto ap ';
					$sql .= 'ON p.codigo = ap.produto ';
					$sql .= "WHERE ap.usuario = $usuario ";
					$sql .= "AND CURDATE() >= ap.data_aviso_inicial ";
					$sql .= "AND CURDATE() <= ap.data_aviso_final ";
					$sql .= "AND p.status = 1 ";
					$sql .= "ORDER BY p.data_validade";
					
					try
					{
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
						$stmt = $conn->query($sql);
						
						$conn = null;
						
						$produtos['usuarios'][$usuario]['produtos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
					}
					catch(PDOException $e)
					{
						$conn = null;
						
						return '{"codigo": "16.4.2", "mensagem": "Erro Select"}';
						
						//return $sql . "<br>" . $e->getMessage();
					}
				}
			}
			
			return $produtos;
		}
	}
?>