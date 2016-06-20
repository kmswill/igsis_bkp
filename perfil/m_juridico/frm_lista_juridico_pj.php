<?php 

//require "../funcoes/funcoesSiscontrat.php";

$linha_tabela_lista = siscontratLista(2,"",1000,1,"DESC",6); //esse gera uma array com os pedidos

//$tipoPessoa,$num_registro,$pagina,$ordem,$estado

$link="index.php?perfil=juridico&p=frm_cadastra_juridico_pj&id_ped=";


?>

<?php include 'includes/menu.php';?>
		
	  	  
<!-- inicio_list -->
	<section id="list_items">
		<div class="container">
			 <div class="sub-title">DESPACHO DE PESSOA JURÍDICA</div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Processo</td>
							<td>Código do Pedido</td>
                            <td>Proponente</td>
							<td>Objeto</td>
							<td>Local</td>
						</tr>
					</thead>
					<tbody>
					
<?php 

$data=date('Y');
for($i = 0; $i < count($linha_tabela_lista); $i++)
 {
	 
	$linha_tabela_pedido_contratacaopj = recuperaDados("sis_pessoa_juridica",$linha_tabela_lista[$i]['IdProponente'],"Id_PessoaJuridica");
	$chamado = recuperaAlteracoesEvento($linha_tabela_lista[$i]['idEvento']);	 
	echo "<tr><td class='lista'> <a href='".$link.$linha_tabela_lista[$i]['idPedido']."'>".$linha_tabela_lista[$i]['NumeroProcesso']."</a></td>";
	echo '<td class="list_description">'.$linha_tabela_lista[$i]['idPedido'].'</td>';
	echo '<td class="list_description">'.$linha_tabela_pedido_contratacaopj['RazaoSocial'].'</td> ';
	echo '<td class="list_description">'.$linha_tabela_lista[$i]['Objeto'].' [';
					if($chamado['numero'] == '0'){
						echo "0";
					}else{
						echo "<a href='?perfil=chamado&p=evento&id=".$linha_tabela_lista[$i]['idEvento']."' target='_blank'>".$chamado['numero']."</a>";	
					}
					
	echo '] </td> ';
	echo '<td class="list_description">'.$linha_tabela_lista[$i]['Local'].'</td> </tr> ';
	}

	?>
	
					</tbody>
				</table>
			</div>
		</div>
	</section>

<!--fim_list-->