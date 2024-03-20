<?php
	error_reporting(0);
	ini_set(“display_errors”, 0 );

    date_default_timezone_set('America/Sao_Paulo');
    ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../../project/session'));
    
    session_start();
    /*
    $_SESSION['valix']['assets']['version'] = ((isset($_SESSION['valix']['assets']['version'])) ? $_SESSION['valix']['assets']['version'] + 1 : 1);
	$assets_version = $_SESSION['valix']['assets']['version'];
	$version = "?version=$assets_version";
	*/
	$version = '?v=2';
	$caminho_raiz = "http://$_SERVER[HTTP_HOST]/";
	$caminho_raiz = '';
?>
	<!DOCTYPE html>
	<html lang="pt">

	<head>
		<title>Valix - Controle de Validade</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=0.9, user-scalable=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="google-signin-client_id" content="282334300322-lbmscfpn3o0c0i1u0fo2kc9mo9qbujnt.apps.googleusercontent.com">
		<link href="<?php echo $caminho_raiz; ?>app/assets/css/font-awesome.min.css<?php echo $version; ?>" rel="stylesheet">
		<link href="<?php echo $caminho_raiz; ?>app/assets/css/bootstrap.min.css<?php echo $version; ?>" rel="stylesheet">
		<link href="<?php echo $caminho_raiz; ?>app/assets/css/ionicons.css<?php echo $version; ?>" rel="stylesheet">
		<link href="<?php echo $caminho_raiz; ?>app/assets/css/mdb.min.css<?php echo $version; ?>" rel="stylesheet">
		<link href="<?php echo $caminho_raiz; ?>app/assets/css/style.css<?php echo $version; ?>" rel="stylesheet">
		<link href="<?php echo $caminho_raiz; ?>app/assets/css/sweetalert.css<?php echo $version; ?>" rel="stylesheet">
		<link href="<?php echo $caminho_raiz; ?>app/assets/css/themes/google/google.css<?php echo $version; ?>" rel="stylesheet">
		<link href="<?php echo $caminho_raiz; ?>app/assets/css/pgwmodal.min.css<?php echo $version; ?>" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Product+Sans' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="<?php echo $caminho_raiz; ?>app/assets/img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo "$caminho_raiz"; ?>app/assets/img/favicon.ico" type="image/x-icon">
	</head>
	<body class="elegant-color-dark">
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
		<nav class="navbar navbar-light bg-faded" style="border-radius:0;" id="home">
			<button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#navValix">
				<i class="fa fa-bars"></i>
			</button>
			<div class="container">
				<center class="hidden-sm-up"><img src="<?php echo $caminho_raiz; ?>app/assets/img/vale10_p.png" height="35px" class="animated bounceIn" /></center>
				<div class="collapse navbar-toggleable-xs" id="navValix">
					<a class="navbar-brand hidden-xs-down" href="."><img src="<?php echo $caminho_raiz; ?>app/assets/img/vale10_p.png" height="35px" class="animated bounceIn" /></a>
					<ul class="nav navbar-nav nav-flex-icons hidden-xs-down" style="margin-top:4px;">
						<li class=" hidden-sm-down" style="padding: 5px;"><a></a></li>
						<li class="">
							<a href="#funcionalidades" class="nav-link waves-effect waves-light" style="padding: 5px;">Funcionalidades</a>
						</li>
						<li class="hidden-sm-down"><a style="padding: 5px;"></a></li>
						<li class="">
							<a href="#precos" class="nav-link waves-effect waves-light" style="padding: 5px;">Preços</a>
						</li>
						<li class="hidden-sm-down"><a style="padding: 5px;"></a></li>
						<li class="hidden-xs-down"><a style="padding: 5px;"></a></li>
						<?php if(!isset($_SESSION['usuario'])){ ?>
							<li class="warning-color-dark" data-toggle="modal" data-target="#modalLogin">
								<a class="nav-link waves-effect waves-light" style="color:white;padding: 5px;">Entrar <i class="icon ion-person"></i></a>
							</li>
						<?php } else { ?>
							<li>
								<div class="btn-group">
									<button class="nav-link waves-effect waves-light dropdown-toggle btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-left: 10px; padding-right: 10px; padding-top: 9px; padding-bottom: 9px;"><i class="icon ion-person"></i> <?php echo $_SESSION['usuario']; ?></button>
									<div class="dropdown-menu">
								        <a class="dropdown-item" href="app/"><small>Acessar Conta</small></a>
								        <a class="dropdown-item" href="app/deslogar.php" style="color:red;"><small>Sair</small></a>
								    </div>
							   </div>
							</li>
						<?php } ?>
					</ul>
					<ul class="nav navbar-nav float-right hidden-sm-up">
						<li class="" style="padding: 5px;">
							<a class="nav-link waves-effect waves-light" href="#home">Home</a>
						</li>
						<li class="" style="padding: 5px;">
							<a class="nav-link waves-effect waves-light" href="#funcionalidades">Funcionalidades</a>
						</li>
						<li class="" style="padding: 5px;">
							<a class="nav-link waves-effect waves-light" href="#precos">Preços</a>
						</li>
						<?php if(!isset($_SESSION['usuario'])){ ?>
							<li class="warning-color-dark" data-toggle="modal" data-target="#modalLogin">
								<a class="nav-link waves-effect waves-light" style="color:white;padding: 5px;">Entrar <i class="icon ion-person"></i></a>
							</li>
						<?php } else { ?>
							<li style="width: 100%;">
								<div class="btn-group" style="width: 100%;">
									<button class="nav-link waves-effect waves-light dropdown-toggle btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-left: 10px; padding-right: 10px; padding-top: 9px; padding-bottom: 9px; width: 100%;"><i class="icon ion-person"></i> <?php echo $_SESSION['usuario']; ?></button>
									<div class="dropdown-menu">
								        <a class="dropdown-item" href="app/">Acessar Conta</a>
								        <a class="dropdown-item" href="app/deslogar.php" style="color:red;">Sair</a>
								    </div>
							   </div>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</nav>
		<div style="height: 300px;" class="container">
			<br /><br /><br />
			<center>
				<h4 style="color:white;">Controle a validade dos produtos no seu estoque <br /><br /> 100% online</h4>
				<br />
				<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalRegister">Teste Grátis Agora <i class="icon ion-checkmark-circled"></i></button>
				<br /><br />
				<a href="#funcionalidades" style="width:40px;color:white;padding:10px;cursor:pointer;" align="center">
					<i class="icon ion-chevron-down"></i>
				</a>
			</center>
		</div>		
		<video autoplay loop style="position: fixed;left: 0;bottom: 0;min-width: 100%;min-height: 100%;width: auto;height: auto;z-index: -1000;background-size: cover;background-position: left;top: -32px;opacity: 0.3;">
			<source src="<?php echo $caminho_raiz; ?>app/assets/video/supermarket.mp4" type="video/mp4" />
		</video>
		<div class="info-color-dark" id="funcionalidades" style="height:auto;">
			<div class="container">
				<div class="row nomargin">
					<div class="col-md-12" align="center" style="color:white;">
						<br />
						<h3><i class="icon ion-star" style="font-size:18px;top:-6px;"></i> Funcionalidades <i class="icon ion-star" style="font-size:18px"></i></h3>
						<hr />
					</div>
				</div>
				<div class="row nomargin">
					<div class="col-md-4 animated bounceIn" align="center" style="color:white;">
						<br />
						<span style="font-size:22px;">Organização <i class="icon ion-cube"></i></span>
						<br /><br />
						Organize os seus produtos por categorias, subcategorias, marcas e fornecedores.
						<hr />
						Tenha um controle completo dos seus produtos.
						<br /><br />
					</div>
					<div class="col-md-4 animated bounceIn" align="center" style="color:white;">
						<br />
						<span style="font-size:22px;">Notificações <i class="icon ion-android-notifications"></i></span>
						<br /><br />
						Receba notificações por Email e SMS com configurações personalizadas.
						<hr />
						Você pode escolher Datas especificas a cada mês, semana ou dia.
						<br /><br />
					</div>
					<div class="col-md-4 animated bounceIn" align="center" style="color:white;">
						<br />
						<span style="font-size:22px;">Relatórios <i class="icon ion-pie-graph"></i></span>
						<br /><br />
						Gere relatórios completos com informações amplas sobre a validade dos produtos.
						<hr />
						Realize o acompanhamento dos seus produtos com uma ampla variedade de filtros.
						<br /><br />
					</div>
				</div>
				<div class="row nomargin">
					<div class="col-md-12">
						<hr />
						
					</div>
				</div>
				<div class="row nomargin">
					<div class="col-md-12">
						<center>
							<a href="#precos" style="width:40px;color:white;padding:10px;cursor:pointer;" align="center">
								<i class="icon ion-chevron-down"></i>
							</a>
						</center>
						<br />
					</div>
				</div>
			</div>
		</div>		
		<div style="background:white;height:auto;" id="precos">			
			<section class="section container" style="margin-bottom:0;">
				<div class="row nomargin">
					<div class="col-md-12" align="center">
						<br />
						<h3><i class="icon ion-star" style="font-size:18px;top:-6px;"></i> Preços <i class="icon ion-star" style="font-size:18px"></i></h3>
						<hr />
					</div>
				</div>
				<br />
				<div class="row nomargin">
					<div class="col-lg-5 offset-lg-1 col-md-6 col-sm-6 mb-r">
						<div class="card pricing-card">
							<div class="header green" style="padding:8px;">
								<div class="version" align="center">
									<h5 style="color:white;">Gratuito</h5>
									<h1 style="color:white;">GRÁTIS</h1>
								</div>
							</div>
							<div class="card-block striped">
								<ul>
									<li>
										<p><i class="fa fa-check"></i> Sim</p>
									</li>
									<li>
										<p><i class="fa fa-times"></i> Não </p>
									</li>
									<li>
										<p><i class="fa fa-times"></i> Não </p>
									</li>
								</ul>
								<center>
									<button class="btn btn-success" data-toggle="modal" data-target="#modalRegister">Cadastrar</button>
								</center>
							</div>
						</div>
					</div>
					<div class="col-lg-5 col-md-6 col-sm-6 mb-r">
						<div class="card pricing-card">
							<div class="header blue" style="padding:8px;">
								<div class="version" align="center">
									<h5 style="color:white;">Premium</h5>
									<h1 style="color:white;">R$ 15 <small><small><small>/ mês</small></small></small></h1>
								</div>
							</div>
							<div class="card-block striped">
								<ul>
									<li>
										<p><i class="fa fa-check"></i> Sim</p>
									</li>
									<li>
										<p><i class="fa fa-check"></i> Sim</p>
									</li>
									<li>
										<p><i class="fa fa-times"></i> Não </p>
									</li>
								</ul>
								<center>
									<button class="btn btn-primary" data-toggle="modal" data-target="#modalRegister">Contratar</button>
								</center>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div style="width:100%;" class="elegant-color">
			<div class="container" align="center" style="padding-top:15px;padding-bottom:15px;color:white;">
				Desenvolvido por <strong>Valix</strong> © <?php echo date('Y'); ?>
			</div>
		</div>
		<?php include_once('modals.php'); ?>
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>app/assets/js/jquery-3.1.1.min.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>app/assets/js/tether.min.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>app/assets/js/bootstrap.min.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>app/assets/js/mdb.min.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>app/assets/js/sweetalert.min.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>app/assets/js/script.js<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo $caminho_raiz; ?>app/assets/js/pgwmodal.min.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>app/assets/js/pickadate/picker.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>app/assets/js/pickadate/picker.date.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>app/assets/js/pickadate/picker.time.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>app/assets/js/pickadate/legacy.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>app/assets/js/pickadate/translations/pt_BR.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>app/assets/js/jquery.ui.position.min.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>app/assets/js/jquery.contextMenu.min.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>app/assets/js/jquery.mask.js<?php echo $version; ?>"></script>
		<script src="<?php echo $caminho_raiz; ?>app/assets/js/jquery.complexify.js<?php echo $version; ?>"></script>
	</body>

	</html>