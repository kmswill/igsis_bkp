<?php
require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";
require "../funcoes/funcoesSiscontrat.php";

if(isset($_GET['id'])){
	$idPedido = $_GET['id'];	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
</head>

<?php 

$status = atualizaEstado($idPedido);

$pedido = recuperaDados("igsis_pedido_contratacao",$idPedido,"idPedidoContratacao");
$estado = recuperaDados("sis_estado",$pedido['estado'],"idEstado");

echo "O pedido $idPedido tem o status ".$estado['estado']."<br /><br />";


var_dump($status);

?>


<body>
</body>
</html>