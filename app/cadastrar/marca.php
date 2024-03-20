<?php 
	include_once('../autoload.php');
	Login::verificarLogado();
?>
<form action="gravar_marca.php" method="POST">
	<table border="1">
		<tr>
			<td>
				Nome Marca
			</td>
			<td>
				<input type="text" name="nome_marca" value="">
			</td>
		</tr>
		<tr align="center">
			<td colspan="2"><input type="submit" value="Gravar"></td>
		</tr>
	</table>
</form>	