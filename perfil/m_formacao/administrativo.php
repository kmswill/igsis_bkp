<?php

$con = bancoMysqli();
if(isset($_GET['pag'])){
	$p = $_GET['pag'];
}else{
	$p = 'inicial';	
}
//$nomeEvento = recuperaEvento($_SESSION['idEvento']);

?>
<?php include "includes/menu_administrativo.php"; ?>


<?php switch($p){

/* =========== INICIAL ===========*/
case 'inicial':
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<h3> Acesso Administrativo</h3>
<p>  </p>
<p>Aqui você acessa a parte administrativa do módulo Formação.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php /* =========== INICIAL ===========*/ break; ?>



<?php
/* =========== INÍCIO CADASTRA CARGO ===========*/
case 'add_cargo':

   if(isset($_POST['add_cargo'])){
		$idCargo = $_POST['add_cargo'];		   
		$cargo = $_POST['Cargo'];
		$justificativa = $_POST['justificativa'];
		$sql_atualiza_cargo = "INSERT INTO sis_formacao_cargo 
		(Cargo, justificativa) VALUES ('$cargo', '$justificativa')";
		$con = bancoMysqli();
		$query_atualiza_cargo = mysqli_query($con,$sql_atualiza_cargo);
		if($query_atualiza_cargo){
			$mensagem = "Cargo ".$cargo." cadastrado com sucesso!";
			gravarLog($sql_atualiza_cargo);
		}else{
			$mensagem = "Erro ao cadastrar.";	
		}		   
   }
?>    
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
			<div class="sub-title">
            	<h2>CADASTRO DE CARGO</h2>
                <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
			</div>
		</div>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="#" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Cargo: *</strong>
						<input type="text" class="form-control" id="Cargo" name="Cargo" placeholder="Cargo"> 
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Justificativa*:</strong><br/>
					 <textarea name="justificativa" class="form-control" rows="5"></textarea>
					</div>
				</div>
					
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="add_cargo" value="1"/>
						<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
					</div>
				</div>
			</form>
		</div>		
	</div>
</div>
</section> 

<?php 
break;
case 'list_cargo':

   if(isset($_POST['atualizar'])){
		$idCargo = $_POST['atualizar'];		   
		$cargo = $_POST['cargo'];	
		$coordenador = $_POST['coordenador'];
		$justificativa = $_POST['justificativa'];
		$sql_atualiza_cargo = "UPDATE sis_formacao_cargo SET
		Cargo = '$cargo',
		coordenador = '$coordenador',
		justificativa = '$justificativa'
		WHERE Id_Cargo = '$idCargo'";
		$con = bancoMysqli();
		$query_atualiza_cargo = mysqli_query($con,$sql_atualiza_cargo);
		if($query_atualiza_cargo){
			$mensagem = "Atualizado com sucesso!";
			gravarLog($sql_atualiza_cargo);
		}else{
			$mensagem = "Erro ao atualizar.";	
		}		   
   }
?> 

	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <br />
                <h2>CARGO</h2>
                    <p><?php if(isset($mensagem)){ echo $mensagem; } ?></p>
    				<br/>
                </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Id</td>
							<td>Cargo</td>
                            <td>Coordenador/<br>Articulador</td>
							<td>Justificativa</td>
  							<td></td>
						</tr>
					</thead>
					<tbody>
<?php
$sql = "SELECT * FROM sis_formacao_cargo" ;
$query = mysqli_query($con,$sql);
while($cargo = mysqli_fetch_array($query)){
?>

<tr>
<form action="?perfil=formacao&p=administrativo&pag=list_cargo" method="post">
<td><?php echo $cargo['Id_Cargo']; ?></td>
<td><input type="text" name="cargo" class="form-control" value="<?php echo $cargo['Cargo']; ?>"/></td>
<td> <select class="form-control" name="coordenador" id="Status">
                	<option value='0'<?php if($cargo['coordenador'] == 0){echo " selected ";} ?>>Não</option>
					<option value='1'<?php if($cargo['coordenador'] == 1){echo " selected ";} ?>>Sim</option>
					 </select></td>

					 <td><textarea name="justificativa" class="form-control" rows="2"><?php echo $cargo['justificativa']; ?></textarea></td>
					 
<td>
<input type="hidden" name="atualizar" value="<?php echo $cargo['Id_Cargo']; ?>" />
<input type ='submit' class='btn btn-theme  btn-block' value='atualizar'></td>
</form>

</tr>
	
    <?php } ?>
					
					</tbody>
				</table>

			</div>

            </div>            
		</div>
	</section>
<?php /* =========== FIM CARGO ===========*/ break; ?>




<?php 
/* =========== INÍCIO COORDENADORIA ===========*/
case 'add_coordenadoria': 

   if(isset($_POST['add_coordenadoria'])){
		$idCoordenadoria = $_POST['add_coordenadoria'];		   
		$coordenadoria = $_POST['Coordenadoria'];		   
		$sql_atualiza_coordenadoria = "INSERT INTO sis_formacao_coordenadoria 
		(Coordenadoria) VALUES ('$coordenadoria')";
		$con = bancoMysqli();
		$query_atualiza_coordenadoria = mysqli_query($con,$sql_atualiza_coordenadoria);
		if($query_atualiza_coordenadoria){
			$mensagem = "Coordenadoria ".$coordenadoria." cadastrado com sucesso!";
			gravarLog($sql_atualiza_coordenadoria);
		}else{
			$mensagem = "Erro ao cadastrar.";	
		}		   
   }
?>  

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
			<div class="sub-title">
            	<h2>CADASTRO DE COORDENADORIA</h2>
                <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
			</div>
		</div>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="#" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Coordenadoria: *</strong>
						<input type="text" class="form-control" id="Coordenadoria" name="Coordenadoria" placeholder="Coordenadoria"> 
					</div>
				</div>
					
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="add_coordenadoria" />
						<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
					</div>
				</div>
			</form>
		</div>		
	</div>
</div>
</section> 

<?php 
break;
case 'list_coordenadoria':
   
   if(isset($_POST['atualizar'])){
		$idCoordenadoria = $_POST['atualizar'];		   
		$coordenadoria = $_POST['coordenadoria'];		   
		$sql_atualiza_coordenadoria = "UPDATE sis_formacao_coordenadoria SET
		Coordenadoria = '$coordenadoria'
		WHERE idCoordenadoria = '$idCoordenadoria'";
		$con = bancoMysqli();
		$query_atualiza_coordenadoria = mysqli_query($con,$sql_atualiza_coordenadoria);
		if($query_atualiza_coordenadoria){
			$mensagem = "Atualizado com sucesso!";
			gravarLog($sql_atualiza_coordenadoria);
		}else{
			$mensagem = "Erro ao atualizar.";	
		}		   
   }
?> 
	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <br />
                <h2>COORDENADORIA</h2>
                    <p><?php if(isset($mensagem)){ echo $mensagem; } ?></p>
    				<br/>
                </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Id</td>
							<td colspan="2">Coordenadoria</td>
  							<td></td>
						</tr>
					</thead>
					<tbody>
<?php
$sql = "SELECT * FROM sis_formacao_coordenadoria" ;
$query = mysqli_query($con,$sql);
while($coordenadoria = mysqli_fetch_array($query)){
?>

<tr>
<form action="?perfil=formacao&p=administrativo&pag=list_coordenadoria" method="post">
<td><?php echo $coordenadoria['idCoordenadoria']; ?></td>
<td><input type="text" name="coordenadoria" class="form-control" value="<?php echo $coordenadoria['Coordenadoria']; ?>"/></td>
<td>
<input type="hidden" name="atualizar" value="<?php echo $coordenadoria['idCoordenadoria']; ?>" />
<input type ='submit' class='btn btn-theme  btn-block' value='atualizar'></td>
</form>

</tr>
	
    <?php } ?>
					
					</tbody>
				</table>

			</div>

            </div>            
		</div>
	</section>
<?php /* =========== FIM COORDENADORIA ===========*/ break; ?>




<?php 
/* =========== INÍCIO EQUIPAMENTO ===========*/
case 'add_equipamento':

if(isset($_POST['add_equipamento'])){
	$id_equipamento = $_POST['add_equipamento'];
	$equipamento = $_POST['Equipamento'];
	$idterritorio = $_POST['IdTerritorio'];
	$idregiao = $_POST['IdRegiao'];
	$numero = $_POST['Numero'];
	$idendereco = $_POST['IdEndereco'];
	$complemento = $_POST['Complemento'];
	$linkacessomapa = $_POST['LinkAcessoMapa'];
	$telefone1 = $_POST['Telefone1'];
	$telefone2 = $_POST['Telefone2'];
	$email = $_POST['Email'];
	$idsubprefeitura = $_POST['IdSubprefeitura'];
	$contato = $_POST['Contato'];
	$tel1responsavel = $_POST['Telefone1Responsavel'];
	$tel2responsavel = $_POST['Telefone2Responsavel'];
	$emailresponsavel = $_POST['EmailResponsavel'];
	$observacao = $_POST['Observacao'];
	$sql_novo = "INSERT INTO `sis_equipamento`(`Equipamento`, `IdTerritorio`, `IdRegiao`, `Numero`, `IdEndereco`,`Complemento`, `LinkAcessoMapa`, `Telefone1`, `Telefone2`, `Email`, `IdSubprefeitura`, `Contato`, `Telefone1Responsavel`, `Telefone2Responsavel`, `EmailResponsavel`, `Observacao`) VALUES(
	'$equipamento',
	'$idterritorio',
	'$idregiao',
	'$numero',
	'$idendereco',
	'$complemento',
	'$linkacessomapa',
	'$telefone1',
	'$telefone2',
	'$email',
	'$idsubprefeitura',
	'$contato',
	'$tel1responsavel',
	'$tel2responsavel',
	'$emailresponsavel',
	'$observacao'
	)";
	$query_novo = mysqli_query($con,$sql_novo);
	if($query_novo){
		$mensagem = "Gerado novo registro";
		gravarLog($sql_novo);
	}else{
		$mensagem = "Erro ao gerar novo registro";
	}
}

 include 'includes/menu.php';?>
<script type="application/javascript">
$(function(){
	$('#instituicao1').change(function(){
		if( $(this).val() ) {
			$('#Equipamento').hide();
			$('.carregando').show();
			$.getJSON('local.ajax.php?instituicao=',{instituicao: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value=""></option>';	
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].idEspaco + '">' + j[i].espaco + '</option>';
				}	
				$('#Equipamento').html(options).show();
				$('.carregando').hide();
			});
		} else {
			$('#Equipamento').html('<option value="">-- Escolha uma instituição --</option>');
		}
	});
});
</script>


<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
			<div class="sub-title">
            	<h2>CADASTRO DE DETALHES DO EQUIPAMENTO</h2>
                <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
			</div>
		</div>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="#" method="post">
			
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Instituição</strong>
                		<select class="form-control" name="instituicao1" id="instituicao1" >
                		<option>Selecione</option>
                		<?php geraOpcao("ig_instituicao","","") ?>
                		</select>
					</div>
					<div class="col-md-6"><strong>Equipamento*:</strong><br/>
                		<select class="form-control" name="Equipamento" id="Equipamento" ></select><br/>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-4 col-md-4"><strong>Território: *</strong><br/>
						<select class="form-control" id="IdTerritorio" name="IdTerritorio">
						<option>Selecione</option>
						<?php geraOpcao("sis_formacao_territorio","","") ?>
						</select><br/>
					</div>
					
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Região:</strong>
                    	<select class="form-control" id="IdRegiao" name="IdRegiao"> 
						<option>Selecione</option>
						<?php geraOpcao("sis_formacao_regiao","","") ?>
					 	</select>
					</div>
					<div class="col-md-6"><strong>Subprefeitura:</strong>
                    	<select class="form-control" id="IdSubprefeitura" name="IdSubprefeitura"> 
						<option>Selecione</option>
						<?php geraOpcao("sis_formacao_subprefeitura","","") ?>
					 	</select>
					</div>
				</div>
                
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #1 do Equipamento: *</strong>
                    	<input type="text" class="form-control" id="Telefone1" name="Telefone1" />
					</div>
                    <div class="col-md-6"><strong>Telefone #2 do Equipamento:</strong>
                    	<input type="text" class="form-control" id="Telefone2" name="Telefone2" />
					</div>
				</div>
                
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>E-mail do Equipamento:</strong><br/>
					  <input type="text" class="form-control" id="Email" name="Email">
					</div>
					<div class="col-md-offset col-md-6"><strong>Localização:</strong>
                    	<input type="text" class="form-control" id="LinkAcessoMapa" name="LinkAcessoMapa" />
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-offset-5 col-md-2"><strong>CEP: *</strong>
                    	<input type="text" class="form-control" id="CEP" name="IdEndereco" />
					</div>
				</div>
                
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Endereço *:</strong><br/>
					  <input type="text" class="form-control" id="Endereco" name="Endereco">
					</div>
					<div class="col-md-6"><strong>Bairro: *</strong><br/>
						<input type="text" class="form-control" id="Bairro" name="Bairro" />  
					</div>
				</div>
                
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
					  <input type="text" class="form-control" id="Numero" name="Numero" placeholder="Numero">
					</div>				  
					<div class=" col-md-6"><strong>Complemento:</strong><br/>
					  <input type="text" class="form-control" id="Complemento" name="Complemento" placeholder="Complemento">
					</div>
				</div>
                
                
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Cidade: *</strong><br/>
						<input type="text" class="form-control" id="Cidade" name="Cidade" placeholder="Cidade">
					</div>
                    <div class="col-md-6"><strong>Estado: *</strong><br/>
					  <input type="text" class="form-control" id="Estado" name="Estado" placeholder="Estado">
					</div>
                </div>
                                                
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Nome do Responsável: *</strong>
                    	<input type="text" class="form-control" id="Contato" name="Contato"/>
					</div>
					<div class="col-md-6"><strong>Email do Responsável:</strong>
                    	<input type="text" class="form-control" id="EmailResponsavel" name="EmailResponsavel" />
					</div>
				</div>
                
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #1 do Responsável: *</strong>
                    	<input type="text" class="form-control" id="Tel1Responsavel" name="Telefone1Responsavel" />
					</div>
                    <div class="col-md-6"><strong>Telefone #2 do Responsável:</strong>
                    	<input type="text" class="form-control" id="Tel2Responsavel" name="Telefone2Responsavel" />
					</div>
				</div>
				
                <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observação:</strong><br/>
					 <textarea name="Observacao" class="form-control" rows="5"></textarea>
					</div>
				</div>
					
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="submit" class="btn btn-theme btn-lg btn-block" name="add_equipamento" value="Gravar">
					</div>
				</div>
			</form>
		</div>		
	</div>
</div>
</section>

<?php
break;
case 'list_equipamento':

if(isset($_POST['atualizar'])){
	/*if(isset($_POST['equipamento1'])){
		$e1  = $_POST['equipamento1'];
		$equipamento = " `Id_Equipamento` = '$e1', ";
	}else{
		$equipamento = "";			
	}
*/
	$id_equipamento = $_POST['atualizar'];
	$equipamento = $_POST['equipamento'];
	$territorios  = $_POST['territorios'];
	$obs = addslashes($_POST['obs']);
	$territorio = $_POST['territorios'];
	$sql_atualiza_equipamento = "UPDATE sis_equipamento SET
	Equipamento '$equipamento'
	IdCargo = '$cargo', 
	Territorio = '$territorio',
	Observacao = '$obs'
	WHERE Id_Equipamento = '$id_equipamento'";
	$query_atualiza_equipamento = mysqli_query($con,$sql_atualiza_equipamento);
	

	if($query_atualiza_equipamento){
		$mensagem = "Atualizado com sucesso!";	
	}else{
		$mensagem = "Erro ao atualizar. Tente novamente.";	
		
	}
	
	;
	
}

?> 

	<section id="list_items">
		<div class="container">
			 <div class="sub-title">EQUIPAMENTO</div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Equipamento</td>
							<td>Território</td>
                            <td>Região</td>
                            <td>Telefone1 Equipamento</td>
						</tr>
					</thead>
					<tbody>
	
<?php

$consulta_tabela_equipamento = mysqli_query ($con,"SELECT `Id_Equipamento`,  `Equipamento`,`IdTerritorio`,`IdRegiao`,`Telefone1` FROM `sis_equipamento` ORDER BY Id_Equipamento");
$linha_tabela_equipamento= mysqli_fetch_assoc($consulta_tabela_equipamento);

	
	$link1= "?perfil=formacao&p=administrativo&pag=altera_equipamento&Id_equipamento=";

	do{
		$equipamento = recuperaDados("ig_local",$linha_tabela_equipamento["Equipamento"],"idLocal");
		$territorio = recuperaDados("sis_formacao_territorio",$linha_tabela_equipamento["IdTerritorio"],"Id_Territorio");
		$regiao = recuperaDados("sis_formacao_regiao",$linha_tabela_equipamento["IdRegiao"],"Id_Regiao");
		
		echo "<tr><td class='lista'> <a href='".$link1.$linha_tabela_equipamento['Id_Equipamento']."'>".$equipamento['sala']."</a></td>";
		echo '<td class="lista">'.$territorio['Territorio'].	'</td> ';
		echo '<td class="lista">'.$regiao['Regiao'].		'</td> ';
		echo '<td class="lista">'.$linha_tabela_equipamento['Telefone1'].		'</td></tr>';
	}while($linha_tabela_equipamento = mysqli_fetch_assoc($consulta_tabela_equipamento));
?>

</tbody>
				</table>
			</div>
		</div>
	</section>

<?php
break;
case 'altera_equipamento':    

$id_eq=$_GET['Id_equipamento'];
$recuperar = recuperaDados("sis_equipamento",$_GET['Id_equipamento'],"Id_Equipamento");
$a = $recuperar['Equipamento'];
/*
$innerequipamento = mysqli_query($con,"SELECT ig_local.sala, sis_equipamento.Equipamento FROM ig_local INNER JOIN sis_equipamento ON ig_local.idLocal = sis_equipamento.Equipamento WHERE sis_equipamento.Equipamento = $a");

$row = mysql_fetch_row($innerequipamento);
$base_pay = $row[0];
*/

?>

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
			<div class="sub-title">
            	<h2>ALTERAR DETALHES DO EQUIPAMENTO</h2>
                <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
			</div>
		</div>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="#" method="post">
			
				<div class="col-md-6"><strong>Equipamento*:</strong><br/>
                		 <?php echo $recuperar['Equipamento'] ?>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-4 col-md-4"><strong>Território: *</strong><br/>
						<select class="form-control" id="IdTerritorio" name="IdTerritorio">
						<option>Selecione</option>
						<?php geraOpcao("sis_formacao_territorio","","") ?>
						</select><br/>
					</div>
					
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Região:</strong>
                    	<select class="form-control" id="IdRegiao" name="IdRegiao"> 
						<option>Selecione</option>
						<?php geraOpcao("sis_formacao_regiao","","") ?>
					 	</select>
					</div>
					<div class="col-md-6"><strong>Subprefeitura:</strong>
                    	<select class="form-control" id="IdSubprefeitura" name="IdSubprefeitura"> 
						<option>Selecione</option>
						<?php geraOpcao("sis_formacao_subprefeitura","","") ?>
					 	</select>
					</div>
				</div>
                
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #1 do Equipamento: *</strong>
                    	<input type="text" class="form-control" id="Telefone1" name="Telefone1" value="<?php echo $recuperar['Telefone1'] ?>" />
					</div>
                    <div class="col-md-6"><strong>Telefone #2 do Equipamento:</strong>
                    	<input type="text" class="form-control" id="Telefone2" name="Telefone2" value="<?php echo $recuperar['Telefone2'] ?>" />
					</div>
				</div>
                
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>E-mail do Equipamento:</strong><br/>
					  <input type="text" class="form-control" id="Email" name="Email" value="<?php echo $recuperar['Email'] ?>" />
					</div>
					<div class="col-md-offset col-md-6"><strong>Localização:</strong>
                    	<input type="text" class="form-control" id="LinkAcessoMapa" name="LinkAcessoMapa" value="<?php echo $recuperar['LinkAcessoMapa'] ?>" />
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-offset-5 col-md-2"><strong>CEP: *</strong>
                    	<input type="text" class="form-control" id="CEP" name="CEP" value="<?php echo $recuperar['IdEndereco']?>" />
					</div>
				</div>
                
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Endereço *:</strong><br/>
					  <input type="text" class="form-control" id="Endereco" name="Endereco" />
					</div>
					<div class="col-md-6"><strong>Bairro: *</strong><br/>
						<input type="text" class="form-control" id="Bairro" name="Bairro"  />  
					</div>
				</div>
                
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
					  <input type="text" class="form-control" id="Numero" name="Numero" placeholder="Numero" value="<?php echo $recuperar['Numero']?>" />
					</div>				  
					<div class=" col-md-6"><strong>Complemento:</strong><br/>
					  <input type="text" class="form-control" id="Complemento" name="Complemento" value="<?php echo $recuperar['Complemento']?>">
					</div>
				</div>
                
                
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Cidade: *</strong><br/>
						<input type="text" class="form-control" id="Cidade" name="Cidade" placeholder="Cidade">
					</div>
                    <div class="col-md-6"><strong>Estado: *</strong><br/>
					  <input type="text" class="form-control" id="Estado" name="Estado" placeholder="Estado">
					</div>
                </div>
                                                
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Nome do Responsável: *</strong>
                    	<input type="text" class="form-control" id="Contato" name="Contato" value="<?php echo $recuperar['Contato']?>" />
					</div>
					<div class="col-md-6"><strong>Email do Responsável:</strong>
                    	<input type="text" class="form-control" id="EmailResponsavel" name="EmailResponsavel" value="<?php echo $recuperar['EmailResponsavel']?>" />
					</div>
				</div>
                
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #1 do Responsável: *</strong>
                    	<input type="text" class="form-control" id="Tel1Responsavel" name="Telefone1Responsavel" value="<?php echo $recuperar['Telefone1Responsavel']?>" />
					</div>
                    <div class="col-md-6"><strong>Telefone #2 do Responsável:</strong>
                    	<input type="text" class="form-control" id="Tel2Responsavel" name="Telefone2Responsavel" value="<?php echo $recuperar['Telefone2Responsavel']?>" />
					</div>
				</div>
				
                <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observação:</strong><br/>
					 <textarea name="Observacao" class="form-control" rows="5" > <?php echo $recuperar['Observacao']?>  </textarea>
					</div>
				</div>
					
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="submit" class="btn btn-theme btn-lg btn-block" name="add_equipamento" value="Gravar">
					</div>
				</div>
			</form>
		</div>		
	</div>
</div>
</section>




<?php /* =========== FIM EQUIPAMENTO ===========*/ break?>
<?php 
/* =========== INÍCIO LINGUAGEM ===========*/
case 'add_linguagem':

if(isset($_POST['add_linguagem'])){
		$idLinguagem = $_POST['add_linguagem'];		   
		$linguagem = $_POST['Linguagem'];		   
		$sql_atualiza_linguagem = "INSERT INTO sis_formacao_linguagem 
		(Linguagem) VALUES ('$linguagem')";
		$con = bancoMysqli();
		$query_atualiza_linguagem = mysqli_query($con,$sql_atualiza_linguagem);
		if($query_atualiza_linguagem){
			$mensagem = "Linguagem ".$linguagem." cadastrado com sucesso!";
			gravarLog($sql_atualiza_linguagem);
		}else{
			$mensagem = "Erro ao cadastrar.";	
		}		   
   }
?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
			<div class="sub-title">
            	<h2>CADASTRO DE LINGUAGEM</h2>
                <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
			</div>
		</div>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="#" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Linguagem: *</strong>
						<input type="text" class="form-control" id="Linguagem" name="Linguagem" placeholder="Linguagem"> 
					</div>
				</div>
					
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="add_linguagem" />
						<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
					</div>
				</div>
			</form>
		</div>		
	</div>
</div>
</section> 

<?php 
break;
case 'list_linguagem':

	if(isset($_POST['atualizar'])){
		$idLinguagem = $_POST['atualizar'];		   
		$linguagem = $_POST['linguagem'];		   
		$sql_atualiza_linguagem = "UPDATE sis_formacao_linguagem SET
		Linguagem = '$linguagem'
		WHERE Id_Linguagem = '$idLinguagem'";
		$con = bancoMysqli();
		$query_atualiza_linguagem = mysqli_query($con,$sql_atualiza_linguagem);
		if($query_atualiza_linguagem){
			$mensagem = "Atualizado com sucesso!";
			gravarLog($sql_atualiza_linguagem);
		}else{
			$mensagem = "Erro ao atualizar.";	
		}		   
   }
?> 

	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <br />
                <h2>LINGUAGEM</h2>
                    <p><?php if(isset($mensagem)){ echo $mensagem; } ?></p>
    				<br/>
                </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Id</td>
							<td colspan="2">Linguagem</td>
  							<td></td>
						</tr>
					</thead>
					<tbody>
<?php
$sql = "SELECT * FROM sis_formacao_linguagem" ;
$query = mysqli_query($con,$sql);
while($linguagem = mysqli_fetch_array($query)){
?>

<tr>
<form action="?perfil=formacao&p=administrativo&pag=list_linguagem" method="post">
<td><?php echo $linguagem['Id_Linguagem']; ?></td>
<td><input type="text" name="linguagem" class="form-control" value="<?php echo $linguagem['Linguagem']; ?>"/></td>
<td>
<input type="hidden" name="atualizar" value="<?php echo $linguagem['Id_Linguagem']; ?>" />
<input type ='submit' class='btn btn-theme  btn-block' value='atualizar'></td>
</form>

</tr>
	
    <?php } ?>
					
					</tbody>
				</table>

			</div>

            </div>            
		</div>
	</section>
<?php /* =========== FIM LINGUAGEM ===========*/ break; ?> 




<?php 
/* =========== INÍCIO PROJETO ===========*/
case 'add_projeto':

if(isset($_POST['add_projeto'])){
		$idProjeto = $_POST['add_projeto'];		   
		$projeto = $_POST['Projeto'];		   
		$sql_atualiza_projeto = "INSERT INTO sis_formacao_projeto 
		(Projeto) VALUES ('$projeto')";
		$con = bancoMysqli();
		$query_atualiza_projeto = mysqli_query($con,$sql_atualiza_projeto);
		if($query_atualiza_projeto){
			$mensagem = "Projeto ".$projeto." cadastrado com sucesso!";
			gravarLog($sql_atualiza_projeto);
		}else{
			$mensagem = "Erro ao cadastrar.";	
		}		   
   }
?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
			<div class="sub-title">
            	<h2>CADASTRO DE PROJETO</h2>
                <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
			</div>
		</div>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="#" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Projeto: *</strong>
						<input type="text" class="form-control" id="Projeto" name="Projeto" placeholder="Projeto"> 
					</div>
				</div>
					
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="add_projeto" />
						<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
					</div>
				</div>
			</form>
		</div>		
	</div>
</div>
</section> 

<?php 
break;
case 'list_projeto':

	if(isset($_POST['atualizar'])){
		$idProjeto = $_POST['atualizar'];		   
		$projeto = $_POST['projeto'];		   
		$sql_atualiza_projeto = "UPDATE sis_formacao_projeto SET
		Projeto = '$projeto'
		WHERE Id_Projeto = '$idProjeto'";
		$con = bancoMysqli();
		$query_atualiza_projeto = mysqli_query($con,$sql_atualiza_projeto);
		if($query_atualiza_projeto){
			$mensagem = "Atualizado com sucesso!";
			gravarLog($sql_atualiza_projeto);
		}else{
			$mensagem = "Erro ao atualizar.";	
		}		   
   }
?> 
	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <br />
                <h2>PROJETO</h2>
                    <p><?php if(isset($mensagem)){ echo $mensagem; } ?></p>
    				<br/>
                </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Id</td>
							<td colspan="2">Projeto</td>
  							<td></td>
						</tr>
					</thead>
					<tbody>
<?php
$sql = "SELECT * FROM sis_formacao_projeto" ;
$query = mysqli_query($con,$sql);
while($projeto = mysqli_fetch_array($query)){
?>

<tr>
<form action="?perfil=formacao&p=administrativo&pag=list_projeto" method="post">
<td><?php echo $projeto['Id_Projeto']; ?></td>
<td><input type="text" name="projeto" class="form-control" value="<?php echo $projeto['Projeto']; ?>"/></td>
<td>
<input type="hidden" name="atualizar" value="<?php echo $projeto['Id_Projeto']; ?>" />
<input type ='submit' class='btn btn-theme  btn-block' value='atualizar'></td>
</form>

</tr>
	
    <?php } ?>
					
					</tbody>
				</table>

			</div>

            </div>            
		</div>
	</section>
<?php /* =========== FIM PROJETO ===========*/ break; ?> 




<?php 
/* =========== INÍCIO SUBPREFEITURA ===========*/
case 'add_subprefeitura':

if(isset($_POST['add_subprefeitura'])){
		$idSubprefeitura = $_POST['add_subprefeitura'];		   
		$subprefeitura = $_POST['Subprefeitura'];		   
		$sql_atualiza_subprefeitura = "INSERT INTO sis_formacao_subprefeitura 
		(Subprefeitura) VALUES ('$subprefeitura')";
		$con = bancoMysqli();
		$query_atualiza_subprefeitura = mysqli_query($con,$sql_atualiza_subprefeitura);
		if($query_atualiza_subprefeitura){
			$mensagem = "Subprefeitura ".$subprefeitura." cadastrado com sucesso!";
			gravarLog($sql_atualiza_subprefeitura);
		}else{
			$mensagem = "Erro ao cadastrar.";	
		}		   
   }
?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
			<div class="sub-title">
            	<h2>CADASTRO DE SUBPREFEITURA</h2>
                <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
			</div>
		</div>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="#" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Subprefeitura: *</strong>
						<input type="text" class="form-control" id="Subprefeitura" name="Subprefeitura" placeholder="Subprefeitura"> 
					</div>
				</div>
					
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="add_subprefeitura" />
						<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
					</div>
				</div>
			</form>
		</div>		
	</div>
</div>
</section> 

<?php 
break;
case 'list_subprefeitura':

	if(isset($_POST['atualizar'])){
		$idSubprefeitura = $_POST['atualizar'];		   
		$subprefeitura = $_POST['subprefeitura'];		   
		$sql_atualiza_subprefeitura = "UPDATE sis_formacao_subprefeitura SET
		Subprefeitura = '$subprefeitura'
		WHERE Id_Subprefeitura = '$idSubprefeitura'";
		$con = bancoMysqli();
		$query_atualiza_subprefeitura = mysqli_query($con,$sql_atualiza_subprefeitura);
		if($query_atualiza_subprefeitura){
			$mensagem = "Atualizado com sucesso!";
			gravarLog($sql_atualiza_subprefeitura);
		}else{
			$mensagem = "Erro ao atualizar.";	
		}		   
   }
?> 

	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <br />
                <h2>SUBPREFEITURA</h2>
                    <p><?php if(isset($mensagem)){ echo $mensagem; } ?></p>
    				<br/>
                </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Id</td>
							<td colspan="2">Subprefeitura</td>
  							<td></td>
						</tr>
					</thead>
					<tbody>
<?php
$sql = "SELECT * FROM sis_formacao_subprefeitura" ;
$query = mysqli_query($con,$sql);
while($subprefeitura = mysqli_fetch_array($query)){
?>

<tr>
<form action="?perfil=formacao&p=administrativo&pag=list_subprefeitura" method="post">
<td><?php echo $subprefeitura['Id_Subprefeitura']; ?></td>
<td><input type="text" name="subprefeitura" class="form-control" value="<?php echo $subprefeitura['Subprefeitura']; ?>"/></td>
<td>
<input type="hidden" name="atualizar" value="<?php echo $subprefeitura['Id_Subprefeitura']; ?>" />
<input type ='submit' class='btn btn-theme  btn-block' value='atualizar'></td>
</form>

</tr>
	
    <?php } ?>
					
					</tbody>
				</table>

			</div>

            </div>            
		</div>
	</section>
<?php /* =========== FIM SUBPREFEITURA ===========*/ break; ?> 



<?php 
/* =========== INÍCIO EDITAL ===========*/
case 'add_edital':

if(isset($_POST['add_edital'])){
		$idEdital = $_POST['add_edital'];		   
		$itensEdital = $_POST['itensEdital'];
		$edital = $_POST['edital'];
		$itensCredenciamento = $_POST['itensCredenciamento'];
		$dataDO = $_POST['dataDO'];
		$meses = $_POST['meses'];
		$folhaPesquisa = $_POST['folhaPesquisa'];
		$processoPesquisa = $_POST['processoPesquisa'];
		$sql_atualiza_edital = "INSERT INTO `sis_formacao_edital`(`itensEdital`, `edital`, `itensCredenciamento`, `dataDO`, `meses`, `folhaPesquisa`, `processoPesquisa`) VALUES ($itensEdital, $edital, $itensCredenciamento, $dataDO, $meses, $folhaPesquisa, $processoPesquisa)";
		$con = bancoMysqli();
		$query_atualiza_edital = mysqli_query($con,$sql_atualiza_edital);
		if($query_atualiza_edital){
			$mensagem = "Edital ".$edital." cadastrado com sucesso!";
			gravarLog($sql_atualiza_edital);
		}else{
			$mensagem = "Erro ao cadastrar.";	
		}		   
   }
?> 

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
			<div class="sub-title">
            	<h2>CADASTRO INFORMAÇÕES DO EDITAL</h2>
                <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
			</div>
		</div>
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="#" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Edital nº: *</strong>
						<input type="text" class="form-control" id="edital" name="edital"> 
					</div>
					<div class="col-md-6"><strong>Itens do Edital: *</strong>
						<input type="text" class="form-control" id="itensEdital" name="itensEdital"> 
					</div>
				</div>
                
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Itens do Credenciamento: *</strong>
						<input type="text" class="form-control" id="itensCredenciamento" name="itensCredenciamento"> 
					</div>
					<div class="col-md-6"><strong>Data do resultado no D.O.: *</strong>
						<input type="date" class="form-control" id="dataDO" name="dataDO">
					</div>
				</div>
                
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Período (meses): *</strong>
						<input type="text" class="form-control" id="meses" name="meses"> 
					</div>
					<div class="col-md-6"><strong>Folha de Pesquisa: *</strong>
						<input type="text" class="form-control" id="folhaPesquisa" name="folhaPesquisa"> 
					</div>
				</div>
                
                 <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Proceso de pesquisa: *</strong>
						<input type="text" class="form-control" id="processoPesquisa" name="processoPesquisa"> 
					</div>
				</div>
					
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="add_edital" value="1" />
						<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
					</div>
				</div>
			</form>
		</div>		
	</div>
</div>
</section> 

<?php 
break;
case 'list_edital':
/*
   if(isset($_POST['atualizar'])){
		$idCargo = $_POST['Id_Cargo'];		   
		$cargo = $_POST['Cargo'];		   
		$sql_atualiza_cargoo = "UPDATE sis_cargo SET
		Cargo = '$cargo'
		WHERE Id_Cargo = '$idCargo'";
		$con = bancoMysqli();
		$query_atualiza_cargo = mysqli_query($con,$sql_atualiza_cargo);
		if($query_atualiza_cargo){
			$mensagem = "Atualizado com sucesso!";
		}else{
			$mensagem = "Erro ao atualizar.";	
		}		   
   }*/
?> 

	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <br />
                <h2>EDITAL</h2>
                    <p><?php if(isset($mensagem)){ echo $mensagem; } ?></p>
    				<br/>
                </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Id</td>
							<td>Edital</td>
                            <td>Data D.O.</td>
                            <td>Processo de Pesquisa</td>
  							<td></td>
						</tr>
					</thead>
					<tbody>
<?php
$sql = "SELECT * FROM sis_formacao_edital" ;
$query = mysqli_query($con,$sql);
while($edital = mysqli_fetch_array($query)){
?>

<tr>
<form action="?perfil=formacao&p=administrativo&pag=list_edital" method="post">
<td><?php echo $edital['idFormacaoEdital']; ?></td>
<td><input type="text" name="Edital" class="form-control" value="<?php echo $edital['edital']; ?>"/></td>
<td>
<input type="hidden" name="atualizar" value="<?php echo $edital['idFormacaoEdital']; ?>" />
<input type ='submit' class='btn btn-theme  btn-block' value='atualizar'></td>
</form>

</tr>
	
    <?php } ?>
					
					</tbody>
				</table>

			</div>

            </div>            
		</div>
	</section>

<?php /* =========== FIM EDITAL ===========*/ break; ?> 

<?php } //fim da switch ?>