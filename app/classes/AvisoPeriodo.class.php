<?php
	include_once("Conexao.class.php");
	
	class AvisoPeriodo{
		
		function verificaPeriodo()
		{
			$conn = Conexao::getConexao();
			
			$produtos = array();
			
			$sql  = 'SELECT usuario ';
			$sql .= 'FROM tbl_aviso_periodico ';
			$sql .= 'WHERE CURDATE() >= data_aviso_proximo ';
			$sql .= 'GROUP BY usuario';
			
			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->query($sql);
				
				$conn = null;
				
				$rs_periodo = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return '{"codigo": "24.4.1", "mensagem": "Erro Select"}';
				
				//return $sql . "<br>" . $e->getMessage();
			}
			
			if(count($rs_periodo))
			{				
				foreach($rs_periodo as $valor)
				{
					$usuario = $valor['usuario'];

					//---------------------------------------------------

					//produtos cadastrados nesse periodo

					$conn = Conexao::getConexao();
					
					$sql  = 'SELECT p.codigo, p.nome, m.nome as marca, c.nome as categoria, sc.nome as subcategoria, p.status, p.un_med_custo, ';
					$sql .= 'p.fator, p.quantidade, u.nome as unidade_medida, p.data_validade, p.data_cadastro, p.preco_custo ';
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
					$sql .= 'INNER JOIN tbl_aviso_periodico ap ';
					$sql .= 'ON p.usuario = ap.usuario ';
					$sql .= "WHERE p.usuario = $usuario ";
					$sql .= "AND p.data_cadastro >= ap.data_aviso_ultimo ";
					$sql .= "AND p.data_cadastro <= ap.data_aviso_proximo ";
					//$sql .= "AND p.status = 1 ";
					$sql .= "ORDER BY p.data_cadastro";
					
					try
					{
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
						$stmt = $conn->query($sql);
						
						$conn = null;
						
						$produtos['usuarios'][$usuario]['produtos']['cadastrados'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
					}
					catch(PDOException $e)
					{
						$conn = null;
						
						return '{"codigo": "24.4.2", "mensagem": "Erro Select"}';
						
						//return $sql . "<br>" . $e->getMessage();
					}

					//---------------------------------------------------

					//produtos que venceram nesse periodo
					
					$conn = Conexao::getConexao();
					
					$sql  = 'SELECT p.codigo, p.nome, m.nome as marca, c.nome as categoria, sc.nome as subcategoria, p.status, p.un_med_custo, ';
					$sql .= 'p.fator, p.quantidade, u.nome as unidade_medida, p.data_validade, p.data_cadastro, p.preco_custo ';
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
					$sql .= 'INNER JOIN tbl_aviso_periodico ap ';
					$sql .= 'ON p.usuario = ap.usuario ';
					$sql .= "WHERE p.usuario = $usuario ";
					$sql .= "AND p.data_validade >= ap.data_aviso_ultimo ";
					$sql .= "AND p.data_validade <= ap.data_aviso_proximo ";
					//$sql .= "AND p.status = 1 ";
					$sql .= "ORDER BY p.data_validade";
					
					try
					{
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
						$stmt = $conn->query($sql);
						
						$conn = null;
						
						$produtos['usuarios'][$usuario]['produtos']['vencidos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
					}
					catch(PDOException $e)
					{
						$conn = null;
						
						return '{"codigo": "24.4.3", "mensagem": "Erro Select"}';
						
						//return $sql . "<br>" . $e->getMessage();
					}
				}
			}
			
			return $produtos;
		}
	}
?>