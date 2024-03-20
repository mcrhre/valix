<?php
	class AvisoPeriodico {
		
		private $codigo;
		private $usuario;
		private $data_aviso_ultimo;
		private $data_aviso_proximo;
		
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
		
		function getDataAvisoUltimo()
		{
		  return $this->data_aviso_ultimo;
		}
		
		function setDataAvisoUltimo($data_aviso_ultimo)
		{
		  $this->data_aviso_ultimo = $data_aviso_ultimo;
		}
		
		function getDataAvisoProximo()
		{
		  return $this->data_aviso_proximo;
		}
		
		function setDataAvisoProximo($data_aviso_proximo)
		{
		  $this->data_aviso_proximo = $data_aviso_proximo;
		}
	}
?>