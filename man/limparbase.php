<?php
/* 
Limpar a tabela de ig_evento

*/

	$sql_data = "DELETE FROM ig_evento WHERE ig_tipo_evento_idTipoEvento = '0'";
	$query_data = mysqli_query($con,$sql_data);
	if($query_data){
		$mensagem = "Base de eventos limpa.";
	}else{
		$mensagem = "Erro ao limpar a base";
	}
	
	$relatorio .= "<h2>Limpeza da base</h2>
	<p>".$mensagem."</p>
	";