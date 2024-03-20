<?php
	include_once('../autoload.php');
	Login::verificarLogado();
	
	$codigo = (empty($_GET['id']) ? exit : $_GET['id']);
	
	$obj_unidade_medida = new UnidadeMedidaDAO();
	$res_unidade_medida = $obj_unidade_medida->selectUnidadeMedidaId($codigo, Login::codigoUsuario());
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		//botao excluir
		$("#ex").click(function(){
			window.location.href = '../deletar/unidade_medida.php?id=<?php echo $res_unidade_medida['codigo'] ?>';
		});
	}); 
</script>
<form action="gravar_unidade_medida.php" method="POST">
	<input type="hidden" name="codigo_unidade_medida" value="<?php echo $res_unidade_medida['codigo'] ?>">
	<table border="1">
		<tr>
			<td>
				Unidade Medida
			</td>
			<td>
				<input type="text" name="nome_unidade_medida" value="<?php echo $res_unidade_medida['nome'] ?>">
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