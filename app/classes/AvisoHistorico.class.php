<?php
	class AvisoHistorico {
		
		private $codigo;
		private $usuario;
		private $tipo_aviso;
		private $data;
		private $aviso_email;
		private $aviso_sms;
		private $url_hash;
		private $relatorio;
		
		function getCodigo()
		{
		  return $this->codigo;
		}

		function setCodigo($codigo)
		{
		  $this->codigo = $codigo;
		}
		
		function getTipoAviso()
		{
		  return $this->tipo_aviso;
		}

		function setTipoAviso($tipo_aviso)
		{
		  $this->tipo_aviso = $tipo_aviso;
		}
		
		function getUsuario()
		{
		  return $this->usuario;
		}
		
		function setUsuario($usuario)
		{
		  $this->usuario = $usuario;
		}
		
		function getData()
		{
		  return $this->data;
		}
		
		function setData($data)
		{
		  $this->data = $data;
		}
		
		function getAvisoEmail()
		{
		  return $this->aviso_email;
		}
		
		function setAvisoEmail($aviso_email)
		{
		  $this->aviso_email = $aviso_email;
		}
		
		function getAvisoSMS()
		{
		  return $this->aviso_sms;
		}
		
		function setAvisoSMS($aviso_sms)
		{
		  $this->aviso_sms = $aviso_sms;
		}
		
		function getURLHash()
		{
		  return $this->url_hash;
		}
		
		function setURLHash($url_hash)
		{
		  $this->url_hash = $url_hash;
		}
		
		function getRelatorio()
		{
		  return $this->relatorio;
		}
		
		function setRelatorio($relatorio)
		{
		  $this->relatorio = $relatorio;
		}
	}
?>