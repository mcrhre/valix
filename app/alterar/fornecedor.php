<?php
	include_once('../autoload.php');
	Login::verificarLogado();
	
	$codigo = (empty($_GET['id']) ? exit : $_GET['id']);
	
	$obj_fornecedor = new FornecedorDAO();
	$res_fornecedor = $obj_fornecedor->selectFornecedorId($codigo, Login::codigoUsuario());
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		//botao excluir
		$("#ex").click(function(){
			window.location.href = '../deletar/fornecedor.php?id=<?php echo $res_fornecedor['codigo'] ?>';
		});
	}); 
</script>
<form action="gravar_fornecedor.php" method="POST">
	<input type="hidden" name="codigo_fornecedor" value="<?php echo $res_fornecedor['codigo'] ?>">
	<table border="1">
		<tr>
			<td>
				Nome Fornecedor
			</td>
			<td>
				<input type="text" name="nome_fornecedor" value="<?php echo $res_fornecedor['nome'] ?>">
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