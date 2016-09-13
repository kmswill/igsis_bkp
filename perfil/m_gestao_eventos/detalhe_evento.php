<?php

$con = bancoMysqli();
if(isset($_GET['pag'])){
	$p = $_GET['pag'];
}else{
	$p = 'inicial';	
}
//$nomeEvento = recuperaEvento($_SESSION['idEvento']);

$idEvento = $_GET['id_eve'];
$evento = recuperaEvento($_GET['id_eve']);
$_SESSION['idEvento'] = $idEvento;

?>
<?php include "includes/menu.php"; ?>


<?php switch($p){

/* =========== INICIAL ===========*/
case 'inicial':

$idEvento = $_GET['id_eve'];
?>

<section id="list_items" class="home-section bg-white">
	<div class="container">
	<h5>Dados do evento | 
		<a href="?perfil=gestao_eventos&p=detalhe_evento&pag=servicos&id_eve=<?php echo $idEvento;?>">Solicitação de serviços</a> | 
		<a href="?perfil=gestao_eventos&p=detalhe_evento&pag=pedidos&id_eve=<?php echo $idEvento;?>">Pedidos de contratação</a> |  
		<a href="?perfil=gestao_eventos&p=detalhe_evento&pag=pendencias&id_eve=<?php echo $idEvento;?>">Pendências</a>
	</h5>
	<div class="table-responsive list_info" >
        <h4><?php echo $evento['nomeEvento'] ?></h4>
			<p align="left"><?php descricaoEvento($idEvento); ?></p>      
        <h5>Ocorrências</h5>
            <?php echo resumoOcorrencias($idEvento); ?><br /><br />
            <?php listaOcorrenciasTexto($idEvento); ?>
		<h5>Especificidades</h5>
			<div class="left"><?php descricaoEspecificidades($idEvento,$evento['ig_tipo_evento_idTipoEvento']); ?></div>
	</div>
</section>
<?php /* =========== INICIAL ===========*/ break; ?>

<?php /* =========== INÍCIO SERVIÇOS ===========*/
case "servicos":

?>
<section id="list_items" class="home-section bg-white">
	<div class="container">
	<h5><a href="?perfil=gestao_eventos&p=detalhe_evento&pag=inicial&id_eve=<?php echo $idEvento;?>">Dados do evento</a> | 
		Solicitação de serviços | 
		<a href="?perfil=gestao_eventos&p=detalhe_evento&pag=pedidos&id_eve=<?php echo $idEvento;?>">Pedidos de contratação</a> |  
		<a href="?perfil=gestao_eventos&p=detalhe_evento&pag=pendencias&id_eve=<?php echo $idEvento;?>">Pendências</a>
	</h5>
	<div class="table-responsive list_info" >    
		<h4><?php echo $evento['nomeEvento'] ?></h4>
		<div class="left">
            <h5>Previsão de serviços externos</h5>
            <?php listaServicosExternos($idEvento); ?><br /><br />
			<h5>Serviços Internos</h5>
			<?php listaServicosInternos($idEvento) ?>
        </div>
	</div>
</section>		
<?php /* =========== FIM SEVIÇOS ===========*/ break; ?>


<?php /* =========== INÍCIO PEDIDOS ===========*/
case "pedidos":

$pedido = listaPedidoContratacao($_SESSION['idEvento']);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container">
	<h5><a href="?perfil=gestao_eventos&p=detalhe_evento&pag=inicial&id_eve=<?php echo $idEvento;?>">Dados do evento</a> | 
		<a href="?perfil=gestao_eventos&p=detalhe_evento&pag=servicos&id_eve=<?php echo $idEvento;?>">Solicitação de serviços</a> |  
		Pedidos de contratação |  
		<a href="?perfil=gestao_eventos&p=detalhe_evento&pag=pendencias&id_eve=<?php echo $idEvento;?>">Pendências</a>
	</h5>
	<div class="table-responsive list_info" >
	<?php if($pedido != NULL){ ?>

            <h4><?php echo $evento['nomeEvento'] ?></h4>

			  <?php for($i = 0; $i < count($pedido); $i++){
			$dados = siscontrat($pedido[$i]);
			$pessoa = siscontratDocs($dados['IdProponente'],$dados['TipoPessoa']);
			?>
            <p align="left">
			Nome ou Razão Social: <b><?php echo $pessoa['Nome'] ?></b><br />
			Tipo de pessoa: <b><?php echo retornaTipoPessoa($dados['TipoPessoa']);?></b><br />
			Dotação: <b><?php echo retornaVerba($dados['Verba']);?></b><br />
			Valor: <b>R$ <?php echo dinheiroParaBr($dados['ValorGlobal']);?></b><br />		
			 </p>      
<?php } // fechamento do for 

}else{ ?>
	<h5> Não há pedidos de contratação. </h5>
<?php }	?>

	</div>
</section>
<?php /* =========== FIM SEVIÇOS ===========*/ break; ?>


<?php /* =========== INÍCIO PENDENCIAS ===========*/
case "pendencias":
require_once("../funcoes/funcoesVerifica.php");
require_once("../funcoes/funcoesSiscontrat.php");
	$evento = recuperaDados("ig_evento",$_SESSION['idEvento'],"idEvento");
	$campos = verificaCampos($idEvento);
	$ocorrencia = verificaOcorrencias($idEvento);
?>
<section id="list_items" class="home-section bg-white">
	<div class="container">
	<h5><a href="?perfil=gestao_eventos&p=detalhe_evento&pag=inicial&id_eve=<?php echo $idEvento;?>">Dados do evento</a> | 
		<a href="?perfil=gestao_eventos&p=detalhe_evento&pag=servicos&id_eve=<?php echo $idEvento;?>">Solicitação de serviços</a> |  
		<a href="?perfil=gestao_eventos&p=detalhe_evento&pag=pedidos&id_eve=<?php echo $idEvento;?>">Pedidos de contratação</a> | 
		Pendências
	</h5>
	<div class="table-responsive list_info" >
        <h4><?php echo $evento['nomeEvento'] ?></h4>
        <div class="left">
            <?php if($campos['total'] > 0){
				echo "<h4>Há campos obrigatórios não preenchidos.</h4>";	
				echo "<strong>".substr($campos['campos'],1)."</strong>";
			}else{
				echo "<h4>Todos os campos obrigatórios foram preenchidos.</h4>";
			}?>
			<br /><br />
		<p><?php if($ocorrencia > 0){
			echo "<h4>Há ocorrências cadastradas.</h4>";	
			echo "<br /><br />";
			prazoContratos($idEvento);
		}else{
			echo "Não há ocorrências cadastradas.";
		}?></p>
		</div>
            <br />
	</div>	
	<div class="form-group">
		<div class="col-md-offset-4 col-md-6">
			<form method='POST' action='?perfil=gestao_eventos&p=detalhe_evento&pag=finalizar&id_eve=<?php echo $idEvento;?>'>
			<input type='hidden' name='carregar' value='".$idEvento."' />
			<input type ='submit' class='btn btn-theme btn-lg btn-block' value='Enviar'></form>
        </div>
    </div>

	</div>
</section>
<?php /* =========== FIM PENDENCIAS ===========*/ break; ?>


<?php /* =========== INÍCIO FINALIZAR ===========*/

case "finalizar":
include "../include/menuEvento.php";
require_once("../funcoes/funcoesVerifica.php");
require_once("../funcoes/funcoesSiscontrat.php");

$verifca = verificaPendencias($idEvento);
if($verifica == 0){
 ?>

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
	                <h2>O pedido será enviado!</h2>
                </div>
            </div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<p>Uma vez enviado o formulário, não poderá mais editá-lo.</p>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
				<?php 
				$con = bancoMysqli();
				?>
				<form method='POST' action='?perfil=finalizar'>
				<input type='hidden' name='finalizar' value='<?php echo $idEvento ?>' />
				<input type ='submit' class='btn btn-theme btn-lg btn-block' value='Enviar' onclick="this.disabled = true; this.value = 'Enviando…'; this.form.submit();"></form>
				</div>
			</div>
        </div>
    </div>
</section>      

<?php }else{?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">
        
            <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
	                <h2>Não é possível enviar o formulário!</h2>
                </div>
            </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
			<p>Há pendências que necessitam ser resolvidas. </p>
            </div>
          </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	       	        	       	          <form method='POST' action='?perfil=finalizar'>
			<input type='hidden' name='finalizar' value='".$idEvento."' />
			<input type ='submit' class='btn btn-theme btn-lg btn-block' value='Enviar'></form>

            </div>
          </div>
        </div>
    </div>
</section>    
<?php } ?> 

<?php /* =========== FIM FINALIZAR ===========*/ break; ?>


<?php } //fim da switch ?>