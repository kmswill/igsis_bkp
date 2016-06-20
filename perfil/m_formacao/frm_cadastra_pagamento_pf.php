<?php

$id_ped=$_GET['id_ped'];
//$id_parcela = $_GET['parcela'];



$pedido = siscontrat($id_ped);
$pessoa = siscontratDocs($pedido['IdProponente'],1);
$parcelamento = retornaParcelaPagamento($id_ped);


$server = "http://".$_SERVER['SERVER_NAME']."/igsis/"; 
$http = $server."/pdf/";
$link1 = $http."rlt_pagamento_formacao_pf.php"."?id=".$id_ped;
$link2 = $http."rlt_recibo_pagamento_formacao_pf.php"."?id=".$id_ped;
$link3 = $http."rlt_atestado_confirmacao_servicos_pf.php"."?id=".$id_ped;
$link4 = $http."rlt_flcontabilidade_formacao_pf.php"."?id=".$id_ped;
$link5 = $http."rlt_relatorio_horas_trabalhadas_formacao.php"."?id=".$id_ped;
$link6 = $http."rlt_fac_pf.php"."?id=".$id_ped;
?>


<?php

function recuperaProcessoPagamento($id_ped){ 
	$con = bancoMysqli();
	$sql = "SELECT `Id_Formacao`, `NumeroProcessoPagamento` FROM sis_formacao WHERE `idPedidoContratacao` = '$id_ped' LIMIT 0,1";
	$query = mysqli_query($con,$sql);
	$campo = mysqli_fetch_array($query);
	return $campo;		
}

$formacao = recuperaProcessoPagamento($id_ped);
$id_formacao = $formacao["Id_Formacao"];

if(isset($_POST['inserir'])){ //
	$con = bancoMysqli();
	
	$id_formacao = $_POST['inserir'];
	$processoPagamento = $_POST['NumeroProcessoPagamento'];
	
	$sql_insere_processo = "UPDATE sis_formacao SET NumeroProcessoPagamento='$processoPagamento' WHERE Id_Formacao = '$id_formacao'";
	$query_insere_processo = mysqli_query($con,$sql_insere_processo);
	if($query_insere_processo){
		$mensagem = "Atualizado com sucesso!";
		$formacao = recuperaProcessoPagamento($id_ped);
	}else{
		$mensagem = "Erro ao atualizar. Tente novamente.";
	}
}

?>


<!-- MENU -->	

<?php include 'includes/menu.php';?>
		
	  
	 <!-- Contact -->
	<section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h4>PEDIDO DE PAGAMENTO DA FORMAÇÃO</h4>
               </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">
                <form class="form-horizontal" role="form" action="#" method="post">

				<div class="form-group">
					<div class="col-md-offset-2 col-md-4"><strong>Pedido de Contratação nº:</strong> <?php echo $id_ped; ?></div>
					<div class="col-md-4"><strong>Processo nº:</strong> <?php echo $pedido["NumeroProcesso"]; ?></div>
                </div>
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Proponente:</strong> <?php echo $pessoa['Nome']." (".$pessoa['CPF'].")"; ?></div>
                </div>
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Objeto:</strong> <?php echo $pedido["Objeto"]; ?></div>
                </div>
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Local:</strong> <?php echo $pedido["Local"]; ?></div>
                </div>
				
				<div class="form-group">
				<form class="form-horizontal" role="form" action="?perfil=formacao&p=frm_cadastra_pagamento_pf&id=<?php echo $id_ped; ?>" method="post">
					<h5><?php if(isset($mensagem)){echo $mensagem;}?></h5>
					<div class="col-md-offset-1 col-md-3"><strong>Número Processo Pagamento:</strong>
					</div>
					<div class="col-md-5">
					<input type='text' class='form-control processo' name="NumeroProcessoPagamento" value="<?php echo $formacao["NumeroProcessoPagamento"]; ?>"></div>
					<div class="col-md-2">
						<input type="hidden" name="inserir" value="<?php echo $id_formacao = $formacao["Id_Formacao"] ?>" />		
						<input type="submit" value="GRAVAR" class="btn btn-theme">
					</div>
				</form>	
				</div>
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><a target="_blank" href="<?php echo $link6; ?>"><strong>EMITIR FACC</strong></a><br/><br/></div>
                </div>
				
				</div>
			</div>
		</div>
	
	
	<section id="list_items">	
		<div class="container">
				<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Nº Parcela</td>
							<td>Período</td>
							<td>Valor</td>
							<td>Pagamento</td>
                            <td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</thead>
					<tbody>
<?php				
for($i = 1; $i < count($parcelamento); $i++)
 {
	echo '<tr><td class="list_description">'.$i.'</td> ';
	echo '<td class="list_description">'.$parcelamento[$i]['periodo'].'</td> ';
	echo '<td class="list_description">R$ '.$parcelamento[$i]['valor'].'</td> ';
	echo '<td class="list_description">'.$parcelamento[$i]['pagamento'].'</td>';
	echo '<td class="list_description"><a target="_blank" href='.$link1.'&parcela='.$i.'>Pagamento</a></td>';
	echo '<td class="list_description"><a target="_blank" href='.$link2.'&parcela='.$i.'>Recibo</a></td>';
	echo '<td class="list_description"><a target="_blank" href='.$link3.'&parcela='.$i.'>Atestado Serviço</a></td>';
	echo '<td class="list_description"><a target="_blank" href='.$link5.'&parcela='.$i.'>Relatório Horas</a></td>';
	echo '<td class="list_description"><a target="_blank" href='.$link4.'&parcela='.$i.'>Contabilidade</a></td></tr>';
} ?>	

					</tbody>
				</table>
				</div>
             
                 
				 			
		</div>	
	</section>  
</section>