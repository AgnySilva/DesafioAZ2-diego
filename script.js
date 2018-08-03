	//funcão que verifica a extenção do arquivo
	function verificaExtensao($input){
		var extPermitida = ['dat'];
		var extArquivo = $input.value.split('.').pop();
		
		if(typeof extPermitida.find(function(ext){ return extArquivo == ext; }) == 'undefined'){
			alert("Extensão ."+extArquivo+" não é permitida!");
			
			document.getElementById("btn_verificar").disabled = true;
		}
		else{
			document.getElementById("btn_verificar").disabled = false;
		}
	}
	//funcões que realizam o upload do arquivo para o Php
	function _(el){
		return document.getElementById(el);
	}
	//funcão que envia o arquivo file para o php
	function sendArquivo(){
		var file = _("arquivo").files[0];
		//alert(file.name+" | "+file.size+" | "+file.type);
		var formdata = new FormData();
		formdata.append("arquivo",file);
		var ajax = new XMLHttpRequest();
		ajax.upload.addEventListener("progress",progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		ajax.open("POST", "check_arquivo2.php");
		ajax.send(formdata);
	}
	//função que verifica o progresso do upload
	function progressHandler(event){
		var percent = (event.loaded / event.total) * 100;
		_("progressBar").value = Math.round(percent);
		_("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
	}
	//função que altera os campos relatorio e status qnd o upload está completo
	function completeHandler(event){
		_("relatorio").innerHTML = event.target.responseText;
		_("progressBar").value = 100;
		_("status").innerHTML = "<i>Upload Completed!</i>";
		
	}
	//função que exibe erros durante o upload
	function errorHandler(event){
		_("status").innerHTML = "<i>Uploaded Failed!</i>";
		
	}
	//função que informa quando o upload é abortado
	function abortHandler(event){
		_("status").innerHTML = "<i>Uploaded aborted!</i>";
		
	}