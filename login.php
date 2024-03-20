<?php
  date_default_timezone_set('America/Sao_Paulo');
  $version = 1;
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.9, shrink-to-fit=no, user-scalable=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Valix</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
  <link href="app/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="app/assets/css/mdb.min.css" rel="stylesheet">
  <link href="app/assets/css/style.css?version=<?php echo $version; ?>" rel="stylesheet">
  <link href="app/assets/css/sweetalert2.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
  <link rel="shortcut icon" href="app/assets/img/favicon.ico" type="image/x-icon">
  <link rel="icon" href="app/assets/img/favicon.ico" type="image/x-icon">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body class="elegant-color-dark">
  <div style="height: 100vh">
    <div class="flex-center">
      <form method="POST" action="logar.php">
        <div class="card">
          <div class="card-block">
              <div class="form-header" align="center">
               <img src="app/assets/img/vale10_p.png" style="margin-left:80px;margin-right:80px;" />
              </div>
              <br />
              <div class="md-form">
               <i class="fa fa-envelope prefix"></i>
               <input type="text" id="usuario" name="usuario" class="form-control">
               <label for="usuario">Usuário</label>
              </div>
              <div class="md-form">
               <i class="fa fa-lock prefix"></i>
               <input type="password" id="senha" name="senha" class="form-control">
               <label for="senha">Senha</label>
              </div>
              <div class="text-xs-center">
               <button class="btn btn-primary btn-dark" type="submit" id="login">Entrar</button>
              </div>
          </div>
          <div class="modal-footer">
              <div class="options" align="center">
               <p><a href="#">Esqueci minha senha?</a></p>
              </div>
          </div>
          <div class="modal-footer warning-color-dark">
              <div class="options" align="center" style="color:white;">
               <p>Quer se cadastrar? <a href="#">Clique aqui</a></p>
              </div>
          </div>
        </div>
      </form>
    </div>
    <?php ?>
  </div>
  <script type="text/javascript" src="app/assets/js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="app/assets/js/tether.min.js"></script>
  <script type="text/javascript" src="app/assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="app/assets/js/mdb.min.js"></script>
  <script type="text/javascript" src="app/assets/js/sweetalert2.min.js"></script>
  <script type="text/javascript" src="app/assets/js/script.js?version=<?php echo $version; ?>"></script>
</body>

</html>