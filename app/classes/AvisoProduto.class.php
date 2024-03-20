<?php
	class AvisoProduto {
		
		private $codigo;
		private $produto;
		private $usuario;
		private $data_aviso_inicial;
		private $data_aviso_final;
		
		function getCodigo()
		{
		  return $this->codigo;
		}

		function setCodigo($codigo)
		{
		  $this->codigo = $codigo;
		}
		
		function getProduto()
		{
		  return $this->produto;
		}

		function setProduto($produto)
		{
		  $this->produto = $produto;
		}
		
		function getUsuario()
		{
		  return $this->usuario;
		}
		
		function setUsuario($usuario)
		{
		  $this->usuario = $usuario;
		}
		
		function getDataAvisoInicial()
		{
		  return $this->data_aviso_inicial;
		}
		
		function setDataAvisoInicial($data_aviso_inicial)
		{
		  $this->data_aviso_inicial = $data_aviso_inicial;
		}
		
		function getDataAvisoFinal()
		{
		  return $this->data_aviso_final;
		}
		
		function setDataAvisoFinal($data_aviso_final)
		{
		  $this->data_aviso_final = $data_aviso_final;
		}
	}
?>