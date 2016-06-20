<?php

$lista = lista_prazo("todos",1000,1,"DESC"); //esse gera uma array com os pedidos

//$tipoPessoa,$num_registro,$pagina,$ordem

$link="index.php?perfil=gestao_prazos&p=detalhe_evento&id_eve=";


?>
	
<?php include 'includes/menu.php';?>	
	  	  
	 <!-- inicio_list -->
	<section id="list_items">
		<div class="container">
			 <div class="sub-title"><br/><br/><h4>PEDIDOS DE CONTRATAÇÃO</h4></div>
			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
							<td>Id Evento</td>
							<td>Codigo do Pedido</td>
							<td>Proponente</td>
							<td>Objeto</td>
							<td>Local</td>
							<td>Periodo</td>
                            <td>Fiscal</td>
						</tr>
					</thead>
					<tbody>
<?php
$data=date('Y');
for($i = 0; $i < count($lista); $i++)
 {
	 
	$pf = recuperaDados("sis_pessoa_fisica",$lista[$i]['IdProponente'],"Id_PessoaFisica");
	$chamado = recuperaAlteracoesEvento($lista[$i]['idEvento']);	 
	echo "<tr><td class='lista'> <a href='".$link.$lista[$i]['idEvento']."'>".$lista[$i]['idEvento']."</a></td>";
	echo "<td class='lista'>" .$lista[$i]['idPedido']."</td>";
	echo '<td class="list_description">'.$pf['Nome'].'</td> ';
	echo '<td class="list_description">'.$lista[$i]['Objeto'].' [';
					if($chamado['numero'] == '0'){
						echo "0";
					}else{
						echo "<a href='?perfil=chamado&p=evento&id=".$lista[$i]['idEvento']."' target='_blank'>".$chamado['numero']."</a>";	
					}
					
	echo '] </td> ';
	echo '<td class="list_description">'.$lista[$i]['Local'].'</td> ';
	echo '<td class="list_description">'.$lista[$i]['Periodo'].'</td> ';
	echo '<td class="list_description">'.$lista[$i]['Fiscal'].'</td> </tr>';
	
	}

echo "<br/><h5>Foram encontrados ".$i." registros</h5>";
?>
	
					
					</tbody>
				</table>
			</div>
		</div>
	</section>

<!--fim_list-->