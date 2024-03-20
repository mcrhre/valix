<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLogin" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title w-100" id="myModalLabel">Acesse sua conta</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="logar.php">
                    <br />
                    <div class="md-form">
                        <i class="fa fa-envelope prefix"></i>
                        <input type="text" id="usuario" name="usuario" class="form-control">
                        <label for="usuario">Email</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-lock prefix"></i>
                        <input type="password" id="senha" name="senha" class="form-control">
                        <label for="senha">Senha</label>
                    </div>
                    <div class="text-xs-center">
                        <button class="btn btn-warning btn-dark" type="submit" id="login">Entrar</button>
                    </div>
                    <br />
                    <div class="text-xs-center">
                        <a href="#" data-toggle="modal" data-target="#modalEsqueci" data-dismiss="modal" aria-label="Close">Esqueci minha senha</a>
                    </div>
                </form>
            </div>	
        </div>
    </div>
</div>
<div class="modal fade" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="modalRegister" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title w-100">Cadastre-se</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin:0;">
                    <div class="col-md-4">
                        <div class="md-form" style="margin:0;margin-top:12px;">
                            <input type="text" id="nome" class="form-control" style="margin:0;padding-left:5px;" name="nome" placeholder="" maxlength="18" />
                            <label for="nome" class="">Nome</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="md-form" style="margin:0;margin-top:12px;">
                            <input type="email" id="email" class="form-control" style="margin:0;padding-left:5px;" name="email" placeholder="" />
                            <label for="email" class="">E-mail</label>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row" style="margin:0;">
                    <div class="col-md-4">
                        <div class="md-form" style="margin:0;margin-top:12px;">
                            <input type="password" id="nova" class="form-control" style="margin:0;padding-left:5px;" name="senha" placeholder="" maxlength="18" />
                            <label for="senha" class="">Senha</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="md-form" style="margin:0;margin-top:12px;">
                            <input type="password" id="confirmacao" class="form-control" style="margin:0;padding-left:5px;" name="confirmacao" placeholder="" maxlength="18" />
                            <label for="confirmacao" class="">Confirmação de Senha</label>
                        </div>
                    </div>
                    <div class="col-md-4" align="center">
                        <button class="btn btn-success" onclick="realizar_cadastro();">Cadastrar</button>
                    </div>
                    <div class="col-md-12">
                        <br /><span id="nivel_senha"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEsqueci" tabindex="-1" role="dialog" aria-labelledby="modalEsqueci" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title w-100">Esqueci minha senha</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin:0;">
                    <div class="col-md-12">
                        <div class="md-form" style="margin:0;margin-top:12px;">
                            <input type="email" id="email_esqueci" class="form-control" style="margin:0;padding-left:5px;" name="email_esqueci" placeholder="Digite seu email" />
                            <label for="email_esqueci" class="">E-mail</label>
                        </div>
                    </div>
                </div>     
                <br />
                <div class="text-xs-center">
                    <button class="btn btn-warning btn-dark" type="submit" id="login">Enviar</button>
                </div>       
            </div>
        </div>
    </div>
</div>