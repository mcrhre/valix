<?php
	class Produto {
		
		private $codigo;
		private $nome;
		private $marca;
		private $categoria;
		private $subcategoria;
		private $descricao;
		private $quantidade;
		private $unidade_medida;
		private $preco_custo;
		private $un_medida_custo;
		private $fator;
		private $fornecedor;
		private $localizacao;
		private $lote;
		private $data_validade;
		private $status;
		private $data_cadastro;
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
			
		function getMarca()
		{
		  return $this->marca;
		}

		function setMarca($marca)
		{
		  $this->marca = $marca;
		}
			
		function getCategoria()
		{
		  return $this->categoria;
		}

		function setCategoria($categoria)
		{
		  $this->categoria = $categoria;
		}
		
		function getSubcategoria()
		{
		  return $this->subcategoria;
		}

		function setSubcategoria($subcategoria)
		{
		  $this->subcategoria = $subcategoria;
		}
		
		function getDescricao()
		{
		  return $this->descricao;
		}
		
		function setDescricao($descricao)
		{
		  $this->descricao = $descricao;
		}
		
		function getQuantidade()
		{
		  return $this->quantidade;
		}
		
		function setQuantidade($quantidade)
		{
		  $this->quantidade = $quantidade;
		}
		
		function getUnidadeMedida()
		{
		  return $this->unidade_medida;
		}
		
		function setUnidadeMedida($unidade_medida)
		{
		  $this->unidade_medida = $unidade_medida;
		}
		
		function getPrecoCusto()
		{
		  return $this->preco_custo;
		}
		
		function setPrecoCusto($preco_custo)
		{
		  $this->preco_custo = $preco_custo;
		}
		
		function getUnMedidaCusto()
		{
		  return $this->un_medida_custo;
		}
		
		function setUnMedidaCusto($un_medida_custo)
		{
		  $this->un_medida_custo = $un_medida_custo;
		}
		
		function getFator()
		{
		  return $this->fator;
		}
		
		function setFator($fator)
		{
		  $this->fator = $fator;
		}
		
		function getFornecedor()
		{
		  return $this->fornecedor;
		}
		
		function setFornecedor($fornecedor)
		{
		  $this->fornecedor = $fornecedor;
		}
		
		function getLocalizacao()
		{
		  return $this->localizacao;
		}
		
		function setLocalizacao($localizacao)
		{
		  $this->localizacao = $localizacao;
		}
		
		function getLote()
		{
		  return $this->lote;
		}
		
		function setLote($lote)
		{
		  $this->lote = $lote;
		}
		
		function getDataValidade()
		{
		  return $this->data_validade;
		}
		
		function setDataValidade($data_validade)
		{
		  $this->data_validade = $data_validade;
		}
		
		function getStatus()
		{
		  return $this->status;
		}
		
		function setStatus($status)
		{
		  $this->status = $status;
		}
		
		function getDataCadastro()
		{
		  return $this->data_cadastro;
		}
		
		function setDataCadastro($data_cadastro)
		{
		  $this->data_cadastro = $data_cadastro;
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