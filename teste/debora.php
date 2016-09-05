<?php
require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";
require "../funcoes/funcoesSiscontrat.php";

$pedido = siscontratLista(1,"",10,1,"DESC","todos"); //esse gera uma array com os pedidos



?>
	
	  	  
	 <!-- inicio_list -->
	<section id="list_items">
		<div class="container">
			 <div class="sub-title">PEDIDO DE CONTRATAÇÃO DE PESSOA FÍSICA</div>
			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
							<td>Codigo do Pedido</td>
							<td>Proponente</td>
							<td>Tipo</td>
							<td>Objeto</td>
							<td>Local</td>
							<td>Instituição</td>
							<td>Periodo</td>
							<td>Valor</td>
							<td>Parcelas</td>
							<td>Verba</td>
                            <td>Processo</td>
						</tr>
					</thead>
					<tbody>
<?php
echo var_dump($pedido);

$data=date('Y');
for($i = 0; $i < count($pedido); $i++)
 {
	 	
	echo '<td class="list_description">'.$pedido[$i]['idPedido'].'</td> ';
	
	if($pedido[$i]['TipoPessoa'] == 2){
		$pessoa = recuperaDados("sis_pessoa_juridica",$pedido[$i]['IdProponente'],"Id_PessoaJuridica");
		echo '<td class="list_description">'.$pedido[$i]['proponente'] = $pessoa['RazaoSocial'].'</td>';
		echo '<td class="list_description">'.$pedido[$i]['tipo'] = "Jurídica".'</td>';
	}else{
		$pessoa = recuperaDados("sis_pessoa_fisica",$pedido[$i]['IdProponente'],"Id_PessoaFisica");
		echo '<td class="list_description">'.$pedido[$i]['proponente'] = $pessoa['Nome'].'</td>';
		echo '<td class="list_description">'.$pedido[$i]['tipo'] = "Física".'</td>';
	}
	

	echo '<td class="list_description">'.$pedido[$i]['Objeto'].'</td>';
	echo '<td class="list_description">'.$pedido[$i]['Local'].'</td> ';
	echo '<td class="list_description">'.$pedido[$i]['Instituicao'].'</td> ';
	echo '<td class="list_description">'.$pedido[$i]['Periodo'].'</td> ';
	echo '<td class="list_description">'.$pedido[$i]['ValorGlobal'].'</td> ';
	echo '<td class="list_description">'.$pedido[$i]['parcelas'].'</td> ';
	echo '<td class="list_description">'.$pedido[$i]['Verba'].'</td> ';
	echo '<td class="list_description">'.$pedido[$i]['NumeroProcesso'].'</td> </tr>';
	}

?>
	
					
					</tbody>
				</table>
			</div>
		</div>
	</section>

<!--fim_list-->