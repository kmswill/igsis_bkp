<?php 

// não precisa chamar a funcao porque o index contrato já chama.
$con = bancoMysqli();
?>
	
<?php include 'includes/menu.php'; ?>	

	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Dados de contratação</h2>
                                          
<p></p>

					</div>
				  </div>
			  </div>
              	<section id="list_items" class="home-section bg-white">
		<div class="container">
<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td></td>
							<td>Proponente</td>
							<td>Telefone</td>
							<td>Programa</td>
                            							<td>Ano</td>
							<td>Cargo</td>
							<td>Status</td>
						</tr>
					</thead>
					<tbody>
					
<?php

$sql_lista_formacao = "SELECT * FROM sis_formacao WHERE publicado = '1' AND Ano <> ''";
$query_lista_formacao = mysqli_query($con,$sql_lista_formacao);
while($formacao = mysqli_fetch_array($query_lista_formacao)){
	$pessoa = recuperaDados("sis_pessoa_fisica",$formacao['IdPessoaFisica'],"Id_PessoaFisica");
	
?>
<tr>
	<td class="list_description"><?php echo $formacao['Id_Formacao'];  ?></td>
   	<td class="list_description"><a href="?perfil=formacao&p=frm_cadastra_dadoscontratacao&id=<?php echo $formacao['Id_Formacao']; ?>"><?php echo $pessoa['Nome'];  ?></a></td>
   	<td class="list_description"><?php echo $pessoa['Telefone1'];  ?></td>
  	<td class="list_description"><?php echo retornaPrograma($formacao['IdPrograma']);  ?></td>
  	<td class="list_description"><?php echo $formacao['Ano'];  ?></td>
	<td class="list_description"><?php echo retornaCargo($formacao['IdCargo']);  ?></td>
	<td class="list_description"><?php echo retornaStatus($formacao['Status']);  ?></td>    
</tr>

<?php } ?>
						
					</tbody>
				</table>

			</div>
            		</div>
                    </div>
                    
	</section>	  	  


<?php  ?>