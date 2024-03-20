<?php 
	include('header.php');
	switch($_GET['page']){
		case 'inicio':
			include('menu/inicio.php');
			break;
		case 'marca':
			include('listar/marca.php');
			break;
		case 'categoria':
			include('listar/categoria.php');
			break;
		case 'subcategoria':
			include('listar/subcategoria.php');
			break;
		case 'unidade_medida':
			include('listar/unidade_medida.php');
			break;
		case 'fornecedor':
			include('listar/fornecedor.php');
			break;
		case 'relatorio':
			include('menu/relatorio.php');
			break;
		case 'ajuda':
			include('menu/ajuda.php');
			break;
		case 'ajustes':
			include('menu/ajustes.php');
			break;
		default:
			include('listar/produto.php');
			break;
	}
	include('footer.php'); 
?>
