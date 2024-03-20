<?php
	include_once('../autoload.php');
	Login::verificarLogado();
	
	$codigo = (empty($_GET['id']) ? exit : $_GET['id']);
	
	$obj_categoria = new CategoriaDAO();
	$res_categoria = $obj_categoria->selectCategoriaId($codigo, Login::codigoUsuario());
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		//botao excluir
		$("#ex").click(function(){
			window.location.href = '../deletar/categoria.php?id=<?php echo $res_categoria['codigo'] ?>';
		});
	}); 
</script>
<form action="gravar_categoria.php" method="POST">
	<input type="hidden" name="codigo_categoria" value="<?php echo $res_categoria['codigo'] ?>">
	<table border="1">
		<tr>
			<td>
				Nome Categoria
			</td>
			<td>
				<input type="text" name="nome_categoria" value="<?php echo $res_categoria['nome'] ?>">
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