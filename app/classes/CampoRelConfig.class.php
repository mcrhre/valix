<?php
	class CampoRelConfig{
		
		private $codigo;
		private $usuario;
		private $c_marca;
		private $c_categoria;
		private $c_subcategoria;
		private $c_status;
		private $c_preco_custo;
		private $c_quantidade;
		private $c_data_validade;
		private $c_data_cadastro;
		private $c_fornecedor;
		private $c_localizacao;
		private $c_lote;
		private $c_descricao;
		
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
		
		function getCMarca()
		{
			return $this->c_marca;
		}

		function setCMarca($c_marca)
		{
			$this->c_marca = $c_marca;
		}
		
		function getCCategoria()
		{
			return $this->c_categoria;
		}

		function setCCategoria($c_categoria)
		{
			$this->c_categoria = $c_categoria;
		}
		
		function getCSubcategoria()
		{
			return $this->c_subcategoria;
		}

		function setCSubcategoria($c_subcategoria)
		{
			$this->c_subcategoria = $c_subcategoria;
		}
		
		function getCStatus()
		{
			return $this->c_status;
		}

		function setCStatus($c_status)
		{
			$this->c_status = $c_status;
		}
		
		function getCPrecoCusto()
		{
			return $this->c_preco_custo;
		}

		function setCPrecoCusto($c_preco_custo)
		{
			$this->c_preco_custo = $c_preco_custo;
		}
		
		function getCQuantidade()
		{
			return $this->c_quantidade;
		}

		function setCQuantidade($c_quantidade)
		{
			$this->c_quantidade = $c_quantidade;
		}
		
		function getCDataValidade()
		{
			return $this->c_data_validade;
		}

		function setCDataValidade($c_data_validade)
		{
			$this->c_data_validade = $c_data_validade;
		}
		
		function getCDataCadastro()
		{
			return $this->c_data_cadastro;
		}

		function setCDataCadastro($c_data_cadastro)
		{
			$this->c_data_cadastro = $c_data_cadastro;
		}
		
		function getCFornecedor()
		{
			return $this->c_fornecedor;
		}

		function setCFornecedor($c_fornecedor)
		{
			$this->c_fornecedor = $c_fornecedor;
		}
		
		function getCLocalizacao()
		{
			return $this->c_localizacao;
		}

		function setCLocalizacao($c_localizacao)
		{
			$this->c_localizacao = $c_localizacao;
		}
		
		function getCLote()
		{
			return $this->c_lote;
		}

		function setCLote($c_lote)
		{
			$this->c_lote = $c_lote;
		}
		
		function getCDescricao()
		{
			return $this->c_descricao;
		}

		function setCDescricao($c_descricao)
		{
			$this->c_descricao = $c_descricao;
		}
	}
?>