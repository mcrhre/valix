<?php
	include_once('../autoload.php');
	Login::verificarLogado();
	
	$codigo = (empty($_GET['id']) ? exit : $_GET['id']);
	
	$obj_categoria = new CategoriaDAO();
	$res_categoria = $obj_categoria->selectCategoria(Login::codigoUsuario());
	
	$obj_subcategoria = new SubcategoriaDAO();
	$res_subcategoria = $obj_subcategoria->selectSubcategoriaId($codigo, Login::codigoUsuario());
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		//botao excluir
		$("#ex").click(function(){
			window.location.href = '../deletar/subcategoria.php?id=<?php echo $res_subcategoria['codigo'] ?>';
		});
	}); 
</script>
<form action="gravar_subcategoria.php" method="POST">
	<input type="hidden" name="codigo_subcategoria" value="<?php echo $res_subcategoria['codigo'] ?>">
	<table border="1">
		<tr>
			<td>
				Nome
			</td>
			<td>
				<input type="text" name="nome_subcategoria" value="<?php echo $res_subcategoria['nome']?>">
			</td>
		</tr>
		<tr>
			<td>
				Subcategoria de 
			</td>
			<td>
				<select name="categoria_produto">
					<option value="0"></option>
					<?php 
						foreach($res_categoria as $valor){
							$selected = ($valor['codigo'] == $res_subcategoria['categoria']) ? 'selected' : '';
							echo "<option value='{$valor['codigo']}' $selected >{$valor['nome']}</option>";
						} 
					?>
				</select>
				&nbsp;
				<a href="../cadastrar/categoria.php">Cadastrar Categoria</a>
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