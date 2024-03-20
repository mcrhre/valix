<?php
	class UsuarioEmail {
		
		private $codigo;
		private $email;
		private $usuario;
		
		function getCodigo()
		{
		  return $this->codigo;
		}

		function setCodigo($codigo)
		{
		  $this->codigo = $codigo;
		}
		
		function getEmail()
		{
		  return $this->email;
		}

		function setEmail($email)
		{
		  $this->email = $email;
		}
		
		function getUsuario()
		{
		  return $this->usuario;
		}
		
		function setUsuario($usuario)
		{
		  $this->usuario = $usuario;
		}
	}
?>