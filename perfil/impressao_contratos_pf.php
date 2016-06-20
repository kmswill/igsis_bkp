
<?php
include 'includes/menu.php';
$conexao = bancoMysqli();
$_SESSION['idPedido'] = $_GET['id_ped'];
$id_ped = $_GET['id_ped'];
$id = $id_ped;

$server = "http://".$_SERVER['SERVER_NAME']."/igsis_OK/"; //mudar para pasta do igsis
$http = $server."/pdf/";
$link0 = $http."rlt_pedido_contratacao_pf.php";
$link1 = $http."rlt_proposta_padrao_pf.php";
$link2 = $http."rlt_proposta_artistico_pf.php";
$link3 = $http."rlt_proposta_eventoexterno_pf.php";
$link4 = $http."rlt_proposta_oficina_pf.php";
$link5 = $http."rlt_fac_pf.php";
$link6 = $http."rlt_evento_pf.php";
$link7 = $http."rlt_pedido_reserva_padrao_pf.php";
$link8 = $http."rlt_pedido_reserva_fepac_pf.php";
$link9 = $http."rlt_pedido_reserva_cooperativa_pf.php";
$link10 = $http."rlt_pedido_reserva_vocacional_pf.php";
$link11 = $http."rlt_recibo_ne_pf.php";
$link12 = $http."rlt_declaracao_naoservidor_pf.php";
$link13 = $http."rlt_declaracao_iss_pf.php";
$link14 = $http."rlt_parecer_pf.php";
$link15 = $http."rlt_proposta_reversao_pf.php";

 
	 $last_id = mysqli_insert_id($conexao);
	 echo "
	 
<section id='list_items' class='home-section bg-white'><h6>Qual modelo de documento deseja imprimir?</h6>
<div class='container'>
<div class='col-md-offset-2 col-md-8'>	
	<div class='table-responsive list_info'>
	
	<table class='table table-condensed'>					
	   <tbody>
		<tr class='list_menu'> 
			<td colspan='2'><strong>PEDIDO</strong></td>
		</tr>
		
		<tr>
			<td width='50%'><a href='$link0?id=$id_ped' target='_blank'><strong>Pedido de Contratação</strong></a></td>
			<td></td>
		</tr>
		
		<tr><td class='list_description'><br/></td></tr>
		
		<tr class='list_menu'><td colspan='2'><strong>CONTRATAÇÃO</strong></td></tr>
		
		<tr>
			<td><a href='$link1?id=$id_ped' target='_blank'><strong>Padrão</strong></a></td>
			<td><a href='$link2?id=$id_ped' target='_blank'><strong>Artístico</strong></a></td>
		</tr>
		
		<tr>
			<td><a href='$link3?id=$id_ped' target='_blank'><strong>Evento Externo</strong></a></td>
			<td><a href='$link4?id=$id_ped' target='_blank'><strong>Oficinas</strong></a></td>
		</tr>
		
		<tr>
			<td><a href='$link15?id=$id_ped' target='_blank'><strong>Reversão</strong></a></td>
		</tr>
		
		<tr><td class='list_description'><br/></td></tr>
		
		<tr class='list_menu'><td colspan='2'><strong>DECLARAÇÃO</strong></td></tr>
		
		<tr>
			<td><a href='$link12?id=$id_ped' target='_blank'><strong>Não Servidor</strong></a></td>
			<td><a href='$link13?id=$id_ped' target='_blank'><strong>ISS</strong></a></td>
		</tr>
		
		<tr><td class='list_description'><br/></td></tr>
		
		<tr class='list_menu'><td colspan='2'><strong>OUTROS</strong></td></tr>
		
		<tr>
			<td><a href='$link5?id=$id_ped' target='_blank'><strong>FACC</strong></a></td>
			<td><a href='$link14?id=$id_ped' target='_blank'><strong>Parecer da Comissão</strong></a></td>
		</tr>
		
		<tr><td class='list_description'><br/></td></tr>
		
		<tr class='list_menu'><td colspan='2'><strong>PEDIDO DE RESERVA</strong></td></tr>
		
		<tr>
			<td><a href='$link7?id=$id_ped' target='_blank'><strong>Padrão</strong></a></td>
			<td><a href='$link9?id=$id_ped' target='_blank'><strong>Cooperativa</strong></a></td>
		</tr>
		<tr>
			<td><a href='$link8?id=$id_ped' target='_blank'><strong>FEPAC</strong></a></td>
			<td><a href='$link10?id=$id_ped' target='_blank'><strong>Vocacional</strong></a></td>
		</tr>
		
	  </tbody>
	  </table>
		
	</div>	
</div>
</div>
</section>";


?>


