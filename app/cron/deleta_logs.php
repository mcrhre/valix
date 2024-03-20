<?php
    date_default_timezone_set('America/Sao_Paulo');
    
    $diretorio = '../logs/';
    $pasta = array();
    $total_delete = 0;

    function deletaPastaEConteudo($dir) 
	{ 
		$arquivos = array_diff(scandir($dir), array('.','..'));

		foreach ($arquivos as $arquivo)
		{ 																		//deleta arquivo
			(is_dir("$dir/$arquivo")) ? deletaPastaEConteudo("$dir/$arquivo") : unlink("$dir/$arquivo"); 
		} 

		//deleta pasta
		return rmdir($dir); 
	}
    
    if(is_dir($diretorio))
    $pasta = array_diff(scandir($diretorio), array('..', '.'));

    foreach($pasta as $nome_pasta)
    {
        $time = stat($diretorio.$nome_pasta);
		
		//verifica se a pasta é de 14 dias atras
        if ($time['atime'] <= strtotime('-14 days'))
		{
			$caminho = $diretorio.$nome_pasta;
			
			deletaPastaEConteudo($caminho);

			$total_delete ++;
		}
    }

    echo "TD: $total_delete";
?>