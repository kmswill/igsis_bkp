<?php

$id_ped = $_GET['id_ped'];
$server = "http://".$_SERVER['SERVER_NAME']."/igsis/";
$http = $server."/pdf/";
$link1=$http."rlt_recibo_liquidacao_pf.php";
$link2=$http."rlt_recibo_liquidacao_pj.php";

$_SESSION['idPedido'] = $_GET['id_ped'];
$pedido = recuperaDados("igsis_pedido_contratacao",$_GET['id_ped'],"idPedidoContratacao");



	$con = bancoMysqli();
if(isset($_POST['atualizar'])){ // atualiza o pedido
	$ped = $_GET['id_ped'];
	$extratoLiquidacao=$_POST['extratoLiquidacao'];
	$retencoesINSS= $_POST['retencoesINSS'];
	$retencoesISS= $_POST['retencoesISS'];
	$retencoesIRRF=$_POST['retencoesIRRF'];

	$sql_atualiza_pedido = "UPDATE igsis_pedido_contratacao SET 
			extratoLiquidacao = '$extratoLiquidacao',
			retencoesINSS = '$retencoesINSS',
			retencoesISS = '$retencoesISS',
			retencoesIRRF = '$retencoesIRRF',			
			estado = 10
			WHERE idPedidoContratacao = '$id_ped' ";
	if(mysqli_query($con,$sql_atualiza_pedido))
	{
		if($pedido['tipoPessoa'] == 1)
			{
				$mensagem = "<h5>Deseja gerar o recibo?</h5>
				<div class='col-md-offset-2 col-md-8'>
					<a href='$link1?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Recibo Padrão</a>
				</div>	 
				<div class='col-md-offset-2 col-md-8'>
					<br/>
				</div>"	;		
			}
			else
			{
				$mensagem = "<h5>Deseja gerar o recibo?</h5>
				<div class='col-md-offset-2 col-md-8'>
					<a href='$link2?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Recibo Padrão</a>
				</div>				
				<div class='col-md-offset-2 col-md-8'>
					<br/>
				</div>";	
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
					<div class="sub-title"><h2>CADASTRO DE NOTA DE LIQUIDAÇÃO</h2></div>
					<div><?php if(isset($mensagem)){ echo $mensagem; } ?></div>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=pagamento&p=frm_cadastra_liquidacao&id_ped=<?php echo $id_ped; ?>" method="post">
				  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Código do Pedido de Contratação:</strong>
					  <input type="text" class="form-control" disabled id="Id_PedidoContratacao"  name="Id_PedidoContratacao" <?php echo " value='$id_ped' ";?>>
					</div>
				</div>
				 
                <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Extrato de Liquidação e Pagamento nº:</strong>
					  <input type="text" class="form-control" name="extratoLiquidacao" placeholder="Número do Extrato de Liquidação e Pagamento" value="<?php echo $pedido['extratoLiquidacao']; ?>">
					</div>
				</div>
                  
                <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Retenções de I.N.S.S:</strong>
					  <input type="text" class="form-control" name="retencoesINSS" placeholder="Guia de Recolhimento ou Depósito da Prefeitura do Município de São Paulo nº" value="<?php echo $pedido['retencoesINSS']; ?>">
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Retenções de I.S.S:</strong>
					  <input type="text" class="form-control" name="retencoesISS" placeholder="Documento de Arrecadação de Tributos Imobiliários – DARM n.º" value="<?php echo $pedido['retencoesISS']; ?>">
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Retenções de I.R.R.F:</strong>
					  <input type="text" class="form-control" name="retencoesIRRF" placeholder="Guia Recibo de Recolhimento ou Depósito nº" value="<?php echo $pedido['retencoesIRRF']; ?>">
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
