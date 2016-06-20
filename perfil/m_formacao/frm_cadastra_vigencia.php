<?php
$con = bancoMysqli();

include 'includes/menu_administrativo.php';


if(isset($_GET['pag'])){
	$pag = $_GET['pag'];
}else{
	$pag = "inicial";	
}

switch($pag){

case "inicial":

if(isset($_GET['novo'])){
	$sql_insere = "INSERT INTO `sis_formacao_vigencia` (`Id_Vigencia`,`publicado`) VALUES (NULL,'1')";
	$query_insere = mysqli_query($con,$sql_insere);
	if($query_insere){
		$idVigencia = mysqli_insert_id($con);
		for($i = 1; $i <= 12; $i++){
			$sql_insere_parcelas = "INSERT INTO `sis_formacao_parcelas` (`Id_Vigencia`, `N_Parcela`) VALUES ('$idVigencia', '$i')";
			mysqli_query($con,$sql_insere_parcelas);			
		}
	}	

}	

if(isset($_POST['editar'])){
	$idVigencia = $_POST['editar'];
}
 
if(isset($_POST['cadastrar'])){
	$mensagem = "";
	$idVigencia = $_POST['cadastrar'];
	$ano = $_POST['Ano'];
	$descricao = $_POST['DescricaoVigencia'];
	$sql_atualiza_vigencia = "UPDATE `sis_formacao_vigencia` SET `descricao` = '$descricao', `ano` = '$ano' WHERE `Id_Vigencia` = '$idVigencia'";
	$query_atualiza_vigencia = mysqli_query($con,$sql_atualiza_vigencia);
	if($query_atualiza_vigencia){
		for($i = 1; $i <= 12; $i++){
		$valor = dinheiroDeBr($_POST['parcela'.$i]);
		if($_POST['dataInicial'.$i] == ""){
			$data_inicial = NULL;
		}else{
			$data_inicial = exibirDataMysql($_POST['dataInicial'.$i]);
		}
		if($_POST['dataFinal'.$i] == ""){
			$data_final = NULL;	
		}else{
			$data_final = exibirDataMysql($_POST['dataFinal'.$i]);
		}
		if($_POST['dataPagamento'.$i] == ""){
			$pagamento = NULL;
		}else{
			$pagamento = exibirDataMysql($_POST['dataPagamento'.$i]);
		}
		$horas = $_POST['cargahoraria'.$i];
		$sql_atualiza_parcela = "UPDATE `sis_formacao_parcelas` SET 
		`Valor` = '$valor', 
		`dataInicio` = '$data_inicial', 
		`dataFinal` = '$data_final', 
		`pagamento` = '$pagamento', 
		`horas` = '$horas' WHERE Id_Vigencia = '$idVigencia' AND N_Parcela = '$i'";
 		$query_atualiza_parcela = mysqli_query($con,$sql_atualiza_parcela);
			if($query_atualiza_parcela){
				$mensagem = $mensagem." Parcela $i atualizada.<br />"; 
			}else{
				$mensagem = $mensagem."Erro ao atualizar parcela $i.<br />"; 	
	
			}
		}
	}else{
		$mensagem = "Erro ao atualizar";	
	}
	 
	
	/*
	
 */
}

$vigencia = recuperaDados("sis_formacao_vigencia",$idVigencia,"Id_Vigencia"); 
 
 
 ?>


		
	  
	 <!-- Contact -->
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<div class="sub-title">
                    	<h2>CADASTRO DE VIGÊNCIA</h2>
                        <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                    </div>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=formacao&p=frm_cadastra_vigencia" method="post">
				  
				  <div class="form-group">
					<div class="col-md-offset-5	col-md-2"><strong>Ano: *</strong>
					  <input type="text" class="form-control" id="Ano" name="Ano" value="<?php echo $vigencia['ano'] ?>">
					</div>
				  </div>
				 
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Descrição da Vigência: *</strong>
					  <input type="text" class="form-control" id="" name="DescricaoVigencia" placeholder="Descrição da Vigência" value="<?php echo $vigencia['descricao']; ?>"> 
					</div>
				  </div>

				<?php 
				for($i = 1; $i <= 12; $i++){
					$sql_rec_parcela = "SELECT * FROM sis_formacao_parcelas WHERE Id_Vigencia = '$idVigencia' AND N_Parcela	= '$i'";
					$query_rec_parcela = mysqli_query($con,$sql_rec_parcela);
					$parcela = mysqli_fetch_array($query_rec_parcela);				
				?>
                  <div class="form-group">
					<div class="col-md-15 col-sm-1"><strong>Parcela</strong><br/>
					  <input type='text' disabled name="Valor" id='valor<?php echo $i ?>' class='form-control' value="<?php echo $i ?>" >
					</div>					
                    <div class=" col-sm-2"><strong>Valor</strong><br/>
					  <input type='text'  name="parcela<?php echo $i ?>" id='valor' class='form-control valor' value="<?php echo dinheiroParaBr($parcela['Valor']) ?>" >
					</div>
                    
                    <div class="col-sm-2"><strong>Data inicial:</strong><br/>
					  <input type='text' name="dataInicial<?php echo $i ?>" id='' class='form-control datepicker' value="<?php if($parcela['dataInicio'] == NULL OR $parcela['dataInicio'] == '0000-00-00' ){}else{ echo exibirDataBr($parcela['dataInicio']);}?>">
					</div>
                    <div class="col-sm-2"><strong>Data final:</strong><br/>
					  <input type='text'  name="dataFinal<?php echo $i ?>" id='' class='form-control datepicker' value="<?php if($parcela['dataFinal'] == NULL OR $parcela['dataFinal'] == '0000-00-00' ){}else{ echo exibirDataBr($parcela['dataFinal']);} ?>">
					</div>
                    <div class="col-sm-2"><strong>Pagamento:</strong><br/>
					  <input type='text'  name="dataPagamento<?php echo $i ?>" id='' class='form-control datepicker' value="<?php if($parcela['pagamento'] == NULL OR $parcela['pagamento'] == '0000-00-00' ){}else{ echo exibirDataBr($parcela['pagamento']);} ?>">
					</div>
                    <div class="col-sm-2"><strong>Carga Horária:</strong><br/>
					  <input type='text'  name="cargahoraria<?php echo $i ?>" id='duracao' class='form-control' value="<?php echo $parcela['horas'] ?>">
					</div>
				  </div>
				<?php } ?>	
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="cadastrar" value="<?php echo $vigencia['Id_Vigencia'] ?>" />
					 <input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
					</div>
				  </div>
                  
				</form>
                          <!--        
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <form class="form-horizontal" role="form" action="?perfil=formacao&p=frm_parcela" method="post">
                      <input type="hidden" name="idPedido"  />                     
					 <input type="submit" class="btn btn-theme btn-med btn-block" value="Cadastrar Parcelas">
                     </form><br/>
					</div>
				  </div>-->
	
	  			</div>
			
	  		</div>
			

	  	</div>
	  </section>  
<?php 
break;
case "lista":
?>
	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <br />
                <h2>Lista de Vigências</h2>
                    <p><?php if(isset($mensagem)){ echo $mensagem; } ?></p>
    				<br/>
                </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Id</td>
							<td colspan="2">Vigência</td>
  							<td></td>
						</tr>
					</thead>
					<tbody>
<?php
$sql = "SELECT * FROM sis_formacao_vigencia WHERE publicado = '1' AND descricao <> ''" ;
$query = mysqli_query($con,$sql);
while($vigencia = mysqli_fetch_array($query)){
?>

<tr>
<form action="?perfil=formacao&p=frm_cadastra_vigencia" method="post">
<td><?php echo $vigencia['Id_Vigencia']; ?></td>
<td><?php echo $vigencia['descricao']; ?></td>
<td>
<input type="hidden" name="editar" value="<?php echo  $vigencia['Id_Vigencia']; ?>" />
<input type ='submit' class='btn btn-theme  btn-block' value='editar'></td>
</form>

</tr>
	
    <?php } ?>
					
					</tbody>
				</table>

			</div>

            </div>            
		</div>
	</section>
<?php break; ?>
<?php } ?>