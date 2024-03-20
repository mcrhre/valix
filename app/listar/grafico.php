<?php
	date_default_timezone_set('America/Sao_Paulo');

  include_once('../autoload.php');
	
	@include_once('../classes/Login.class.php');

	Login::verificarLogado();
	
  $obj_produto = new ProdutoDAO();
  $campos = $obj_produto->gerarGrafico(Login::codigoUsuario());

  if(is_string($campos))
  {
    $resul_json = json_decode($campos);

    //verifica se deu algum erro
    if (array_key_exists('mensagem', $resul_json))
    {
      Funcao::gravarLog(Login::codigoUsuario(), $campos, __FILE__, __LINE__, 'erros');
    }
  }

?>
<div class="close" onclick="window.location.reload()" style="position: absolute;right: 11px;top: 5px;">x</div>
<script>
    $('#loader').fadeOut();
    var chart = AmCharts.makeChart("chartdiv",{
        "type": "pie",        
        "titleField"  : "category",
        "valueField"  : "total",
        "colorField"  : "color",
        "dataProvider"  : [
            {
              "category": "Na Validade",
              "total": <?php echo $campos['validade']; ?>,
              "color": "#008000"
            },
            {
              "category": "Vencendo",
              "total": <?php echo $campos['proximo']; ?>,
              "color": "#f80"
            },
            {
              "category": "Vencido",
              "total": <?php echo $campos['vencido']; ?>,
              "color": "#ff0000"
            }
        ]
    });
</script>
<div id="chartdiv" style="width: 100%; height: 250px;"></div>
<br />
<center>
  <small style="opacity:0.8;">* Somente Produtos com a <b>Notificação Ativada</b> aparecem no gráfico</small>
</center>
<br />