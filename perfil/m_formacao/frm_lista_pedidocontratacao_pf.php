<?php

// não precisa chamar a funcao porque o index contrato já chama.
//$linha_tabela_lista = siscontratLista(4,$_SESSION['idInstituicao'],100,1,"DESC","2"); //esse gera uma array com os pedidos

$con = bancoMysqli();

$link="?perfil=formacao&&p=frm_cadastra_pedidocontratacao_pf&id_ped=";

include 'includes/menu.php';	

switch($_GET['enviados']){
	case 1:

?>

	<br /><br /><br />

	  	  
	 <!-- inicio_list -->
	<section id="list_items">
		<div class="container">
			 <div class="sub-title">PEDIDO ENVIADOS DE CONTRATAÇÃO DE PESSOA FÍSICA</div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Codigo do Pedido</td>
							<td>Proponente</td>
							<td>Objeto</td>
							<td>Local</td>
							<td>Periodo</td>
							<td>Status</td>
						</tr>
					</thead>
					<tbody>
<?php
$sql_enviados = "SELECT idPedidoContratacao,idPessoa FROM igsis_pedido_contratacao WHERE estado IS NOT NULL AND tipoPessoa = '4' AND publicado = '1' ORDER BY idPedidoContratacao DESC";
$data=date('Y');
$query_enviados = mysqli_query($con,$sql_enviados);
while($pedido = mysqli_fetch_array($query_enviados))
 {
	$linha_tabela_pedido_contratacaopf = recuperaDados("sis_pessoa_fisica",$pedido['idPessoa'],"Id_PessoaFisica");
	$ped = siscontrat($pedido['idPedidoContratacao']);	 
	echo "<tr><td class='lista'> <a href='".$link.$pedido['idPedidoContratacao']."'>".$pedido['idPedidoContratacao']."</a></td>";
	echo '<td class="list_description">'.$linha_tabela_pedido_contratacaopf['Nome'].					'</td> ';
	echo '<td class="list_description">'.$ped['Objeto'].						'</td> ';
	echo '<td class="list_description">'.$ped['Local'].				'</td> ';
	echo '<td class="list_description">'.$ped['Periodo'].						'</td> ';
	echo '<td class="list_description">'.retornaEstado($ped['Status']).						'</td> </tr>';
	}

?>
	
					
					</tbody>
				</table>
			</div>
		</div>
	</section>
    
<?php 
break;
case 0:

?>
<br /><br /><br />
	 <!-- inicio_list -->
	<section id="list_items">
		<div class="container">
			 <div class="sub-title">PEDIDOS NÃO ENVIADOS DE CONTRATAÇÃO DE PESSOA FÍSICA</div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Codigo do Pedido</td>
							<td>Proponente</td>
							<td>Objeto</td>
							<td>Local</td>
							<td>Periodo</td>
							<td>Status</td>
						</tr>
					</thead>
					<tbody>
<?php
$data=date('Y');
$sql_n_enviados = "SELECT idPedidoContratacao,idPessoa FROM igsis_pedido_contratacao WHERE estado IS NULL AND tipoPessoa = '4' AND publicado = '1' ORDER BY idPedidoContratacao DESC";
$query_n_enviados = mysqli_query($con,$sql_n_enviados);
while($pedido = mysqli_fetch_array($query_n_enviados))
 {
	$linha_tabela_pedido_contratacaopf = recuperaDados("sis_pessoa_fisica",$pedido['idPessoa'],"Id_PessoaFisica");
	$ped = siscontrat($pedido['idPedidoContratacao']);	 
	echo "<tr><td class='lista'> <a href='".$link.$pedido['idPedidoContratacao']."'>".$pedido['idPedidoContratacao']."</a></td>";
	echo '<td class="list_description">'.$linha_tabela_pedido_contratacaopf['Nome'].					'</td> ';
	echo '<td class="list_description">'.$ped['Objeto'].						'</td> ';
	echo '<td class="list_description">'.$ped['Local'].				'</td> ';
	echo '<td class="list_description">'.$ped['Periodo'].						'</td> ';
	//echo '<td class="list_description">'.$ped['Status'].						'</td> </tr>';
	echo '<td class="list_description"></td> </tr>';

	}

?>
	
					
					</tbody>
				</table>
			</div>
		</div>
	</section>

<?php 
break;
}
?>    
<!--fim_list-->


