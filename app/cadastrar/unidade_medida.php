<?php 
	include_once('../autoload.php');
	Login::verificarLogado();
?>
<form action="gravar_unidade_medida.php" method="POST">
	<table border="1">
		<tr>
			<td>
				Unidade Medida
			</td>
			<td>
				<input type="text" name="nome_unidade_medida" value="">
			</td>
		</tr>
		<tr align="center">
			<td colspan="2"><input type="submit" value="Gravar"></td>
		</tr>
	</table>
</form>	