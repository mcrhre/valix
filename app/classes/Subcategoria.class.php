<?php
	class Subcategoria {
		
		private $codigo;
		private $nome;
		private $categoria;
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
		
		function getCategoria()
		{
		  return $this->categoria;
		}

		function setCategoria($categoria)
		{
		  $this->categoria = $categoria;
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