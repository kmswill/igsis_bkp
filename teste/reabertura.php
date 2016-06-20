<?php 
   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 	

//if(isset($_SESSION['idUsuario'])){
//require '../include/';
   require_once("../funcoes/funcoesConecta.php");
   require_once("../funcoes/funcoesGerais.php");
   require_once("../funcoes/funcoesSiscontrat.php");
   require_once("../funcoes/funcoesSiscontrat.php");
   require_once("../include/phpexcel/Classes/PHPExcel.php");


//CONEXÃO COM BANCO DE DADOS 
$con = bancoMysqli();

$sql_log = "SELECT * FROM ig_log WHERE  `descricao` LIKE  '%SET dataEnvio = NULL%'";
$query_log = mysqli_query($con,$sql_log);
$num_log = mysqli_num_rows($query_log);
echo "Foram $num_log eventos reabertos desde 13/04/2016. <br /><Br />";
while($n = mysqli_fetch_array($query_log)){
	$idEvento = soNumero($n['descricao']);
	$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
	$usuario = recuperaDados("ig_usuario",$evento['idUsuario'],"idUsuario");
	echo "O usuário ".$usuario['nomeCompleto']." reabriu o evento ".$evento['nomeEvento']." em ".exibirDataBr($n['dataLog'])." . <br />";
}


?>