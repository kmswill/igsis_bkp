<?php 

//require "../funcoes/funcoesSiscontrat.php";

$linha_tabela_lista = siscontratLista(4,"",1000,1,"DESC",6); //esse gera uma array com os pedidos

//$tipoPessoa,$num_registro,$pagina,$ordem,$estado

$link="index.php?perfil=juridico&p=frm_lista_modelo_pf&id_ped=";


?>

<?php include 'includes/menu.php';?>
		
	  	  
<!-- inicio_list -->
	<section id="list_items">
		<div class="container">
			 <div class="sub-title">DESPACHO DE PESSOA FÍSICA</div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Processo</td>
							<td>Código do Pedido</td>
                            <td>Proponente</td>
						</tr>
					</thead>
					<tbody>
					
<?php 

$data=date('Y');
for($i = 0; $i < count($linha_tabela_lista); $i++)
 {
	 
	$linha_tabela_pedido_contratacaopf = recuperaDados("sis_pessoa_fisica",$linha_tabela_lista[$i]['IdProponente'],"Id_PessoaFisica");
	$chamado = recuperaAlteracoesEvento($linha_tabela_lista[$i]['idEvento']);	 
	echo "<tr><td class='lista'> <a href='".$link.$linha_tabela_lista[$i]['idPedido']."'>".$linha_tabela_lista[$i]['NumeroProcesso']."</a></td>";
	echo '<td class="list_description">'.$linha_tabela_lista[$i]['idPedido'].'</td>';
	echo '<td class="list_description">'.$linha_tabela_pedido_contratacaopf['Nome'].'</td> </tr> ';
	}

	?>
	
					</tbody>
				</table>
			</div>
		</div>
	</section>

<!--fim_list-->