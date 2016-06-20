<?php
require_once("../funcoes/funcoesVerifica.php");
require_once("../funcoes/funcoesSiscontrat.php");
if(isset($_GET['idEvento'])){
	$evento = verificaCampos($_GET['idEvento']);
	$ocorrencia = verificaOcorrencias($_GET['idEvento']);	
}

if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p= "inicio";	
}

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
<?php include "../include/menuServicos.php"; ?>
<?php 

switch($p){
case "inicio":
?>

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                <h1>Solicitação de serviços internos</h1>
	                <h4>Escolha uma opção</h4>
                </div>
            </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="?perfil=servicos&p=registros" class="btn btn-theme btn-lg btn-block">Registros</a>
	            <a href="?perfil=servicos&p=grafico" class="btn btn-theme btn-lg btn-block">Projeto Gráfico</a>
	            <a href="?perfil=servicos&p=digacervo" class="btn btn-theme btn-lg btn-block">Digitalização de acervo</a>
                
            </div>
          </div>
        </div>
    </div>
</section>    

<?php 
break;
case "registros":
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Registros</h2>
					<h4></h4>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                 </div>
				  </div>
			  </div>  
			
			<div class="table-responsive list_info">
                  <table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td width='10%'>ID</td>
							<td>Evento</td>
							<td>Data do envio</td>
							<td>Data e local</td>
   							<td>Registros</td>
						</tr>
					</thead>
					<tbody>
					<?php
					$idUsuario = $_SESSION['idUsuario'];
					$idInstituicao = $_SESSION['idInstituicao'];
					$con = bancoMysqli();
					$sql_busca = "SELECT * FROM ig_comunicacao, ig_producao WHERE ig_comunicacao.ig_evento_idEvento = ig_producao.ig_evento_idEvento AND (ig_producao.registroAudio = '1' OR ig_producao.registroVideo = '1' OR ig_producao.registroFotografia = '1')AND ig_comunicacao.idInstituicao = '$idInstituicao' ORDER BY ig_comunicacao.idCom DESC";
					$query_busca = mysqli_query($con,$sql_busca);
						while($chamado = mysqli_fetch_array($query_busca)){ 
						$tipo = recuperaDados("ig_tipo_evento",$chamado['ig_tipo_evento_idTipoEvento'],"idTipoEvento");
						$chamado2 = recuperaAlteracoesEvento($chamado['ig_evento_idEvento']);	 
						//var_dump($chamado); 
						
						?>
						
					<tr>
					<td><?php echo $chamado['ig_evento_idEvento']; ?></td>
					<td><a href="?perfil=busca&p=detalhe&evento=<?php echo $chamado['ig_evento_idEvento'] ?>" target="_blank" ><?php echo $tipo['tipoEvento']." - ".$chamado['nomeEvento']; ?> </a>
                     [<?php 
					if($chamado2['numero'] == '0'){
						echo "0";
					}else{
						echo "<a href='?perfil=chamado&p=evento&id=".$chamado['ig_evento_idEvento']."' target='_blank'>".$chamado2['numero']."</a>";	
					}
					
					?>]
                  
                   </td>
					<td></td>
   					<td><?php echo resumoOcorrencias($chamado['ig_evento_idEvento']); ?></td>
					<td><?php
					if($chamado['registroAudio'] == '1'){
						echo "Áudio ";	
					}
					if($chamado['registroVideo'] == '1'){
						echo "Vídeo ";	
					}
					if($chamado['registroFotografia'] == '1'){
						echo "Fotografia ";	
					}
					
					
					 ?></td>
					</tr>					
					<?php
						}
					?>
					
					
					</tbody>
					</table>
				   
			</div>
		</div>
	</section>


<?php 
break;
case "grafico":
?>



	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Projeto Gráfico</h2>
					<h4></h4>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                 </div>
				  </div>
			  </div>  
			
			<div class="table-responsive list_info">
                  <table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td width='10%'>ID</td>
							<td>Evento</td>
							<td>Data do envio</td>
							<td>Data e local</td>
   							<td>Solicitação</td>
						</tr>
					</thead>
					<tbody>
					<?php
					$idUsuario = $_SESSION['idUsuario'];
					$idInstituicao = $_SESSION['idInstituicao'];
					$con = bancoMysqli();
					$sql_busca = "SELECT * FROM ig_comunicacao, ig_artes_visuais WHERE ig_comunicacao.ig_evento_idEvento = ig_artes_visuais.idEvento AND (ig_artes_visuais.painel = '1' OR ig_artes_visuais.legendas = '1' OR ig_artes_visuais.identidade = '1' OR ig_artes_visuais.suporte = '1')AND ig_comunicacao.idInstituicao = '$idInstituicao' ORDER BY idCom DESC";
					$query_busca = mysqli_query($con,$sql_busca);
						while($chamado = mysqli_fetch_array($query_busca)){ 
						$tipo = recuperaDados("ig_tipo_evento",$chamado['ig_tipo_evento_idTipoEvento'],"idTipoEvento");
						//var_dump($chamado); 
						
						?>
						
					<tr>
					<td><?php echo $chamado['ig_evento_idEvento']; ?></td>
					<td><a href="?perfil=busca&p=detalhe&evento=<?php echo $chamado['ig_evento_idEvento'] ?>" target="_blank" ><?php echo $tipo['tipoEvento']." - ".$chamado['nomeEvento']; ?>
                  
                    </a></td>
					<td></td>
   					<td><?php echo resumoOcorrencias($chamado['ig_evento_idEvento']); ?></td>
					<td><?php
					if($chamado['painel'] == '1'){
						echo "Painel ";	
					}
					if($chamado['legendas'] == '1'){
						echo "Legendas ";	
					}
					if($chamado['identidade'] == '1'){
						echo "Identidade visual ";	
					}
					if($chamado['suporte'] == '1'){
						echo "Suporte ";	
					}
					
					
					 ?></td>
					</tr>					
					<?php
						}
					?>
					
					
					</tbody>
					</table>
				   
			</div>
		</div>
	</section>

<?php 
break;
case "digiacervo":
$chamado = recuperaDados("igsis_chamado",$_GET['id'],"idChamado");
$tipo = recuperaDados("igsis_tipo_chamado",$chamado['tipo'],"idTipoChamado");
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Digitalização de acervo</h2>
	                  <h5>Em construção<?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                 </div>
				  </div>
			  </div>  
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
       
            </div>			
					</div>
	</section>
<?php break; ?>
<?php } ?>
