<?php
	date_default_timezone_set('America/Sao_Paulo');

	include_once('autoload.php');
	
	$obj_marca = new MarcaDAO();
	$res_marca = $obj_marca->selectMarca(Login::codigoUsuario());
	
	$obj_categoria = new CategoriaDAO();
	$res_categoria = $obj_categoria->selectCategoria(Login::codigoUsuario());
	
	$obj_fornecedor = new FornecedorDAO();
	$res_fornecedor = $obj_fornecedor->selectFornecedor(Login::codigoUsuario());
	
	$obj_unidade_medida = new UnidadeMedidaDAO();
	$res_unidade_medida = $obj_unidade_medida->selectUnidadeMedida(Login::codigoUsuario());

	if(is_string($res_marca))
	{
		$resul_json = json_decode($res_marca);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_marca, __FILE__, __LINE__, 'erros');
		}
	}

	if(is_string($res_categoria))
	{
		$resul_json = json_decode($res_categoria);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_categoria, __FILE__, __LINE__, 'erros');
		}
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

	if(is_string($res_unidade_medida))
	{
		$resul_json = json_decode($res_unidade_medida);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_unidade_medida, __FILE__, __LINE__, 'erros');
		}
	}
?>
<script>
	document.title = "Relatórios - Valix";
	$(document).ready(function(){
		$('.datepicker').pickadate({
			today: '',
			clear: '',
			close: 'Fechar',
			format: 'dd/mm/yyyy',
			selectYears: 60
		}).attr('placeholder','__/__/____');
		$("#categoria").change(function(){
			codigo_categoria = $('#categoria').val();			
			if(codigo_categoria != '0'){
				//ajax
				$.getJSON('ajax/subcategoria.php',{id_categoria: codigo_categoria, ajax: 'true'}, function(j){
					
					//se vier resposta adiciona na combo
					if(j.length){
						var options;
						
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
						}	
						$('select#subcategoria').html("<option value='0'>Todas</option>" + options).show().removeAttr('disabled');
						
					}else{
						$('select#subcategoria').html("<option value='0'>Todas</option>").attr('disabled','disabled');
					}	
				});
			}else{
				$('select#subcategoria').html("<option value='0'>Todas</option>").attr('disabled','disabled');
			}			
		});
		$('#filtrar1').change(function(){
			$('#validade').removeAttr('disabled','disabled');
			$('#cadastro').removeAttr('disabled','disabled');
			$('#inicial').removeAttr('disabled','disabled');
			$('#final').removeAttr('disabled','disabled');
		});
		$('#filtrar2').change(function(){
			$('#validade').attr('disabled','disabled');
			$('#cadastro').attr('disabled','disabled');
			$('#inicial').attr('disabled','disabled');
			$('#final').attr('disabled','disabled');
		});
	});
</script>
<div class="row" style="margin:0;background:#272727 !important;">
	<div class="col-md-12" align="center">
		<h4 style="color: white; padding-top: 18px; padding-bottom: 12px;">Relatório</h4>	
	</div>
</div>
<br />
<div id="editor"></div>
<div class="relatorio_gerado" style="display:none;">
	<div class="row" style="margin:0;">
		<div class="col-md-12">
			<div class="card card-block">
				<div class="row" style="margin:0;">
					<div class="col-md-12" align="center">
						<button class="btn btn-sm btn-warning" onclick="$('.relatorio').slideDown();$('.relatorio_gerado').slideUp();" type="button">Voltar</button>
						&nbsp; &nbsp;
						<button class="btn btn-sm btn-primary" type="button" onclick="imprimir_relatorio();">Imprimir</button>
					</div>
				</div>
				<br />
				<div class="row" style="margin:0;">
					<div class="col-md-12" align="center">
						<div style="max-width:100%;overflow-x:auto;">
							<div class="relatorio_container">
								<table class="table table-striped table-bordered table-relatorio" style="width:100%;">
									<thead>
										<tr>
											<th class="hidden nome">Nome</th>
											<th class="hidden quantidade">Quantidade</th>
											<th class="hidden marca">Marca</th>
											<th class="hidden categoria">Categoria</th>
											<th class="hidden subcategoria">Subcategoria</th>
											<th class="hidden data_validade">Data de Validade</th>
											<th class="hidden data_cadastro">Data de Cadastro</th>
											<th class="hidden fornecedor">Fornecedor</th>
											<th class="hidden preco_custo">Preço de Custo</th>
											<th class="hidden localizacao">Localização Estoque</th>
											<th class="hidden lote">Lote</th>
											<th class="hidden notificacao">Notificação Ativada</th>
											<th class="hidden descricao">Descrição</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<form method="post" class="relatorio">
	<div class="row" style="margin:0;">
		<div class="col-md-12">
			<div class="card card-block">
				<div class="row" style="margin:0;margin-top:12px;">
					<div class="col-md-2 col-xs-6" align="left">
						<label class="active" style="margin-bottom:1px;">Tipo de Relatório</label>
						<br />
					  	<input type="radio" id="sintetico" name="relatorio" checked="checked" value="1" />
					    <label for="sintetico"><span></span>Sintético</label>
					    &nbsp; &nbsp;
					    <input type="radio" id="analitico" name="relatorio" value="2" />
					    <label for="analitico"><span></span>Analitico</label>
					</div>
					<div class="col-md-3 col-xs-6" align="left">
					  	<button class="btn btn-sm btn-primary" style="margin-top:12px;" data-toggle="modal" data-target="#modal_personalizar" type="button">
					  		Personalizar
					  	</button>
					</div>
				</div>
				<div class="row" style="margin:0;margin-top:12px;">
					<div class="col-md-2 col-xs-6">
						<label class="active" style="margin-bottom:1px;">Marca</label>
						<select name="marca" id="marca" class="form-control input-sm formWindow">
							<option value="0">Todas</option>
							<?php 
								foreach($res_marca as $valor){
									echo "<option value='{$valor['codigo']}'>{$valor['nome']}</option>";
								} 
							?>
						</select>
					</div>
					<div class="col-md-2 col-xs-6">
						<label class="active" style="margin-bottom:1px;">Categoria</label>
						<select name="categoria" id="categoria" class="form-control input-sm formWindow">
							<option value="0">Todas</option>
							<?php 
								foreach($res_categoria as $valor){
									echo "<option value='{$valor['codigo']}'>{$valor['nome']}</option>";
								} 
							?>
						</select>
					</div>
					<div class="col-md-2 col-xs-6">
						<label class="active" style="margin-bottom:1px;">Subcategoria</label>
						<select name="subcategoria" id="subcategoria" class="form-control input-sm formWindow" disabled="disabled">
							<option value="0">Todas</option>
						</select>
					</div>
					<div class="col-md-2 col-xs-6">
						<label class="active" style="margin-bottom:1px;">Unidade/Medida</label>
						<select name="unidade_medida" id="unidade_medida" class="form-control input-sm formWindow">
							<option value="0">Todas</option>
							<?php 
								foreach($res_unidade_medida as $valor){ 
									echo "<option value='{$valor['codigo']}' $selected >{$valor['nome']}</option>";
								}
							?>
						</select>
					</div>
					<div class="col-md-2 col-xs-6">
						<label class="active" style="margin-bottom:1px;">Fornecedor</label>
						<select name="fornecedor" id="fornecedor" class="form-control input-sm formWindow">
							<option value="0">Todos</option>
							<?php 
								foreach($res_fornecedor as $valor){ 
									echo "<option value='{$valor['codigo']}' $selected >{$valor['nome']}</option>";
								}
							?>
						</select>
					</div>
				</div>
				<br />
				<div class="row" style="margin:0;">
					<div class="col-md-2 col-sm-4 col-xs-6">
						<label class="active" style="margin-bottom:1px;">Filtrar Intervalo</label>
						<br />
					  	<input type="radio" id="filtrar1" name="filtrar" value="1" />
					    <label for="filtrar1"><span></span>Sim</label>
					    <br />
					    <input type="radio" id="filtrar2" name="filtrar" value="2" checked="checked" />
					    <label for="filtrar2"><span></span>Não</label>
					</div>
					<div class="col-md-2 col-sm-4 col-xs-6">
						<label class="active" style="margin-bottom:1px;">Tipo de Filtro</label>
						<br />
					  	<input type="radio" id="validade" name="tipo_intervalo" checked="checked" value="1" disabled="disabled" />
					    <label for="validade"><span></span>Data Validade</label>
					    &nbsp; &nbsp;
					    <input type="radio" id="cadastro" name="tipo_intervalo" value="2" disabled="disabled" />
					    <label for="cadastro"><span></span>Data Cadastro</label>
					</div>
					<div class="col-md-3 col-sm-4 col-xs-6">
						<label class="active" style="margin-bottom:1px;">Data Inicial</label>
						<input type="text" name="inicial" id="inicial" class="datepicker form-control" disabled="disabled" />
					</div>
					<div class="col-md-3 col-sm-4 col-xs-6">
						<label class="active" style="margin-bottom:1px;">Data Final</label>
						<input type="text" name="final" id="final" class="datepicker form-control" disabled="disabled" />
					</div>	
				</div>
				<br />
				<div class="row" style="margin:0;">
					<div class="col-md-3 col-xs-6">
						<label class="active" style="margin-bottom:1px;">Organizar por</label>
						<select name="organizar" id="organizar" class="form-control input-sm formWindow">
							<option value="1">Data de Vencimento</option>
							<option value="2">Data de Cadastro</option>
							<option value="3">A - Z</option>
							<option value="4">Z - A</option>
						</select>
					</div>
					<div class="col-md-3 col-xs-6">
						<label class="active" style="margin-bottom:1px;">Mostrar Produtos</label>
						<select name="mostrar" id="mostrar" class="form-control input-sm formWindow">
							<option value="0">Todos</option>
							<option value="1">Vencidos</option>
							<option value="2">Dentro da Validade</option>
							<option value="3">Proximo da validade</option>
						</select>
					</div>
					<div class="col-md-3 col-xs-6">
						<label class="active" style="margin-bottom:1px;">Notificação Desativada</label>
						<br />
					  	<input type="radio" id="notificacao1" name="notificacao" value="1" />
					    <label for="notificacao1"><span></span>Sim</label>
					    <br />
					    <input type="radio" id="notificacao2" name="notificacao" value="2" checked="checked" />
					    <label for="notificacao2"><span></span>Não</label>
					</div>
				</div>
				<hr />
				<div class="row" style="margin:0;">
					<div class="col-md-12" align="right">
						<button class="btn btn-success" type="button" onclick="gerar_relatorio()">
					  		Gerar Relatório
					  	</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="modal_personalizar" class="modal fade" role="dialog">
	  <div class="modal-dialog modal-md">
	    <div class="modal-content">
	    	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h5>Personalizar Campos do Relatório</h5>       
		  	</div>
		  	<div class="modal-body">
		  		<div class="row" style="margin:0;">
					<div class="col-md-4 col-xs-6">
				  		<input type="checkbox" id="checkbox2" name="check_validade" />
				  		<label for="checkbox2"><span></span>Data de Validade</label>
				  		<br />
					</div>
					<div class="col-md-4 col-xs-6">
				  		<input type="checkbox" id="checkbox3" name="check_cadastro" />
				  		<label for="checkbox3"><span></span>Data de Cadastro</label>
				  		<br />
					</div>
		  			<div class="col-md-4 col-xs-6">
				  		<input type="checkbox" id="checkbox4" name="check_quantidade" />
				  		<label for="checkbox4"><span></span>Quantidade</label>
						<br />
					</div>
					<div class="col-md-4 col-xs-6">
				  		<input type="checkbox" id="checkbox6" name="check_notificacao" />
		  				<label for="checkbox6"><span></span>Notificação</label>
				  		<br />
					</div>
					<div class="col-md-4 col-xs-6">
				  		<input type="checkbox" id="checkbox7" name="check_marca" />
		  				<label for="checkbox7"><span></span>Marca</label>
				  		<br />
					</div>
					<div class="col-md-4 col-xs-6">
				  		<input type="checkbox" id="checkbox8" name="check_categoria" />
		  				<label for="checkbox8"><span></span>Categoria</label>
				  		<br />
					</div>
		  			<div class="col-md-4 col-xs-6">
				  		<input type="checkbox" id="checkbox9" name="check_subcategoria" />
		  				<label for="checkbox9"><span></span>Subcategoria</label>
						<br />
					</div>
					<div class="col-md-4 col-xs-6">
				  		<input type="checkbox" id="checkbox10" name="check_fornecedor" />
		  				<label for="checkbox10"><span></span>Fornecedor</label>
				  		<br />
					</div>
					<div class="col-md-4 col-xs-6">
				  		<input type="checkbox" id="checkbox11" name="check_preco" />
		  				<label for="checkbox11"><span></span>Preço de Custo</label>
				  		<br />
					</div>
					<div class="col-md-4 col-xs-6">
				  		<input type="checkbox" id="checkbox12" name="check_localizacao" />
		  				<label for="checkbox12"><span></span>Localização Estoque</label>
				  		<br />
					</div>
					<div class="col-md-4 col-xs-6">
				  		<input type="checkbox" id="checkbox13" name="check_lote" />
		  				<label for="checkbox13"><span></span>Lote</label>
				  		<br />
					</div>
		  			<div class="col-md-4 col-xs-6">
				  		<input type="checkbox" id="checkbox14" name="check_descricao" />
				  		<label for="checkbox14"><span></span>Descrição</label>
		  				<br />
		  			</div>
		  		</div>
		  		<div class="row" style="margin:0;">
		  			<div class="col-md-12">
		  				<small>* Marque os campos que vão aparecer no relatório</small>
		  			</div>
		  		</div>
		  	</div>
	    </div>
	</div>
</form>
