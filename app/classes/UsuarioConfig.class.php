<?php
	class UsuarioConfig{
		
		private $codigo;
		private $usuario;
		private $aviso_validade;
		private $tipo_aviso_validade;
		private $aviso_vencido;
		private $tipo_aviso_vencido;
		private $aviso_periodo;
		private $tipo_aviso_periodo;
		private $receber_sms_periodo;
		private $receber_email_periodo;
		private $receber_sms_validade;
		private $receber_email_validade;
		private $receber_aviso_periodo;
		
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
		
		function getAvisoValidade()
		{
			return $this->aviso_validade;
		}

		function setAvisoValidade($aviso_validade)
		{
			$this->aviso_validade = $aviso_validade;
		}
		
		function getTipoAvisoValidade()
		{
			return $this->tipo_aviso_validade;
		}

		function setTipoAvisoValidade($tipo_aviso_validade)
		{
			$this->tipo_aviso_validade = $tipo_aviso_validade;
		}
		
		function getAvisoVencido()
		{
			return $this->aviso_vencido;
		}

		function setAvisoVencido($aviso_vencido)
		{
			$this->aviso_vencido = $aviso_vencido;
		}
		
		function getTipoAvisoVencido()
		{
			return $this->tipo_aviso_vencido;
		}

		function setTipoAvisoVencido($tipo_aviso_vencido)
		{
			$this->tipo_aviso_vencido = $tipo_aviso_vencido;
		}
		
		function getAvisoPeriodo()
		{
			return $this->aviso_periodo;
		}

		function setAvisoPeriodo($aviso_periodo)
		{
			$this->aviso_periodo = $aviso_periodo;
		}
		
		function getTipoAvisoPeriodo()
		{
			return $this->tipo_aviso_periodo;
		}

		function setTipoAvisoPeriodo($tipo_aviso_periodo)
		{
			$this->tipo_aviso_periodo = $tipo_aviso_periodo;
		}
		
		function getReceberSmsPeriodo()
		{
			return $this->receber_sms_periodo;
		}

		function setReceberSmsPeriodo($receber_sms_periodo)
		{
			$this->receber_sms_periodo = $receber_sms_periodo;
		}
		
		function getReceberEmailPeriodo()
		{
			return $this->receber_email_periodo;
		}

		function setReceberEmailPeriodo($receber_email_periodo)
		{
			$this->receber_email_periodo = $receber_email_periodo;
		}
		
		function getReceberSmsValidade()
		{
			return $this->receber_sms_validade;
		}

		function setReceberSmsValidade($receber_sms_validade)
		{
			$this->receber_sms_validade = $receber_sms_validade;
		}
		
		function getReceberEmailValidade()
		{
			return $this->receber_email_validade;
		}

		function setReceberEmailValidade($receber_email_validade)
		{
			$this->receber_email_validade = $receber_email_validade;
		}
		
		function getReceberAvisoPeriodo()
		{
			return $this->receber_aviso_periodo;
		}

		function setReceberAvisoPeriodo($receber_aviso_periodo)
		{
			$this->receber_aviso_periodo = $receber_aviso_periodo;
		}
	}
?>