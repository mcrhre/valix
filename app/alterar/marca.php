<?php
	include_once('../autoload.php');
	Login::verificarLogado();

	$codigo = (empty($_GET['id']) ? exit : $_GET['id']);
	
	$obj_marca = new MarcaDAO();
	$res_marca = $obj_marca->selectMarcaId($codigo, Login::codigoUsuario());
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		//botao excluir
		$("#ex").click(function(){
			window.location.href = '../deletar/marca.php?id=<?php echo $res_marca['codigo'] ?>';
		});
	}); 
</script>
<form action="gravar_marca.php" method="POST">
	<input type="hidden" name="codigo_marca" value="<?php echo $res_marca['codigo'] ?>">
	<table border="1">
		<tr>
			<td>
				Nome Marca
			</td>
			<td>
				<input type="text" name="nome_marca" value="<?php echo $res_marca['nome'] ?>">
			</td>
		</tr>
		<tr align="center">
			<td colspan="2">
				<input type="submit" value="Gravar">	
				<input type="button" id="ex" value="Excluir">
			</td>
		</tr>
	</table>
</form>