<?php

require_once("../funcoes/funcoesVerifica.php");
require_once("../funcoes/funcoesSiscontrat.php");

include "../include/menuBusca.php";

$id_ped = $_GET['id_ped'];

$con = bancoMysqli();
if(isset($_POST['atualizar'])){ // atualiza o pedido
	$ped = $_GET['id_ped'];

	$sql_atualiza_pedido = "UPDATE igsis_pedido_contratacao SET
		estado = 11
		WHERE idPedidoContratacao = '$id_ped'";
	if(mysqli_query($con,$sql_atualiza_pedido)){
			$mensagem = "Pedido $id_ped concluído com sucesso!";
		}else{
			$mensagem = "Erro ao atualizar! Tente novamente.";
		}
		
	}

$ano=date('Y');
$id_ped = $_GET['id_ped'];	
$linha_tabelas = siscontrat($id_ped);
$fisico = siscontratDocs($linha_tabelas['IdProponente'],1);	

$ped = recuperaDados("igsis_pedido_contratacao",$id_ped,"idPedidoContratacao");
$status = recuperaDados("sis_estado",$ped['estado'],"idEstado");

?>


  	
	  
	 <!-- Contact -->
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group"><h2>CONTRATAÇÃO DE PESSOA FÍSICA</h2>
        <h4><?php if(isset($mensagem)){ echo $mensagem; } ?></h4></div>
		<div class="row">
	  	<div class="col-md-offset-1 col-md-10">
            <div class="col-md-offset-2 col-md-8">
            <div class="left">
                <p align="justify"><strong>Código do pedido de contratação:</strong> <?php echo $ano."-".$id_ped; ?></p>
				<p align="justify"><strong>Número do Processo:</strong> <?php echo $linha_tabelas['NumeroProcesso'];?></p>
				<p align="justify"><strong>Proponente:</strong> <?php echo $fisico['Nome'];?></p>
                <p align="justify"><strong>Objeto:</strong> <?php echo $linha_tabelas['Objeto'];?></p>
                <p align="justify"><strong>Local:</strong> <?php echo $linha_tabelas['Local'];?></p>
				<p align="justify"><strong>Status do Pedido:</strong> <?php echo $status['estado'];?></p>
			</div>
            </div>
            <form class="form-horizontal" role="form" action="?perfil=formacao&p=frm_concluir_final_formacao&id_ped=<?php echo $id_ped; ?>" method="post">
				<div class="col-md-offset-2 col-md-8">
					 <input type="submit" name="atualizar" class="btn btn-theme btn-lg btn-block" value="Concluir Pedido">
				</div>
            </form>
      </div>
      </div>
      </div>
   </div>
</section>         