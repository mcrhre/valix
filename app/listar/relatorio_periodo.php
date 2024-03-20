<?php
	if (strlen(trim($_GET['hs'])) == 40)
	{
		date_default_timezone_set('America/Sao_Paulo');

		include_once('../classes/AvisoHistoricoDAO.class.php');
		include_once('../classes/Funcao.class.php');
		
		include_once('../fpdf/fpdf.php');
		include_once('../fpdf/html2pdf.php');
		include_once('../fpdf/html_table.php');
		include_once('../fpdf/makefont/makefont.php');
		
		$aviso_vali_dao = New AvisoHistoricoDAO();
		$resultado = $aviso_vali_dao->selectAvisoHistoricoHash(trim($_GET['hs']));

		$aviso_vali_dao->updateAvisoLido(trim($_GET['hs']));
	
		if (!empty($resultado))
		{
			//verifica se deu algum erro
			if (@array_key_exists('usuario', $resultado))
			{	
				//echo '<pre>'; print_r($resultado); echo '<br>';
				$relatorio   = json_decode($resultado['relatorio'], true);
				$data = Funcao::dataTexto($resultado['data']);
				$produtos    = $relatorio['produtos'];
				$cadastrados = $produtos['cadastrados'];
				$vencidos = $produtos['vencidos'];
				$produtos_cadastrados = '';
				$produtos_vencidos = '';
				$i_cadastrados = 0;
				$i_vencidos = 0;
				$campos = array();

				foreach ($cadastrados as $key => $value) {					
					//print_r($value); exit;
					//print_r($value);
					$nome = strlen(@$value['nome']) <= 12 ?  $value['nome']: trim(substr($value['nome'], 0, 12)).'...';
					$nome = $nome ? Funcao::removeAcento($nome) : '<font color="#979797">Vazio</font>';
					$marca = @$value['marca'] ? Funcao::removeAcento($value['marca']) : '<font color="#979797">Vazio</font>';
					$quantidade  = @$value['quantidade'];
					$quantidade  = $quantidade ? $quantidade : '<font color="#979797">Vazio</font>';
					if($quantidade) $quantidade .= ' '.@$value['unidade_medida'];
					if(@$value['quantidade'] > 1) $quantidade .= 's';					
					if(@$value['fator']) {
						$quantidade .= ' c/ ';
						$quantidade .= ' '.@$value['fator'].' (UN)';
					}
					$categoria = @$value['categoria'] ? Funcao::removeAcento($value['categoria']) : '<font color="#979797">Vazio</font>';
					$subcategoria = @$value['subcategoria'] ? Funcao::removeAcento($value['subcategoria']) : '<font color="#979797">Vazio</font>';
					$validade = @$value['data_validade'];
					$cadastro = @$value['data_cadastro'];
					$data_validade = date('d/m/Y', strtotime($validade));
					if($i % 2) $bgcolor = ''; else $bgcolor = '#dadada';
					if(strtotime($validade) <= strtotime(date('Y-m-d'))) $data_validade = '<font r="255" g="0" b="0">'.$data_validade.'</font>';
					$data_cadastro = date('d/m/Y', strtotime($cadastro));
					$fornecedor = @$value['fornecedor'] ? Funcao::removeAcento($value['fornecedor']) : '<font color="#979797">Vazio</font>';
					$preco_custo = @$value['preco_custo'] ? 'R$ '.$value['preco_custo'].' p/ '.@$value['un_med_custo'] : '<font color="#979797">Vazio</font>';
					$localizacao = @$value['localizacao'] ? $value['localizacao'] : '<font color="#979797">Vazio</font>';
					$lote = @$value['lote'] ? $value['lote'] : '<font color="#979797">Vazio</font>';
					$descricao = strlen(@$value['descricao']) <= 12 ?  $value['descricao']: trim(substr($value['descricao'], 0, 12)).'...';
					$descricao = $descricao ? Funcao::removeAcento($descricao) : '<font color="#979797">Vazio</font>';
					$produtos_cadastrados .= '<tr>';
					if(array_key_exists('nome', $value)) $campos['nome'] = true;
					if(array_key_exists('nome', $value)) $produtos_cadastrados .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$nome.'</td>';
					if(array_key_exists('quantidade', $value)) $campos['quantidade'] = true;
					if(array_key_exists('quantidade', $value)) $produtos_cadastrados .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$quantidade.'</td>';
					if(array_key_exists('marca', $value)) $campos['marca'] = true;
					if(array_key_exists('marca', $value)) $produtos_cadastrados .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$marca.'</td>';
					if(array_key_exists('categoria', $value)) $campos['categoria'] = true;
					if(array_key_exists('categoria', $value)) $produtos_cadastrados .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$categoria.'</td>';
					if(array_key_exists('subcategoria', $value)) $campos['subcategoria'] = true;
					if(array_key_exists('subcategoria', $value)) $produtos_cadastrados .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$subcategoria.'</td>';
					if(array_key_exists('data_validade', $value)) $campos['data_validade'] = true;
					if(array_key_exists('data_validade', $value)) $produtos_cadastrados .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$data_validade.'</td>';
					if(array_key_exists('data_cadastro', $value)) $campos['data_cadastro'] = true;
					if(array_key_exists('data_cadastro', $value)) $produtos_cadastrados .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$data_cadastro.'</td>';
					if(array_key_exists('fornecedor', $value)) $campos['fornecedor'] = true;
					if(array_key_exists('fornecedor', $value)) $produtos_cadastrados .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$fornecedor.'</td>';
					if(array_key_exists('preco_custo', $value)) $campos['preco_custo'] = true;
					if(array_key_exists('preco_custo', $value)) $produtos_cadastrados .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$preco_custo.'</td>';
					if(array_key_exists('localizacao', $value)) $campos['localizacao'] = true;
					if(array_key_exists('localizacao', $value)) $produtos_cadastrados .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$localizacao.'</td>';
					if(array_key_exists('lote', $value)) $campos['lote'] = true;
					if(array_key_exists('lote', $value)) $produtos_cadastrados .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$lote.'</td>';
					if(array_key_exists('descricao', $value)) $campos['descricao'] = true;
					if(array_key_exists('descricao', $value)) $produtos_cadastrados .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$descricao.'</td>';
					$produtos_cadastrados .= '</tr>';
					$i_cadastrados++;
				}

				foreach ($vencidos as $key => $value) {					
					//print_r($value); exit;
					//print_r($value);
					$nome = strlen(@$value['nome']) <= 12 ?  $value['nome']: trim(substr($value['nome'], 0, 12)).'...';
					$nome = $nome ? Funcao::removeAcento($nome) : '<font color="#979797">Vazio</font>';
					$marca = @$value['marca'] ? Funcao::removeAcento($value['marca']) : '<font color="#979797">Vazio</font>';
					$quantidade  = @$value['quantidade'];
					$quantidade  = $quantidade ? $quantidade : '<font color="#979797">Vazio</font>';
					if($quantidade) $quantidade .= ' '.@$value['unidade_medida'];
					if(@$value['quantidade'] > 1) $quantidade .= 's';					
					if(@$value['fator']) {
						$quantidade .= ' c/ ';
						$quantidade .= ' '.@$value['fator'].' (UN)';
					}
					$categoria = @$value['categoria'] ? Funcao::removeAcento($value['categoria']) : '<font color="#979797">Vazio</font>';
					$subcategoria = @$value['subcategoria'] ? Funcao::removeAcento($value['subcategoria']) : '<font color="#979797">Vazio</font>';
					$validade = @$value['data_validade'];
					$cadastro = @$value['data_cadastro'];
					$data_validade = date('d/m/Y', strtotime($validade));
					if($i % 2) $bgcolor = ''; else $bgcolor = '#dadada';
					if(strtotime($validade) <= strtotime(date('Y-m-d'))) $data_validade = '<font r="255" g="0" b="0">'.$data_validade.'</font>';
					$data_cadastro = date('d/m/Y', strtotime($cadastro));
					$fornecedor = @$value['fornecedor'] ? Funcao::removeAcento($value['fornecedor']) : '<font color="#979797">Vazio</font>';
					$preco_custo = @$value['preco_custo'] ? 'R$ '.$value['preco_custo'].' p/ '.@$value['un_med_custo'] : '<font color="#979797">Vazio</font>';
					$localizacao = @$value['localizacao'] ? $value['localizacao'] : '<font color="#979797">Vazio</font>';
					$lote = @$value['lote'] ? $value['lote'] : '<font color="#979797">Vazio</font>';
					$descricao = strlen(@$value['descricao']) <= 12 ?  $value['descricao']: trim(substr($value['descricao'], 0, 12)).'...';
					$descricao = $descricao ? Funcao::removeAcento($descricao) : '<font color="#979797">Vazio</font>';
					$produtos_vencidos .= '<tr>';
					if(array_key_exists('nome', $value)) $campos['nome'] = true;
					if(array_key_exists('nome', $value)) $produtos_vencidos .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$nome.'</td>';
					if(array_key_exists('quantidade', $value)) $campos['quantidade'] = true;
					if(array_key_exists('quantidade', $value)) $produtos_vencidos .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$quantidade.'</td>';
					if(array_key_exists('marca', $value)) $campos['marca'] = true;
					if(array_key_exists('marca', $value)) $produtos_vencidos .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$marca.'</td>';
					if(array_key_exists('categoria', $value)) $campos['categoria'] = true;
					if(array_key_exists('categoria', $value)) $produtos_vencidos .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$categoria.'</td>';
					if(array_key_exists('subcategoria', $value)) $campos['subcategoria'] = true;
					if(array_key_exists('subcategoria', $value)) $produtos_vencidos .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$subcategoria.'</td>';
					if(array_key_exists('data_validade', $value)) $campos['data_validade'] = true;
					if(array_key_exists('data_validade', $value)) $produtos_vencidos .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$data_validade.'</td>';
					if(array_key_exists('data_cadastro', $value)) $campos['data_cadastro'] = true;
					if(array_key_exists('data_cadastro', $value)) $produtos_vencidos .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$data_cadastro.'</td>';
					if(array_key_exists('fornecedor', $value)) $campos['fornecedor'] = true;
					if(array_key_exists('fornecedor', $value)) $produtos_vencidos .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$fornecedor.'</td>';
					if(array_key_exists('preco_custo', $value)) $campos['preco_custo'] = true;
					if(array_key_exists('preco_custo', $value)) $produtos_vencidos .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$preco_custo.'</td>';
					if(array_key_exists('localizacao', $value)) $campos['localizacao'] = true;
					if(array_key_exists('localizacao', $value)) $produtos_vencidos .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$localizacao.'</td>';
					if(array_key_exists('lote', $value)) $campos['lote'] = true;
					if(array_key_exists('lote', $value)) $produtos_vencidos .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$lote.'</td>';
					if(array_key_exists('descricao', $value)) $campos['descricao'] = true;
					if(array_key_exists('descricao', $value)) $produtos_vencidos .= '<td bgcolor="'.$bgcolor.'" align="center" height="40" width="{width}">'.$descricao.'</td>';
					$produtos_vencidos .= '</tr>';
					$i_vencidos++;
				}

				//print_r($campos); exit;
				$total_campos = count($campos);
				$font_size = 10;
				if($total_campos > 10) $font_size = 7;
				if(!$total_campos) $total_campos = 1;
				$width = 1110 / $total_campos;				
				$width = round($width);
				$width = "{$width}px";				
				$produtos_cadastrados = str_replace('{width}', $width, $produtos_cadastrados);
				$produtos_vencidos = str_replace('{width}', $width, $produtos_vencidos);
				$colunas = '<tr>';
				if(@$campos['nome']) $colunas .= "<td align='center' height='70' width='{width}'><b>Nome</b></td>";
				if(@$campos['quantidade']) $colunas .= "<td align='center' height='70' width='{width}'><b>Quantidade</b></td>";
				if(@$campos['marca']) $colunas .= "<td align='center' height='70' width='{width}'><b>Marca</b></td>";
				if(@$campos['categoria']) $colunas .= "<td align='center' height='70' width='{width}'><b>Categoria</b></td>";
				if(@$campos['subcategoria']) $colunas .= "<td align='center' height='70' width='{width}'><b>Subcategoria</b></td>";
				if(@$campos['data_validade']) $colunas .= "<td align='center' height='70' width='{width}'><b>Validade</b></td>";
				if(@$campos['data_cadastro']) $colunas .= "<td align='center' height='70' width='{width}'><b>Cadastro</b></td>";
				if(@$campos['fornecedor']) $colunas .= "<td align='center' height='70' width='{width}'><b>Fornecedor</b></td>";
				if(@$campos['preco_custo']) $colunas .= "<td align='center' height='70' width='{width}'><b>Custo</b></td>";
				if(@$campos['localizacao']) $colunas .= "<td align='center' height='70' width='{width}'><b>Localizacao</b></td>";
				if(@$campos['lote']) $colunas .= "<td align='center' height='70' width='{width}'><b>Lote</b></td>";
				if(@$campos['descricao']) $colunas .= "<td align='center' height='70' width='{width}'><b>Descricao</b></td>";
				$colunas .= '</tr>';
				$colunas = str_replace('{width}', $width, $colunas);
				$html1 = '<img src="logo.png" width="85">';
				$html2  = '
					<br /><br /><br />
					<table border="2">
						<tr>
							<td align="right" width="880px">
								<br />Total de Produtos Cadastrados: '.$i_cadastrados.' 
								<br />Total de Produtos Vencidos: '.$i_vencidos.'
								<br /><br />
								<a href="http://valix.com.br/" target="_blank">www.valix.com.br</a>
							</td>
						</tr>';
				if($produtos_cadastrados) $html2 .= '<tr><td><br /><b>Produtos Cadastrados</b></td></tr>'.$colunas.$produtos_cadastrados;
				if($produtos_vencidos) $html2 .= '<tr><td><br /><b>Produtos Vencidos</b></td></tr>'.$colunas.$produtos_vencidos;

				$html2 .= '
					</table>
					<br />
					<table border="2">
						<tr>
							<td align="right" width="800px">
								<font size="1">Gerado em: '.$data.'</span>
							</td>
						</tr>
					</table>
				';

				//echo $html;
				$pdf = new PDF();
				$pdf->SetTitle('Relatorio Periodico');
				$pdf->AddPage('L');
				$pdf->SetFont('Arial','',$font_size);
				$pdf->WriteTable($html1);
				$pdf->WriteTable($html2);				
				$pdf->Output('relatorio.pdf','I');
			}
			else
			{	
				Funcao::gravarLog(trim($_GET['hs']), $resultado, __FILE__, __LINE__, 'erros');

				echo '<meta charset="utf8" />';
				echo '<style>html, body { height: 100%; } html { display: table; margin: auto; } body { display: table-cell; vertical-align: middle; font-family: Arial; }</style>';
				echo '<center>';
				echo '<h2>Ocorreu um erro <br />Erro: '.$resultado.'</h2><br />';
				echo '<img src="http://valix.com.br/app/assets/img/vale10_p.png" width="70" />';
				echo '</center>';
			}
		}
		else
		{
			echo '<meta charset="utf8" />';
			echo '<style>html, body { height: 100%; } html { display: table; margin: auto; } body { display: table-cell; vertical-align: middle; font-family: Arial; }</style>';
			echo '<center>';
			echo '<h2>Relatório não<br /> encontrado</h2><br />';
			echo '<img src="http://valix.com.br/app/assets/img/vale10_p.png" width="70" />';
			echo '</center>';
		}
	}
?>