<?php
	class Funcao{		
		static function criptografarSenha($senha)
		{
			$salt = 'fQ2dLC39#';
			$senha = trim($senha).$salt;
			return md5($senha);
		}
		
		static function dataTexto($data)
		{
		   date_default_timezone_set('America/Sao_Paulo');
		   $data = date("d/m/Y",strtotime($data));
      	   $result = str_replace('/01/','/Janeiro/',$data);
      	   $result = str_replace('/02/','/Fevereiro/',$result);
      	   $result = str_replace('/03/','/Março/',$result);
      	   $result = str_replace('/04/','/Abril/',$result);
     	   $result = str_replace('/05/','/Maio/',$result);
      	   $result = str_replace('/06/','/Junho/',$result);
    	   $result = str_replace('/07/','/Julho/',$result);
   		   $result = str_replace('/08/','/Agosto/',$result);
   		   $result = str_replace('/09/','/Setembro/',$result);
   		   $result = str_replace('/10/','/Outubro/',$result);
  		   $result = str_replace('/11/','/Novembro/',$result);
  		   $result = str_replace('/12/','/Dezembro/',$result);
   		   $result = str_replace('/',' de ',$result);
      	   return $result;
		}
		
		static function normalizarNome($string)
		{
			include_once("GUtils.class.php");
			return GUtils::normalizarNome($string);
		}

		static function removeAcento($string)
		{
			$replace = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
							
			return strtr( $string, $replace );
		}
		
		static function mask($val, $mask)
		{
			$maskared = '';
			$k = 0;
			for($i = 0; $i<=strlen($mask)-1; $i++){
				if($mask[$i] == '#')
				{
					if(isset($val[$k]))
						$maskared .= $val[$k++];
				} else {
					if(isset($mask[$i]))
					$maskared .= $mask[$i];
				}
			}
			return $maskared;
		}

		static function documento($documento)
		{
			$documento = str_replace('.', '', $documento);
			$documento = str_replace('-', '', $documento);
			$documento = str_replace('/', '', $documento);
			if(strlen($documento) == 11) return self::mask($documento,'###.###.###-##');
			else return self::mask($documento,'##.###.###/####-##');
		}
		
		static function gravarLog($usuario, $msg_json, $caminho_arq, $linha_arq = '', $nome_pasta = '', $nome_arquivo = '')
		{
			$data_pasta = date('dmY');
			$caminho = $_SERVER['DOCUMENT_ROOT']."app/logs/$data_pasta";
	
			if(!is_dir($caminho))
			{
				mkdir($caminho);
				chmod($caminho, 0777);
			}
			
			if($nome_pasta)
			{
				$caminho = $_SERVER['DOCUMENT_ROOT']."app/logs/$data_pasta/$nome_pasta";
				
				if(!is_dir($caminho))
				{
					mkdir($caminho);
					chmod($caminho, 0777);
				}
			}
			
			if(!$nome_arquivo)
			{
				$nome_arquivo = explode('.', basename($caminho_arq));
				$nome_arquivo = $nome_arquivo[0];
			}
			
			$nome_arquivo .= '.txt';

			$arr = json_decode($msg_json, true);

			$arr['codigo_usuario'] = $usuario;
			$arr['caminho_arquivo'] = substr($caminho_arq, strpos($caminho_arq, '/app/'));
			
			if ($linha_arq) 
			{ 
				$arr['linha_arquivo'] = $linha_arq; 
			}
			
			$arr['hora'] = date('H:i:s');
		
			$conteudo  = json_encode($arr);
			$conteudo .= PHP_EOL;
			
			file_put_contents("$caminho/$nome_arquivo", $conteudo, FILE_APPEND);
		}
	}
?>