<?php
	include_once('../autoload.php');
	Login::verificarLogado();
	
	$obj_categoria = new CategoriaDAO();
	$res_categoria = $obj_categoria->selectCategoria(Login::codigoUsuario());
?>
<form action="gravar_subcategoria.php" method="POST">
	<table border="1">
		<tr>
			<td>
				Nome
			</td>
			<td>
				<input type="text" name="nome_subcategoria" value="">
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
							echo "<option value='{$valor['codigo']}'>{$valor['nome']}</option>";
						} 
					?>
				</select>
				&nbsp
				<a href="categoria.php">Cadastrar Categoria</a>
			</td>
		</tr>
		<tr align="center">
			<td colspan="2"><input type="submit" value="Gravar"></td>
		</tr>
	</table>
</form>