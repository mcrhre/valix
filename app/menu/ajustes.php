<?php
	date_default_timezone_set('America/Sao_Paulo');

	include_once('autoload.php');
	
	$obj_cadastro = new UsuarioCadastroDAO();
	$res_usuario_cad = $obj_cadastro->selectUsuarioCadastro(Login::codigoUsuario());
	
	$obj_config = new UsuarioConfigDAO();
	$res_usuario_config = $obj_config->selectUsuarioConfig(Login::codigoUsuario());
	
	$obj_email = new UsuarioEmailDAO();
	$res_usuario_email = $obj_email->selectUsuarioEmail(Login::codigoUsuario());
	
	$obj_telefone = new UsuarioTelefoneDAO();
	$res_usuario_tel = $obj_telefone->selectUsuarioTelefone(Login::codigoUsuario());
	
	$obj_config = new CampoRelConfigDAO();
	$res_config = $obj_config->selectCampoRelConfig(Login::codigoUsuario());

	if(is_string($res_usuario_cad))
	{
		$resul_json = json_decode($res_usuario_cad);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_usuario_cad, __FILE__, __LINE__, 'erros');
		}
	}

	if(is_string($res_usuario_config))
	{
		$resul_json = json_decode($res_usuario_config);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_usuario_config, __FILE__, __LINE__, 'erros');
		}
	}

	if(is_string($res_usuario_email))
	{
		$resul_json = json_decode($res_usuario_email);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_usuario_email, __FILE__, __LINE__, 'erros');
		}
	}

	if(is_string($res_usuario_tel))
	{
		$resul_json = json_decode($res_usuario_tel);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_usuario_tel, __FILE__, __LINE__, 'erros');
		}
	}

	if(is_string($res_config))
	{
		$resul_json = json_decode($res_config);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $res_config, __FILE__, __LINE__, 'erros');
		}
	}

	switch ($_GET['tab']) {
		case 2:
			$tab = 2;
			$title = "Aviso de Validade";
			break;
		default:
			$tab = 1;
			$title = "Meus Dados";
			break;
	}
?>
<script>	
	document.title = "<?php echo $title; ?> - Valix";	
</script>
<div class="">
	<!--menu-->
	<div class="row" style="margin:0;padding-top:14px;padding-bottom:8px;background:#272727 !important;">
		<div class="col-md-12 tabs-ajustes" align="center" style="color:white;padding-bottom:6px;">
		    <div class="tabs-ajustes">
		    	<a class="nav-link <?php if($tab == 1) echo 'active'; ?>" href=".?page=ajustes&tab=1">
					&nbsp; &nbsp; <i class="fa fa-user"></i> &nbsp; &nbsp; Meus Dados &nbsp; &nbsp;
				</a>
				<a class="nav-link <?php if($tab == 2) echo 'active'; ?>" href=".?page=ajustes&tab=2">
					&nbsp; &nbsp; <i class="fa ion-android-notifications"></i> &nbsp; &nbsp; Aviso de Validade &nbsp; &nbsp;
				</a>
			</div>
		</div>
	</div>
	<br />
	<div class="row tabs-rows" style="margin:0;">
		<?php if($tab == 1){ ?>
		<!--meus dados-->
		<div class="col-xs-12">
			<div class="card card-block">
				<div class="row" style="margin:0;">
					<div class="col-md-3 col-sm-12">
						<div class="md-form" style="margin:0;margin-top:12px;">
						    <input type="text" id="nome" class="form-control" style="margin:0;" name="nome" tabindex="1" placeholder="" value="<?php echo utf8_encode($res_usuario_cad['nome']); ?>" data-masker="alphanumeric" />
						    <label for="nome" class="">Nome <span class="text-danger">*</span></label>
						</div>
					</div>
					<div class="col-md-4 col-sm-12">
						<div class="md-form" style="margin:0;margin-top:12px;">
						    <input type="text" id="documento" class="form-control documento" style="margin:0;" name="documento"  tabindex="2" placeholder="" value="<?php echo Funcao::documento($res_usuario_cad['documento']); ?>" maxlength="18" />
						    <label for="documento" class="">Documento <span class="text-danger">*</span></label>
						</div>
					</div>
					<div class="col-md-3 col-sm-12">
						<div class="md-form" style="margin:0;margin-top:12px;">
						    <input type="text" id="email" class="form-control" style="margin:0;" tabindex="3" placeholder="" value="<?php echo $res_usuario_cad['email']; ?>" />
						    <label for="email" class="">Email de Contato <span class="text-danger">*</span></label>
						</div>
					</div>
				</div>
				<br />
				<div class="row" style="margin:0;">
					<div class="col-md-3 col-sm-12">
						<div class="md-form" style="margin:0;margin-top:12px;">
						    <input type="text" id="cep" class="form-control" style="margin:0;" name="cep" data-mask="99999-999" tabindex="4" placeholder="" value="<?php echo $res_usuario_cad['cep']; ?>" />
						    <label class="">CEP <span class="text-danger">*</span></label>
						</div>
					</div>
					<div class="col-md-4 col-sm-12">
						<div class="md-form" style="margin:0;margin-top:12px;">
						    <input type="text" id="endereco" class="form-control" style="margin:0;" name="endereco" placeholder="" value="<?php echo utf8_encode($res_usuario_cad['endereco']); ?>" />
						    <label for="endereco" class="">Endereço <span class="text-danger">*</span></label>
						</div>
					</div>
					<div class="col-md-2 col-sm-12">
						<div class="md-form" style="margin:0;margin-top:12px;">
						    <input type="text" id="numero" class="form-control" style="margin:0;" name="numero" tabindex="5" placeholder="" value="<?php echo $res_usuario_cad['numero']; ?>" />
						    <label for="numero" class="">Número <span class="text-danger">*</span></label>
						</div>
					</div>
					<div class="col-md-2 col-sm-12">
						<div class="md-form" style="margin:0;margin-top:12px;">
						    <input type="text" id="complemento" class="form-control" style="margin:0;" name="complemento" tabindex="6" placeholder="" value="<?php echo utf8_encode($res_usuario_cad['complemento']); ?>" />
						    <label for="complemento" class="">Complemento</label>
						</div>
					</div>
				</div>
				<br />
				<div class="row" style="margin:0;">
					<div class="col-md-3 col-sm-12">
						<div class="md-form" style="margin:0;margin-top:12px;">
						    <input type="text" id="bairro" class="form-control" style="margin:0;" name="bairro" placeholder="" value="<?php echo utf8_encode($res_usuario_cad['bairro']); ?>" />
						    <label for="bairro" class="">Bairro <span class="text-danger">*</span></label>
						</div>
					</div>
					<div class="col-md-3 col-sm-12">
						<div class="md-form" style="margin:0;margin-top:12px;">
						    <input type="text" id="cidade" class="form-control" style="margin:0;" name="cidade" placeholder="" value="<?php echo utf8_encode($res_usuario_cad['cidade']); ?>" />
						    <label for="cidade" class="">Cidade <span class="text-danger">*</span></label>
						</div>
					</div>
					<div class="col-md-3 col-sm-12">
						<div class="md-form" style="margin:0;margin-top:12px;">						    
						    <select id="estado" class="form-control" style="margin:0;height:2.9rem;margin-top:18px !important;padding-left:10px;" name="estado" placeholder="">
						    	<option value="..." hidden disabled>...</option>
						    	<option value="" selected="selected">Selecione</option>
								<option value="AC">AC</option>
								<option value="AL">AL</option>
								<option value="AM">AM</option>
								<option value="AP">AP</option>
								<option value="BA">BA</option>
								<option value="CE">CE</option>
								<option value="DF">DF</option>
								<option value="ES">ES</option>
								<option value="GO">GO</option>
								<option value="MA">MA</option>
								<option value="MG">MG</option>
								<option value="MS">MS</option>
								<option value="MT">MT</option>
								<option value="PA">PA</option>
								<option value="PB">PB</option>
								<option value="PE">PE</option>
								<option value="PI">PI</option>
								<option value="PR">PR</option>
								<option value="RJ">RJ</option>
								<option value="RN">RN</option>
								<option value="RS">RS</option>
								<option value="RO">RO</option>
								<option value="RR">RR</option>
								<option value="SC">SC</option>
								<option value="SE">SE</option>
								<option value="SP">SP</option>
								<option value="TO">TO</option>
						    </select>
						    <label for="estado" class="" style="font-size:13px;margin-top:-32px;">Estado <span class="text-danger">*</span></label>
						</div>
					</div>
				</div>
				<br />
				<div class="row" style="margin:0;">
					<div class="col-md-3 col-sm-12">
						<div class="md-form" style="margin:0;margin-top:12px;">
						    <input type="text" id="telefone" class="form-control" style="margin:0;" name="telefone" data-mask="(99)9999-9999" placeholder="" tabindex="7" value="<?php echo $res_usuario_cad['telefone']; ?>" />
						    <label for="telefone" class="">Telefone <span class="text-danger">*</span></label>
						</div>
					</div>
					<div class="col-md-3 col-sm-12">
						<div class="md-form" style="margin:0;margin-top:12px;">
						    <input type="text" id="celular" class="form-control" style="margin:0;" name="celular" data-mask="(99)99999-99999" placeholder="" tabindex="8" value="<?php echo $res_usuario_cad['celular']; ?>" />
						    <label for="celular" class="">Celular <span class="text-danger">*</span></label>
						</div>
					</div>
				</div>
				<hr />
				<div class="row" style="margin:0;">
					<div class="col-md-2 col-xs-6" align="center" style="padding-top:12px;">
						<button class="btn btn-default btn-sm btn-block" type="button" style="margin:0;padding-left:6px;padding-right:6px;" data-toggle="modal" data-target="#alterarSenha">
							Alterar Senha &nbsp; <i class="fa fa-lock"></i>
						</button>
					</div>
					<div class="col-md-2 col-xs-6" align="center" style="padding-top:12px;">
						<button class="btn btn-default btn-sm btn-block" type="button" style="margin:0;padding-left:6px;padding-right:6px;" data-toggle="modal" data-target="#alterarAcesso">
							Alterar Acesso &nbsp; <i class="fa ion-person"></i>
						</button>
						<div class="hidden">
							<input type="checkbox" id="notifica" value="1" name="notifica" />
		   					<label for="notifica"><span></span>Receber Newsletter <i class="fa fa-newspaper-o" aria-hidden="true"></i></label>	
						</div>	
					</div>
					<div class="col-md-5">&nbsp;</div>
					<div class="col-md-3 col-sm-12 hidden" align="center" style="padding-top:6px;">
						<h5>
							<span class="tag tag-info">Conta Gratuita</span>&nbsp;<small><a href="#">Fazer Upgrade</a></small>
						</h5>
					</div>
					<div class="col-md-3 col-sm-12" align="right">
						<button class="btn btn-success" tabindex="9" onclick="salvarDados();">
							Salvar
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="alterarSenha" tabindex="-1" role="dialog" aria-labelledby="Alterar Senha" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#alterarSenha input').val('');$('#nivel_senha').html('');$('#confirmacao').attr('disabled','disabled');">
		                    <span aria-hidden="true">&times;</span>
		                </button>
		                <h4 class="modal-title w-100">Alterar Senha</h4>
		            </div>
		            <div class="modal-body">
		            	<div class="row" style="margin:0;">
		            		<div class="col-md-6">
				                <div class="md-form" style="margin:0;margin-top:12px;">
								    <input type="password" id="atual" class="form-control" style="margin:0;" name="atual" placeholder="" maxlength="18" />
								    <label for="atual" class="">Senha Atual <span class="text-danger">*</span></label>
								</div>
							</div>
						</div>
						<br />
						<div class="row" style="margin:0;">
		            		<div class="col-md-6">
				                <div class="md-form" style="margin:0;margin-top:12px;">
								    <input type="password" id="nova" class="form-control" style="margin:0;" name="nova" placeholder="" maxlength="18" />
								    <label for="nova" class="">Senha Nova <span class="text-danger">*</span></label>
								</div>
							</div>
							<div class="col-md-6">
				                <div class="md-form" style="margin:0;margin-top:12px;">
								    <input type="password" id="confirmacao" class="form-control" style="margin:0;" name="confirmacao" placeholder="" maxlength="18" disabled="disabled" />
								    <label for="confirmacao" class="">Confirmação Senha Nova <span class="text-danger">*</span></label>
								</div>
							</div>
						</div>
						<div class="row" style="margin:0;">
							<div class="col-md-6">
								<span id="nivel_senha"></span>
							</div>
						</div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-success" onclick="alterar_senha();">Salvar</button>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="modal fade" id="alterarAcesso" tabindex="-1" role="dialog" aria-labelledby="Alterar Email de Acesso" aria-hidden="true" data-keyboard="false" data-backdrop="static">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#email_acesso').val('<?php echo Login::Usuario(); ?>');$('#email_dados').show();$('#senha_dados').hide();$('#senha_dados_input').val('');">
		                    <span aria-hidden="true">&times;</span>
		                </button>
		                <h4 class="modal-title w-100">Alterar Email de Acesso</h4>
		            </div>
		            <div class="modal-body">
		            	<div class="row" style="margin:0;" id="email_dados">
		            		<div class="col-md-6">
				                <div class="md-form" style="margin:0;margin-top:12px;">
								    <input type="email" id="email_acesso" class="form-control" style="margin:0;" name="email_acesso" placeholder="" value="<?php echo Login::Usuario(); ?>" />
								    <label for="email" class="">Email <span class="text-danger">*</span></label>
								</div>
							</div>
						</div>
						<div class="row" style="margin:0;display:none;" id="senha_dados">
		            		<div class="col-md-12">
				                <div class="md-form" style="margin:0;margin-top:12px;">
								    <input type="password" id="senha_dados_input" class="form-control" style="margin:0;" />
								    <label for="email" class="">Digite sua senha <span class="text-danger">*</span></label>
								</div>
							</div>
						</div>
		            </div>
		            <div class="modal-footer">		            	
		                <button type="button" class="btn btn-success" onclick="alterar_dados();">Salvar</button>
		            </div>
		        </div>
		    </div>
		</div>
		<script type="text/javascript">
			document.getElementById('estado').value = '<?php echo $res_usuario_cad['estado'] ?>';
		</script>
		<?php } elseif($tab == 2){ ?>
		<!--aviso de validade-->
		<form class="col-xs-12" id="aviso_form">
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
							  		<input type="checkbox" name="c_data_validade" id="c_data_validade" <?php if($res_config['c_data_validade'] == 1) echo 'checked="checked"'; ?> />
							  		<label for="c_data_validade"><span></span>Data de Validade</label>
							  		<br />
								</div>
								<div class="col-md-4 col-xs-6">
							  		<input type="checkbox" name="c_data_cadastro" id="c_data_cadastro" <?php if($res_config['c_data_cadastro'] == 1) echo 'checked="checked"'; ?> />
							  		<label for="c_data_cadastro"><span></span>Data de Cadastro</label>
							  		<br />
								</div>
					  			<div class="col-md-4 col-xs-6">
							  		<input type="checkbox" name="c_quantidade" id="c_quantidade" <?php if($res_config['c_quantidade'] == 1) echo 'checked="checked"'; ?> />
							  		<label for="c_quantidade"><span></span>Quantidade</label>
									<br />
								</div>
								<div class="col-md-4 col-xs-6">
							  		<input type="checkbox" name="c_status" id="c_status" <?php if($res_config['c_status'] == 1) echo 'checked="checked"'; ?> />
					  				<label for="c_status"><span></span>Notificação</label>
							  		<br />
								</div>
								<div class="col-md-4 col-xs-6">
							  		<input type="checkbox" name="c_marca" id="c_marca" <?php if($res_config['c_marca'] == 1) echo 'checked="checked"'; ?> />
					  				<label for="c_marca"><span></span>Marca</label>
							  		<br />
								</div>
								<div class="col-md-4 col-xs-6">
							  		<input type="checkbox" name="c_categoria" id="c_categoria" <?php if($res_config['c_categoria'] == 1) echo 'checked="checked"'; ?> />
					  				<label for="c_categoria"><span></span>Categoria</label>
							  		<br />
								</div>
					  			<div class="col-md-4 col-xs-6">
							  		<input type="checkbox" name="c_subcategoria" id="c_subcategoria" <?php if($res_config['c_subcategoria'] == 1) echo 'checked="checked"'; ?> />
					  				<label for="c_subcategoria"><span></span>Subcategoria</label>
									<br />
								</div>
								<div class="col-md-4 col-xs-6">
							  		<input type="checkbox" name="c_fornecedor" id="c_fornecedor" <?php if($res_config['c_fornecedor'] == 1) echo 'checked="checked"'; ?> />
					  				<label for="c_fornecedor"><span></span>Fornecedor</label>
							  		<br />
								</div>
								<div class="col-md-4 col-xs-6">
							  		<input type="checkbox" name="c_preco_custo" id="c_preco_custo" <?php if($res_config['c_preco_custo'] == 1) echo 'checked="checked"'; ?> />
					  				<label for="c_preco_custo"><span></span>Preço de Custo</label>
							  		<br />
								</div>
								<div class="col-md-4 col-xs-6">
							  		<input type="checkbox" name="c_localizacao" id="c_localizacao" <?php if($res_config['c_localizacao'] == 1) echo 'checked="checked"'; ?> />
					  				<label for="c_localizacao"><span></span>Localização Estoque</label>
							  		<br />
								</div>
								<div class="col-md-4 col-xs-6">
							  		<input type="checkbox" name="c_lote" id="c_lote" <?php if($res_config['c_lote'] == 1) echo 'checked="checked"'; ?> />
					  				<label for="c_lote"><span></span>Lote</label>
							  		<br />
								</div>
					  			<div class="col-md-4 col-xs-6">
							  		<input type="checkbox" name="c_descricao" id="c_descricao" <?php if($res_config['c_descricao'] == 1) echo 'checked="checked"'; ?> />
							  		<label for="c_descricao"><span></span>Descrição</label>
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
			</div>
			<div class="card card-block" align="center">
				<div class="col-xs-12">
					<div class="row" style="margin:0;padding-top:14px;">
						<div class="col-md-3" align="center" style="padding-top:7px;">
							<i class="fa fa-paper-plane"></i> Enviar Relatório a cada:
						</div>
						<div class="col-md-4 periodico" align="center" style="<?php echo ((!$res_usuario_config['receber_aviso_periodo'])? 'opacity: 0.5;pointer-events: none;': '' ); ?>">
							<div class="row" style="margin:0;">
								<div class="col-xs-6" style="padding-left:2px;padding-right:2px;" align="center">
									<input type="number" class="form-control" style="padding: 3px !important;height: 28px;text-align: center !important;margin: 0;" min="1" value="<?php echo $res_usuario_config['aviso_periodo']; ?>" id="aviso_periodo" name="aviso_periodo" <?php echo ((!$res_usuario_config['receber_aviso_periodo'])? 'readonly="readonly"': '' ); ?>>
								</div>
								<div class="col-xs-6" style="padding-left:2px;padding-right:2px;" align="center">
									<select id="relatorio_alerta" class="form-control input-sm" style="margin-top:2px;padding: 3px !important;height: 33px;text-align: center !important;text-align:center;" name="relatorio_alerta" <?php echo ((!$res_usuario_config['receber_aviso_periodo'])? 'readonly="readonly"': '' ); ?>>
										<option value="1" 
										<?php 
											if($res_usuario_config['tipo_aviso_periodo'] == 1) 
												echo 'selected="selected"';
										?>
										>Dias</option>
										<option value="2"
										<?php 
											if($res_usuario_config['tipo_aviso_periodo'] == 2) 
												echo 'selected="selected"';
										?>
										>Meses</option>
										<option value="3"
										<?php 
											if($res_usuario_config['tipo_aviso_periodo'] == 3) 
												echo 'selected="selected"';
										?>
										>Anos</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-5 periodico" align="center" style="padding-top:6px;<?php echo ((!$res_usuario_config['receber_aviso_periodo'])? 'opacity: 0.5;pointer-events: none;': '' ); ?>">
							<div class="row" style="margin:0;" align="center">
								<div class="col-xs-6" style="padding:0;" align="center">
									<small>
										<input type="checkbox" id="sms_relatorio" value="1" name="sms_relatorio" <?php echo (($res_usuario_config['receber_sms_periodo'])? 'CHECKED': '' ); ?> <?php echo ((!$res_usuario_config['receber_aviso_periodo'])? 'readonly="readonly"': '' ); ?> />
		   								<label for="sms_relatorio"><span></span>Receber SMS <i class="fa fa-comments"></i></label>	
									</small>
								</div>
								<div class="col-xs-6" style="padding:0;" align="center">
									<small>
										<input type="checkbox" id="email_relatorio" value="1" name="email_relatorio" <?php echo (($res_usuario_config['receber_email_periodo'])? 'CHECKED': '' ); ?> <?php echo ((!$res_usuario_config['receber_aviso_periodo'])? 'readonly="readonly"': '' ); ?> />
		   								<label for="email_relatorio"><span></span>Receber Email <i class="fa fa-envelope"></i></label>
									</small>
								</div>
							</div>
						</div>
					</div>
					<div class="row" style="margin:0;padding-top:5px;">
						<div class="col-md-4"></div>
						<div class="col-md-4" align="center">
							<small>
								<input type="checkbox" id="receber_aviso_periodo" value="1" name="receber_aviso_periodo" <?php echo (($res_usuario_config['receber_aviso_periodo'])? 'CHECKED': '' ); ?> />
   								<label for="receber_aviso_periodo"><span></span>Receber Relatório Periódico</label>	
							</small>
						</div>
					</div>
					<hr class="visible-sm-down" />
					<div class="row" style="margin:0;padding-top:14px;">
						<div class="col-md-12" align="center" style="padding-top:7px;">
							<h5><i class="fa fa-bell"></i> Alertar</h5>
						</div>
					</div>
					<hr class="visible-sm-down" />
					<div class="row" style="margin:0;padding-top:14px;">
						<div class="col-md-2" align="center"></div>
						<div class="col-md-4" align="center" style="padding-top:7px;">
							Próximo do vencimento até:
							<br /><br />
							<div class="row" style="margin:0;"" align="center">
								<div class="col-xs-6" style="padding-left:2px;padding-right:2px;"" align="center">
									<input type="number" class="form-control" style="padding: 3px !important;height: 28px;text-align: center !important;margin: 0;" min="1" value="<?php echo $res_usuario_config['aviso_validade']; ?>" id="aviso_validade" name="aviso_validade" onkeyup="$('#tempo_antes').html($(this).val())" onblur="$('#tempo_antes').html($(this).val())" maxlength="2" max="30">
								</div>
								<div class="col-xs-6" style="padding-left:2px;padding-right:2px;"" align="center">
									<select id="validade_alerta" class="form-control input-sm" style="margin-top:2px;padding: 3px !important;height: 33px;text-align: center !important;text-align:center;" name="validade_alerta"
									onchange="
									if($(this).val() == 1) $('#tipo_antes').html('dia(s)');
									if($(this).val() == 2) $('#tipo_antes').html('me(ses)');
									if($(this).val() == 3) $('#tipo_antes').html('ano(s)');
									">
										<option value="1"
										<?php 
											if($res_usuario_config['tipo_aviso_validade'] == 1) 
												echo 'selected="selected"';
										?>
										>Dias Antes</option>
										<option value="2"
										<?php 
											if($res_usuario_config['tipo_aviso_validade'] == 2) 
												echo 'selected="selected"';
										?>
										>Meses Antes</option>
										<option value="3"
										<?php 
											if($res_usuario_config['tipo_aviso_validade'] == 3) 
												echo 'selected="selected"';
										?>
										>Anos Antes</option>
									</select>
								</div>
							</div>
							<small style="color:darkgray;">Você receberá alertas diarios durante o periodo de <br /><strong><span id="tempo_antes"><?php echo $res_usuario_config['aviso_validade']; ?></span> <span id="tipo_antes"><?php
								if($res_usuario_config['tipo_aviso_validade'] == 1) echo 'dia(s)';
								if($res_usuario_config['tipo_aviso_validade'] == 2) echo 'mes(es)';
								if($res_usuario_config['tipo_aviso_validade'] == 3) echo 'ano(s)';
							?>
							</span> antes</strong> do vencimento.</small>
						</div>						
						<div class="col-md-4" align="center" style="padding-top:7px;">
							Após o vencimento até:
							<br /><br />
							<div class="row" style="margin:0;"" align="center">
								<div class="col-xs-6" style="padding-left:2px;padding-right:2px;"" align="center">
									<input type="number" class="form-control" style="padding: 3px !important;height: 28px;text-align: center !important;margin: 0;" min="1" id="aviso_vencido" name="aviso_vencido" value="<?php echo $res_usuario_config['aviso_vencido']; ?>" maxlength="2" onkeyup="$('#tempo_depois').html($(this).val())" onblur="$('#tempo_depois').html($(this).val())"  max="30">
								</div>
								<div class="col-xs-6" style="padding-left:2px;padding-right:2px;"" align="center">
									<select id="vencido_alerta" class="form-control input-sm" style="margin-top:2px;padding: 3px !important;height: 33px;text-align: center !important;text-align:center;" name="vencido_alerta" onchange="
									if($(this).val() == 1) $('#tipo_depois').html('dia(s)');
									if($(this).val() == 2) $('#tipo_depois').html('mes(es)');
									if($(this).val() == 3) $('#tipo_depois').html('ano(s)');
									">
										<option value="1"
										<?php 
											if($res_usuario_config['tipo_aviso_vencido'] == 1) 
												echo 'selected="selected"';
										?>
										>Dias Depois</option>
										<option value="2"
										<?php 
											if($res_usuario_config['tipo_aviso_vencido'] == 2) 
												echo 'selected="selected"';
										?>
										>Meses Depois</option>
										<option value="3"
										<?php 
											if($res_usuario_config['tipo_aviso_vencido'] == 3) 
												echo 'selected="selected"';
										?>
										>Anos Depois</option>
									</select>
								</div>
							</div>
							<small style="color:darkgray;">Você receberá alertas diarios durante o periodo de <br /> <strong><span id="tempo_depois"><?php echo $res_usuario_config['aviso_vencido']; ?></span> <span id="tipo_depois">
							<?php
								if($res_usuario_config['tipo_aviso_vencido'] == 1) echo 'dia(s)';
								if($res_usuario_config['tipo_aviso_vencido'] == 2) echo 'mes(es)';
								if($res_usuario_config['tipo_aviso_vencido'] == 3) echo 'ano(s)';
							?>
							</span> depois</strong> do vencimento.</small>
						</div>
					</div>
					<div class="row" style="margin:0;padding-top:0px;">						
						<div class="col-xs-12" align="center" style="padding:0;"><hr /></div>
					</div>	
					<div class="row" style="margin:0;padding-top:0px;">						
						<div class="col-md-2"></div>
						<div class="col-md-8" style="padding-top:6px;" align="center">
							<div class="row" style="margin:0;">
								<div class="col-xs-4" style="padding:0;" align="center">
										<button class="btn btn-sm btn-primary" style="margin:0;" data-toggle="modal" data-target="#modal_personalizar" type="button">
									  		Personalizar
									  	</button>
								</div>
								<div class="col-xs-4" style="padding:0;" align="center">
									<small>
										<input type="checkbox" id="sms_aviso" value="1" name="sms_aviso" <?php echo (($res_usuario_config['receber_sms_validade'])? 'CHECKED': '' ); ?> />
		   								<label for="sms_aviso"><span></span>Receber SMS <i class="fa fa-comments"></i></label>	
									</small>
								</div>
								<div class="col-xs-4" style="padding:0;" align="center">
									<small>
										<input type="checkbox" id="email_aviso" value="1" name="email_aviso" <?php echo (($res_usuario_config['receber_email_validade'])? 'CHECKED': '' ); ?> />
		   								<label for="sms_aviso"><span></span>Receber Email <i class="fa fa-envelope"></i></label>
									</small>
								</div>
							</div>
						</div>
					</div>
				<div class="row" style="margin:0;padding-top:0px;">						
					<div class="col-xs-12" align="center" style="padding:0;"><hr /></div>
				</div>				
				<div class="col-md-6 col-xs-12" style="border-right:0.1px solid rgba(0,0,0,.15);">
					<p style="margin-bottom:6px;">Aviso via Email <i class="fa fa-envelope"></i></p>
					<table class="table table-striped" id="emails">
						<tr>
							<td><input class="form-control input-sm" style="padding-top:2px;padding-bottom:2px;margin:0;padding-left:4px;background:white;" placeholder="Digite um email" id="novo_email" /></td>
							<td align="right">
								<button class="btn btn-sm btn-success" type="button" style="padding: 8px 10px 5px 10px;margin: 0;" onclick="insereEmail();">
									<i class="fa fa-plus"></i>
								</button>
							</td>
						</tr>
						<?php $i_email = 0; foreach ($res_usuario_email as $key => $email) { ?>
						<tr class="email-row" id="email-row<?php echo $key; ?>"><input type="hidden" name="emails<?php echo $i_email; ?>" id="emails<?php echo $i_email; ?>" class="input-emails" value="<?php echo $email['email']; ?>"><td><?php echo $email['email']; ?></td><td align="right"><button class="btn btn-sm btn-danger" style="padding: 5px 10px 5px 10px;margin:0;" onclick="removerEmail(<?php echo $key; ?>);"><i class="fa ion-trash-b"></i></button></td></tr>
						<?php $i_email++; } ?>
					</table>
				</div>
				<div class="col-md-6 col-xs-12">
					<p style="margin-bottom:6px;">Aviso via SMS <i class="fa fa-comments"></i></p>
					<table class="table table-striped" id="celulares">
						<tr>
							<td><input class="form-control input-sm" style="padding-top:2px;padding-bottom:2px;margin:0;padding-left:4px;background:white;" placeholder="Digite um celular" data-mask="(99)99999-9999" id="novo_celular" /></td>
							<td align="right">
								<button class="btn btn-sm btn-success" type="button" style="padding: 8px 10px 5px 10px;margin: 0;" onclick="insereCelular();">
									<i class="fa fa-plus"></i>
								</button>
							</td>
						</tr>
						<?php $i_celular = 0; foreach ($res_usuario_tel as $key => $telefone) { ?>
						<tr class="celular-row" id="celular-row<?php echo $key; ?>"><input type="hidden" name="celulares<?php echo $i_celular; ?>" class="input-celulares" value="<?php echo $telefone['telefone']; ?>"><td data-mask="(99)99999-9999"><?php echo $telefone['telefone']; ?></td><td align="right"><button class="btn btn-sm btn-danger" style="padding: 5px 10px 5px 10px;margin: 0;" onclick="removerCelular(<?php echo $key; ?>);"><i class="fa ion-trash-b"></i></button></td></tr>

						<?php $i_celular++; } ?>
					</table>
				</div>
				<div class="col-md-12" align="right">
					<hr />
					<button class="btn btn-success" type="button" onclick="alterar_aviso();">
						Salvar
					</button>
				</div>
			</div>
		</form>
		<?php } ?>
	</div>
</div>