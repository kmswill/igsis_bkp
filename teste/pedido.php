<?php
require_once("../funcoes/funcoesVerifica.php");
require_once("../funcoes/funcoesSiscontrat.php");
require_once("../funcoes/funcoesFinanca.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

$con = bancoMysqli();

   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 

$pedido = siscontrat($_GET['id']);
echo "<pre>";
var_dump($pedido);
echo "</pre>";

$evento = viradaOcorrencia($pedido['idEvento']);
echo "<br /> <pre>";
var_dump($evento);
echo "</pre>";
?>