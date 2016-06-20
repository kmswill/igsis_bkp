<?php 
@ini_set('display_errors', '1');
error_reporting(E_ALL); 


require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";
require "../funcoes/funcoesSiscontrat.php";

$pedido = $_GET['pedido'];

$x = retornaParcelaPagamento($pedido,$parcela);
echo "<pre>";
var_dump($x);
echo "</pre>";

?>