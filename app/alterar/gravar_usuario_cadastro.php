<?php
	header('Content-Type: application/json');

	date_default_timezone_set('America/Sao_Paulo');
	
	include_once('../autoload.php');
	
	Login::verificarLogado();
	
	if ($_POST){
		
		$usuario_cadastro = New UsuarioCadastro();
		
		$usuario_cadastro->setUsuario(Login::codigoUsuario());
		$usuario_cadastro->setNome(Funcao::normalizarNome($_POST['nome']));
		$usuario_cadastro->setDocumento($_POST['documento']);
		$usuario_cadastro->setTelefone($_POST['telefone']);
		$usuario_cadastro->setCelular($_POST['celular']);
		$usuario_cadastro->setEmail($_POST['email']);
		$usuario_cadastro->setEndereco(utf8_decode(Funcao::normalizarNome($_POST['endereco'])));
		$usuario_cadastro->setNumero($_POST['numero']);
		$usuario_cadastro->setComplemento(Funcao::normalizarNome($_POST['complemento']));
		$usuario_cadastro->setCep($_POST['cep']);
		$usuario_cadastro->setBairro(utf8_decode(Funcao::normalizarNome($_POST['bairro'])));
		$usuario_cadastro->setCidade(utf8_decode(Funcao::normalizarNome($_POST['cidade'])));
		$usuario_cadastro->setEstado($_POST['estado']);
		
		$usuario_cadastro_dao = New UsuarioCadastroDAO();
		
		$rs_usuario_cadastro = $usuario_cadastro_dao->updateUsuarioCadastro($usuario_cadastro);

		$resul_json = json_decode($rs_usuario_cadastro);
				
		//verifica se deu algum erro
		if (array_key_exists('mensagem', $resul_json))
		{
			Funcao::gravarLog(Login::codigoUsuario(), $rs_usuario_cadastro, __FILE__, __LINE__, 'erros');
		}

		echo $rs_usuario_cadastro;
	}
?>

