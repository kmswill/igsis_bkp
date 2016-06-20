<?php
$con = bancoMysqli();

$id_pf = $_GET['id_pf'];

if(isset($_POST['novo'])){
	$sql_novo = "INSERT INTO `sis_formacao` (`IdPessoaFisica`, `publicado` ) VALUES ('$id_pf','0')";
	$query_novo = mysqli_query($con,$sql_novo);
	if($query_novo){
		$ultimo = mysqli_insert_id($con);
		$mensagem = "Gerado novo registro"; 
	}else{
		$mensagem = "Erro ao gerar novo registro";
	}
}

if(isset($_GET['id'])){
	$id = $_GET['id'];
}else{
	$id = $ultimo;	
}	

if(isset($_POST['atualizar'])){
	if(isset($_POST['equipamento1'])){
		$e1  = $_POST['equipamento1'];
		$equipamento1 = " `IdEquipamento01` = '$e1', ";
	}else{
		$equipamento1 = "";			
	}

	if(isset($_POST['equipamento2'])){
	$e2  = $_POST['equipamento2'];
	$equipamento2 = " `IdEquipamento02` = '$e2', ";
	}else{
		$equipamento2 = "";			
	}

	if(isset($_POST['equipamento3'])){
	$e3  = $_POST['equipamento3'];
	$equipamento3 = " `IdEquipamento03` = '$e3', ";
	}else{
		$equipamento3 = "";			
	}

	

	
	$id = $_POST['atualizar'];
	$ano = $_POST['ano'];
	$status  = $_POST['status'];
	$chamados  = $_POST['chamados'];
	$territorios  = $_POST['territorios'];
	$coordenadoria  = $_POST['coordenadoria'];
	$subprefeitura  = $_POST['subprefeitura'];
	$programa  = $_POST['programa'];
	$linguagem  = $_POST['linguagem'];
	$projeto  = $_POST['projeto'];
	$cargo  = $_POST['cargo'];
	$obs = addslashes($_POST['obs']);
	$chamado = $_POST['chamados'];
	$classificacao = $_POST['classificacao'];
	$status = $_POST['status'];
	$verba = $_POST['verba'];
	$territorio = $_POST['territorios'];
	$vigencia = $_POST['vigencia'];
	$sql_atualiza_formacao = "UPDATE sis_formacao SET
	`Ano` = '$ano',
	$equipamento1  
	$equipamento2  
	$equipamento3  
	`IdCargo` = '$cargo', 
	`Chamados` = '$chamados', 
	`Coordenarias` = '$coordenadoria', 
	`IdPrograma` = '$programa', 
	`IdLinguagem` = '$linguagem', 
	`IdProjeto` = '$projeto', 
	`Status` = '$status', 
	`Pontuacao` = '$classificacao', 
	`Territorio` = '$territorio', 
	`publicado` = '1',
	`Verba` = '$verba',
	`subprefeitura` = '$subprefeitura',
	`IdVigencia` = '$vigencia',

	`Observacao` = '$obs'
	WHERE Id_Formacao = '$id'";
	$query_atualiza_formacao = mysqli_query($con,$sql_atualiza_formacao);
	

	if($query_atualiza_formacao){
		$mensagem = "Atualizado com sucesso!";	
	}else{
		$mensagem = "Erro ao atualizar. Tente novamente.";	
		
	}
	
	;
	
}

$formacao = recuperaDados("sis_formacao",$id,"Id_Formacao");
$pessoa = recuperaDados("sis_pessoa_fisica",$formacao['IdPessoaFisica'],"Id_PessoaFisica");


 include 'includes/menu.php';?>
<script type="application/javascript">
$(function(){
	$('#instituicao1').change(function(){
		if( $(this).val() ) {
			$('#local1').hide();
			$('.carregando').show();
			$.getJSON('local.ajax.php?instituicao=',{instituicao: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value=""></option>';	
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].idEspaco + '">' + j[i].espaco + '</option>';
				}	
				$('#local1').html(options).show();
				$('.carregando').hide();
			});
		} else {
			$('#local1').html('<option value="">-- Escolha uma instituição --</option>');
		}
	});
});
</script>
<script type="application/javascript">
$(function(){
	$('#instituicao2').change(function(){
		if( $(this).val() ) {
			$('#local2').hide();
			$('.carregando').show();
			$.getJSON('local.ajax.php?instituicao=',{instituicao: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value=""></option>';	
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].idEspaco + '">' + j[i].espaco + '</option>';
				}	
				$('#local2').html(options).show();
				$('.carregando').hide();
			});
		} else {
			$('#local2').html('<option value="">-- Escolha uma instituição --</option>');
		}
	});
});
</script>
	<script type="application/javascript">
$(function(){
	$('#instituicao3').change(function(){
		if( $(this).val() ) {
			$('#local3').hide();
			$('.carregando').show();
			$.getJSON('local.ajax.php?instituicao=',{instituicao: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value=""></option>';	
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].idEspaco + '">' + j[i].espaco + '</option>';
				}	
				$('#local3').html(options).show();
				$('.carregando').hide();
			});
		} else {
			$('#local3').html('<option value="">-- Escolha uma instituição --</option>');
		}
	});
});
</script>
		
	  
	 <!-- Contact -->
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<div class="sub-title">
                    	<h2>DADOS PARA CONTRATAÇÃO</h2>
                        <h5><?php if(isset($mensagem)){echo $mensagem;}?></h5>
                    </div>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

			
				  
				  		 
                  <div class="form-group"> 
					<div class="col-md-offset-2 col-md-8"><strong>Proponente:</strong><br/>
					  <input type='text'  readonly class='form-control' name='nome' id='nome' value="<?php echo $pessoa['Nome']; ?>">                    	
                    </div>
                  </div>  
                  	<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <form class="form-horizontal" role="form" action="?perfil=formacao&p=frm_cadastra_proponente&id=<?php echo $id; ?>" method="post">
                                       
					 <input type="submit" class="btn btn-theme btn-med btn-block" value="Abrir proponente">
                     </form>
					</div>
				  </div>
				<form class="form-horizontal" role="form" action="" method="post">	  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Ano:</strong>
					  <select class="form-control" name="ano" id="Status">
                	<option value='2016'<?php if($formacao['Ano'] == 2016){echo " selected ";} ?>>2016</option>
					<option value='2017'<?php if($formacao['Ano'] == 2017){echo " selected ";} ?>>2017</option>
					 </select><br/>
					</div>
					<div class="col-md-6"><strong>Status:</strong><br/>
					   <select class="form-control" name="status" id="Status">
							<option value='1'<?php if($formacao['Status'] == 1){echo " selected ";} ?>>Ativo</option>
							<option value='0'<?php if($formacao['Status'] == 0){echo " selected ";} ?>>Inativo</option>
						</select><br/>
					</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Chamados:</strong>
					   <input type='text' name="chamados" class='form-control' value="<?php echo $formacao['Chamados'] ?>">
					</div>
					<div class="col-md-6"><strong>Classificação:</strong><br/>
					   <input type='text' name="classificacao" class='form-control' value="<?php echo $formacao['Pontuacao'] ?>"><br/>
					</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Territórios:</strong>
					   <select class="form-control" name="territorios" id="Verba">
                       <?php geraOpcao("sis_formacao_territorio",$formacao['Territorio'],"") ?>
                      </select>
					</div>
					<div class="col-md-6"><strong>Coordenadoria:</strong><br/>
					   <select class="form-control" name="coordenadoria" id="Verba">
                       <?php geraOpcao("sis_formacao_coordenadoria",$formacao['Coordenarias'],"") ?>
                      </select><br/>
					</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Subprefeitura:</strong>
					   <select class="form-control" name="subprefeitura" id="Verba">
                        <?php geraOpcao("sis_formacao_subprefeitura",$formacao['subprefeitura'],"") ?>
                      </select>
					</div>
					<div class="col-md-6"><strong>Programa *:</strong><br/>
					   <select class="form-control" name="programa" id="Verba">
                       <?php geraOpcao("sis_formacao_programa",$formacao['IdPrograma'],"") ?>
                      </select><br/>
					</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Linguagem *:</strong>
					   <select class="form-control" name="linguagem" id="Verba">
                       <?php geraOpcao("sis_formacao_linguagem",$formacao['IdLinguagem'],"") ?>
                      </select>
					</div>
					<div class="col-md-6"><strong>Projeto *:</strong><br/>
					   <select class="form-control" name="projeto" id="Verba">
                       <?php geraOpcao("sis_formacao_projeto",$formacao['IdProjeto'],"") ?>
                      </select><br/>
					</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Cargo *:</strong>
					   <select class="form-control" name="cargo" id="Verba">
                       <?php geraOpcao("sis_formacao_cargo",$formacao['IdCargo'],"") ?>
                      </select>
					</div>
                    </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Instituição</strong>
                		<select class="form-control" name="instituicao1" id="instituicao1" >
                		<option>Selecione</option>
                		<?php geraOpcao("ig_instituicao","","") ?>
                		</select>
					</div>
					<div class="col-md-6"><strong>Equipamento #1 *:</strong><br/>
                		<select class="form-control" name="equipamento1" id="local1" ></select><br/>
					</div>
				  </div>

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Instituição</strong>
                		<select class="form-control" name="instituicao2" id="instituicao2" >
                		<option>Selecione</option>
                		<?php geraOpcao("ig_instituicao","","") ?>
                		</select>
					</div>
					<div class="col-md-6"><strong>Equipamento #2 *:</strong><br/>
               		 		<select class="form-control" name="equipamento2" id="local2" ></select><br/>
					</div>
				  </div>
                  
                  <div class="form-group">
                  
					<div class="col-md-offset-2 col-md-6"><strong>Instituição</strong>
                		<select class="form-control" name="instituicao3" id="instituicao3" >
                		<option>Selecione</option>
                		<?php geraOpcao("ig_instituicao","","") ?>
                		</select>
					</div>
					<div class="col-md-6"><strong>Equipamento #3:</strong><br/>
                		<select class="form-control" name="equipamento3" id="local3" ></select><br/>
					</div>
				  </div>
                  
                  	</div>
					<div class="form-group">
                   <div class="col-md-offset-2 col-md-8"><h5>Equipamentos selecionados:</h5><br/>
 					<p>Equipamento #1: <strong><?php echo retornaLocal($formacao['IdEquipamento01']) ?></strong><p>
 					<p>Equipamento #2: <strong><?php echo retornaLocal($formacao['IdEquipamento02']) ?></strong><p>
 					<p>Equipamento #3: <strong><?php echo retornaLocal($formacao['IdEquipamento03']) ?></strong><p>
                    <br />
                    <br  />

 					</div>
				  </div>
                  
                 <div class="form-group"> 
					<div class="col-md-offset-2 col-md-8"><strong>Vigência:</strong><br/>
					 <select class="form-control" name="vigencia" id="local3" >
                     <?php  
					 $sql_vigencia = "SELECT * FROM sis_formacao_vigencia WHERE publicado = '1'";
					 $query_vigencia = mysqli_query($con,$sql_vigencia);
					 while($vigencia = mysqli_fetch_array($query_vigencia)){
					 	if($vigencia['Id_Vigencia'] == $formacao['IdVigencia']){
					 ?>
                     	<option value="<?php echo $vigencia['Id_Vigencia']; ?>" selected><?php echo $vigencia['descricao'] ?></option>
                     <?php }else{?>
                     	<option value="<?php echo $vigencia['Id_Vigencia']; ?>" ><?php echo $vigencia['descricao'] ?></option>
                     
                     <?php 
					 	}
					 } ?>
>
                     </select><br/>
                    </div>
                  </div>  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Origem da Verba *:</strong>
					   <select class="form-control" name="verba" id="Verba">
                       <option value="1" <?php if($formacao['Verba'] == 1){ echo "selected";} ?>>Secretaria Municipal de Cultura (SMC)</option>
                       <option value="2" <?php if($formacao['Verba'] == 2){ echo "selected";} ?>>Secretaria Municipal de Educação (SME)</option>
                      </select>
                      <br />
					</div>
                    </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observação:</strong><br/>
					    <textarea name="obs" class="form-control" cols="40" rows="5"><?php echo $formacao['Observacao']; ?></textarea>
					</div>
				  </div>
				
                <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/></div>
                </div>
                
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="atualizar" value="<?php echo $id ?>" />
					 <input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
					</div>
				  </div>
				</form>
                                <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/></div>
                </div>
                <?php 
				if($formacao['idPedidoContratacao'] == NULL){
				?>
	            <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <form class="form-horizontal" role="form" action="?perfil=formacao&p=frm_cadastra_pedidocontratacao_pf" method="post">
                      <input type="hidden" name="action" value="novo"  />
                      <input type="hidden" name="idFormacao" value="<?php echo $formacao['Id_Formacao']; ?>"  />
					 <input type="submit" class="btn btn-theme btn-med btn-block" value="Criar pedido de contratação">
                     </form>
					</div>
				  </div>
				<?php } ?>
	  			</div>
			
	  		</div>
			

	  	</div>
	  </section>  
