<!-- Desenvolvido por Valix 2016 -->
<?php
	error_reporting(0);
	ini_set(“display_errors”, 0 );
	
	date_default_timezone_set('America/Sao_Paulo');
	include_once('autoload.php');

	Login::verificarLogado();

	$aviso_vali_dao = New AvisoHistoricoDAO();
	$avisos = $aviso_vali_dao->selectAvisoLeitura(Login::codigoUsuario());
	/*
	$_SESSION['valix']['assets']['version'] = ((isset($_SESSION['valix']['assets']['version'])) ? $_SESSION['valix']['assets']['version'] + 1 : 1);
	$assets_version = $_SESSION['valix']['assets']['version'];
	$version = "?version=$assets_version";
	$version = '?version=6';
	*/

  	$version = '?v=5';

	$caminho_raiz = "http://$_SERVER[HTTP_HOST]/app/";
	$caminho_raiz = '';
?>
	<!DOCTYPE html>
	<html lang="pt">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>Valix - Controle de Validade</title>
		<!-- CSS -->
		<link href="<?php echo $caminho_raiz; ?>assets/css/font-awesome.min.css<?php echo $version; ?>" rel="stylesheet">
		<link href="<?php echo $caminho_raiz; ?>assets/css/bootstrap.min.css<?php echo $version; ?>" rel="stylesheet">
		<link href="<?php echo $caminho_raiz; ?>assets/css/ionicons.css<?php echo $version; ?>" rel="stylesheet">
		<link href="<?php echo $caminho_raiz; ?>assets/css/mdb.min.css<?php echo $version; ?>" rel="stylesheet">
		<link href="<?php echo $caminho_raiz; ?>assets/css/datepicker.css<?php echo $version; ?>" rel="stylesheet">
		<link href="<?php echo $caminho_raiz; ?>assets/css/style.css<?php echo $version; ?>" rel="stylesheet">
		<link href="<?php echo $caminho_raiz; ?>assets/css/sweetalert.css<?php echo $version; ?>" rel="stylesheet">
		<!--<link href="<?php echo $caminho_raiz; ?>assets/css/themes/google/google.css<?php echo $version; ?>" rel="stylesheet">-->
		<link href="<?php echo $caminho_raiz; ?>assets/css/pgwmodal.min.css<?php echo $version; ?>" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo $caminho_raiz; ?>assets/css/pickadate/default.css<?php echo $version; ?>" id="theme_base">
		<link rel="stylesheet" href="<?php echo $caminho_raiz; ?>assets/css/pickadate/default.date.css<?php echo $version; ?>" id="theme_date">
		<link rel="stylesheet" href="<?php echo $caminho_raiz; ?>assets/css/pickadate/default.time.css<?php echo $version; ?>" id="theme_time">
		<link href="<?php echo $caminho_raiz; ?>assets/css/jquery.contextMenu.min.css<?php echo $version; ?>" rel="stylesheet">
		<!-- FONTS -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Product+Sans' rel='stylesheet' type='text/css'>
		<!-- FAVICON -->
		<link rel="shortcut icon" href="<?php echo $caminho_raiz; ?>assets/img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo $caminho_raiz; ?>assets/img/favicon.ico" type="image/x-icon">
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>assets/js/jquery-3.1.1.min.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>assets/js/tether.min.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>assets/js/bootstrap.min.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>assets/js/mdb.min.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>assets/js/sweetalert.min.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>assets/js/pgwmodal.min.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>assets/js/pickadate/picker.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>assets/js/pickadate/picker.date.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>assets/js/pickadate/picker.time.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>assets/js/pickadate/legacy.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>assets/js/pickadate/translations/pt_BR.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>assets/js/jquery.ui.position.min.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>assets/js/jquery.contextMenu.min.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>assets/js/jquery.mask.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>assets/js/jquery.complexify.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>assets/js/jspdf.min.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>assets/js/printThis.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>assets/amcharts/amcharts.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>assets/amcharts/pie.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>assets/js/mascara.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>assets/js/script.js<?php echo $version; ?>"></script>
	</head>

	<body onoffline="$('#semConexao').fadeIn();$('#comConexao').fadeOut();" ononline="$('#semConexao').fadeOut();$('#comConexao').fadeIn().delay(5000).fadeOut();">
		<!--<span class="context-menu-one btn btn-neutral">right click me</span>-->
		<!-- API Facebook -->
		<script>
		  window.fbAsyncInit = function() {
		    FB.init({
		      appId      : '1719754781648792',
		      xfbml      : true,
		      version    : 'v2.8'
		    });
		    FB.AppEvents.logPageView();
		  };

		  (function(d, s, id){
		     var js, fjs = d.getElementsByTagName(s)[0];
		     if (d.getElementById(id)) {return;}
		     js = d.createElement(s); js.id = id;
		     js.src = "//connect.facebook.net/en_US/sdk.js";
		     fjs.parentNode.insertBefore(js, fjs);
		   }(document, 'script', 'facebook-jssdk'));
		</script>
		<div id="semConexao" style="display:none;float: right;position: fixed;background: red;right: 0;top: 0;z-index: 10000;padding: 10px;margin: 20px;color: white;border-radius: 10px;">Sem conexão com a internet <i class="icon ion-alert-circled"></i></div>
		<div id="comConexao" style="display:none;float: right;position: fixed;background: green;right: 0;top: 0;z-index: 10000;padding: 10px;margin: 20px;color: white;border-radius: 10px;">Conexão reestabelecida <i class="icon ion-wifi"></i></div>
		<form class="hidden"></form>
		<div class="elegant-color-dark" id="loader">
			<div style="height: 100vh;width:100%;" align="center">
				<div class="flex-center">
					<img src="<?php echo $caminho_raiz; ?>assets/img/vale10_b.png" />
					<br />
					<p><i class="fa fa-spinner fa-spin fa-3x fa-fw text-warning"></i></p>					
				</div>
			</div>
		</div>
		<div class="row" style="margin:0;">
			<div class="col-md-12 elegant-color-dark hidden-md-up" id="containerTopMenu">
				<button class="btn btn-primary btn-sm" id="enableLeftMenu">
		        	&nbsp;<i class="fa fa-bars"></i>&nbsp;
		      	</button>
				<center><img src="<?php echo $caminho_raiz; ?>assets/img/valix_gratuito_b.png" id="logoTopMenu" /></center>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 hidden-sm-down" id="colLeftMenu">
				<div id="containerLeftMenu">
					<br class="hidden-sm-down" />
					<div class="container hidden-sm-down" id="containerLogoLeftMenu" align="center" style="background:#565656;padding-top:11px;padding-bottom:11px;margin-top:-24px;margin-bottom:6px !important;">
						<img src="<?php echo $caminho_raiz; ?>assets/img/valix_gratuito_b.png" id="logoLeftMenu"  class="animated bounceIn"/>
					</div>
					<div>
						<center style="background:#272727;">
							<a data-href="inicio" data-select="1" class="hidden nav-link button-menu menuItem <?php if($_GET['page'] == 'inicio'){ echo " button-menu-active "; } else { echo "nonactiveItem ";  } ?>" style="margin-top:0 !important;">
								<i class="icon ion-home fa-menus-left hidden-md-down iLeftMenu"></i>
								<span class="hidden-sm-down textLeftMenu">Tela Inicial</span>
								<small class="hidden-md-up textLeftMenu">Tela Inicial</small>
							</a>
							<a data-href="produto" data-select="1" class="nav-link button-menu menuItem <?php if($_GET['page'] == 'produto' || !isset($_GET['page'])){ echo " button-menu-active "; } else { echo "nonactiveItem ";  } ?>">
								<i class="icon ion-cube fa-menus-left hidden-md-down iLeftMenu"></i>
								<span class="hidden-sm-down textLeftMenu">Produtos</span>
								<small class="hidden-md-up textLeftMenu">Produtos</small>
							</a>
			              	<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#cadastroAuxiliar2" aria-expanded="false" aria-controls="cadastroAuxiliar2" style="display:none;" id="CadastroAuxiliar">
			              	</button>
							<div class="dividerLeftMenu"></div>
							<a data-select="1" class="nav-link button-menu nonactiveItem" id="botaoAuxiliar" onclick="$('#chevronAuxiliar').toggleClass('ion-android-arrow-dropdown');$('#chevronAuxiliar').toggleClass('ion-android-arrow-dropup');$('#CadastroAuxiliar').click();" data-toggle="collapse" href="#cadastroAuxiliar2" aria-expanded="false" aria-controls="cadastroAuxiliar2" 
							style="<?php if($_GET['page']=='marca'||$_GET['page']=='categoria'||$_GET['page']=='subcategoria'||$_GET['page']=='unidade_medida'||$_GET['page']=='fornecedor'){echo 'opacity: 1 !important;';} ?>">
								<span class="hidden-sm-down textLeftMenu"><span class="hidden-md-down">Cadastro</span> Auxiliar</span>
								<small class="hidden-md-up textLeftMenu"> Auxiliar</small>
								<i class="fa <?php if($_GET['page']=='marca'||$_GET['page']=='categoria'||$_GET['page']=='subcategoria'||$_GET['page']=='unidade_medida'||$_GET['page']=='fornecedor'){echo 'ion-android-arrow-dropup';}else{echo 'ion-android-arrow-dropdown';} ?> fa-menus-right iLeftMenu" id="chevronAuxiliar" style="margin-top:2px;font-size:22px;"></i>
							</a>
							<div id="cadastroAuxiliar2" class="collapse <?php if($_GET['page']=='marca'||$_GET['page']=='categoria'||$_GET['page']=='subcategoria'||$_GET['page']=='unidade_medida'||$_GET['page']=='fornecedor'){echo 'in';}?>">
                				<div class="dividerLeftMenu" id="dividerDown"></div>
								<a data-href="marca" data-select="1" class="nav-link button-menu menuItem <?php if($_GET['page'] == 'marca'){ echo " button-menu-active "; } else { echo "nonactiveItem ";  } ?>">
									<i class="icon ion-pricetags fa-menus-left hidden-md-down iLeftMenu"></i>
									<span class="hidden-sm-down textLeftMenu">Marcas</span>
									<small class="hidden-md-up textLeftMenu">Marcas</small>
								</a>
								<a data-href="categoria" data-select="1" class="nav-link button-menu menuItem <?php if($_GET['page'] == 'categoria'){ echo " button-menu-active "; } else { echo "nonactiveItem ";  } ?>">
									<i class="icon ion-grid fa-menus-left hidden-md-down iLeftMenu"></i>
									<span class="hidden-sm-down textLeftMenu">Categorias</span>
									<small class="hidden-md-up textLeftMenu">Categorias</small>
								</a>
								<a data-href="subcategoria" data-select="1" class="nav-link button-menu menuItem <?php if($_GET['page'] == 'subcategoria'){ echo " button-menu-active "; } else { echo "nonactiveItem ";  } ?>">
									<i class="icon ion-more fa-menus-left hidden-md-down iLeftMenu"></i>
									<span class="hidden-sm-down textLeftMenu">Subcategorias</span>
									<small class="hidden-md-up textLeftMenu">Subcategorias</small>
								</a>
								<a data-href="unidade_medida" data-select="1" class="nav-link button-menu menuItem <?php if($_GET['page'] == 'unidade_medida'){ echo " button-menu-active "; } else { echo "nonactiveItem ";  } ?>">
									<i class="icon ion-android-funnel fa-menus-left hidden-md-down iLeftMenu"></i>
									<span class="hidden-sm-down textLeftMenu">Unidade/Medida</span>
									<small class="hidden-md-up textLeftMenu">Unidade<br />Medida</small>
								</a>
								<a data-href="fornecedor" data-select="1" class="nav-link button-menu menuItem <?php if($_GET['page'] == 'fornecedor'){ echo " button-menu-active "; } else { echo "nonactiveItem ";  } ?>">
									<i class="icon ion-person-stalker fa-menus-left hidden-md-down iLeftMenu"></i>
									<span class="hidden-sm-down textLeftMenu">Fornecedores</span>
									<small class="hidden-md-up textLeftMenu">Fornecedores</small>
								</a>
							</div>
							<div class="dividerLeftMenu"></div>
							<a data-href="relatorio" data-select="1" class="nav-link button-menu menuItem <?php if($_GET['page'] == 'relatorio'){ echo " button-menu-active "; } else { echo "nonactiveItem ";  } ?>">
								<i class="icon ion-pie-graph fa-menus-left hidden-md-down iLeftMenu"></i>
								<span class="hidden-sm-down textLeftMenu">Relatórios</span>
								<small class="hidden-md-up textLeftMenu">Relatórios</small>
							</a>
							<a data-href="ajuda" data-select="1" class="nav-link button-menu menuItem <?php if($_GET['page'] == 'ajuda'){ echo " button-menu-active "; } else { echo "nonactiveItem ";  } ?>">
								<i class="icon ion-ios-help fa-menus-left hidden-md-down iLeftMenu"></i>
								<span class="hidden-sm-down textLeftMenu">Ajuda</span>
								<small class="hidden-md-up textLeftMenu">Ajuda</small>
							</a>
							<a data-href="ajustes" data-select="1" class="nav-link button-menu menuItem <?php if($_GET['page'] == 'ajustes'){ echo " button-menu-active "; } else { echo "nonactiveItem ";  } ?>">
								<i class="icon ion-ios-cog fa-menus-left hidden-md-down iLeftMenu"></i>
								<span class="hidden-sm-down textLeftMenu">Ajustes</span>
								<small class="hidden-md-up textLeftMenu">Ajustes</small>
							</a>
							<a onclick="logout();" class="nav-link button-menu nonactiveItem">
								<i class="icon ion-android-exit fa-menus-left hidden-md-down iLeftMenu"></i>
								<span class="textLeftMenu">Sair</span>
							</a>
							<a class="nav-link button-menu" style="max-width:70px;background:#4285f4;margin-top:30px;padding:2px;" onclick="abrirHistoricoNovo();">
								<i class="icon ion-ios-bell iLeftMenu"></i> <?php echo $avisos; ?>
							</a>
						</center>
					</div>
				</div>
			</div>
			<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" id="colMainMenu">
				<div id="main-page">