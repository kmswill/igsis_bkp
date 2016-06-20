<?php
@ini_set('display_errors', '1');
error_reporting(E_ALL); 
ini_set('max_execution_time', 300);

require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";
require "../funcoes/funcoesSiscontrat.php";

$con = bancoMysqli(); 
$data = date('d/m/Y H:i:s');
$relatorio = "<h1>Relatório do Sistema</h1>
<p>Gerado em $data</p>
<br />";

// Busca todos os eventos que tem data de envio válido mas tem pedidos sem estado
$sql_evento = "SELECT ig_evento.idEvento,idPedidoContratacao FROM ig_evento,igsis_pedido_contratacao WHERE 
	ig_evento.dataEnvio IS NOT NULL 
	AND ig_evento.publicado ='1' 
	AND igsis_pedido_contratacao.idEvento = ig_evento.idEvento
	AND igsis_pedido_contratacao.publicado = 1
	AND (igsis_pedido_contratacao.estado IS NULL OR igsis_pedido_contratacao.estado = '')";
$query_evento = mysqli_query($con,$sql_evento);

$relatorio .= "<h2>Eventos que possuem data de envio válida mas tem pedidos sem status definido</h2>";
while($pedido = mysqli_fetch_array($query_evento)){
	$relatorio .= "Evento: ".$pedido['idEvento']."<br />";	
}

//Busca todos os pedidos que tem data de envio válido mas tem eventos como não enviados
$sql_evento = "SELECT ig_evento.idEvento,idPedidoContratacao FROM ig_evento,igsis_pedido_contratacao WHERE 
	 ig_evento.publicado ='1' 
	 AND igsis_pedido_contratacao.estado IS NOT NULL
	AND igsis_pedido_contratacao.idEvento = ig_evento.idEvento
	AND igsis_pedido_contratacao.publicado = '1'
	AND igsis_pedido_contratacao.tipoPessoa <> '4'
	AND (ig_evento.dataEnvio IS NULL OR ig_evento.dataEnvio = '')";
$query_evento = mysqli_query($con,$sql_evento);

$relatorio .= "<h2>Pedidos que possuem status válido mas tem eventos como não enviados</h2>";
while($pedido = mysqli_fetch_array($query_evento)){
	$relatorio .= "Pedido: ".$pedido['idPedidoContratacao']."<br />";	
}


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

echo $relatorio;


/*

				$conteudo_email = "Olá, <br /><br />
				
				O evento <b>".$evento['nomeEvento']."</b> foi cadastrado no sistema por ".$usuario['nomeCompleto']." em ".exibirDataHoraBr($datetime).".<br /><br />
					Número da IG: <b>".$idEvento."</b><br />
					<b>Tipo de evento:</b> ".$tipoEvento['tipoEvento']."<br />";
	
	if($evento['ig_programa_idPrograma'] != 0){ $conteudo_email .= "<b>Programa especial:</b> ".$programa['programa']."<br />";}
	if($evento['projetoEspecial'] != 0){ $conteudo_email .= "<b>Projeto especial:</b> ".$projetoEspecial['projetoEspecial']."<br />";}
	if($evento['projeto'] != ""){ $conteudo_email .= "<b>Projeto:</b> ".$evento['projeto']."<br />";}
	$conteudo_email .= "
	<br />
	<b>Responsável pelo evento:</b> ".$fiscal['nomeCompleto']."<br />
	<b>Suplente:</b> ".$suplente['nomeCompleto']."<br />
	<br />
	<b>Sinopse:</b><br />".nl2br($evento['sinopse'])."<br /><br />
	<b>Local / Período: </br >".substr($local,1)." / ".$periodo."<br />
	<br />
	
	
	Saiba mais acessando: <a href='http://www.centrocultural.cc/igsis/'> centrocultural.cc/igsis </a>
	
	<br />
	<br />
	<p>Atenciosamente,<br />
	Equipe IGSIS</p>
				";

				$subject = "O evento ".$evento['nomeEvento']." foi cadastrado no sistema.";
				enviarEmail($conteudo_email, $_SESSION['idInstituicao'], $subject, $idEvento, $num_pedidos );

*/

?>

