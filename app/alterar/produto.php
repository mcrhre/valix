<?php 
	include_once('../autoload.php');
	Login::verificarLogado();
	
	$codigo = (empty($_GET['id']) ? exit : $_GET['id']);

	$obj_produto = new ProdutoDAO();
	$res_produto = $obj_produto->selectProdutoId($codigo, Login::codigoUsuario());
	
	$obj_marca = new MarcaDAO();
	$res_marca = $obj_marca->selectMarca(Login::codigoUsuario());
	
	$obj_categoria = new CategoriaDAO();
	$res_categoria = $obj_categoria->selectCategoria(Login::codigoUsuario());

	$obj_subcategoria = new SubcategoriaDAO();
	$res_subcategoria = $obj_subcategoria->selectSubcategoria($res_produto['categoria'], Login::codigoUsuario());
	
	$obj_fornecedor = new FornecedorDAO();
	$res_fornecedor = $obj_fornecedor->selectFornecedor(Login::codigoUsuario());
	
	$obj_unidade_medida = new UnidadeMedidaDAO();
	$res_unidade_medida = $obj_unidade_medida->selectUnidadeMedida(Login::codigoUsuario());
?>
	<script>
		setTimeout(function(){
			$('#loader').fadeOut();
		}, 400);
		$(document).keyup(function(e) {
			if (e.keyCode == 27) { 
				cancelEdit();
    		}
    	});
		$(document).ready(function(){
			$('.datepicker').pickadate({
				today: '',
				clear: '',
				close: 'Fechar',
				format: 'dd/mm/yyyy',
				selectYears: 60
			});
			$("#subcategoria").change(function(){				
				codigo_categoria = $('#categoria_produto :selected').val();
				//ajax
				$.getJSON('ajax/subcategoria.php',{id_categoria: codigo_categoria, ajax: 'true'}, function(j){
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
					}	
					$('select#subcategoria_produto').html("<option value='0'>Escolher</option>" + options).show().removeAttr('disabled');
				});
			});
			
			$("#categoria_produto").change(function(){
				codigo_categoria = $('#categoria_produto :selected').val();
				
				if(codigo_categoria != '0'){
					//ajax
					$.getJSON('ajax/subcategoria.php',{id_categoria: codigo_categoria, ajax: 'true'}, function(j){
						
						//se vier resposta adiciona na combo
						if(j.length){
							var options;
							
							for (var i = 0; i < j.length; i++) {
								options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
							}	
							$('select#subcategoria_produto').html("<option value='0'>Escolher</option>" + options).show().removeAttr('disabled');
							
						}else{
							$('select#subcategoria_produto').html("<option value='0'>Escolher</option>").attr('disabled','disabled');
						}	
					});
				}else{
					$('select#subcategoria_produto').html("<option value='0'>Escolher</option>").attr('disabled','disabled');
				}
				
			});
			
			//unidade medida preco custo
			$("#unidade_medida").change(function(){
				unidade_medida = $('#unidade_medida :selected').text();
				
				if(unidade_medida.toLowerCase() != "unidade"){
					$("option#id_3").remove();
					 
					option = "";
					option += '<option id="id_3" value="' + unidade_medida + '">' + unidade_medida + '</option>';
					 
					$('#unidade_medida_custo').append(option);
					 
				}else{
					$("option#id_3").remove();
				}
			});
			
			<?php if ($res_produto['un_med_custo']){ ?>
				
				//se produto cadastrado tiver uma unidade de medida do preço de custo cadastrada
				
				unidade_medida = '<?php echo $res_produto['un_med_custo'] ?>';
				
				if(unidade_medida.toLowerCase() != "unidade"){
					$("option#id_3").remove();
					 
					option = "";
					option += '<option id="id_3" value="' + unidade_medida + '" selected >' + unidade_medida + '</option>';
					 
					$('#unidade_medida_custo').append(option);
					
				}else{
					$('#un_med_custo').attr('selected','selected');
					
					unidade_medida = $('#unidade_medida :selected').text();
				
					if(unidade_medida.toLowerCase() != "unidade"){
						$("option#id_3").remove();
						 
						option = "";
						option += '<option id="id_3" value="' + unidade_medida + '">' + unidade_medida + '</option>';
						 
						$('#unidade_medida_custo').append(option);
						
					}
				}
			<?php }else{ ?>
				
				unidade_medida = $('#unidade_medida :selected').text();
				
				if(unidade_medida.toLowerCase() != "unidade"){
					$("option#id_3").remove();
					 
					option = "";
					option += '<option id="id_3" value="' + unidade_medida + '">' + unidade_medida + '</option>';
					 
					$('#unidade_medida_custo').append(option);
					
				}
			<?php } ?>
			
			<?php if ($res_produto['subcategoria']){ ?>
				//ajax
				$.getJSON('ajax/subcategoria.php',{id_categoria: <?php echo $res_produto['categoria'] ?>, ajax: 'true'}, function(j){
					
					//se vier resposta adiciona na combo
					if(j.length){
						var options;
						
						for (var i = 0; i < j.length; i++) {
							selected = j[i].codigo == <?php echo $res_produto['subcategoria'] ?> ? "selected" : "";
							options += '<option value="' + j[i].codigo + '"' + selected + '>' + j[i].nome + '</option>';
						}	
						$('select#subcategoria_produto').html("<option value='0'>Escolher</option>" + options).show().removeAttr('disabled');
						
					}else{
						$('select#subcategoria_produto').html("<option value='0'>Escolher</option>").attr('disabled','disabled');
					}	
				});
			<?php } ?>
		}); 
	</script>
	<form action="alterar/gravar_produto.php" method="POST" id="gravarProduto">
		<input placeholder="" class="form-control" type="hidden" name="codigo_produto" value="<?php echo $res_produto['codigo'] ?>" readonly="readonly">
		<div class="close" onclick="cancelEdit()" style="position: absolute;right: 11px;top: 5px;">x</div>
		<br />
		<div class="container">
			<div class="row nomargin">
				<div class="col-xs-6 col-md-8">
					<div class="md-form">
						<input placeholder="" class="form-control formWindow" type="text" name="nome_produto" value="<?php echo $res_produto['nome'] ?>">
						<label class="active">Nome <span class="text-danger">*</span></label>
					</div>
				</div>
				<div class="col-xs-6 col-md-4">
					<div class="md-form">
						<input placeholder="" type="text" class="form-control formWindow datepicker" name="validade_produto" value="<?php echo  date('d/m/Y', strtotime($res_produto['data_validade'])); ?>" style="height: 33px !important;">
						<label class="active">Data de Validade <span class="text-danger">*</span></label>
					</div>
				</div>
			</div>
			<div class="row nomargin">
				<div class="col-md-3 col-xs-6">
					<div class="md-form">
						<input placeholder="" class="form-control" type="text" name="quantidade_produto" value="<?php echo $res_produto['quantidade']; ?>"
						style="" onkeypress="return isNumberKey(event)">
						<label class="active">Quantidade <span class="text-danger">*</span></label>						
					</div>
				</div>
				<div class="col-md-4 col-xs-6">
					<div class="md-form input-group">
						<select name="unidade_medida" id="unidade_medida" class="form-control formWindow" style="margin-top:7px;" onchange="if($(this).val() == 1){$('.itensFator').hide();$('#quantidade_fator').attr('disabled','disabled');}else{$('.itensFator').show();$('#quantidade_fator').removeAttr('disabled');}">
							<?php 
								foreach($res_unidade_medida as $valor){
									$selected = ($valor['codigo'] == $res_produto['unidade_medida']) ? 'selected' : '';
									echo "<option value='{$valor['codigo']}' $selected >{$valor['nome']}</option>";
								} 
							?>
						</select>
						<label class="active">Unidade/Medida</label>
						<span class="input-group-btn">
							<button class="btn btn-success btn-prompt" type="button" onclick="novaUnidadeMedida2();" style="margin-top:7px !important;">+</button>
						</span>
					</div>
				</div>
				<div class="col-md-1 col-xs-12 itensFator" style="padding-top:20px !important;<?php if($res_produto['unidade_medida'] == 1){echo'display:none;';}?>" align="center">
					<span>com</span>
				</div>
				<div class="col-md-3 col-xs-11 itensFator" style="<?php if($res_produto['unidade_medida'] == 1){echo'display:none;';}?>">
					<input placeholder="" class="form-control" <?php if($res_produto['unidade_medida'] == 1){echo'disabled="disabled"';}?> type="text" name="quantidade_fator" value="<?php echo $res_produto['fator'] ?>"  id="quantidade_fator">
				</div>
				<div class="col-xs-1 itensFator" style="padding-top:20px !important;<?php if($res_produto['unidade_medida'] == 1){echo'display:none;';}?>" align="left">
					<span>(UN)</span>
				</div>
			</div>
			<br />
			<div class="row nomargin">
				<div class="col-md-4 col-xs-6">
					<div class="md-form input-group">					
						<label class="active" style="margin-bottom:1px;">Marca</label>
						<select name="marca_produto" class="form-control formWindow" id="marca_produto">
							<option value="0">Escolher</option>
							<?php
								foreach($res_marca as $valor){
									$selected = ($valor['codigo'] == $res_produto['marca']) ? 'selected' : '';
									echo "<option value='{$valor['codigo']}' $selected >{$valor['nome']}</option>";
								}
							?>
						</select>
						<span class="input-group-btn">
							<button class="btn btn-success btn-prompt" type="button" onclick="novaMarca2();">+</button>
						</span>
					</div>				
				</div>			
				<div class="col-md-4 col-xs-6">
					<div class="md-form input-group" style="padding-top:4px;">
						<label class="active" style="margin-bottom:1px;">Categoria</label>
						<select name="categoria_produto" id="categoria_produto" class="form-control formWindow">
							<option value="0">Escolher</option>
							<?php 
								foreach($res_categoria as $valor){
									$selected = ($valor['codigo'] == $res_produto['categoria']) ? 'selected' : '';
									echo "<option value='{$valor['codigo']}' $selected >{$valor['nome']}</option>";
								} 
							?>
						</select>
						<span class="input-group-btn">
							<button class="btn btn-success btn-prompt" type="button" onclick="novaCategoria2();">+</button>
						</span>
					</div>
				</div>
				<div class="col-md-4 col-xs-6">
					<div class="md-form input-group" style="padding-top:4px;">
						<label class="active" style="margin-bottom:1px;">Subcategoria</label>
						<select name="subcategoria_produto" id="subcategoria_produto" class="form-control formWindow">
							<option value="0">Escolher</option>
							<?php 
								foreach($res_subcategoria as $valor){
									$selected = ($valor['codigo'] == $res_produto['subcategoria']) ? 'selected' : '';
									echo "<option value='{$valor['codigo']}' $selected >{$valor['nome']}</option>";
								}
							?>
						</select>
						<span class="input-group-btn">
							<button class="btn btn-success btn-prompt" type="button" onclick="novaSubCategoria2();" id="novaSubcategoria">+</button>
						</span>
					</div>
				</div>
				<div class="col-md-4 col-xs-6">
					<div class="md-form input-group" style="padding-top:4px;">
						<label class="active" style="margin-bottom:1px;">Fornecedor</label>
						<select name="fornecedor_produto" class="form-control formWindow" id="fornecedor_produto" style="margin-top:5px;">
							<option value="0">Escolher</option>
							<?php 
								foreach($res_fornecedor as $valor){
									$selected = ($valor['codigo'] == $res_produto['fornecedor']) ? 'selected' : '';
									echo "<option value='{$valor['codigo']}' $selected >{$valor['nome']}</option>";
								} 
							?>
						</select>
						<span class="input-group-btn">
							<button class="btn btn-success btn-prompt" type="button" onclick="novoFornecedor2();" style="margin-top: 5px !important;">+</button>
						</span>
					</div>
				</div>
			</div>
			<div class="row nomargin">	
				<div class="col-md-4 col-xs-6">
					<div class="md-form">
						<input placeholder="" type="text" name="preco_custo_produto" value="<?php echo $res_produto['preco_custo'] ?>" class="form-control"  size="12" onkeyup="maskIt(this,event,'###.###.###,##',true)">
						<label class="active">Preço de custo</label>
					</div>
				</div>
				<div class="col-md-4 col-xs-6">
					<div class="md-form input-group">
						<label class="active">Unidade/Medida de Custo</label>
						<select name="unidade_medida_custo" id="unidade_medida_custo" class="form-control formWindow" style="margin-top:10px;">
							<option value="0">Escolher</option>
							<option value="Unidade" id="un_med_custo">Unidade</option>
						</select>
					</div>
				</div>
				<div class="hidden-sm-up col-xs-12"><br /></div>
				<div class="col-md-3 col-xs-12">
					<div class="md-form">
						<input placeholder="" class="form-control" type="text" name="localizacao_produto" value="<?php echo $res_produto['localizacao'] ?>">
						<label class="active">Localização Estoque</label>
					</div>
				</div>
				<div class="hidden-sm-up col-xs-12"><br /></div>
				<div class="col-md-4 col-xs-12">
					<div class="md-form">
						<input placeholder="" type="text" name="lote_produto" value="<?php echo $res_produto['lote'] ?>"  class="form-control">
						<label class="active">Lote</label>
					</div>
				</div>
			</div>
			<div class="row nomargin">
				<div class="col-md-12">
					<label for="descricao_produto">Descrição</label>
					<div class="md-form" style="margin-top:-3px;">
						<textarea name="descricao_produto" id="descricao_produto" style="height:68px;"><?php echo $res_produto['descricao'] ?></textarea>
					</div>
				</div>
			</div>
			<div class="row nomargin">
				<div class="col-xs-12">
					<input type="checkbox" id="checkbox" value="1" name="notifica" <?php echo (($res_produto['status'])? 'checked="checked"': ''); ?> />
		   			<label for="checkbox"><span></span>Receber notificações de validade <i class="fa ion-ios-bell"></i></label>		
				</div>
			</div>
			<hr />
			<div class="row nomargin">
				<div class="col-xs-12" align="center">
					<button class="btn btn-danger btn-sm" type="button" onclick="excluirProduto(<?php echo $res_produto['codigo'] ?>);" style="margin-right: 10px;">Excluir <i class="fa fa-trash" style="font-size:10px;"></i></button>
					&nbsp; &nbsp;&nbsp; &nbsp;
					<button class="btn btn-success btn-sm" type="button" onclick="gravarProduto();">Salvar</button>
				</div>
			</div>	
		</div>
	</form>	