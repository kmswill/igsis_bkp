<?php
//include para comunicação
require "../funcoes/funcoesComunicacao.php";
require "../funcoes/funcoesBilhetagem.php";
require "../funcoes/funcoesProducao.php";

 ?>
<?php

// verifica se o usuário tem acesso a página


	if(isset($_GET['p'])){
		$p = $_GET['p'];	
	}else{
		$p = "inicial";
	}
	$idInstituicao = $_SESSION['idInstituicao'];
?>
<?php include "../include/menuBilhetagem.php"; ?>
<?php
	switch($p){
	
	case "inicial":

	if(isset($_GET['order'])){
		$order = $_GET['order'];
	}else{
		$order = "";
	}
	
	if(isset($_GET['sentido'])){
		$sentido = $_GET['sentido'];
		if($sentido == "ASC"){
			$invertido = "DESC";
		}else{
			$invertido = "ASC";
		}
	}
	
	
	
	?>


	
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                <h3>Bilhetagem</h3>
	                <h4>Escolha uma opção</h4>
                </div>
            </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="?perfil=bilhetagem&p=all" class="btn btn-theme btn-lg btn-block">Todos os eventos</a>

            </div>
          </div>
        </div>
    </div>
</section>  

	<?php
	
	
	break;
	case "all":
	$con = bancoMysqli();
	
	if(isset($_GET['order'])){
	$ordem = $_GET['order'];
}else{
	$ordem = "idEvento";
}
	
	if(isset($_POST['aprova'])){
	$idEvento = $_POST['idEvento'];
	if($_POST['aprova'] == 1){
	$status = 0;	
	}else{
	$status = 1;
	}
	$idUsuario = $_SESSION['idUsuario'];
	$idInstituicao = $_SESSION['idInstituicao'];
	$sql = "SELECT * FROM igsis_verifica_producao WHERE idEvento = '$idEvento' AND idUsuario = '$idUsuario'";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0){
		$sql_aprova = "UPDATE igsis_verifica_producao SET status = '$status' WHERE idEvento = '$idEvento' AND idUsuario = '$idUsuario'" ;
	}else{
		$sql_aprova = "INSERT INTO igsis_verifica_producao (idEvento, idUsuario, idInstituicao, status) VALUES ('$idEvento', '$idUsuario', '$idInstituicao', '$status')";
	}

	$query_aprova = mysqli_query($con,$sql_aprova);
	if($query_aprova){
		if($status == 0){
			$mensagem = "Evento $idEvento com atribuição NOVO/NÃO VERIFICADO";	
		}else{
			$mensagem = "Evento $idEvento VERIFICADO";
		}	
	}
}
		?>


	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Bilhetagem</h2>
					<h4></h4>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                 </div>
				  </div>
			  </div>  
			
			<div class="table-responsive list_info">
                  <table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td width="30%">Nome do Evento</td>
							<td width="20%">Tipo</td>
							<td width="20%">Local</td>
							<td width="20%">Data/Periodo</td>
   							<td>Status</td>
						</tr>
					</thead>
					<tbody>
<?php

$ocorrencia = listaOcorrenciasInstituicao($_SESSION['idInstituicao'],$ordem);


$data=date('Y');
if($ocorrencia['num'] > 0){
for($i = 0; $i < $ocorrencia['num']; $i++)
{
	$evento = recuperaDados("ig_evento",$ocorrencia[$i]['idEvento'],"idEvento");	
	$chamado = recuperaAlteracoesEvento($ocorrencia[$i]['idEvento']);
	$status = verificaStatus($ocorrencia[$i]['idEvento'],$_SESSION['idUsuario']); 
	echo "<tr><td class='lista'> <a href='?perfil=bilhetagem&p=detalhe&evento=".$ocorrencia[$i]['idEvento']."' target='_blank' >".$evento['nomeEvento']."</a>"; ?>
	 [<?php 
					if($chamado['numero'] == '0'){
						echo "0";
					}else{
						echo "<a href='?perfil=chamado&p=evento&id=".$ocorrencia[$i]['idEvento']."' target='_blank'>".$chamado['numero']."</a>";	
					}
					
					?>]
    <?php echo "          
	</td>";
	echo '<td class="list_description">'.retornaTipo($evento['ig_tipo_evento_idTipoEvento']).'</td> ';
	echo '<td class="list_description">'.substr(listaLocais($ocorrencia[$i]['idEvento']),1).'</td> ';
	echo '<td class="list_description">'.retornaPeriodo($ocorrencia[$i]['idEvento']).'</td> ';


	echo '<td class="list_description">'; 
    echo "<form method='POST' action='?perfil=bilhetagem&p=all'>
<input type='hidden' name='aprova' value='".$status."' >
<input type='hidden' name='idEvento' value='".$evento['idEvento']."' >
<input type ='submit' class='btn btn-theme  btn-block' value='";
	if($status == 1){echo "OK'";}else{ echo "NOVO' style='background: red;'";}  
		echo "></form>	</td> </tr>";
	}
}
?>
					
					
					</tbody>
					</table>
				   
			</div>
		</div>
	</section>
	
    <?php 
	break;
	case "detalhe":
	$evento = recuperaDados("ig_comunicacao",$_GET['evento'],"ig_evento_idEvento");
	?>

	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					                     

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
			<div class="table-responsive list_info" >
            <h4><?php echo $evento['nomeEvento'] ?></h4>
            <p align="left">
              <?php descricaoEvento($_GET['evento']); ?>
                  </p>      
            <h5>Ocorrências</h5>
            <?php echo resumoOcorrencias($_GET['evento']); ?><br /><br />
            <?php listaOcorrenciasTexto($_GET['evento']); ?>
			
			<div class="left">
            <?php descricaoEspecificidades($_GET['evento'],$evento['ig_tipo_evento_idTipoEvento']); ?>
			</div>
<div class="left">
			<h5>Previsão de serviços externos</h5>
            <?php listaServicosExternos($_GET['evento']); ?><br /><br />
            			<h5>Serviços Internos</h5>
			<?php listaServicosInternos($_GET['evento']) ?>
</div>
<div class="left">
			<h5>Anexos</h5>
<?php listaArquivosDetalhe($_GET['evento']) ?>
</div>

</div>
</div>
            </div>
</section>
<?php 
if($evento['ig_tipo_evento_idTipoEvento'] == '1'){
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Grade de filmes</h2>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                 </div>
				  </div>
			  </div>  
			
			<div class="table-responsive list_info">
                         <?php gradeFilmes($_GET['evento']); ?>
			</div>
		</div>
	</section>
<?php	
}

?>    
    
	<?php
	break;

	}


 ?>