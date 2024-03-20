<?php
	class Categoria {
		
		private $codigo;
		private $nome;
		private $usuario;
		
		function getCodigo()
		{
		  return $this->codigo;
		}

		function setCodigo($codigo)
		{
		  $this->codigo = $codigo;
		}
		
		function getNome()
		{
		  return $this->nome;
		}

		function setNome($nome)
		{
		  $this->nome = $nome;
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