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
$pedido = siscontrat($id_ped);
$pj = siscontratDocs($pedido['IdProponente'],2);
$evento = recuperaDados("ig_evento",$pedido['idEvento'],"idEvento");
$executante = siscontratDocs($pedido['IdExecutante'],1);

$ped = recuperaDados("igsis_pedido_contratacao",$id_ped,"idPedidoContratacao");
$rep01 = siscontratDocs($pj['Representante01'],3);
$rep02 = siscontratDocs($pj['Representante02'],3);

$status = recuperaDados("sis_estado",$ped['estado'],"idEstado");

?>

	  
	 <!-- Contact -->
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group"><h2>CONTRATAÇÃO DE PESSOA JURÍDICA</h2>
        <h4><?php if(isset($mensagem)){ echo $mensagem; } ?></h4></div>
		<div class="row">
	  	<div class="col-md-offset-1 col-md-10">
            <div class="col-md-offset-2 col-md-8">
            <div class="left">
                <p align="justify"><strong>Código do pedido de contratação:</strong> <?php echo $ano."-".$id_ped; ?></p>
				<p align="justify"><strong>Número do Evento:</strong> <?php echo $pedido['idEvento'];?></p>
				<p align="justify"><strong>Número do Processo:</strong> <?php echo $pedido['NumeroProcesso'];?></p>
                <p align="justify"><strong>Setor:</strong> <?php echo $pedido['Setor'];?></p>	
				<p align="justify"><strong>Proponente:</strong> <?php echo $pj['Nome'];?></p>
				<p align="justify"><strong>Executante:</strong> <?php echo $executante['Nome'];?></p>
				<p align="justify"><strong>Representante #1:</strong> <?php echo $rep01["Nome"];?></p>
				<p align="justify"><strong>Representante #2:</strong> <?php echo $rep02["Nome"];?></p>
                <p align="justify"><strong>Objeto:</strong> <?php echo $pedido['Objeto'];?></p>
                <p align="justify"><strong>Local:</strong> <?php echo $pedido['Local'];?></p>
                <p align="justify"><strong>Valor:</strong> R$ <?php echo dinheiroParaBr($pedido["ValorGlobal"]);?></p>
				<p align="justify"><strong>Forma de Pagamento:</strong> <?php echo $pedido['FormaPagamento'];?></p>
                <p align="justify"><strong>Data/Período:</strong> <?php echo $pedido['Periodo'];?></p>
                <p align="justify"><strong>Duração:</strong> <?php echo $pedido['Duracao'];?>utos</p>
                <p align="justify"><strong>Carga Horária:</strong> <?php echo $pedido['CargaHoraria'];?></p>
                <p align="justify"><strong>Justificativa:</strong> <?php echo $pedido['Justificativa']; ?></p>
                <p align="justify"><strong>Fiscal:</strong> <?php echo $pedido['Fiscal'];?></p>
                <p align="justify"><strong>Suplente:</strong> <?php echo $pedido['Suplente'];?></p>
				<p align="justify"><strong>Parecer:</strong> <?php echo addslashes($pedido['ParecerTecnico']);?></p>
				<p align="justify"><strong>Nota de Empenho:</strong> <?php echo $pedido['NotaEmpenho'];?></p>
				<p align="justify"><strong>Data de Emissão da N.E.:</strong> <?php echo $pedido['EmissaoNE'];?></p>
				<p align="justify"><strong>Data de Entrega de N.E.:</strong> <?php echo $pedido['EntregaNE'];?></p>
				<p align="justify"><strong>Dotação Orçamentária:</strong> <?php echo $pedido['ComplementoDotacao'];?></p>
                <p align="justify"><strong>Observação:</strong> <?php echo $pedido['Observacao'];?></p>
                <p align="justify"><strong>Data do Cadastro/Envio:</strong> <?php echo exibirDataBr($pedido['DataCadastro']);?></p>  
				<p align="justify"><strong>Status do Pedido:</strong> <?php echo $status['estado'];?></p>				
			</div>
            </div>
            <form class="form-horizontal" role="form" action="?perfil=pagamento&p=frm_concluir_processo_pj&id_ped=<?php echo $id_ped; ?>" method="post">
				<div class="col-md-offset-2 col-md-8">
					 <input type="submit" name="atualizar" class="btn btn-theme btn-lg btn-block" value="Concluir Pedido">
				</div>
            </form>
      </div>
      </div>
      </div>
   </div>
</section>         