<?php
	class UsuarioTelefone {
		
		private $codigo;
		private $telefone;
		private $usuario;
		
		function getCodigo()
		{
		  return $this->codigo;
		}

		function setCodigo($codigo)
		{
		  $this->codigo = $codigo;
		}
		
		function getTelefone()
		{
		  return $this->telefone;
		}

		function setTelefone($telefone)
		{
		  $this->telefone = $telefone;
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