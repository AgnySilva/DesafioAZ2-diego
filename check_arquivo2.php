<?php
	
	$arquivo = $_FILES["arquivo"];
	
	require_once("funcoes.php");
	$ler_arquivo = new arquivo();
	
	if (!empty($arquivo["name"])) {
		
		// nome dado pelo servidor ao arquivo
		$tmpName = $arquivo['tmp_name'];
		// nome do arquivo
		$fileName = $arquivo['name'];
		//valor do error caso haja algum
		$error = (int) $arquivo['error'];
		//verifica se existe error no UPLOAD
		if($error == 0){
		//executa o move_uploaded_file enquanto verifica se este foi executado corretamente
		if(move_uploaded_file($tmpName, 'arquivos/'.$fileName)){
			//
			$func_arquivo = $ler_arquivo->lerArquivo($fileName);
			
		} else {
			//exibe erro caso haja erro ao mover o arquivo
			echo 'Problemas ao mover o arquivo.';
		}
		} else {
			//exibe erro caso haja erro ao enviar o arquivo
			echo 'Problemas ao enviar o arquivo.';
		}
	}
	else{
		//exibe erro caso haja erro ao fazer UPLOAD do arquivo
		echo"Erro ao fazer UPLOAD do arquivo!";
	}
	
?>