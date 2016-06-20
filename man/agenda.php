<?php 
/* Agenda */



//Busca eventos que estão na agenda mas não são válidos
$sql_agenda = "SELECT ig_evento.idEvento FROM ig_evento,igsis_agenda WHERE
	ig_evento.idEvento = igsis_agenda.idEvento
	AND ig_evento.dataEnvio IS NULL
	AND ig_evento.ocupacao IS NULL
    GROUP BY idEvento";
$query_agenda = mysqli_query($con,$sql_agenda);
$relatorio .= "<h2>Eventos que estão na Agenda mas não são válidos </h2>";
while($agenda = mysqli_fetch_array($query_agenda)){
	$relatorio .= "Evento: ".$agenda['idEvento']."<br />";	
}

//Busca eventos que não estão na agenda 
$sql_agenda = "SELECT ig_evento.idEvento FROM ig_evento,igsis_agenda WHERE
	ig_evento.idEvento <> igsis_agenda.idEvento
	AND ig_evento.publicado <> '1'
	AND ig_evento.ocupacao <> '1'";
$query_agenda = mysqli_query($con,$sql_agenda);
$relatorio .= "<h2>Eventos que não estão na agenda</h2>";
while($agenda = mysqli_fetch_array($query_agenda)){
	$relatorio .= "Evento: ".$agenda['idEvento']."<br />";	
}

