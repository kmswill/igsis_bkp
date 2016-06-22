<?php

require_once("../funcoes/funcoesVerifica.php");
require_once("../funcoes/funcoesSiscontrat.php");

include "../include/menuBusca.php";

$ano=date('Y');
$id_ped = $_GET['id_ped'];	
$pedido = siscontrat($id_ped);
$idEvento = $pedido['idEvento'];
$pessoa = siscontratDocs($pedido['IdProponente'],$pedido['TipoPessoa']);
$evento = recuperaDados('ig_evento',$idEvento,'idEvento');

?>

	  
	 <!-- Contact -->
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group"><h3><?php echo $evento['nomeEvento'] ?></h3>
        <h5><?php if(isset($mensagem)){ echo $mensagem; } ?></h5></div>
		<div class="row">
	  	<div class="col-md-offset-1 col-md-10">            
            <div class="left">
				<?php if($pedido['TipoPessoa'] == '4'){ ?>
					<h3>CONTRATAÇÃO DA SMC-DIVISÃO DE FORMAÇÃO</h3>
				<?php }else{ ?>
				<p align="justify"><?php descricaoEvento($idEvento); ?></p>
				<br/>
				<h5>Ocorrências</h5>
				<p align="justify"><?php echo resumoOcorrencias($idEvento); ?></p>
				<p align="justify"><?php listaOcorrenciasTexto($idEvento); ?></p>				
				<br />
				<h5>Especificidades</h5>
				<p align="justify"><?php descricaoEspecificidades($idEvento,$evento['ig_tipo_evento_idTipoEvento']); ?></p>
				<br/>
				<h5>Sub-eventos</h5>
				<?php if($evento['subEvento'] == '1'){ ?>
					<p align="justify"><?php listaSubEventosCom($idEvento); ?></p>
				<?php }else{ ?>
					<p>Não há sub-eventos cadastrados.</p>
				<?php } ?>
				<?php if($evento['ig_tipo_evento_idTipoEvento'] == '1'){ ?>
					<br />
					<h5>Grade de Filmes</h5>
					<p align="justify"><?php gradeFilmes($idEvento) ?></p>
				<?php } ?>
				<br />
				<h5>Serviços externos</h5>
				<p align="justify"><?php listaServicosExternos($idEvento); ?></p>
				<br />
				<h5>Serviços Internos</h5>
				<p align="justify"><?php listaServicosInternos($idEvento) ?></p>
				<?php } ?>
				<br />				
				<h5>Pedidos de contratação</h5>
				<?php if($pedido != NULL){ ?>
					<p align="justify"><strong>Código do pedido de contratação:</strong> <?php echo $ano."-".$id_ped; ?></p>
					<p align="justify"><strong>Número do Processo:</strong> <?php echo $pedido['NumeroProcesso'];?></p>
					<p align="justify"><strong>Setor:</strong> <?php echo $pedido['Setor'];?></p>
					<p align="justify"><strong>Tipo de pessoa:</strong> <?php echo retornaTipoPessoa($pedido['TipoPessoa']);?></p>
					<p align="justify"><strong>Proponente:</strong> <?php echo $pessoa['Nome'];?></p>
					<p align="justify"><strong>Objeto:</strong> <?php echo $pedido['Objeto'];?></p>
					<p align="justify"><strong>Local:</strong> <?php echo $pedido['Local'];?></p>
					<?php if($pedido['TipoPessoa'] == '4'){ ?>
						<p align="justify"><strong>Carga Horária:</strong> <?php echo $pedido['CargaHoraria'];?></p>
					<?php } ?>
					<p align="justify"><strong>Verba:</strong> <?php echo retornaVerba($pedido['Verba']);?></p>
					<p align="justify"><strong>Valor:</strong> R$ <?php echo dinheiroParaBr($pedido["ValorGlobal"]);?></p>
					<p align="justify"><strong>Forma de Pagamento:</strong> <?php echo addslashes($pedido['FormaPagamento']);?></p>
					<p align="justify"><strong>Data/Período:</strong> <?php echo $pedido['Periodo'];?></p>
					<p align="justify"><strong>Justificativa:</strong> <?php echo $pedido['Justificativa']; ?></p>
					<p align="justify"><strong>Parecer:</strong> <?php echo $pedido['ParecerTecnico'];?></p>
					<p align="justify"><strong>Nota de Empenho:</strong> <?php echo $pedido['NotaEmpenho'];?></p>
					<p align="justify"><strong>Data de Emissão da N.E.:</strong> <?php echo exibirDataBr($pedido['EmissaoNE']);?></p>
					<p align="justify"><strong>Data de Entrega de N.E.:</strong> <?php echo exibirDataBr($pedido['EntregaNE']);?></p>
					<p align="justify"><strong>Dotação Orçamentária:</strong> <?php echo $pedido['ComplementoDotacao'];?></p>
					<p align="justify"><strong>Observação:</strong> <?php echo $pedido['Observacao'];?></p>
					<?php $status = recuperaDados("sis_estado",$pedido['Status'],"idEstado"); ?>
					<p align="justify"><strong>Último Status:</strong> <?php echo $status['estado'];?></p>
				<?php }else{ ?>
					<h5> Não há pedidos de contratação. </h5>
				<?php } ?>
			</div>
		</div>
		</div>
    </div>
</section>         