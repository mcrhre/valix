<?php
	class Usuario {
		
		private $codigo;
		private $usuario;
		private $senha;
		
		function getCodigo()
		{
			return $this->codigo;
		}

		function setCodigo($codigo)
		{
			$this->codigo = $codigo;
		}
		
		function getUsuario()
		{
			return $this->usuario;
		}

		function setUsuario($usuario)
		{
			$this->usuario = $usuario;
		}
		
		function getSenha()
		{
			return $this->senha;
		}

		function setSenha($senha)
		{
			$this->senha = $senha;
		}
	}
?>