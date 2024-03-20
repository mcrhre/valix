<?php
	require('fpdf/fpdf.php');
	require('fpdf/WriteHTML.php');
	$html = '
		<img src="http://valix.com.br/app/assets/img/vale10_p.png" width="100">
		<table style="border:2px solid black;">
			<tr>
				<td>Teste 22</td>
			</tr>
		</table>
	';
	$pdf = new PDF_HTML();
	$pdf->AddPage();
	$pdf->SetFont('Arial');
	$pdf->WriteHTML($html);
	$pdf->Output('teste/teste.pdf','I');
?>
