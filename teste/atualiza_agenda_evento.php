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
$evento = $_GET['id'];
$mensagem = atualizarAgenda($evento);
echo $mensagem;


?>