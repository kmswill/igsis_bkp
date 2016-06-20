    <?php include 'includes/menu.php';?>
<?php
$con = bancoMysqli(); 
if(isset($_POST['pesquisar'])){ // inicia a busca por Razao Social ou CNPJ
	$busca = $_POST['busca'];
	$sql_busca = "SELECT * FROM sis_pessoa_fisica WHERE CPF = '$busca' ORDER BY Nome";
	$query_busca = mysqli_query($con,$sql_busca); 
	$num_busca = mysqli_num_rows($query_busca);
	if($num_busca > 0){ // Se exisitr, lista a resposta.
	?>

	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Contratados - Pessoa Física</h2>
                                          
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
							<td>Nome</td>
							<td>CPF</td>
							<td>Cadastro formação</td>
                            <td width="15%"></td>
						</tr>
					</thead>
					<tbody>
                    <?php
				while($descricao = mysqli_fetch_array($query_busca)){
				$formacao = recuperaDados("sis_pessoa_fisica_formacao",$descricao['Id_PessoaFisica'],"IdPessoaFisica");

				if(!isset($formacao['IdPessoaFisica'])){ $for = "Não há"; }else{ $for = "Cadastrado"; }				

			echo "<tr>";
			echo "<td class='list_description'><b>".$descricao['Nome']."</b></td>";
			echo "<td class='list_description'>".$descricao['CPF']."</td>";
			echo "<td class='list_description'>".$for."</td>";
			
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=formacao&p=frm_edita_pf&id_pf=".$descricao['Id_PessoaFisica']."'>
			<input type='hidden' name='detalhe' value='".$descricao['Id_PessoaFisica']."'>
			<input type ='submit' class='btn btn-theme btn-md btn-block' value='Editar'></td></form>"	;
			echo "</tr>";
				}
?>
						
					</tbody>
				</table>
			</div>
            		</div>
                    </div>
                    
	</section>
	
    <?php }else{ // Se não existe, exibe um formulario para insercao. ?>
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>CADASTRO DE PESSOA FÍSICA</h3>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                                            <p> O CPF <?php //echo $busca; ?> não está cadastrado no nosso sistema. <br />Por favor, insira as informações da Pessoa Física a ser contratada. </p>
                    <p><a href="?perfil=formacao&p=cadastra_pf">Pesquisar outro CPF</a> </p>  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=formacao&p=frm_edita_pf" method="post">
				  
			 
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="Nome" placeholder="Nome" >
					</div>
				  </div>

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome Artístico:</strong><br/>
					  <input type="text" class="form-control" id="NomeArtistico" name="NomeArtistico" placeholder="Nome Artístico">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Tipo de documento *:</strong><br/>
					  <select class="form-control" id="tipoDocumento" name="tipoDocumento" >
					   <?php
						geraOpcao("igsis_tipo_documento",$fisica['tipoDocumento'],"");
						?>  
					  </select>

					</div>				  
					<div class=" col-md-6"><strong>Documento *:</strong><br/>
                      <input type="text" class="form-control" id="RG" name="RG" placeholder="Documento">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>CPF *:</strong><br/>
					  <input type="text" readonly class="form-control" id="cpf" name="CPF" value="<?php echo $busca; ?>">
					</div>				  
					<div class=" col-md-6"><strong>CCM *:</strong><br/>
					  <input type="text" class="form-control" id="CCM" name="CCM" placeholder="CCM">
					</div>
				  </div>

				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Estado civil:</strong><br/>
					  <select class="form-control" id="IdEstadoCivil" name="IdEstadoCivil" >
					   <?php
						geraOpcao("sis_estado_civil","","");
						?>  
					  </select>
					</div>				  
					<div class=" col-md-6"><strong>Data de nascimento:</strong><br/>
 <input type="text" class="form-control" id="datepicker01" name="DataNascimento" placeholder="Data de Nascimento">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Nacionalidade:</strong><br/>
					   <input type="text" class="form-control" id="Nacionalidade" name="Nacionalidade" placeholder="Nacionalidade">
					</div>				  
					<div class=" col-md-6"><strong>CEP *:</strong><br/>
					 					  <input type="text" class="form-control" id="CEP" name="CEP" placeholder="CEP">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Endereço:</strong><br/>
					  <input type="text" class="form-control" id="Endereco" name="Endereco" placeholder="Endereço">
					</div>
				  </div>
                  				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
					  <input type="text" class="form-control" id="Numero" name="Numero" placeholder="Numero">
					</div>				  
					<div class=" col-md-6"><strong>Bairro:</strong><br/>
					  <input type="text" class="form-control" id="Bairro" name="Bairro" placeholder="Bairro">
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Complemento:</strong><br/>
					    <input type="text" class="form-control" id="Complemento" name="Complemento" placeholder="Complemento">
					</div>
					<div class="col-md-6"><strong>Cidade:</strong><br/>
						<input type="text" class="form-control" id="Cidade" name="Cidade" placeholder="Cidade">
					</div>
                  </div>
                    				  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Estado:</strong><br/>
					  <input type="text" class="form-control" id="Estado" name="Estado" placeholder="Estado">
					</div>
                  	<div class="col-md-6"><strong>E-mail:</strong><br/>
						<input type="text" class="form-control" id="Email" name="Email" placeholder="E-mail">
					</div>
                </div>	  


				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #1 *:</strong><br/>
					  <input type="text" class="form-control" id="Telefone1" name="Telefone1" placeholder="Telefone">
					</div>
					<div class="col-md-6"><strong>Telefone #2:</strong><br/>
					  <input type="text" class="form-control" id="Telefone1" name="Telefone2" placeholder="Telefone">
					</div>
                 </div>
                 				  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
					  <input type="text" class="form-control" id="Telefone2" name="Telefone3" placeholder="Telefone">
					</div>
					<div class="col-md-6"><strong>DRT:</strong><br/>
					  <input type="text" class="form-control" id="DRT" name="DRT" placeholder="DRT">
					</div>
                 </div>
                 
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>C.B.O.:</strong><br/>
					  <input type="text" class="form-control" id="cbo" name="cbo" placeholder="C.B.O.">
					</div> 				  
					<div class=" col-md-6"><strong>Função:</strong><br/>
					  <input type="text" class="form-control" id="Funcao" name="Funcao" placeholder="Função">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Inscrição do INSS ou PIS/PASEP:</strong><br/>
					  <input type="text" class="form-control" id="InscricaoINSS" name="InscricaoINSS" placeholder="Inscrição no INSS ou PIS/PASEP">
					</div>				  
					<div class=" col-md-6"><strong>OMB:</strong><br/>
					  <input type="text" class="form-control" id="OMB" name="OMB" placeholder="OMB">
					</div>
				  </div>
				 
                 <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Banco:</strong><br/>
					 <select class="form-control" name="codBanco" id="codBanco">
 					<option></option>
                     <option value='32'>Banco do Brasil S.A.</option>
					<?php					
					geraOpcao("igsis_bancos",$fisica['codBanco'],"");					
					 ?>
                     </select>
					</div>
				  </div> 
                  
                <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Agência</strong><br/>
					  <input type="text" class="form-control" id="agencia" name="agencia" placeholder="">
					</div>				  
					<div class=" col-md-6"><strong>Conta:</strong><br/>
					  <input type="text" class="form-control" id="conta" name="conta" placeholder="">
					</div>
				  </div> 
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observação:</strong><br/>
					 <textarea name="Observacao" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="insereFisica" value="<?php //echo $fisica['Id_PessoaFisica'] ?>" />
                    <?php // if(isset($id_pedido)){ ?>
                   <input type="hidden" name="idPedido" value="<?php //echo $id_pedido ?>" />
                   <?php // } ?>
                    <input type="hidden" name="Sucesso" id="Sucesso" />
					 <input type="submit" value="Inserir Pesssoa Física" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
				</form>
    
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  

  

<?php	} 
	

}else{ // Se não existe pedido de busca, exibe campo de pesquisa.
?>    
	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Cadastro de Pessoa Física - Formação</h2>

<p></p>

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            
                        <form method="POST" action="?perfil=formacao&p=frm_cadastra_pf" class="form-horizontal" role="form">
            		<label>Insira o CPF</label>
            		<input type="text" name="busca" class="form-control" id="cpf" >
            	</div>
             </div>
				<br />             
	            <div class="form-group">
		            <div class="col-md-offset-2 col-md-8">
                	<input type="hidden" name="pesquisar" value="1" />
    		        <input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
                    </form>
        	    	</div>
        	    </div>

            </div>
	</section>
<?php } ?>



<?php

if(isset($_POST['cadastrarFisica'])){ //cadastra e insere pessoa física
	$cpf = $_POST['CPF'];
	$verificaCPF = verificaExiste("sis_pessoa_fisica","CPF",$cpf,"");
	if($verificaCPF['numero'] > 0){ //verifica se o cpf já existe
		$mensagem = "O CPF já consta no sistema. Faça uma busca e insira diretamente";
	}else{ // o CPF não existe, inserir.
		$Nome = $_POST['Nome'];
		$NomeArtistico = $_POST['NomeArtistico'];
		$RG = $_POST['RG'];
		$CPF = $_POST['CPF'];
		$CCM = $_POST['CCM'];
		$IdEstadoCivil = $_POST['IdEstadoCivil'];
		$DataNascimento = exibirDataMysql($_POST['DataNascimento']);
		$Nacionalidade = $_POST['Nacionalidade'];
		$CEP = $_POST['CEP'];
		$Endereco = $_POST['Endereco'];
		$Numero = $_POST['Numero'];
		$Complemento = $_POST['Complemento'];
		$Bairro = $_POST['Bairro'];
		$Cidade = $_POST['Cidade'];
		$Telefone1 = $_POST['Telefone1'];
		$Telefone2 = $_POST['Telefone2'];
		$Telefone3 = $_POST['Telefone3'];
		$Email = $_POST['Email'];
		$DRT = $_POST['DRT'];
		$Funcao = $_POST['Funcao'];
		$InscricaoINSS = $_POST['InscricaoINSS'];
		$OMB = $_POST['OMB'];
		$Observacao = $_POST['Observacao'];
		$Pis = 0;
		$data = date('Y-m-d');
		$idUsuario = $_SESSION['idUsuario'];
		$sql_insert_pf = "INSERT INTO `sis_pessoa_fisica` (`Id_PessoaFisica`, `Foto`, `Nome`, `NomeArtistico`, `RG`, `CPF`, `CCM`, `IdEstadoCivil`, `DataNascimento`, `LocalNascimento`, `Nacionalidade`, `CEP`, `Numero`, `Complemento`, `Telefone1`, `Telefone2`, `Telefone3`, `Email`, `DRT`, `Funcao`, `InscricaoINSS`, `Pis`, `OMB`, `DataAtualizacao`, `Observacao`, `IdUsuario`) VALUES (NULL, NULL, '$Nome', '$nomeArtistico', '$RG', '$CPF', '$CCM', '$IdEstadoCivil', '$DataNascimento', NULL, '$Nacionalidade', '$CEP', '$Numero', '$Complemento', '$Telefone1', '$Telefone2', '$Telefone3', '$Email', '$DRT', '$Funcao', '$InscricaoINSS', '$Pis', '$OMB', '$data', '$Observacao', '$idUsuario');";
		$query_insert_pf = mysqli_query($con,$sql_insert_pf);
		if($query_insert_pf){
			gravarLog($sql_insert_pf);
			echo "<h1>Inserido com sucesso!</h1>";
			}else{
				echo "<h1>Erro ao inserir!</h1>";
			}
	}
}


/*
$ultimo = $_GET['id_pf']; //recupera o id da pessoa

if(isset($_POST['idPedido'])){
	$id_pedido = $_POST['idPedido']; //recupera o id do pedido
	$mensagem = $id_pedido;
}


$con = bancoMysqli();

	if(isset($_POST['cadastrarFisica'])){
		$idPessoaFisica = $_POST['cadastrarFisica'];
		$Nome = $_POST['Nome'];
		$NomeArtistico = $_POST['NomeArtistico'];
		$RG = $_POST['RG'];
		$CPF = $_POST['CPF'];
		$CCM = $_POST['CCM'];
		$IdEstadoCivil = $_POST['IdEstadoCivil'];
		$DataNascimento = exibirDataMysql($_POST['DataNascimento']);
		$Nacionalidade = $_POST['Nacionalidade'];
		$CEP = $_POST['CEP'];
		//$Endereco = $_POST['Endereco'];
		$Numero = $_POST['Numero'];
		$Complemento = $_POST['Complemento'];
		$Bairro = $_POST['Bairro'];
		$Cidade = $_POST['Cidade'];
		$Telefone1 = $_POST['Telefone1'];
		$Telefone2 = $_POST['Telefone2'];
		$Telefone3 = $_POST['Telefone3'];
		$Email = $_POST['Email'];
		$DRT = $_POST['DRT'];
		$cbo = $_POST['cbo'];
		$Funcao = $_POST['Funcao'];
		$InscricaoINSS = $_POST['InscricaoINSS'];
		$OMB = $_POST['OMB'];
		$codBanco = $_POST['codBanco'];
		$agencia = $_POST['agencia'];
		$conta = $_POST['conta'];
		$Observacao = $_POST['Observacao'];
		$tipoDocumento = $_POST['tipoDocumento'];
		$Pis = 0;
		$data = date('Y-m-d');
		$idUsuario = $_SESSION['idUsuario'];
		
		$sql_atualizar_pessoa = "UPDATE sis_pessoa_fisica SET
		`Nome` = '$Nome',
		`NomeArtistico` = '$NomeArtistico',
		`RG` = '$RG', 
		`CPF` = '$CPF', 
		`CCM` = '$CCM', 
		`IdEstadoCivil` = '$IdEstadoCivil' , 
		`DataNascimento` = '$DataNascimento', 
		`Nacionalidade` = '$Nacionalidade', 
		`CEP` = '$CEP', 
		`Numero` = '$Numero', 
		`Complemento` = '$Complemento', 
		`Telefone1` = '$Telefone1', 
		`Telefone2` = '$Telefone2',  
		`Telefone3` = '$Telefone3', 
		`Email` = '$Email', 
		`DRT` = '$DRT', 
		`cbo` = '$cbo',
		`Funcao` = '$Funcao', 
		`InscricaoINSS` = '$InscricaoINSS', 
		`Pis` = '$Pis', 
		`OMB` = '$OMB', 
		`DataAtualizacao` = '$data', 
		`Observacao` = '$Observacao', 
		`IdUsuario` = '$idUsuario', 
		`tipoDocumento` = '$tipoDocumento', 
		`codBanco` = '$codBanco', 
		`agencia` = '$agencia', 
		`conta` = '$conta'  
		WHERE `Id_PessoaFisica` = '$idPessoaFisica'";	
		
		if(mysqli_query($con,$sql_atualizar_pessoa)){
			$mensagem = "Atualizado com sucesso!";	
		}else{
			$mensagem = "Erro ao atualizar! Tente novamente.";
		}
		
	}



$fisica = recuperaDados("sis_pessoa_fisica",$ultimo,"Id_PessoaFisica");

?>



 
<?php */ ?>