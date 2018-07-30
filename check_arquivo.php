<?php
	$arquivo = $_FILES["arquivo"];
	
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
			
			//Insere o caminho e o nome do arquivo na variavel
			$caminho_arquivo = "arquivos/".$fileName;
			//abre o arquivo
			$arquivoLeitura = fopen($caminho_arquivo,'r');
			//verifica se a leitura do arquivo foi realizada
			if ($caminho_arquivo == false) die('Não foi possível abrir o arquivo.');
			//vetores e contadores para guardar o valor de cada linha
			$contadorSM = 0;
			$salesman = array();
			$contadorC = 0;
			$customer = array();
			$contadorS = 0;
			$sales = array();
			//Enquanto o arquivo estiver aberto, lê as linhas no arquivo
			while(true) {
				$linha = fgets($arquivoLeitura);
				//verifica se a linha possui algum caracter
				if ($linha==null){
					break;
				}
				else{
					$idLinha = explode(",",$linha);
				}
				if($idLinha[0] == "001"){
					//atribui o valor da linha ao vetor salesman
					$salesman[$contadorSM] = $linha;
					$contadorSM++;					
				}
				if($idLinha[0] == "002"){
					//atribui o valor da linha ao vetor customer
					$customer[$contadorC] = $linha;
					$contadorC++;					
				}
				if($idLinha[0] == "003"){
					//atribui o valor da linha ao vetor sales
					$sales[$contadorS] = $linha;
					$contadorS++;					
				}
				
			}//fim while
			
			//fecha o arquivo após a leitura dos dados
			fclose($arquivoLeitura);
			$checkSalario = 0;
			$totalSalario = 0;
			//verifica os dados de vendedor/salesman
			for($sm = 0;$sm < $contadorSM;$sm++){
				$checkSalario = explode(",",$salesman[$sm]);
				$totalSalario = $totalSalario + $checkSalario[3];
				
			}//fim for salesman

			//Armazena a media salarial dos vendedores
			$mediaSalario = $totalSalario / $contadorSM;
			
			$checkVenda = 0;
			$maiorVenda = 0;
			$menorVenda = 0;
			$idMaior = 0;
			$idPior = 0;
			//verifica os dados da venda/sales
			for($s = 0;$s < $contadorS;$s++){
				$checkVenda = explode(",",$sales[$s]);
				if($checkVenda[4] > $maiorVenda){
					$maiorVenda = $checkVenda[4];
					$idMaior = $checkVenda[1];
				}
				if($menorVenda == 0){
					$menorVenda = $checkVenda[4];
				}
				else{
					if($checkVenda[4] < $menorVenda){
						$menorVenda = $checkVenda[4];
						$idPior = $checkVenda[5];
					}
				}
			}//fim for sale/venda
			$conteudo_relatorio  = "
			RELATORIO:
			Total de clientes: $contadorC
			Total de Vendedores: $contadorSM
			Media Salarial: $mediaSalario
			ID Maior venda: $idMaior
			Pior Vendedor: $idPior";
			
			$relatorio = pathinfo($fileName);
			
			$caminho_relatorio = "relatorio/".$relatorio['filename'].".done.".$relatorio['extension'];
			// abre o arquivo colocando o ponteiro de escrita no final
			$arquivoRelatorio = fopen($caminho_relatorio,'w+');
			if ($arquivoRelatorio) {
			if (!fwrite($arquivoRelatorio, $conteudo_relatorio)){
				die('Não foi possível fazer o relatório');
			} 
			else{
				echo"Clique para visualizar o relatório: <a href='$caminho_relatorio'> $caminho_relatorio</a>";
			}
			fclose($arquivoRelatorio);
			}


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