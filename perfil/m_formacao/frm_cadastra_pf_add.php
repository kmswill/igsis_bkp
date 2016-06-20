<?php include 'includes/menu.php';?>

<?php
$con = bancoMysqli();

$ultimo = $_GET['id_pf']; //recupera o id da pessoa

	if(isset($_POST['editarFisica'])){
		$idPessoaFisica = $_POST['editarFisica'];
		$etnia = $_POST['etnia'];
		$regiao = $_POST['regiao'];
		$instrucao = $_POST['instrucao'];
		$grupo = $_POST['grupo'];
		$cv = addslashes($_POST['cv']);
		$spcultura = $_POST['spcultura'];
		$sql_atualizar_pessoa = "UPDATE `sis_pessoa_fisica_formacao` SET
		`IdEtinia` = '$etnia', 
		`IdRegiao` = '$regiao', 
		`IdGrauInstrucao` = '$instrucao', 
		`Grupo` = '$grupo', 
		`Curriculo` = '$cv', 
		`Id_Agente_Spcultura` = '$spcultura' WHERE IdPessoaFisica = '$idPessoaFisica'";
		
	
		if(mysqli_query($con,$sql_atualizar_pessoa)){
			$mensagem = "Atualizado com sucesso!";	
		}else{
			$mensagem = "Erro ao atualizar! Tente novamente.";
		}
		
	}




	$sql_verifica = "SELECT * FROM sis_pessoa_formacao WHERE Id_PessoaFormacao = '$ultimo'";
	$query_verifica = mysqli_query($con,$sql_verifica);
	$num_verifica = mysqli_num_rows($query_verifica);
	if ($num_verifica == 0){
	$sql_insert = "INSERT INTO sis_pessoa_fisica_formacao (`IdPessoaFisica`) VALUES ('$ultimo')";
	if(mysqli_query($con,$sql_insert)){
		$mensagem = "Atualizado com sucesso!";	
	}else{
		$mensagem = "Erro ao atualizar! Tente novamente.";	
		
	}
	}
	

$fisica = recuperaDados("sis_pessoa_fisica_formacao",$ultimo,"IdPessoaFisica"); //recupera tabela sis_pessoa_fisica_formacao


?>
<?php 
?>


	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>INFORMAÇÕES ADICIONAIS DE PESSOA FÍSICA</h3>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                                        </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=formacao&p=frm_cadastra_pf_add&id_pf=<?php echo $ultimo ?>" method="post">
                  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-2"><strong>Etnia:</strong><br/>
					  <select class="form-control" id="tipoDocumento" name="etnia" >
					   <?php
						geraOpcao("sis_etnia",$fisica['IdEtinia'],"");
						?>  
					  </select>
					</div>				  
					<div class="col-md-3"><strong>Região:</strong><br/>
                      <select class="form-control" id="tipoDocumento" name="regiao" >
					   <?php
						geraOpcao("sis_formacao_regiao",$fisica['IdRegiao'],"");
						?>  
					  </select>
					</div>
                    <div class=" col-md-3"><strong>Grau de Instrução:</strong><br/>
                      <select class="form-control" id="tipoDocumento" name="instrucao" >
					   <?php
						geraOpcao("sis_grau_instrucao",$fisica['IdGrauInstrucao'],"");
						?>  
					  </select>
					</div>
				  </div>

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Grupo:</strong><br/>
					  <input type="text" class="form-control" id="Grupo" name="grupo" placeholder="Grupo ou Coletivo" value="<?php echo $fisica['Grupo']; ?>">
					</div>
				  </div>
                  				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>ID SPCultura</strong><br/>
					  <input type="text" class="form-control" id="Grupo" name="spcultura" placeholder="" value="<?php echo $fisica['Id_Agente_Spcultura']; ?>">
                      <?php 
					   if($fisica['Id_Agente_Spcultura'] != 0 OR ($fisica['Id_Agente_Spcultura'] != NULL)){?>
                     <p><a href="http://spcultura.prefeitura.sp.gov.br/agente/<?php echo $fisica['Id_Agente_Spcultura']; ?>/" target="_blank">http://spcultura.prefeitura.sp.gov.br/agente/<?php echo $fisica['Id_Agente_Spcultura']; ?>/</a></p>
                      <?php } ?>	
					</div>
				  </div>
                  				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Currículo:</strong><br/>
					 <textarea name="cv" class="form-control" rows="10" placeholder=""><?php echo $fisica['Curriculo']; ?></textarea>
					</div>
				  </div>
				  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="editarFisica" value="<?php echo $fisica['IdPessoaFisica'] ?>" />
                    <input type="hidden" name="Sucesso" id="Sucesso" />
					 <input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
                  
				</form>
                <div class="form-group">
               		<div class="col-md-offset-2 col-md-6">
                    
                     <a href="?perfil=formacao&p=frm_edita_pf&id_pf=<?php echo $_GET['id_pf'] ?>"><input type="submit" value="Voltar ao CADASTRO" class="btn btn-theme btn-block"></a>
                   

					</div>
			    
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  

