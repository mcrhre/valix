<?php
	include_once('../autoload.php');
	
	Login::verificarLogado();
	
	$obj_marca = new MarcaDAO();
	$res_marca = $obj_marca->selectMarca(Login::codigoUsuario());
	
	$obj_categoria = new CategoriaDAO();
	$res_categoria = $obj_categoria->selectCategoria(Login::codigoUsuario());
	
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
			codigo_categoria = $('#categoria_produto').val();
			//ajax
			$.getJSON('ajax/subcategoria.php',{id_categoria: codigo_categoria, ajax: 'true'}, function(j){
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
				}	
				$('select#subcategoria_produto').html("<option value='0'>Escolher</option>" + options).show().removeAttr('disabled');
			});
		});		

		$("#categoria_produto").change(function(){
			codigo_categoria = $('#categoria_produto').val();
			
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
				console.log(option);
				 
				$('#unidade_medida_custo').append(option);
				 
			}else{
				$("option#id_3").remove();
			}
		});
	}); 
</script>
	<form action="cadastrar/gravar_produto.php" method="POST" id="gravarProduto" class="">
		<br />
		<div class="container">
			<div class="row nomargin">
				<div class="col-xs-6 col-md-8">
					<div class="md-form">
						<input placeholder="" class="form-control formWindow" type="text" name="nome_produto">
						<label class="active">Nome <span class="text-danger">*</span></label>
					</div>
				</div>
				<div class="col-xs-6 col-md-4">
					<div class="md-form">
						<input placeholder="" type="text" class="form-control formWindow datepicker" name="validade_produto" style="height: 33px !important;">
						<label class="active">Data de Validade <span class="text-danger">*</span></label>
					</div>
				</div>
			</div>
			<div class="row nomargin">
				<div class="col-md-3 col-xs-6">
					<div class="md-form">
						<input placeholder="" class="form-control" type="text" name="quantidade_produto" onkeypress="return isNumberKey(event)" />
						<label class="active">Quantidade <span class="text-danger">*</span></label>						
					</div>
				</div>
				<div class="col-md-4 col-xs-6">
					<div class="md-form input-group">
						<select name="unidade_medida" id="unidade_medida" class="form-control formWindow" style="margin-top:7px;" 
						onchange="
							if($(this).val() == 1){
								$('.itensFator').hide();
								$('#quantidade_fator').attr('disabled','disabled');
							} else {
								$('.itensFator').show();
								$('#quantidade_fator').removeAttr('disabled');
							}
						">
							<?php 
								foreach($res_unidade_medida as $valor){ 
									$selected = (strtolower($valor['nome']) == 'unidade') ? 'selected' : '';
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
				<div class="col-md-1 col-xs-12 itensFator" style="padding-top:20px !important;display:none;" align="center">
					<span>com</span>
				</div>
				<div class="col-md-3 col-xs-11 itensFator" style="display:none;">
					<input placeholder="" class="form-control" type="text" name="quantidade_fator" id="quantidade_fator">
				</div>
				<div class="col-xs-1 itensFator" style="padding-top:20px !important;display:none;" align="left">
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
									echo "<option value='{$valor['codigo']}'>{$valor['nome']}</option>";
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
									echo "<option value='{$valor['codigo']}'>{$valor['nome']}</option>";
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
									echo "<option value='{$valor['codigo']}'>{$valor['nome']}</option>";
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
						<input placeholder="" type="text" name="preco_custo_produto" class="form-control"  size="12" onkeyup="maskIt(this,event,'###.###.###,##',true)">
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
						<input placeholder="" class="form-control" type="text" name="localizacao_produto">
						<label class="active">Localização Estoque</label>
					</div>
				</div>
				<div class="hidden-sm-up col-xs-12"><br /></div>
				<div class="col-md-4 col-xs-12">
					<div class="md-form">
						<input placeholder="" type="text" name="lote_produto" class="form-control">
						<label class="active">Lote</label>
					</div>
				</div>
			</div>
			<div class="row nomargin">
				<div class="col-md-12">
					<label for="descricao_produto">Descrição</label>
					<div class="md-form" style="margin-top:-3px;">
						<textarea name="descricao_produto" id="descricao_produto" style="height:68px;"></textarea>
					</div>
				</div>
			</div>
			<div class="row nomargin">
				<div class="col-xs-12">
				    <input type="checkbox" id="checkbox" value="1" name="notifica" checked="checked" />
		   			<label for="checkbox"><span></span>Receber notificações de validade <i class="fa ion-ios-bell"></i></label>	
				</div>
			</div>
			<hr />
			<div class="row nomargin">
				<div class="col-xs-12" align="center">
					<button class="btn btn-success btn-sm" type="button" onclick="gravarProduto();">Salvar</button>
					<button class="btn btn-warning btn-sm" type="button" onclick="cancelEdit();">Cancelar</button>					
				</div>
			</div>
		</div>
	</form>	