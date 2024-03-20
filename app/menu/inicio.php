<script>
	document.title = "Página Inicial - Valix";
	setTimeout(function(){$('#loader').fadeOut();},800);
</script>
<div class="row" style="margin:0;background:#272727;width:100%;padding-top:20px;padding-bottom:19px;color:white;">
  <div class="col-md-3 col-xs-6" align="center">
    Bem Vindo <b>Usuário</b>
  </div>
  <div class="col-md-3 col-xs-6" align="center">
    <i class="icon ion-ios-calendar" style="font-size: 18px;"></i> &nbsp; <?php echo Funcao::dataTexto(date('d-m-Y')); ?>
  </div>
  <div class="col-md-3 col-xs-6" align="center">
    <i class="icon ion-ios-calendar" style="font-size: 18px;"></i> &nbsp; <?php echo Funcao::dataTexto(date('d-m-Y')); ?>
  </div>
</div>
<br />