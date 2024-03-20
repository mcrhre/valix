<?php
	include_once("Conexao.class.php");
	
	class Relatorio{
		
		function gerarRelatorio($usuario, $dados)
		{
			$conn = Conexao::getConexao();
			
			$sql_order = '';
			$sql_filtro = '';
			$sql_intervalo = '';
			$sql_notificacao = '';
			$sql_campos = 'p.nome, ';
			$sql_marca = '';
			$sql_categoria = '';
			$sql_subcategoria = '';
			$sql_unidade_medida = '';
			$sql_fornecedor = '';

			$marca = $dados['marca'];
			$categoria = $dados['categoria'];
			$subcategoria = $dados['subcategoria'];
			$unidade_medida = $dados['unidade_medida'];
			$fornecedor = $dados['fornecedor'];

			if($dados['campos']['marca']) $sql_campos .= "m.nome as marca, ";
			if($dados['campos']['categoria']) $sql_campos .= "c.nome as categoria, ";
			if($dados['campos']['subcategoria']) $sql_campos .= "sc.nome as subcategoria, ";
			if($dados['campos']['status']) $sql_campos .= "p.status, ";
			if($dados['campos']['preco_custo']) $sql_campos .= "p.un_med_custo, p.preco_custo, ";
			if($dados['campos']['quantidade']) $sql_campos .= "p.fator, p.quantidade, u.nome as unidade_medida, ";
			if($dados['campos']['data_validade']) $sql_campos .= "p.data_validade, ";
			if($dados['campos']['data_cadastro']) $sql_campos .= "p.data_cadastro, ";
			if($dados['campos']['fornecedor']) $sql_campos .= "f.nome as fornecedor, ";
			if($dados['campos']['localizacao']) $sql_campos .= "p.localizacao, ";
			if($dados['campos']['lote']) $sql_campos .= "p.lote, ";
			if($dados['campos']['descricao']) $sql_campos .= "p.descricao, ";

			$sql_campos .= substr($sql_campos, 0, -2).' ';
			
			switch ($dados['filtro_produto']) {
				case 1:
					$sql_filtro = "AND p.data_validade < CURDATE() ";
					break;
				case 2:
					$sql_filtro = "AND CURDATE() < (SELECT data_aviso_inicial FROM tbl_aviso_produto ap WHERE ap.produto = p.codigo) ";
					break;
				case 3:
					$sql_filtro = "AND CURDATE() >= (SELECT data_aviso_inicial FROM tbl_aviso_produto ap WHERE ap.produto = p.codigo) AND CURDATE() < p.data_validade ";
					break;
			}

			$sql_notificacao = ($dados['notificacao'] == 1)? 'AND p.status = 0 ' : 'AND p.status = 1 ';
			
			if($marca != 0)
			{
				$sql_marca = 'AND m.codigo = :marca ';
			}
			
			if($categoria != 0)
			{
				$sql_categoria = 'AND c.codigo = :categoria ';
			}
			
			if($subcategoria != 0)
			{
				$sql_subcategoria = 'AND sc.codigo = :subcategoria ';
			}
			
			if($unidade_medida != 0)
			{
				$sql_unidade_medida = 'AND u.codigo = :unidade_medida ';
			}
			
			if($fornecedor != 0)
			{
				$sql_fornecedor = 'AND f.codigo = :fornecedor ';
			}
			
			if(array_key_exists("intervalo", $dados))
			{
				$data_inicial = $dados['intervalo']['data_inicial'];
				$data_final = $dados['intervalo']['data_final'];
				$tipo_intervalo = ($dados['intervalo']['tipo_intervalo'] == 1)? 'p.data_validade' : 'p.data_cadastro';
				
				$sql_intervalo = "AND $tipo_intervalo BETWEEN '".date("Y-m-d", strtotime(str_replace('/', '-', $data_inicial)))."' AND '".date("Y-m-d", strtotime(str_replace('/', '-', $data_final)))."' ";
			}
			
			switch ($dados['organizar']) {
				case 1:
					$sql_order = "ORDER BY p.data_validade ";
					break;
				case 2:					
					$sql_order = "ORDER BY p.data_cadastro DESC ";
					break;	
				case 3:
					$sql_order = "ORDER BY p.nome ";
					break;
				case 4:
					$sql_order = "ORDER BY p.nome DESC ";
					break;
			}
			
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
			$sql .= "WHERE p.usuario = :usuario ";
			$sql .= $sql_marca;
			$sql .= $sql_categoria;
			$sql .= $sql_subcategoria;
			$sql .= $sql_unidade_medida;
			$sql .= $sql_fornecedor;
			$sql .= $sql_notificacao;
			$sql .= $sql_filtro;
			$sql .= $sql_intervalo;
			$sql .= $sql_order;

			//echo $sql; exit;

			try
			{
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$stmt = $conn->prepare($sql);
				
				$stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);

				if($marca != 0)
				{
					$stmt->bindParam(':marca', $marca, PDO::PARAM_INT);
				}
			
				if($categoria != 0)
				{
					$stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
				}
				
				if($subcategoria != 0)
				{
					$stmt->bindParam(':subcategoria', $subcategoria, PDO::PARAM_INT);
				}
				
				if($unidade_medida != 0)
				{
					$stmt->bindParam(':unidade_medida', $unidade_medida, PDO::PARAM_INT);
				}
				
				if($fornecedor != 0)
				{
					$stmt->bindParam(':fornecedor', $fornecedor, PDO::PARAM_INT);
				}
				
				$stmt->execute();
				
				$conn = null;
				
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				$conn = null;
				
				return array("codigo" => "14.4.1", "mensagem" => "Erro Select");
				
				//return $sql . "<br>" . $e->getMessage();
			}
		}
	}
?>