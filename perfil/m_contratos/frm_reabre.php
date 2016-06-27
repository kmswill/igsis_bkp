<?php
require_once("../funcoes/funcoesVerifica.php");
require_once("../funcoes/funcoesSiscontrat.php");
require_once("../funcoes/funcoesReabertura.php");
$con = bancoMysqli();

if(isset($_POST['idEvento'])){
	$idEvento = $_POST['idEvento'];
	$evento = recuperaDados("ig_evento",$_POST['idEvento'],"idEvento");
	$voltar = $_POST['voltar'];

}

if(isset($_POST['reabrir'])){
$titulo = "Reabertura do evento ".$evento['nomeEvento']." pela área de Contratos";
$idUsuario = $_SESSION['idUsuario'];
$tipo = 7;
$event = $idEvento;
$descricao = $titulo;	
$justificativa = addslashes($_POST['justificativa']);
$data = date('Y-m-d H:i:s');
$reabertura = reaberturaEvento($idEvento);
if($reabertura == 0){

	$sql_inserir_chamado = "INSERT INTO `igsis_chamado` (`idChamado`, `titulo`, `descricao`, `data`, `idUsuario`, `estado`, `tipo`, `idEvento`, `justificativa`) VALUES (NULL, '$titulo', '$descricao', '$data', '$idUsuario', '1', '$tipo', '$event', '$justificativa')";
	$query_inserir_chamado = mysqli_query($con,$sql_inserir_chamado);
	if($query_inserir_chamado){ ?>
    
    </script>
<?php include 'includes/menu.php';?>
<section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                    <h3>O evento <?php echo $evento['nomeEvento']; ?> foi reaberto com sucesso!</h3>
                     <h4><?php if(isset($mensagem)){echo $mensagem;} ?></h4>
                </div>
            </div>
    </div>
    
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="form-group">
				<p> Não será mais possível visualizar os pedidos deste evento até que o responsável o reenvie. </p>
            </div>
        </div>
    </div>
</section>  
    
    
    <?php
		}
	}
}else{




?>
<script type="application/javascript">
$(function(){
	$('#instituicao').change(function(){
		if( $(this).val() ) {
			$('#local').hide();
			$('.carregando').show();
			$.getJSON('local.ajax.php?instituicao=',{instituicao: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value=""></option>';	
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].idEspaco + '">' + j[i].espaco + '</option>';
				}	
				$('#local').html(options).show();
				$('.carregando').hide();
			});
		} else {
			$('#local').html('<option value="">-- Escolha uma instituição --</option>');
		}
	});
});
</script>
<?php include 'includes/menu.php';?>
<section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                    <h3>Reabrir evento e pedido</h3>
                     <h4><?php if(isset($mensagem)){echo $mensagem;} ?></h4>
                </div>
            </div>
    </div>
    
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
        <form method="POST" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" class="form-horizontal" role="form">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
					<div class="left">
                	<p><b>Evento:</b> <?php echo $evento['nomeEvento']; ?></p>
                	 <?php 
					 $outros = listaPedidoContratacao($idEvento); 
					 for($i = 0; $i < count($outros); $i++){
						$dados = siscontrat($outros[$i]);
							?>
        		    <p align="left">
        		    <b>Número do Pedido de Contratação:</b> <a href="?perfil=contratos&p=frm_edita_propostapf&id_ped=<?php echo $outros[$i]; ?>"><?php echo $outros[$i]; ?></a><br />		</p>
            <?php } ?>
 
               		 </div>
            	</div>
             </div>
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            		<label>Justificativa para reabertura</label>
            		<textarea name="justificativa" class="form-control" rows="10" placeholder="Caso seja uma alteração de dados, justifique."></textarea>
									
            	</div>
            </div>

            <div class="form-group">
	            <div class="col-md-offset-2 col-md-8">
                	<input type="hidden" name="reabrir" value="1" />
                	<input type="hidden" name="idEvento" value="<?php echo $_POST['idEvento'] ?>" />
                	<input type="hidden" name="voltar" value="<?php echo $_POST['voltar'] ?>" />
    		        <input type="submit" class="btn btn-theme btn-lg btn-block" value="Reabrir evento" onclick="this.disabled = true; this.value = 'Reabrindo…'; this.form.submit();">

            	</div>
            </div>
            </form>
             <div class="form-group">
	            <div class="col-md-offset-2 col-md-8">
	            <a href="<?php echo $voltar; ?>" class="btn btn-theme btn-lg btn-block">Voltar</a>
            	</div>
            </div>
        </div>
    </div>
</section>  

<?php } ?>
