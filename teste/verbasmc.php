<?php


function bancoMysqli(){ 
	$servidor = 'localhost';
	$usuario = 'root';
	$senha = 'lic54eca';
	$banco = 'igsis';
	$con = mysqli_connect($servidor,$usuario,$senha,$banco); 
	mysqli_set_charset($con,"utf8");
	return $con;
}
$con = bancoMysqli();
function recuperaDados($tabela,$idEvento,$campo){ //retorna uma array com os dados de qualquer tabela. serve apenas para 1 registro.
	$con = bancoMysqli();
	$sql = "SELECT * FROM $tabela WHERE ".$campo." = '$idEvento' LIMIT 0,1";
	$query = mysqli_query($con,$sql);
	$campo = mysqli_fetch_array($query);
	return $campo;		
}


$sql_pesquisar = "SELECT * FROM igsis_pedido_contratacao WHERE publicado = '1' AND idVerba = '8'";
$query = mysqli_query($con,$sql_pesquisar);
while($importa = mysqli_fetch_array($query)){
	$id = $importa['idEvento'];	
	$evento = recuperaDados("ig_evento",$id,"idEvento");
	echo "ID:".$importa['idPedidoContratacao']." - ".$evento['nomeEvento']."<br />";
}


?>