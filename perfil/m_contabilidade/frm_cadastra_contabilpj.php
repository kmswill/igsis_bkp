<?php

$id_ped = $_GET['id_ped'];
$server = "http://".$_SERVER['SERVER_NAME']."/igsis/";
$http = $server."/pdf/";
$link1=$http."rlt_anexo_nota_empenho_pj.php";
$data = date('Y-m-d H:i:s');

	$con = bancoMysqli();
if(isset($_POST['atualizar'])){ // atualiza o pedido
	$ped = $_GET['id_ped'];

	$sql_atualiza_pedido = "UPDATE igsis_pedido_contratacao SET
		estado = 9,
		DataContabilidade = '$data'
		WHERE idPedidoContratacao = '$id_ped'";
	if(mysqli_query($con,$sql_atualiza_pedido)){
			$mensagem = "
			<div class='form-group'>
    		 <div class='col-md-offset-2 col-md-8'>
				<a href='$link1?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Gerar Word</a></div>
	</div><br/><br/>
	";	
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
$res01 = siscontratDocs($ped['idRepresentante01'],3);
$res02 = siscontratDocs($ped['idRepresentante02'],3);

?>

<!-- MENU -->	
<?php include 'includes/menu.php';

$server = "http://".$_SERVER['SERVER_NAME']."/igsis/";
$http = $server."/pdf/";
$link0=$http."rlt_anexo_nota_empenhopj.php";
?>
	 <!-- Contact -->
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group"><h2>ANEXO NOTA DE EMPENHO DE PESSOA JURÍDICA</h2>
        <h4><?php if(isset($mensagem)){ echo $mensagem; } ?></h4></div>
		<div class="row">
	  		<div class="col-md-offset-1 col-md-10">
            <div class="col-md-offset-2 col-md-8">
            <div class="left">
                <p align="justify"><strong>Código do pedido de contratação:</strong> <?php echo $ano."-".$id_ped; ?></p>
				<p align="justify"><strong>Número do Processo:</strong> <?php echo $pedido['NumeroProcesso'];?></p>
				<p align="justify"><strong>Setor:</strong> <?php echo $pedido['Setor'];?></p>	
				<p align="justify"><strong>Proponente:</strong> <?php echo $pj['Nome'];?></p>
                <p align="justify"><strong>Objeto:</strong> <?php echo $pedido['Objeto'];?></p>
                <p align="justify"><strong>Local:</strong> <?php echo $pedido['Local'];?></p>
                <p align="justify"><strong>Valor:</strong> R$ <?php echo dinheiroParaBr($pedido["ValorGlobal"]);?></p>
                <p align="justify"><strong>Forma de Pagamento:</strong> <?php echo $pedido["FormaPagamento"];?></p>
                <p align="justify"><strong>Data/Período:</strong> <?php echo $pedido['Periodo'];?></p>
                <p align="justify"><strong>Duração:</strong> <?php echo $pedido['Duracao'];?> minutos</p>
                <p align="justify"><strong>Carga Horária:</strong> <?php echo $pedido['CargaHoraria'];?></p>
                <p align="justify"><strong>Justificativa:</strong> <?php echo $pedido['Justificativa']; ?></p>
                <p align="justify"><strong>Fiscal:</strong> <?php echo $pedido['Fiscal'];?></p>
                <p align="justify"><strong>Suplente:</strong> <?php echo $pedido['Suplente'];?></p>
                <p align="justify"><strong>Parecer Técnico:</strong> <?php echo $pedido['ParecerTecnico']; ?></p>
                <p align="justify"><strong>Observação:</strong> <?php echo $pedido['Observacao'];?></p>
                <p align="justify"><strong>Data do Cadastro:</strong> <?php echo exibirDataBr($pedido['DataCadastro']);?></p>               
			</div>
            </div>
            <form class="form-horizontal" role="form" action="?perfil=contabilidade&p=frm_cadastra_contabilpj&id_ped=<?php echo $id_ped; ?>" method="post">
				<div class="col-md-offset-2 col-md-8">
					 <input type="submit" name="atualizar" class="btn btn-theme btn-lg btn-block" value="Confirmar">
				</div>
            </form> 
      </div>
      </div>
      </div>
   </div>
</section>         