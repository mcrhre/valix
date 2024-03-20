<?php 
	date_default_timezone_set('America/Sao_Paulo');

	include_once('autoload.php');
	
	@include_once('../classes/Login.class.php');

	Login::verificarLogado();
	
	$pesquisa = addslashes(trim($_GET['pesquisa']));
	$organizar = addslashes(trim($_GET['sort']));
	
	//paginacao
	$limite_pagina = 8;
	
	$active_page = (isset($_GET['pg']) && is_numeric($_GET['pg'])) ? $_GET['pg'] : 1;
	$inicio = ($active_page * $limite_pagina) - $limite_pagina;
	
	$limite = array("inicio" => $inicio, "fim" => $limite_pagina);
	
	$page_url  = '?page=fornecedor';
	$page_url .= (!empty($organizar)) ? '&sort='.$organizar : '';
	$page_url .= (!empty($pesquisa)) ? '&pesquisa='.$pesquisa : '';
	//fim paginacao
	
	$obj_fornecedor = new FornecedorDAO();
	
	if (!empty($pesquisa) && $_GET['page'] == 'fornecedor')
	{
		$res_fornecedor = $obj_fornecedor->pesquisaFornecedor(Login::codigoUsuario(), $pesquisa, $organizar, $limite);
		$total_registros = $obj_fornecedor->totalFornecedor(Login::codigoUsuario(), $pesquisa);
	}
	else
	{
		$res_fornecedor = $obj_fornecedor->selectFornecedor(Login::codigoUsuario(), $organizar, $limite);
		$total_registros = $obj_fornecedor->totalFornecedor(Login::codigoUsuario());
	}

	if(is_string($res_fornecedor))
	{
		$resul_json = json_decode($res_fornecedor);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_fornecedor, __FILE__, __LINE__, 'erros');
		}
	}
	
	//$total_registros = 200;
?>
<script>
	document.title = "Fornecedor - Valix";
</script>
<div class="row" style="margin:0;padding-top: 10px;padding-bottom: 10px;background:#272727 !important;">
	<div class="col-xs-6" style="padding:0;margin:0;" align="center">
		<button class="btn btn-success" type="button" style="margin:0;" onclick="adicionarFornecedor();" style="padding-left:20px;padding-right:20px;"><i class="fa fa-plus" style="font-size:12px;"></i>
			<span>NOVO</span>
		</button>			
	</div>
	<div class="col-xs-6" style="padding:0;margin:0;" align="center">
		<div class="btn-group">
		    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-left:20px;padding-right:20px;">
		    <i class="icon ion-android-funnel"></i> Organizar
		    </button>
		    <div class="dropdown-menu">
		        <a class="dropdown-item <?php if(empty($_GET['sort']) || $_GET['sort'] == 'A-Z'){ echo 'active';} ?>" href=".?page=fornecedor<?php echo (isset($_GET['pesquisa'])) ? "&pesquisa=".$_GET['pesquisa'] : ""; ?>&sort=A-Z">A - Z</a>
		        <a class="dropdown-item <?php if($_GET['sort'] == 'Z-A'){ echo 'active';} ?>" href=".?page=fornecedor<?php echo (isset($_GET['pesquisa'])) ? "&pesquisa=".$_GET['pesquisa'] : ""; ?>&sort=Z-A">Z - A</a>
		    </div>
		</div>		
	</div>
</div>
<!--pesquisar (form)-->
<form class="row nomargin" method="get" onsubmit="return FormPesquisa();">	
	<div class="col-md-6" style="padding:0;margin-bottom:0;">			
		<i class="fa fa-times" style="float:right;display:inherit;z-index:2;right:0;position:absolute;margin-top:12px;margin-right:8px;font-size:18px;color:darkgray;cursor:pointer;<?php if(!$_GET['pesquisa']){echo 'display:none;';} ?>" onclick="limparPesquisa();<?php if($_GET['pesquisa']){echo "$('.submit-pesquisa').click();";} ?>" id="limparPesquisa" ></i>
		<input id="inputPesquisa" class="form-control" style="margin:0;" name="pesquisa" placeholder="O que deseja pesquisar?" value="<?php echo $_GET['pesquisa']; ?>" />
		<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
	</div>
	<div class="col-md-6" style="padding:0;margin-bottom:0;">
		<div class="md-form input-group" style="margin-bottom:0;">
			<select id="inputCategoria" name="campo" class="form-control" style="margin:0;height: 42px;background: #f3f3f3;padding-left: 8px;" disabled="disabled">
				<option value="fornecedor" selected="selected">Fornecedor</option>
			</select>
			<span class="input-group-btn" style="margin:0;">
		        <button class="btn btn-primary submit-pesquisa" style="margin:0;padding-left: 20px;padding-right: 20px;" type="submit">
					<i class="icon ion-ios-search-strong"></i>
				</button>
		    </span>
		</div>
	</div>
</form>
<!--resultado pesquisa (lista)-->
<?php if(!count($res_fornecedor)){ ?>
	<div class="alert alert-warning alert-no-result" role="alert" align="center">Nenhum resultado foi encontrado <i class="fa fa-info-circle"></i></div>
<?php } ?>
<table class="table table-bordered table-striped" border="1" id="tableFornecedores">
	<tr style="display:none;" id="fornecedorTrNova">
		<td style="width:50%;border-right:1px solid rgba(189, 189, 189, 8.26);border-top:0px !important;border-bottom:0px !important;">
			<input class="form-control input-sm" id="novaFornecedor" placeholder="Novo Fornecedor" style="background: white;height: 25px !important;margin: 0;line-height: inherit !important;font-size: 14px;width: 100%;padding: 0;" onkeypress="$(this).val(aspas($(this).val()));" onkeyup="$(this).val(aspas($(this).val()));" />
		</td>
		<td style="width:50%;border-top:0px !important;border-bottom:0px !important;">
			<button class="btn btn-success btn-sm" style="padding:7px;margin:0;" onclick="novaFornecedor();">
				<small>Salvar</small>
			</button>
			<button class="btn btn-warning btn-sm" style="padding:7px;margin:0;" onclick="cancelarFornecedor();">
				<small>Cancelar</small>
			</button>
		</td>
	</tr>
	<?php foreach($res_fornecedor as $valor){  ?>
			<tr id='fornecedorTr<?php echo $valor['codigo']; ?>'>
				<td style='width:50%;border-right:1px solid rgba(189, 189, 189, 8.26);border-top:0px !important;border-bottom:0px !important;'><small id='fornecedorNome<?php echo $valor['codigo']; ?>'><?php echo $valor['nome']; ?></small></td>
				<td style='width:50%;border-top:0px !important;border-bottom:0px !important;'>
					<button class='btn btn-success btn-sm' id='fornecedorSalvar<?php echo $valor['codigo']; ?>' style='padding:7px;margin:0;display:none;' onclick='salvarFornecedor(<?php echo $valor['codigo']; ?>);'><small>Salvar</small></button>
					<button class='btn btn-info btn-sm' id='fornecedorEditar<?php echo $valor['codigo']; ?>' style='padding:7px;margin:0;' onclick='editarFornecedor(<?php echo $valor['codigo']; ?>);'><small>Editar</small></button>
					<button class='btn btn-danger btn-sm' style='padding:7px;margin:0;' onclick='excluirFornecedor(<?php echo $valor['codigo']; ?>);'><small>Excluir</small></button>
					<button class="btn btn-warning btn-sm" id="fornecedorCancelar<?php echo $valor['codigo']; ?>" style="padding:7px;margin:0;display:none;" onclick="cancelarFornecedor(<?php echo $valor['codigo'].", '".str_replace("'","\'",$valor['nome'])."'" ?>)"><small>Cancelar</small></button>
				</td>
			</tr>
	<?php } ?>
</table>
<?php if($total_registros > $limite_pagina){ ?>
	<center>
		<nav>
			<?php
				$qtd_pagina = ceil($total_registros/$limite_pagina);
				
				$lim_link_pg = 3;
				
				$inicio = ((($active_page - $lim_link_pg) > 1) ? $active_page - $lim_link_pg : 1);
				
				$fim = ((($active_page + $lim_link_pg) < $qtd_pagina) ? $active_page + $lim_link_pg : $qtd_pagina);
			?>
			<ul class="pagination">
				<li class="page-item">
				  <a class="page-link" href="<?php echo $page_url; ?>&pg=1" aria-label="Previous" title="Página 1">
					<span aria-hidden="true">&laquo;</span>
					<span class="sr-only">Anterior</span>
				  </a>
				</li>
				<?php for($i = $inicio; $i <= $fim; $i++) { ?>
					<li class="page-item <?php if($active_page == $i){echo 'active'; } ?>">
						<a class="page-link" href="<?php echo $page_url; ?>&pg=<?php echo $i; ?>">
							<?php echo $i; ?>
							<?php if($active_page == $i){echo '<span class="sr-only">(current)</span>'; } ?>
						</a>
					</li>
				<?php } ?>
				<li class="page-item">
				  <a class="page-link" href="<?php echo $page_url; ?>&pg=<?php echo $qtd_pagina; ?>" aria-label="Next" title="Página <?php echo $qtd_pagina; ?>">
					<span aria-hidden="true">&raquo;</span>
					<span class="sr-only">Seguinte</span>
				  </a>
				</li>
			</ul>
			<center style="margin-top:-15px;">
				<p>
					<small>
						<small>
							Página <?php echo $active_page; ?> de <?php echo $qtd_pagina; ?> |
							Total de Fornecedores: <?php echo $total_registros; ?>
						</small>
					</small>
				</p>
			</center>
		</nav>
	</center>
<?php } ?>