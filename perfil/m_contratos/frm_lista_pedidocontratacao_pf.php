<?php
//include "../../funcoes/funcoesFormacao.php";
// não precisa chamar a funcao porque o index contrato já chama.
//$linha_tabela_lista = siscontratLista(4,$_SESSION['idInstituicao'],100,1,"DESC","2"); //esse gera uma array com os pedidos

$con = bancoMysqli();

$link="?perfil=contratos&p=frm_edita_proposta_formacao&id_ped=";

include 'includes/menu.php';	

if(isset($_POST['reabrir'])){
	$idPedido = $_POST['reabrir'];
	$sql_pedido = "UPDATE igsis_pedido_contratacao SET estado = NULL WHERE idPedidoContratacao = '$idPedido'";
	$query_pedido = mysqli_query($con,$sql_pedido);
	if($query_pedido){
		$sql_formacao = "UPDATE sis_formacao SET idPedidoContratacao = NULL WHERE idPedidoContratacao = '$idPedido'";
		$query_formacao = mysqli_query($con,$sql_formacao);
		if($query_formacao){
			$mensagem = "Reabertura do Pedido $idPedido realizado com sucesso.";
		}else{
			$mensagem = "Erro(1).";	
		}
	}else{
		$mensagem = "Erro(2).";	
	}	
}


switch($_GET['enviados']){
	case 1:

?>

	<br /><br /><br />

	  	  
	 <!-- inicio_list -->
	<section id="list_items">
		<div class="container">
			 <div class="sub-title">PEDIDO ENVIADOS DE CONTRATAÇÃO DE PESSOA FÍSICA FORMAÇÃO</div>
			<p><?php if(isset($mensagem)){ echo $mensagem; }?></p>	
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
   							<td></td>
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
	echo '<td class="list_description">'.retornaEstado($ped['Status']).						'</td>'; 
	echo "
	<td class='list_description'>
	<form method='POST' action='?perfil=contratos&p=frm_lista_pedidocontratacao_pf&enviados=1'>
	<input type='hidden' name='reabrir' value='".$pedido['idPedidoContratacao']."' />
	<input type ='submit' class='btn btn-theme btn-block' value='reabrir'></td></form>"	;
	echo "</tr>";

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


