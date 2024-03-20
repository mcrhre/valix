<?php
	date_default_timezone_set('America/Sao_Paulo');

	include_once('../autoload.php');

	Login::verificarLogado();
	
	$aviso_vali_dao = New AvisoHistoricoDAO();	
	$avisos = $aviso_vali_dao->selectAvisoHistorico(Login::codigoUsuario(), '', $_GET['lido']);

	if(is_string($avisos))
	{
		$resul_json = json_decode($avisos);

		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $avisos, __FILE__, __LINE__, 'erros');
		}
	}

	$total_avisos = count($avisos);
?>
<style type="text/css">.pm-content { padding: 0 !important; }</style>
<div class="close" onclick="window.location.reload()" style="position: absolute;right: 11px;top: 5px;">x</div>
<script type="text/javascript">$('#loader').fadeOut();</script>
<?php if($_GET['lido'] == 0){ ?>
	<center>	
		<button class="btn btn-sm btn-info" onclick="abrirHistoricoLido();">Avisos Lidos</button>
	</center>
<?php } else { ?>
	<center>	
		<button class="btn btn-sm btn-info" onclick="abrirHistoricoNovo();">Avisos Não Lidos</button>
	</center>
<?php } ?>
<div style="width: 100%;overflow-y: auto;max-height: 400px;">
	<?php 
		if($total_avisos){ 
			foreach ($avisos as $key => $value) {	
				$vizualizado = $value['visualizou'];
	?>
		<div 
		 style="
		 	padding:11px 10px 11px 15px;
		 	border-top:1px solid darkgray;
		 	<?php if($vizualizado == 1) echo 'background:#eaeaea;'; ?>
		    ">
		 	<b style="font-weight: 300;">
		 		<?php 
		 			if($vizualizado == 0) echo '<i class="fa fa-circle text-danger" aria-hidden="true"></i> ';
					if($value['tipo_aviso'] == 1) echo 'Relatório de Validade'; 
					if($value['tipo_aviso'] == 2) echo 'Relatório Diario'; 
					if($value['tipo_aviso'] == 1) $url = "http://valix.com.br/app/listar/relatorio_validade.php?hs={$value['url_hash']}";
					if($value['tipo_aviso'] == 2) $url = "http://valix.com.br/app/listar/relatorio_periodo.php?hs={$value['url_hash']}";
				?>
			</b>
			<br />
			<small>Data de envio: <?php echo Funcao::dataTexto($value['data']); ?></small>
			<br />
			<small><i class="fa fa-envelope"></i> Envio de Emails: <?php echo $value['aviso_email_qtd']; ?></small> 
			|
			<small><i class="fa fa-comments"></i> Envio de Sms: <?php echo $value['aviso_sms_qtd']; ?></small>
			<a href="<?php echo $url; ?>" target="_blank">
				<button class="btn btn-sm btn-primary pull-right" style="margin-top: -26px;">Abrir</button>
			</a>
			<button class="btn btn-sm btn-danger pull-right" style="margin-top: -26px;padding-left: 10px;padding-right: 10px;" onclick="excluirAviso(<?php echo $value['codigo']; ?>)"><i class="icon ion-trash-a"></i></button>
		</div>
	<?php } ?>
</div>
<center>
	<?php if($_GET['lido'] == 0){ ?>
		<button class="btn btn-sm btn-danger" onclick="limparHistoricoNovo();">Excluir Não Lidos</button>
	<?php } else { ?>
		<button class="btn btn-sm btn-danger" onclick="limparHistoricoLido();">Excluir Lidos</button>
	<?php } ?>
</center>
<?php } else { ?>
	<?php if($_GET['lido'] == 0){ ?>
		<div align="center" style="width: 100%;padding: 50px;color: darkgray;">
			Não há avisos pendentes
		</div>
	<?php } else { ?>
		<div align="center" style="width: 100%;padding: 50px;color: darkgray;">
			Nenhum aviso foi lido
		</div>
	<?php } ?> 
<?php } ?>
