<?php

include 'includes/menu.php';
$conexao = bancoMysqli();
$server = "http://".$_SERVER['SERVER_NAME']."/igsis/";
$http = $server."/pdf/";
$link1=$http."rlt_anexo_nota_empenho_pf.php";
$link2=$http."rlt_proposta_artistico_pf.php";
$link3=$http."rlt_proposta_eventoexterno_pf.php";
$link4=$http."rlt_proposta_oficina_pf.php";
$link5=$http."rlt_fac_pf.php";
$link7=$http."rlt_declaracao_naoservidor_pf.php";
$link8=$http."rlt_declaracao_iss_pf.php";

$id_ped = $_GET['id_ped'];	
$idUsuario = $_SESSION['idUsuario'];

	$sql_atualiza_pedido = "UPDATE igsis_pedido_contratacao SET
		IdUsuarioContratos = '$idUsuario',
		estado = 'Proposta'
		WHERE idPedidoContratacao = '$id_ped'";
	
	$stmt = mysqli_prepare($conexao,$sql_atualiza_pedido);

 if(mysqli_stmt_execute($stmt))
{
 	
	 
	 echo "<br><br><br><br><h4>Qual modelo de documento deseja imprimir?</h4><br>

	
	
	
	<form class='form-horizontal' role='form'>
			
	<div class='form-group'>
     <div class='col-md-offset-2 col-md-8'>
		<a href='$link1?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Documento Word</a></div>
	<!-- <div class='col-md-6'> 
		<a href='$link2?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Proposta Artístico</a></div>
	</div>
			
	<div class='form-group'>
	 <div class='col-md-offset-2 col-md-6'>
	<a href='$link3?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Proposta Evento Externo</a></div> 
	 <div class='col-md-6'>
		<a href='$link4?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Proposta Oficina</a></div> 
	</div>
	
	<br>
		
	<div class='form-group'> 
	 <div class='col-md-offset-2 col-md-6'>
		<a href='$link7?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Declaração Não Servidor</a></div>	
	<div class='col-md-6'>	 
		<a href='$link8?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Declaração ISS</a></div>
	</div>
	
	<div class='form-group'>
	 <div class='col-md-offset-2 col-md-6'>
	<a href='$link5?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>FACC</a></div> 
	</div>	
    --!>
    </form>
    </div></div>

	<br /></center>";

}

?>
