<?php 

// não precisa chamar a funcao porque o index contrato já chama.
$con = bancoMysqli();

?>
	
<?php include 'includes/menu.php'; ?>	
	  	  
	 <!-- inicio_list -->
	<section id="list_items">
		<div class="container">
			 <div class="sub-title">DADOS DE CONTRATAÇÃO</div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Id Dados Contratação</td>
							<td>Proponente</td>
							<td>Programa</td>
							<td>Cargo</td>
						</tr>
					</thead>
					<tbody>
					<tr>
<?php

$sql_lista_formacao = "SELECT * FROM sis_formacao WHERE publicado = '1' AND IdCargo <> '0'";
$query_lista_formacao = mysqli_query($con,$sql_lista_formacao);
while($formacao = mysqli_fetch_array($query_lista_formacao)){

$pf = recuperaDados("sis_pessoa_fisica",$formacao['IdPessoaFisica'],"Id_PessoaFisica");
$programa = recuperaDados("sis_formacao_programa",$formacao['IdPrograma'],"Id_Programa");
$cargo = recuperaDados("sis_formacao_cargo",$formacao['IdCargo'],"Id_Cargo"); 
?>

	<td class="list_description"><?php echo $formacao['Id_Formacao'];  ?></td>
	<td class="list_description"><?php echo $pf['Nome'];  ?></td>
	<td class="list_description"><?php echo $programa['Programa'];  ?></td>
	<td class="list_description"><?php echo $cargo['Cargo'];  ?></td>
	
	</tr>
	
<?php } ?>
	</tr>
					
					</tbody>
				</table>
			</div>
		</div>
	</section>
<!--fim_list-->


<?php  ?>