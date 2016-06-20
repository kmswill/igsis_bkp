<?php

if(isset($_GET['p'])){
	$p = $_GET['p'];
	}else{
	$p = "inicio";

	}

?>
<?php include "../include/menuEventoInicial.php"; ?>
<?php 

switch($p){
case "inicio":
?>
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h2>Propostas SMC</h2>
                    <?php 
					$conn = bancoMysqli();
					$sql = "SELECT * FROM atualizacao WHERE id = '1'";
					$query = mysqli_query($conn,$sql);
					$atualizacao = mysqli_fetch_array($query);
					
					?>
                    <h5>Base atualizada em <?php echo exibirDataBr($atualizacao['data']); ?></h5>
                    <p><?php echo $atualizacao['texto']; ?></p>
			  </div>
<br />
<br />
	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=propostas&p=filtro" method="post">
					  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Linguagem</strong><br /><br />
					            		
            		<select class="form-control" name="linguagem" id="inputSubject" >
                    <option value="todos">Todas as linguagens</option>
					<?php 

					$sql_linguagem = "SELECT DISTINCT oito FROM propostas ORDER BY oito ASC";
					$query_linguagem = mysqli_query($conn,$sql_linguagem);
					while($linguagem = mysqli_fetch_array($query_linguagem)){
					
					?>
					<option value="<?php echo $linguagem['oito']?>" ><?php echo $linguagem['oito']?></option>
                     <?php 
					}
					 ?>   
                    </select>	
                    <br />	
					</div>
<!--
				  <div class="form-group">
                 
					<div class="col-md-offset-2 col-md-6"><strong>Valor inicial:</strong><br /><br />
					  <input type="text" class="form-control valor" id="" name="valor_inicial"  >
					</div>
					<div class="col-md-6"><strong>Valor final final:</strong><br /><br />
					  <input type="text" class="form-control valor" id="" name="valor_final" >
					</div>
				  </div>
                  <br />
				
                  <p>Se os campos estiverem vazios ou zerados, o filtro trará todos os valores.</p>
				  <br /> -->
	       <div class="form-group">
                    
           			
	            	<div class="col-md-offset-2 col-md-8"><strong>Locais de Interesse de realização da apresentação</strong><br /><br /><br />

    		            <input type="checkbox" name="biblioteca" id="especial01"/><label  style="padding:0 10px 0 5px;">Biblioteca</label>
           			    <input type="checkbox" name="centrosculturais" id="especial02" /><label  style="padding:0 10px 0 5px;">Centros Culturais</label>
            		    <input type="checkbox" name="ceus" id="especial03" /><label  style="padding:0 10px 0 5px;">CEUs e Casas de Cultura</label>
            		    <input type="checkbox" name="teatros" id="especial04" /><label  style="padding:0 10px 0 5px;">Teatros</label><br />
            		    <input type="checkbox" name="ruas" id="especial05" /><label  style="padding:0 10px 0 5px;">Ruas, praças ou outros espaços abertos</label>

                	</div>                     
                </div>
				  
				  
				<!-- Botão Gravar -->	
				  <div class="form-group">
                  <br />
                  <br />
					<div class="col-md-offset-2 col-md-8">
                     <input type="hidden" name="filtrar" value="1" />
					 <input type="image" alt="Filtrar" value="submit" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
				</form>
	
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  
      
      
<?php
break;
case "filtro":

$linguagem = $_POST['linguagem'];
if($linguagem == "todos"){
	$ling =	"";
}else{
	$ling = " AND oito LIKE '$linguagem' ";	
}
//$valor_inicial = $_POST['valor_inicial'];
//$valor_final = $_POST['valor_final'];




if(isset($_POST['biblioteca'])){
	$biblioteca = " AND onze LIKE '%Bibliotecas%'"; 	
}else{
	$biblioteca = ""; 	
}

if(isset($_POST['centrosculturais'])){
	$centrosculturais = " AND onze LIKE '%Bibliotecas%'"; 	
}else{
	$centrosculturais = ""; 	
}

if(isset($_POST['ceus'])){
	$ceus = " AND onze LIKE '%CEUs%'"; 	
}else{
	$ceus = ""; 	
}
if(isset($_POST['teatros'])){
	$teatros = " AND onze LIKE '%Teatros%'"; 	
}else{
	$teatros = ""; 	
}

if(isset($_POST['ruas'])){
	$ruas = " AND onze LIKE '%Ruas%'"; 	
}else{
	$ruas = ""; 	
}




?>      
      
      	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                <h2>Relatório de Pedidos de contratação</h2>
	                <h6>Você filtrou por: <br /></h6>
                </div>
            </div>
            
            
            
			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
							<td>Atração</td>
   							<td>Linguagem</td>
							<td>Locais</td>
							<td>Origem</td>
   							<td width="10%">Data de envio</td>

						</tr>
					</thead>
					<tbody>
<?php
	$conn = bancoMysqli();
	$sql_filtro = "SELECT * FROM propostas WHERE sete > '0' $ling $biblioteca $centrosculturais $ceus $teatros $ruas ORDER BY id DESC";
	$query_filtro = mysqli_query($conn,$sql_filtro); 
while($proposta = mysqli_fetch_array($query_filtro)){

?>
<tr>
<td><a href="?perfil=propostas&p=detalhe&id=<?php echo $proposta['id']; ?>" target="_blank" ><?php echo $proposta['dois']; ?></a></td>
<td><?php echo $proposta['oito']; ?></td>
<td><?php echo $proposta['onze']; ?></td>
<td><?php echo $proposta['seis']; ?></td>
<td><?php echo exibirDataHoraBr($proposta['um']); ?></td>

</tr>
	
<?php } ?>    
					
					</tbody>
				</table>
                        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	           <a href="?perfil=propostas&p=inicio" class="btn btn-theme btn-lg btn-block">Fazer outra pesquisa</a>
            </div>
          </div>
			</div>
		</div>
	</section>

<?php 
break;
case "detalhe":
$conn = bancoMysqli();
$id = $_GET['id'];
$sql_evento = "SELECT * FROM propostas WHERE id = '$id' LIMIT 0,1";
$query_evento = mysqli_query($conn,$sql_evento);
$evento = mysqli_fetch_array($query_evento);
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
            <h4><?php echo $evento['dois'] ?></h4>
            <div class="left">
            Sinopse<br />
            <strong><?php echo nl2br($evento['tres']); ?></strong><br /><br />
            Ficha técnica<br />
            <strong><?php echo nl2br($evento['quatro']); ?></strong><br /><br />
           Histórico da Atração Artística e/ou Companhia<br />

            <strong><?php echo nl2br($evento['cinco']); ?></strong><br /><br />
           Origem do grupo<br />

            <strong><?php echo nl2br($evento['seis']); ?></strong><br /><br />
           Orçamento<br />
            <strong><?php echo nl2br($evento['sete']); ?></strong><br /><br />

           Linguagem<br />

            <strong><?php echo nl2br($evento['oito']); ?></strong><br /><br />
           Link<br />

            <strong><?php echo nl2br($evento['nove']); ?></strong><br /><br />
           Infraestrutura<br />

            <strong><?php echo nl2br($evento['dez']); ?></strong><br /><br />
           Locais<br />

            <strong><?php echo nl2br($evento['onze']); ?></strong><br /><br />
           Contato<br />

            <strong><?php echo nl2br($evento['doze']); ?></strong><br /><br />

           O artista, grupo ou coletivo já possui algum tipo de parceria/ocupação com algum equipamento da SMC?<br />
            <strong><?php echo $evento['catorze']; ?> - <?php echo $evento['quinze']; ?></strong>
            <br />
            <br />
			</div>      
            
 <?php } ?>     
 </div></div></div>
 