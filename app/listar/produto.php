<?php 
	date_default_timezone_set('America/Sao_Paulo');

	include_once('autoload.php');
	
	@include_once('../classes/Login.class.php');

	Login::verificarLogado();
	
	$tipo_pesquisa = addslashes(trim($_GET['campo']));
	$pesquisa = addslashes(trim($_GET['pesquisa']));
	$organizar = addslashes(trim($_GET['sort']));
	$filtro = addslashes(trim($_GET['filtro']));
	$data_inicial = addslashes(trim($_GET['d1']));
	$data_final = addslashes(trim($_GET['d2']));
	
	if($data_inicial != '' && $data_final != '')
	{
		$intervalo = array("data_inicial" => $data_inicial, "data_final" => $data_final);
	}

	//paginacao
	$limite_pagina = 4;
	
	$active_page = (isset($_GET['pg']) && is_numeric($_GET['pg'])) ? $_GET['pg'] : 1;
	$inicio = ($active_page * $limite_pagina) - $limite_pagina;
	
	$limite = array("inicio" => $inicio, "fim" => $limite_pagina);
	
	$page_url  = '?page=produto';
	$page_url .= (!empty($organizar)) ? '&sort='.$organizar : '';
	$page_url .= (!empty($pesquisa)) ? '&pesquisa='.$pesquisa : '';
	$page_url .= (!empty($filtro)) ? '&filtro='.$filtro : '';
	$page_url .= (!empty($data_inicial)) ? '&d1='.$data_inicial : '';
	$page_url .= (!empty($data_final)) ? '&d2='.$data_final : '';
	//fim paginacao
	
	$obj_produto = new ProdutoDAO();

	$data_menor = $obj_produto->menorDataValidade(Login::codigoUsuario());
	$data_menor = date('d/m/Y', strtotime($data_menor['menorData']));
	$data_maior = $obj_produto->maiorDataValidade(Login::codigoUsuario());
	$data_maior = date('d/m/Y', strtotime($data_maior['maiorData']));
	
	if ((!empty($pesquisa)) && ($_GET['campo'] == 'produto' || $_GET['campo'] == 'marca' || $_GET['campo'] == 'categoria' || $_GET['campo'] == 'subcategoria' || $_GET['campo'] == 'unidade_medida' || $_GET['campo'] == 'fornecedor'))
	{
		$res_produto = $obj_produto->pesquisaProduto(Login::codigoUsuario(), $tipo_pesquisa, $pesquisa, $organizar, $filtro, $intervalo, $limite);
		$total_registros = $obj_produto->totalProduto(Login::codigoUsuario(), $pesquisa, $intervalo, $filtro);
	}
	else
	{
		$res_produto = $obj_produto->selectProduto(Login::codigoUsuario(), $organizar, $filtro, $intervalo, $limite);
		$total_registros = $obj_produto->totalProduto(Login::codigoUsuario(), '', $intervalo, $filtro);
	}

	if(is_string($res_produto))
	{
		$resul_json = json_decode($res_produto);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_produto, __FILE__, __LINE__, 'erros');
		}
	}
	
	$aviso_produto = New AvisoProdutoDAO();
	
	//$total_registros = 200;
?>
<script>
	document.title = "Produtos - Valix";	
</script>
<div class="">
	<div class="row" style="margin:0;padding-top: 10px;padding-bottom: 10px;background:#272727 !important;">
		<div class="col-md-3 col-xs-6" style="padding:0;margin:0;" align="center">
			<button class="btn btn-success" type="button" style="margin:0;" onclick="novoProduto();" style="padding-left:20px;padding-right:20px;"><i class="fa fa-plus" style="font-size:12px;"></i>
				<span>NOVO</span>
			</button>		
		</div>
		<div class="col-md-3 col-xs-6" style="padding:0;margin:0;" align="center">
			<button class="btn btn-warning" type="button" style="margin:0;" onclick="abrirGrafico();" style="padding-left:20px;padding-right:20px;"><i class="fa fa-pie-chart" style="font-size:12px;"></i>
				<span>GRÁFICO</span>
			</button>	
		</div>
		<div class="col-xs-12 hidden-sm-up"><br /></div>
		<div class="col-md-3 col-xs-6" style="padding:0;margin:0;" align="center">
			<div class="btn-group">
			    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-left:20px;padding-right:20px;">
			    <i class="icon ion-android-funnel"></i> Organizar
			    </button>
			    <div class="dropdown-menu">
			        <a class="dropdown-item <?php if(empty($_GET['sort']) || $_GET['sort'] == 'data_vencimento'){ echo 'active';} ?>" href=".?page=produto<?php echo (isset($_GET['pesquisa'])) ? "&pesquisa=".$_GET['pesquisa'] : ""; ?>&sort=data_vencimento<?php echo (isset($_GET['campo'])) ? "&campo=".$_GET['campo'] : ""; ?><?php echo (isset($_GET['filtro'])) ? "&filtro=".$_GET['filtro'] : ""; ?><?php echo (isset($_GET['d1'])) ? "&d1=".$_GET['d1'] : ""; ?><?php echo (isset($_GET['d2'])) ? "&d2=".$_GET['d2'] : ""; ?>">Data de Vencimento</a>
			        <a class="dropdown-item <?php if($_GET['sort'] == 'data_cadastro'){ echo 'active';} ?>" href=".?page=produto<?php echo (isset($_GET['pesquisa'])) ? "&pesquisa=".$_GET['pesquisa'] : ""; ?>&sort=data_cadastro<?php echo (isset($_GET['campo'])) ? "&campo=".$_GET['campo'] : ""; ?><?php echo (isset($_GET['filtro'])) ? "&filtro=".$_GET['filtro'] : ""; ?><?php echo (isset($_GET['d1'])) ? "&d1=".$_GET['d1'] : ""; ?><?php echo (isset($_GET['d2'])) ? "&d2=".$_GET['d2'] : ""; ?>">Data de Cadastro</a>
			        <a class="dropdown-item <?php if($_GET['sort'] == 'A-Z'){ echo 'active';} ?>" href=".?page=produto<?php echo (isset($_GET['pesquisa'])) ? "&pesquisa=".$_GET['pesquisa'] : ""; ?>&sort=A-Z<?php echo (isset($_GET['campo'])) ? "&campo=".$_GET['campo'] : ""; ?><?php echo (isset($_GET['filtro'])) ? "&filtro=".$_GET['filtro'] : ""; ?><?php echo (isset($_GET['d1'])) ? "&d1=".$_GET['d1'] : ""; ?><?php echo (isset($_GET['d2'])) ? "&d2=".$_GET['d2'] : ""; ?>">A - Z</a>
					<a class="dropdown-item <?php if($_GET['sort'] == 'Z-A'){ echo 'active';} ?>" href=".?page=produto<?php echo (isset($_GET['pesquisa'])) ? "&pesquisa=".$_GET['pesquisa'] : ""; ?>&sort=Z-A<?php echo (isset($_GET['campo'])) ? "&campo=".$_GET['campo'] : ""; ?><?php echo (isset($_GET['filtro'])) ? "&filtro=".$_GET['filtro'] : ""; ?><?php echo (isset($_GET['d1'])) ? "&d1=".$_GET['d1'] : ""; ?><?php echo (isset($_GET['d2'])) ? "&d2=".$_GET['d2'] : ""; ?>">Z - A</a>
			    </div>
			</div>
		</div>
		<div class="col-md-3 col-xs-6" style="padding:0;margin:0;" align="center">
			<div class="btn-group">
			    <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-left:20px;padding-right:20px;">
			    <i class="icon ion-funnel"></i> FILTRAR
			    </button>
			    <div class="dropdown-menu">
			        <a class="dropdown-item <?php if(empty($_GET['filtro']) || $_GET['filtro'] == ''){ echo 'active';} ?>" href=".?page=produto<?php echo (isset($_GET['pesquisa'])) ? "&pesquisa=".$_GET['pesquisa'] : ""; ?><?php echo (isset($_GET['campo'])) ? "&campo=".$_GET['campo'] : ""; ?><?php echo (isset($_GET['sort'])) ? "&sort=".$_GET['sort'] : ""; ?>">Todos</a>
		         	<a class="dropdown-item <?php if($_GET['filtro'] == 'vencidos'){ echo 'active';} ?>" href=".?page=produto<?php echo (isset($_GET['pesquisa'])) ? "&pesquisa=".$_GET['pesquisa'] : ""; ?><?php echo (isset($_GET['campo'])) ? "&campo=".$_GET['campo'] : ""; ?>&filtro=vencidos<?php echo (isset($_GET['sort'])) ? "&sort=".$_GET['sort'] : ""; ?>">Vencidos</a>
					<a class="dropdown-item <?php if($_GET['filtro'] == 'notificacao'){ echo 'active';} ?>" href=".?page=produto<?php echo (isset($_GET['pesquisa'])) ? "&pesquisa=".$_GET['pesquisa'] : ""; ?><?php echo (isset($_GET['campo'])) ? "&campo=".$_GET['campo'] : ""; ?>&filtro=notificacao<?php echo (isset($_GET['sort'])) ? "&sort=".$_GET['sort'] : ""; ?>">Notificação Desativada</a>
		         	<a class="dropdown-item <?php if($_GET['filtro'] == 'validade'){ echo 'active';} ?>" href=".?page=produto<?php echo (isset($_GET['pesquisa'])) ? "&pesquisa=".$_GET['pesquisa'] : ""; ?><?php echo (isset($_GET['campo'])) ? "&campo=".$_GET['campo'] : ""; ?>&filtro=validade<?php echo (isset($_GET['sort'])) ? "&sort=".$_GET['sort'] : ""; ?>">Dentro da Validade</a>
		         	<a class="dropdown-item <?php if($_GET['filtro'] == 'proximo'){ echo 'active';} ?>" href=".?page=produto<?php echo (isset($_GET['pesquisa'])) ? "&pesquisa=".$_GET['pesquisa'] : ""; ?><?php echo (isset($_GET['campo'])) ? "&campo=".$_GET['campo'] : ""; ?>&filtro=proximo<?php echo (isset($_GET['sort'])) ? "&sort=".$_GET['sort'] : ""; ?>">Próximo da Validade</a>
					<a class="dropdown-item <?php if($_GET['filtro'] == 'intervalo'){ echo 'active';} ?>" data-toggle="modal" data-target="#intervalo" style="<?php if($_GET['filtro'] == 'intervalo'){ echo 'color:white;';} ?>">Intervalo</a>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="intervalo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-sm" role="document">
	        <div class="modal-content" style="height: 450px;">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <h4 class="modal-title w-100" id="myModalLabel">Fitrar por Intervalo</h4>
	            </div>
	            <div class="modal-body">
	            	<form method="get">
		            	<br /><br />
		            	<input type="hidden" name="page" value="produto" />
		            	<input type="hidden" name="filtro" value="intervalo" />
		            	<input type="hidden" id="menorData" value="<?php echo $data_menor; ?>" />
		            	<input type="hidden" id="maiorData" value="<?php echo $data_maior; ?>" />
		            	<?php if(isset($_GET['pesquisa'])){ ?>
	            			<input type="hidden" name="pesquisa" value="<?php echo $_GET['pesquisa']; ?>" />
		            	<?php } ?>
		            	<?php if(isset($_GET['campo'])){ ?>
	            			<input type="hidden" name="campo" value="<?php echo $_GET['campo']; ?>" />
		            	<?php } ?>
		            	<?php if(isset($_GET['sort'])){ ?>
	            			<input type="hidden" name="sort" value="<?php echo $_GET['sort']; ?>" />
		            	<?php } ?>
			            <div class="md-form">
			                <input type="text" class="form-control datepicker1" name="d1" value="<?php echo (isset($_GET['d1']) ? $_GET['d1'] : date('d/m/Y')); ?>" />
			                <label for="form81" data-error="wrong" data-success="right">Data Validade Inicial</label>
			            </div>	        
			            <div class="md-form">
			                <input type="text" class="form-control datepicker1" name="d2" value="<?php echo (isset($_GET['d2']) ? $_GET['d2'] : date('d/m/Y')); ?>" />
			                <label for="form81" data-error="wrong" data-success="right">Data Validade Final</label>
			            </div>	
			            <center>
			            	<button class="btn btn-primary btn-sm" type="submit">Filtrar</button>             
			            </center>
		           </form>
	            </div>
	        </div>
	    </div>
	</div>
	<!--pesquisar (form)-->
	<form class="row nomargin" method="get" onsubmit="return FormPesquisa();">	
		<div class="col-md-6" style="padding:0;margin-bottom:0;">			
			<i class="fa fa-times" style="float:right;display:inherit;z-index:2;right:0;position:absolute;margin-top:12px;margin-right:8px;font-size:18px;color:darkgray;cursor:pointer;
				<?php if(!$_GET['pesquisa']){echo 'display:none;';} ?>" onclick="limparPesquisa();<?php if($_GET['pesquisa']){echo "$('.submit-pesquisa').click();";} ?>" id="limparPesquisa" >
			</i>
			<input id="inputPesquisa" class="form-control" style="margin:0;" name="pesquisa" placeholder="O que deseja pesquisar?" value="<?php echo $_GET['pesquisa']; ?>" />
			<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
		</div>
		<div class="col-md-6" style="padding:0;margin-bottom:0;">
			<div class="md-form input-group" style="margin-bottom:0;">
				<select id="inputCategoria" name="campo" class="form-control" style="margin:0;height: 42px;background: #f3f3f3;padding-left: 8px;">
					<option value="produto" <?php if(empty($_GET['campo']) || $_GET['campo'] == 'produto'){echo 'selected="selected"';} ?>>Produto</option>
					<option value="marca" <?php if($_GET['campo'] == 'marca'){echo 'selected="selected"';} ?>>Marca</option>
					<option value="categoria" <?php if($_GET['campo'] == 'categoria'){echo 'selected="selected"';} ?>>Categoria</option>
					<option value="subcategoria" <?php if($_GET['campo'] == 'subcategoria'){echo 'selected="selected"';} ?>>Subcategoria</option>
					<option value="unidade_medida" <?php if($_GET['campo'] == 'unidade_medida'){echo 'selected="selected"';} ?>>Unidade/Medida</option>
					<option value="fornecedor" <?php if($_GET['campo'] == 'fornecedor'){echo 'selected="selected"';} ?>>Fornecedor</option>
				</select>
				<span class="input-group-btn" style="margin:0;">
					<button class="btn btn-primary submit-pesquisa" style="margin:0;padding-left: 20px;padding-right: 20px;margin-right: -1px;border-radius:0;" type="submit">
						<i class="icon ion-ios-search-strong"></i>
					</button>
				</span>
			</div>
		</div>
	</form>
	<!--resultado pesquisa (lista)-->	
	<div class="col-md-12" style="padding:0;">		
		<?php if(!count($res_produto)){ ?>
			<div class="alert alert-warning" role="alert" align="center">Nenhum resultado foi encontrado <i class="fa fa-info-circle"></i></div>
		<?php } ?>
		<table class="table table-bordered table-hover table-striped" style="background: white;">
			<tr></tr>
			<?php 
				foreach($res_produto as $valor){
					$res_aviso_pro = $aviso_produto->selectAvisoProduto($valor['codigo']);
			?>
				<tr style="cursor:pointer;border-top:0px !important;border-bottom:0px !important;" onclick="editarProduto(<?php echo "{$valor['codigo']}"; ?>);">
					<td colspan="0" style="width: 50%;border-right:1px solid rgba(189, 189, 189, 8.26);border-top:0px !important;border-bottom:0px !important;border-left: 8px solid 
						<?php 
							if(strtotime($valor['data_validade']) <= strtotime(date('Y-m-d'))){
								echo 'red'; 
							}elseif(strtotime(date('Y-m-d')) >= strtotime($res_aviso_pro['data_aviso_inicial']) && strtotime(date('Y-m-d')) < strtotime($valor['data_validade'])){
								echo 'orange';
							}else{
								echo 'green'; 
							}	
						?>;
					">
						<?php if(strtotime($valor['data_validade']) <= strtotime(date('Y-m-d'))){ ?>
						<span class="tag tag-danger pull-right" style="margin-top:4px;">
								Vencido
						</span>
						<?php }elseif(strtotime(date('Y-m-d')) >= strtotime($res_aviso_pro['data_aviso_inicial']) && strtotime(date('Y-m-d')) < strtotime($valor['data_validade'])){ ?>
						<span class="tag tag-warning pull-right" style="margin-top:4px;">
								Vencendo
						</span>
						<?php }else{ ?>
						<span class="tag tag-success pull-right" style="margin-top:4px;">
								Na Validade
						</span>
						<?php } ?>
						<?php if($valor['status']){ ?>
							<i class="fa fa-bell-o pull-right" style="font-size:14px;margin-top:6px;margin-right:4px;"></i>
						<?php }else{ ?>
							<i class="fa fa-bell-slash-o pull-right" style="font-size:14px;margin-top:6px;margin-right:4px;"></i>
						<?php } ?>						
						<?php echo "{$valor['nome']} "; ?>
						<br /> 
						<small><b>Quantidade:</b><br class="hidden-sm-up" /> <?php echo "{$valor['quantidade']} "; ?> <?php echo "{$valor['unidade_medida']} "; if($valor['fator']){ ?> c/ <?php echo "{$valor['fator']} "; ?> Un <?php } ?></small>
						<?php if($valor['preco_custo'] != ''){ ?>
							<br />
							<small><b>Preço de Custo:</b><br class="hidden-sm-up" />  R$ <?php echo $valor['preco_custo']; echo ($valor['un_med_custo']!='')? ' ('.$valor['un_med_custo'].')' : ''; ?></small>
						<?php } ?>
					</td>
					<td style="width: 50%;border-top:0px !important;border-bottom:0px !important;">
						<span class="tag tag-primary"><?php echo $valor['marca']; ?></span>
						<span class="tag tag-success"><?php echo $valor['categoria']; ?></span>
						<span class="tag tag-info"><?php echo $valor['subcategoria']; ?></span>
						<br />
						<small><b>Cadastrado em:</b><br class="hidden-sm-up" />  <?php echo Funcao::dataTexto($valor['data_cadastro']); ?></small>
						<br />
						<small><b>Data de Vencimento:</b><br class="hidden-sm-up" /> <?php echo Funcao::dataTexto($valor['data_validade']); ?></small>
					</td>
				</tr>
			<?php } ?>
		</table>
		<?php if(isset($_GET['filtro'])){	?>
		<center>
			<a href=".?page=produto<?php echo (isset($_GET['pesquisa'])) ? "&pesquisa=".$_GET['pesquisa'] : ""; ?><?php echo (isset($_GET['campo'])) ? "&campo=".$_GET['campo'] : ""; ?><?php echo (isset($_GET['sort'])) ? "&sort=".$_GET['sort'] : ""; ?>">
				<button class="btn btn-warning btn-sm">Limpar Filtro</button>
			</a>
		</center>
		<?php } ?>		
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
									Total de Produtos: <?php echo $total_registros; ?>
								</small>
							</small>
						</p>
					</center>
				</nav>
			</center>
		<?php } ?>		
	</div>
</div>