<?php
	class arquivo{
		//vetores e contadores para guardar o valor de cada linha
		private $contadorSM = 0;
		private $salesman = array();
		private $contadorC = 0;
		private $customer = array();
		private $contadorS = 0;
		private $sales = array();
		
		public function lerArquivo($fileName){
			
			//Insere o caminho e o nome do arquivo na variavel
			$caminho_arquivo = "arquivos/".$fileName;
			//abre o arquivo
			$arquivoLeitura = fopen($caminho_arquivo,'r');
			//verifica se a leitura do arquivo foi realizada
			if ($caminho_arquivo == false) die('Não foi possível abrir o arquivo.');
			
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
					$salesman[$this->contadorSM] = $linha;
					$this->contadorSM++;					
				}
				if($idLinha[0] == "002"){
					//atribui o valor da linha ao vetor customer
					$customer[$this->contadorC] = $linha;
					$this->contadorC++;					
				}
				if($idLinha[0] == "003"){
					//atribui o valor da linha ao vetor sales
					$sales[$this->contadorS] = $linha;
					$this->contadorS++;					
				}
				
			}//fim while
			
			//fecha o arquivo após a leitura dos dados
			fclose($arquivoLeitura);
			
			$check = new arquivo();
			$check_dados = $check->check_dados($this->contadorSM,$salesman,$this->contadorS, $sales, $fileName, $this->contadorC);
			
		}//fim funcao ler_arquivo()
		public function check_dados($contadorSM, $salesman, $contadorS, $sales, $fileName, $contadorC){
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
			$check = new arquivo();
			$relatorio = $check->relatorio($this->contadorC, $contadorSM, $mediaSalario, $idMaior, $idPior, $fileName, $contadorC);
		}
		//função que cria e escreve o relatório
		public function relatorio($contadorC, $contadorSM, $mediaSalario, $idMaior, $idPior, $fileName, $contadorC){
			//armazena o conteúdo do relatório
			$conteudo_relatorio  = "
			RELATORIO:
			Total de clientes: $contadorC
			Total de Vendedores: $contadorSM
			Media Salarial: $mediaSalario
			ID Maior venda: $idMaior
			Pior Vendedor: $idPior";
			
			$relatorio = pathinfo($fileName);
			//armazena o caminho e o nome do arquivo que vai conter o relatório
			$caminho_relatorio = "relatorio/".$relatorio['filename'].".done.".$relatorio['extension'];
			// abre o arquivo colocando o ponteiro de escrita no final
			$arquivoRelatorio = fopen($caminho_relatorio,'w+');
			if ($arquivoRelatorio) {
			if (!fwrite($arquivoRelatorio, $conteudo_relatorio)){
				die('Não foi possível fazer o relatório');
			} 
			else{
				include"relatorio.php";
			}
			fclose($arquivoRelatorio);
			}
			
		}//fim função relatorio
	}

?>