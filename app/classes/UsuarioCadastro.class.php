<?php
	class UsuarioCadastro {
		
		private $codigo;
		private $usuario;
		private $nome;
		private $documento;
		private $telefone;
		private $celular;
		private $email;
		private $endereco;
		private $numero;
		private $complemento;
		private $cep;
		private $bairro;
		private $cidade;
		private $estado;
		private $data_cadastro;
		
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
		
		function getNome()
		{
			return $this->nome;
		}

		function setNome($nome)
		{
			$this->nome = $nome;
		}
		
		function getDocumento()
		{
			return $this->documento;
		}

		function setDocumento($documento)
		{
			$this->documento = $documento;
		}
		
		function getTelefone()
		{
			return $this->telefone;
		}

		function setTelefone($telefone)
		{
			$this->telefone = $telefone;
		}
		
		function getCelular()
		{
			return $this->celular;
		}

		function setCelular($celular)
		{
			$this->celular = $celular;
		}
		
		function getEmail()
		{
			return $this->email;
		}

		function setEmail($email)
		{
			$this->email = $email;
		}
		
		function getEndereco()
		{
			return $this->endereco;
		}

		function setEndereco($endereco)
		{
			$this->endereco = $endereco;
		}
		
		function getNumero()
		{
			return $this->numero;
		}

		function setNumero($numero)
		{
			$this->numero = $numero;
		}
		
		function getComplemento()
		{
			return $this->complemento;
		}

		function setComplemento($complemento)
		{
			$this->complemento = $complemento;
		}
		
		function getCep()
		{
			return $this->cep;
		}

		function setCep($cep)
		{
			$this->cep = $cep;
		}
		
		function getBairro()
		{
			return $this->bairro;
		}

		function setBairro($bairro)
		{
			$this->bairro = $bairro;
		}
		
		function getCidade()
		{
			return $this->cidade;
		}

		function setCidade($cidade)
		{
			$this->cidade = $cidade;
		}
		
		function getEstado()
		{
			return $this->estado;
		}

		function setEstado($estado)
		{
			$this->estado = $estado;
		}
		
		function getDataCadastro()
		{
			return $this->data_cadastro;
		}

		function setDataCadastro($data_cadastro)
		{
			$this->data_cadastro = $data_cadastro;
		}
	}
?>