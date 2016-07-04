<?php

$id_ped = $_GET['id_ped'];
$server = "http://".$_SERVER['SERVER_NAME']."/igsis/";
$http = $server."/pdf/";
$link1=$http."rlt_emissao_nf_integral.php";
$link2=$http."rlt_emissao_nf_parcelado.php";

$_SESSION['idPedido'] = $_GET['id_ped'];
$pedido = recuperaDados("igsis_pedido_contratacao",$_GET['id_ped'],"idPedidoContratacao");
$parcelamento = retornaParcelaPagamento($id_ped);



	$con = bancoMysqli();
if(isset($_POST['atualizar'])){ // atualiza o pedido
	$ped = $_GET['id_ped'];
	$notaFiscal=$_POST['notaFiscal'];
	$descricaoNF= $_POST['descricaoNF'];

	$sql_atualiza_pedido = "UPDATE igsis_pedido_contratacao SET 
			notaFiscal = '$notaFiscal',
			descricaoNF = '$descricaoNF',			
			estado = 10
			WHERE idPedidoContratacao = '$id_ped' ";
	if(mysqli_query($con,$sql_atualiza_pedido))
	{
		if($pedido['parcelas'] > 1){ 
			$men = "<br/>
				<h5>Qual documento deseja imprimir?</h5>
					<table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td></td>
							<td>Valor</td>
                            <td>Data</td>
						</tr>
					</thead>
					<tbody>
					
					";
			
			for($i = 1; $i < count($parcelamento); $i++)
			{
				$men .= '
					<tr><td class="list_description"><a target="_blank" href='.$link2.'?id='.$id_ped.'&parcela='.$i.'>EMISSÃO DE N.F. da '.$i.'ª parcela</a></td>
						<td class="list_description">R$ '.$parcelamento[$i]['valor'].'</td> 
						<td class="list_description">R$ '.$parcelamento[$i]['pagamento'].'</td>
					</tr>';
				
			}
			$men .="</tbody></table><br/><br/>";
			?>
			
			<?php
		}
		else {
			$men = "
				<div class='col-md-offset-2 col-md-8'>
					<a href='$link1?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Emissão de N.F.</a>
				</div>	 
				<div class='col-md-offset-2 col-md-8'>
					<br/>
				</div>
			";	
		}
	}
	else
	{
		$mensagem = "Erro ao atualizar! Tente novamente.";
	}
		
}

	$pedido = recuperaDados("igsis_pedido_contratacao",$_GET['id_ped'],"idPedidoContratacao");
?>	


<?php include 'includes/menu.php';?>
		
	  
	 <!-- Contact -->
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<div class="sub-title"><h2>CADASTRO DE NOTA FISCAL</h2></div>
					<div><?php if(isset($mensagem)){ echo $mensagem; } ?></div>
					<div><?php if(isset($men)){ echo $men; } ?></div>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=pagamento&p=frm_cadastra_emissao_nf&id_ped=<?php echo $id_ped; ?>" method="post">
				  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Código do Pedido de Contratação:</strong>
					  <input type="text" class="form-control" disabled id="Id_PedidoContratacao"  name="Id_PedidoContratacao" <?php echo " value='$id_ped' ";?>>
					</div>
				</div>
				 
                <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nota Fiscal nº:</strong>
					  <input type="text" class="form-control" name="notaFiscal" placeholder="Número da Nota Fiscal" value="<?php echo $pedido['notaFiscal']; ?>">
					</div>
				</div>
                  
                <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Descrição:</strong>
					  <input type="text" class="form-control" name="descricaoNF" placeholder="Descrição" value="<?php echo $pedido['descricaoNF']; ?>">
					</div>
				</div>
					
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					 <input type="submit" name="atualizar" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
                  
				</form>
	
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  
