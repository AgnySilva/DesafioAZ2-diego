﻿<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<div class="form-group col-sm-10 col-lg-offset-1">
	<h3>RELATÓRIO</h3>
	<table class="table">
	  <tr>
		<th>Qtde Clientes</th>
		<th>Qtde Vendedores</th> 
		<th>Media Salarial (R$)</th>
		<th>Maior Venda (ID)</th>
		<th>Pior Vendedor</th>
	  </tr>
	  <tr>
		<?php
		echo"<td>$contadorC</td>";
		echo"<td>$contadorSM</td>";
		echo"<td>$mediaSalario</td>";
		echo"<td>$idMaior</td>";
		echo"<td>$idPior</td>";
		?>

	</table>
	<?php
	echo"<p>Clique para visualizar o Arquivo: <a href='$caminho_relatorio'> $caminho_relatorio</a></p>";
	?>
</div>