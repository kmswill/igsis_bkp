<?php

$linha_tabela_lista = siscontratLista(1,"",1000,1,"DESC",8); //esse gera uma array com os pedidos
//$tipoPessoa,$instituicao,$num_registro,$pagina,$ordem,$estado

$link="index.php?perfil=publicacao&p=frm_cadastra_publicacaopf&id_ped=";

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
						</tr>
					</thead>
					<tbody>
<?php
$data=date('Y');
for($i = 0; $i < count($linha_tabela_lista); $i++)
 {
	$linha_tabela_pedido_contratacaopf = recuperaDados("sis_pessoa_fisica",$linha_tabela_lista[$i]['IdProponente'],"Id_PessoaFisica");	 
	echo "<tr><td class='lista'> <a href='".$link.$linha_tabela_lista[$i]['idPedido']."'>".$linha_tabela_lista[$i]['idPedido']."</a></td>";
	echo '<td class="list_description">'.$linha_tabela_lista[$i]['NumeroProcesso'].'</td>';
	echo '<td class="list_description">'.$linha_tabela_pedido_contratacaopf['Nome'].'</td> ';
	echo '<td class="list_description">'.$linha_tabela_lista[$i]['Objeto'].'</td> ';
	echo '<td class="list_description">'.$linha_tabela_lista[$i]['Local'].'</td> ';
	echo '<td class="list_description">'.$linha_tabela_lista[$i]['Periodo'].'</td> </tr>';
	}

?>
	
					
					</tbody>
				</table>
			</div>
		</div>
	</section>

<!--fim_list-->