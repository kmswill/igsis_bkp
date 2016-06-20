<?php

//$linha_tabela_lista = siscontratLista(1,"",1000,1,"DESC",8); //esse gera uma array com os pedidos
//$tipoPessoa,$instituicao,$num_registro,$pagina,$ordem,$estado

$link="index.php?perfil=contabilidade&p=frm_cadastra_contabilpf&id_ped=";
$con = bancoMysqli();
?>
	
<?php include 'includes/menu.php';?>	
	  	  
	 <!-- inicio_list -->
	<section id="list_items">
		<div class="container">
			 <div class="form-group"><br><br><h5><b>PESSOA FÍSICA</h5></b></div>
			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
							<td>Codigo do Pedido</td>
							<td>Processo</td>
							<td>Proponente</td>
							<td>Objeto</td>
							<td>Local</td>
							<td>Periodo</td>
							<td>Status</td>
						</tr>
					</thead>
					<tbody>
<?php
$sql_enviados = "SELECT idPedidoContratacao,idPessoa FROM igsis_pedido_contratacao WHERE estado IS NOT NULL AND tipoPessoa = '4' AND publicado = '1' ORDER BY NumeroProcesso DESC";
$data=date('Y');
$query_enviados = mysqli_query($con,$sql_enviados);
while($pedido = mysqli_fetch_array($query_enviados))
 {
	$linha_tabela_pedido_contratacaopf = recuperaDados("sis_pessoa_fisica",$pedido['idPessoa'],"Id_PessoaFisica");
	$ped = siscontrat($pedido['idPedidoContratacao']);	 
	echo "<tr><td class='lista'> <a href='".$link.$pedido['idPedidoContratacao']."'>".$pedido['idPedidoContratacao']."</a></td>";
	echo '<td class="list_description">'.$ped['NumeroProcesso']. '</td> ';
	echo '<td class="list_description">'.$linha_tabela_pedido_contratacaopf['Nome'].					'</td> ';
	echo '<td class="list_description">'.$ped['Objeto']. '</td> ';
	echo '<td class="list_description">'.$ped['Local'].				'</td> ';
	echo '<td class="list_description">'.$ped['Periodo'].						'</td> ';
	echo '<td class="list_description">'.retornaEstado($ped['Status']).						'</td>'; 
	echo "</tr>";

	}

?>
	
					
					</tbody>
				</table>
			</div>
		</div>
	</section>

<!--fim_list-->