<?php
/*
Para fazer
+ funcao que retornam os locais
+ funcao que retornam os periodos
*/
$con = bancoMysqli();
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'lista';	
}
$nomeEvento = recuperaEvento($_SESSION['idEvento']);

?>
<?php include "../include/menuContratatados.php"; ?>

<?php switch($p){
case 'lista': 
if($_SESSION['idPedido']){ // fecha a session idPedido
	unset($_SESSION['idPedido']);
}
if(isset($_SESSION['idPessoaJuridica'])){
	unset($_SESSION['idPessoaJuridica']);
}


if(isset($_POST['inserirRepresentante'])){ //insere represenante existente
	
}
if(isset($_POST['cadastrarFisica'])){ //cadastra e insere pessoa física
	$cpf = $_POST['CPF'];
	$verificaCPF = verificaExiste("sis_pessoa_fisica","CPF",$cpf,"");
	if($verificaCPF['numero'] > 0){ //verifica se o cpf já existe
		$mensagem = "O CPF já consta no sistema. Faça uma busca e insira diretamente";
	}else{ // o CPF não existe, inserir.
		$Nome = addslashes($_POST['Nome']);
		$NomeArtistico = addslashes($_POST['NomeArtistico']);
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
			$sql_ultimo = "SELECT * FROM sis_pessoa_fisica ORDER BY Id_PessoaFisica DESC LIMIT 0,1"; //recupera ultimo id
			$id_evento = mysqli_query($con,$sql_ultimo);
			$id = mysqli_fetch_array($id_evento);
			$idFisica = $id['Id_PessoaFisica'];
			$idEvento = $_SESSION['idEvento'];	
			$sql_insert_pedido = "INSERT INTO `igsis_pedido_contratacao` (`idPedidoContratacao`, `idEvento`, `tipoPessoa`, `idPessoa`,  `valor`, `valorPorExtenso`, `formaPagamento`, `idVerba`, `anexo`, `observacao`, `publicado`) VALUES (NULL, '$idEvento', '1', '$idFisica', NULL, NULL, NULL, NULL, NULL, NULL, '1')";
			$query_insert_pedido = mysqli_query($con,$sql_insert_pedido);
			
			if($query_insert_pedido){
				gravarLog($sql_insert_pedido);
				echo "<h1>Inserido com sucesso!</h1>";
			}else{
				echo "<h1>Erro ao inserir!</h1>";
			}
		}else{
			echo "<h1>Erro ao inserir!</h1>";
		}
	}
}
	

if(isset($_POST['insereFisica'])){ //insere pessoa física
	$idInstituicao = $_SESSION['idInstituicao'];
	$idPessoa = $_POST['Id_PessoaFisica'];
	$idEvento = $_SESSION['idEvento'];
	$sql_verifica_cpf = "SELECT * FROM igsis_pedido_contratacao WHERE idPessoa = '$idPessoa' AND tipoPessoa = '1' AND publicado = '1' AND idEvento = '$idEvento' ";
	$query_verifica_cpf = mysqli_query($con,$sql_verifica_cpf);
	$num_rows = mysqli_num_rows($query_verifica_cpf);
	if($num_rows > 0){
		$mensagem = "A pessoa física já está na lista de pedido de contratação.";	
	}else{
		$sql_insere_pf = "INSERT INTO igsis_pedido_contratacao (idPessoa, tipoPessoa, publicado,idEvento,instituicao) VALUES ('$idPessoa','1','1','$idEvento','$idInstituicao')";
		$query_insere_pf = mysqli_query($con,$sql_insere_pf);
		if($query_insere_pf){
			gravarLog($query_insere_pf);
			$mensagem = "Pedido inserido com sucesso!";
		}else{
			$mensagem = "Erro ao criar pedido. Tente novamente.";
	}
		 	
	}
}
if(isset($_POST['cadastrarJuridica'])){ //cadastra e insere pessoa jurídica
	$verificaCNPJ = verificaExiste("sis_pessoa_juridica","CNPJ",$_POST['CNPJ'],"");
	if($verificaCNPJ['numero'] > 0){ //verifica se o cpf já existe
		$mensagem = "O CNPJ já consta no sistema. Faça uma busca e insira diretamente";
	}else{ // o CNPJ não existe, inserir.
		$RazaoSocial = addslashes($_POST['RazaoSocial']);
		$CNPJ = $_POST['CNPJ'];
		$CCM = $_POST['CCM'];
		$CEP = $_POST['CEP'];
		$Numero = $_POST['Numero'];
		$Complemento = $_POST['Complemento'];
		$Telefone1 = $_POST['Telefone1'];
		$Telefone2 = $_POST['Telefone2'];
		$Telefone3 = $_POST['Telefone3'];
		$Email = $_POST['Email'];
		$Observacao = $_POST['Observacao'];
		$data = date("Y-m-d");
		$idUsuario = $_SESSION['idUsuario'];
		$sql_inserir_pj = "INSERT INTO `sis_pessoa_juridica` (`Id_PessoaJuridica` , `RazaoSocial` ,`CNPJ` ,`CCM` ,`CEP` ,`Numero` ,`Complemento` ,`Telefone1` ,`Telefone2` ,`Telefone3` ,`Email` , `DataAtualizacao` ,`Observacao` ,`IdUsuario`) VALUES ( NULL ,  '$RazaoSocial',  '$CNPJ', '$CCM' , '$CEP' , '$Numero' , '$Complemento' ,  '$Telefone1', '$Telefone2' , '$Telefone3' , '$Email' , '$data', '$Observacao' ,  '$idUsuario')";
		$query_inserir_pj = mysqli_query($con,$sql_inserir_pj);
		if($query_inserir_pj){
						gravarLog($sql_inserir_pj);
			$sql_ultimo = "SELECT * FROM sis_pessoa_juridica ORDER BY Id_PessoaJuridica DESC LIMIT 0,1"; //recupera ultimo id
			$id_evento = mysqli_query($con,$sql_ultimo);
			$id = mysqli_fetch_array($id_evento);
			$idJuridica = $id['Id_PessoaJuridica'];
			$idEvento = $_SESSION['idEvento'];	
			$sql_insert_pedido = "INSERT INTO `igsis_pedido_contratacao` (`idPedidoContratacao`, `idEvento`, `tipoPessoa`, `idRepresentante01`, `idPessoa`, `valor`, `valorPorExtenso`, `formaPagamento`, `idVerba`, `anexo`, `observacao`, `publicado`, `idRepresentante02`) VALUES (NULL, '$idEvento', '2', 'NULL', '$idJuridica', NULL, NULL, NULL, NULL, NULL, NULL, '1', 'NULL')";
			$query_insert_pedido = mysqli_query($con,$sql_insert_pedido);
			if($query_insert_pedido){
				gravarLog($sql_insert_pedido);
				echo "<h1>Inserido com sucesso!</h1>";
			}else{
				echo "<h1>Erro ao inserir o pedido(1)!</h1>";
			}
			
		}else{
			echo "<h1>Erro ao inserir(2)!</h1>";
		}
	}
}

if(isset($_POST['insereJuridica'])){ //insere pessoa jurídica
	$idInstituicao = $_SESSION['idInstituicao'];
	$idPessoa = $_POST['insereJuridica'];
	$idEvento = $_SESSION['idEvento'];
	$sql_verifica_cnpj = "SELECT * FROM igsis_pedido_contratacao WHERE idPessoa = '$idPessoa' AND tipoPessoa = '2' AND publicado = '1' AND idEvento = '$idEvento' ";
	$query_verifica_cnpj = mysqli_query($con,$sql_verifica_cnpj);
	$num_rows = mysqli_num_rows($query_verifica_cnpj);

	if($num_rows > 0){
		$mensagem = "A pessoa jurídica já está na lista de pedido de contratação.";	
	}else{
		$sql_insere_cnpj = "INSERT INTO igsis_pedido_contratacao (idPessoa, tipoPessoa, publicado, idEvento, instituicao) VALUES ('$idPessoa','2','1','$idEvento','$idInstituicao')";
		$query_insere_cnpj = mysqli_query($con,$sql_insere_cnpj);
		if($query_insere_cnpj){
			$mensagem = "Pedido inserido com sucesso!";
		}else{
			$mensagem = "Erro ao criar pedido. Tente novamente.";
	}
		 	
	}
}

if(isset($_POST['apagarPedido'])){	
	$idPedidoContratacao = $_POST['idPedidoContratacao'];
	$sql_apagar_pedido = "UPDATE igsis_pedido_contratacao SET publicado = '0' WHERE idPedidoContratacao = '$idPedidoContratacao'";
	$query_apagar_pedido = mysqli_query($con,$sql_apagar_pedido);
	if($query_apagar_pedido){
		gravarLog($sql_apagar_pedido);
		$mensagem = "Pedido apagado com sucesso.";	
	}else{
		$mensagem = "Erro ao apagar o pedido. Tente novamente.";	
	}
}
?>	
	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Contratados</h2>
                     <p>Você está inserindo pessoas físicas ou jurídicas para serem contratadas para o evento <strong><?php  echo $nomeEvento['nomeEvento']; ?></strong></p>
                    
                     <p><?php if(isset($mensagem)){ echo $mensagem; } ?></p>
<p></p>

					</div>
				  </div>
			  </div>
			<div class="table-responsive list_info">
           <?php  
			$idEvento = $_SESSION['idEvento'];
			$sql_busca = "SELECT * FROM igsis_pedido_contratacao WHERE idEvento = '$idEvento' AND publicado = '1'";
			$query_busca = mysqli_query($con,$sql_busca);
			$num_reg = mysqli_num_rows($query_busca);		   
		   if($num_reg > 0){
		   ?> 
         
				<table class="table table-condensed">
					<thead>
						<tr class='list_menu'>
						<td>Razão Social / Nome</td>
						<td>Tipo de Pessoa</td>
						<td>CPF/CNPJ</td>
   						<td>Valor</td>
   							<td width="10%">
							<td width="10%">
  							<td width="10%">
							<td width="10%"></td>
						</tr>
					</thead>
                    <?php

					while($descricao = mysqli_fetch_array($query_busca)){
						$recuperaPessoa = recuperaPessoa($descricao['idPessoa'],$descricao['tipoPessoa']);
						echo "<tr>";
						echo "<td class='list_description'><b>".$recuperaPessoa['nome']."</b></td>";
						echo "<td class='list_description'>".$recuperaPessoa['tipo']."</td>";
						echo "<td class='list_description'>".$recuperaPessoa['numero']."</td>";
						echo "<td class='list_description'>".dinheiroParaBr($descricao['valor'])."</td>";
						
						echo "
						<td class='list_description'>
						<form method='POST' action='?perfil=contratados&p=arquivos'>
						<input type='hidden' name='idPessoa' value='".$descricao['idPessoa']."'>
						<input type='hidden' name='tipoPessoa' value='".$descricao['tipoPessoa']."'>

						<input type ='submit' class='btn btn-theme btn-sm btn-block' value='anexos'></td></form>"	; //botão de edição
						
						echo "
						<td class='list_description'>
						<form method='POST' action='?perfil=contratados&p=edicaoPessoa'>
						<input type='hidden' name='idPedidoContratacao' value='".$descricao['idPedidoContratacao']."'>
						<input type ='submit' class='btn btn-theme btn-sm btn-block' value='editar pessoa'></td></form>"	; //botão de edição
						
						echo "
						<td class='list_description'>
						<form method='POST' action='?perfil=contratados&p=edicaoPedido'>
						<input type='hidden' name='idPedidoContratacao' value='".$descricao['idPedidoContratacao']."'>
						<input type ='submit' class='btn btn-theme btn-sm btn-block' value='editar pedido'";
						if($descricao['tipoPessoa'] == 3){ echo "disabled"; } //não permite que Representante legal faça pedido.
						echo " ></td></form>"	; //botão de edição
						
						echo "
						<td class='list_description'>
						<form method='POST' action='?perfil=contratados&p=lista'>
						<input type='hidden' name=apagarPedido value='1'>
						<input type='hidden' name='idPedidoContratacao' value='".$descricao['idPedidoContratacao']."'>
						<input type ='submit' class='btn btn-theme btn-sm btn-block'";
						apagarRepresentante($descricao['idPessoa'],$descricao['tipoPessoa'],$_SESSION['idEvento']);
						echo " value='apagar pedido'></td></form>"	; //botão de apagar

						echo "</tr>";
					}
?>
						
					</tbody>
				</table>
                
                <?php }else{  ?>
                <h5> Não há nenhum pedido de contratação cadastrado. </h5>
   <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="?perfil=contratados&p=fisica" class="btn btn-theme btn-lg btn-block">Inserir um pedido Pessoa Física</a>
	            <a href="?perfil=contratados&p=juridica" class="btn btn-theme btn-lg btn-block">Inserir um pedido Pessoa Jurídica</a>
            </div>
          </div>
                <?php } ?>
		</div>
        </div>
	</section>
<?php break; 
case 'juridica':

 ?>    
<?php
if(isset($_POST['pesquisar'])){ // inicia a busca por Razao Social ou CNPJ
	$busca = $_POST['busca'];
	$sql_busca = "SELECT * FROM sis_pessoa_juridica WHERE RazaoSocial LIKE '%$busca%' OR CNPJ LIKE '%$busca%' ORDER BY RazaoSocial";
	$query_busca = mysqli_query($con,$sql_busca); 
	$num_busca = mysqli_num_rows($query_busca);
	if($num_busca > 0){ // Se exisitr, lista a resposta.
	?>
	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Contratados - Pesso Jurídica</h2>
                                          <p>Você está inserindo pessoas jurídicas para serem contratadas para o evento <strong><?php echo $nomeEvento['nomeEvento']; ?></strong></p>

<p>></p>

					</div>
				  </div>
			  </div>
              	<section id="list_items" class="home-section bg-white">
		<div class="container">
<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Razão Social</td>
							<td>CNPJ</td>
							<td width="15%"></td>
                            <td width="15%"></td>
						</tr>
					</thead>
					<tbody>
                    <?php
				while($descricao = mysqli_fetch_array($query_busca)){			
			echo "<tr>";
			echo "<td class='list_description'><b>".$descricao['RazaoSocial']."</b></td>";
			echo "<td class='list_description'>".$descricao['CNPJ']."</td>";
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=contratados&p=lista'>
			<input type='hidden' name='insereJuridica' value='".$descricao['Id_PessoaJuridica']."'>
			<input type ='submit' class='btn btn-theme btn-md btn-block' value='inserir'></td></form>"	;
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=contratados&p=lista'>
			<input type='hidden' name='detalhe' value='".$descricao['Id_PessoaJuridica']."'>
			<input type ='submit' class='btn btn-theme btn-md btn-block' value='detalhe'></td></form>"	;
			echo "</tr>";
				}
?>
						
					</tbody>
				</table>
			</div>
            		</div>
	</section>
	
    <?php }else{ // Se não existe, exibe um formulario para insercao. ?>
	 <!-- Contact -->

	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>CADASTRO DE PESSOA JURÍDICA</h3>
                    <p>Não foram encontradas nenhuma pessoa jurídica com referência <strong><?php echo $_POST['busca'] ?></strong></p> 
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=contratados&p=lista" method="post">
				  
			  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Razão Social:</strong><br/>
					  <input type="text" class="form-control" id="RazaoSocial" name="RazaoSocial" placeholder="RazaoSocial" >
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>CNPJ:</strong><br/>
					  <input type="text" readonly class="form-control" id="CNPJ" name="CNPJ" placeholder="CNPJ" value=<?php echo $_POST['busca'] ?> >
					</div>
					<div class="col-md-6"><strong>CCM:</strong><br/>
					  <input type="text" class="form-control" id="CCM" name="CCM" placeholder="CCM" >
					</div>
				  </div>
				  
				  <div class="form-group">
                  					<div class="col-md-offset-2 col-md-6"><strong>CEP *:</strong><br/>
					  <input type="text" class="form-control" id="CEP" name="CEP" placeholder="XXXXX-XXX">
					</div>				  
					<div class=" col-md-6"><strong>Estado *:</strong><br/>
					  <input type="text" class="form-control" id="Estado" name="Estado" placeholder="Estado">
					</div>

				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Endereço *:</strong><br/>
					  <input type="text" class="form-control" id="Endereco" name="Endereco" placeholder="Endereço">
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
					<div class="col-md-offset-2 col-md-6"><strong>Bairro *:</strong><br/>
					  <input type="text" class="form-control" id="Bairro" name="Bairro" placeholder="Bairro">
					</div>				  
					<div class=" col-md-6"><strong>Cidade *:</strong><br/>
					  <input type="text" class="form-control" id="Cidade" name="Cidade" placeholder="Cidade">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone:</strong><br/>
					  <input type="text" class="form-control" id="Telefone1" name="Telefone1" placeholder="Telefone">
					</div>				  
					<div class=" col-md-6"><strong>Telefone:</strong><br/>
					  <input type="text" class="form-control" id="Telefone2" name="Telefone2" placeholder="Telefone" >
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone:</strong><br/>
					  <input type="text" class="form-control" id="Telefone3" name="Telefone3" placeholder="Telefone">
					</div>				  
					<div class=" col-md-6"><strong>E-mail:</strong><br/>
					  <input type="text" class="form-control" id="Email" name="Email" placeholder="E-mail">
					</div>
				  </div>
				  
				 
		  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observações:</strong><br/>
					 <textarea name="Observacao" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>
				  
				  
				<!-- Botão Gravar -->	
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                     <input type="hidden" name="cadastrarJuridica" value="1" />
					 <input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
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
					 <h2>Contratados - Pessoa Jurídica</h2>
                    <p>Você está inserindo pessoas físicas para serem contratadas para o evento <strong><?php  echo $nomeEvento['nomeEvento']; ?></strong></p>

<p></p>

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            
                        <form method="POST" action="?perfil=contratados&p=juridica" class="form-horizontal" role="form">
            		<label>Insira o CNPJ</label>
            		<input type="text" name="busca" class="form-control" id="CNPJ" placeholder="" ><br />

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

break;
case 'fisica':
 ?>    
<?php
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
							<td width="15%"></td>
                            <td width="15%"></td>
						</tr>
					</thead>
					<tbody>
                    <?php
				while($descricao = mysqli_fetch_array($query_busca)){			
			echo "<tr>";
			echo "<td class='list_description'><b>".$descricao['Nome']."</b></td>";
			echo "<td class='list_description'>".$descricao['CPF']."</td>";
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=contratados&p=lista'>
			<input type='hidden' name='insereFisica' value='1'>
			<input type='hidden' name='Id_PessoaFisica' value='".$descricao['Id_PessoaFisica']."'>
			<input type ='submit' class='btn btn-theme btn-md btn-block' value='inserir'></td></form>"	;
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=contratados&p=lista'>
			<input type='hidden' name='detalhe' value='".$descricao['Id_PessoaFisica']."'>
			<input type ='submit' class='btn btn-theme btn-md btn-block' value='detalhe'></td></form>"	;
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
	<?php
	$ultimo = cadastroPessoa($_SESSION['idEvento'],$CPF,'1'); 
	$campo = recuperaDados("sis_pessoa_fisica",$ultimo,"Id_PessoaFisica");
	?>
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>CADASTRO DE PESSOA FÍSICA</h3>
                    <p> O CPF <?php echo $busca; ?> não está cadastrado no nosso sistema. <br />Por favor, insira as informações da Pessoa Física a ser contratada. </p>
                    <p><a href="?perfil=contratados&p=fisica"> Pesquisar outro CPF</a> </p>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=contratados&p=lista" method="post">
				  
			 
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="Nome" placeholder="Nome" >
					</div>
				  </div>

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome Artístico:</strong><br/>
					  <input type="text" class="form-control" id="NomeArtistico" name="NomeArtistico" placeholder="Nome Artístico" >
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Tipo de documento *:</strong><br/>
					  <select class="form-control" id="tipoDocumento" name="tipoDocumento" >
					   <?php
						geraOpcao("igsis_tipo_documento","","");
						?>  
					  </select>

					</div>				  
					<div class=" col-md-6"><strong>Documento *:</strong><br/>
                      <input type="text" class="form-control" id="RG" name="RG" placeholder="Documento" >
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>CPF *:</strong><br/>
					  <input type="text" class="form-control" id="cpf" name="CPF" placeholder="CPF" value="<?php echo $busca; ?> ">
					</div>				  
					<div class=" col-md-6"><strong>CCM *:</strong><br/>
					  <input type="text" class="form-control" id="CCM" name="CCM" placeholder="CCM" >
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
 <input type="text" class="form-control" id="datepicker01" name="DataNascimento" placeholder="Data de Nascimento" >
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Nacionalidade:</strong><br/>
					   <input type="text" class="form-control" id="Nacionalidade" name="Nacionalidade" placeholder="Nacionalidade">
					</div>				  
					<div class=" col-md-6"><strong>CEP:</strong><br/>
					 					  <input type="text" class="form-control" id="CEP" name="CEP" placeholder="CEP">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Endereço *:</strong><br/>
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
                     
					<div class="col-md-offset-2 col-md-8"><strong>Complemento *:</strong><br/>
					    <input type="text" class="form-control" id="Complemento" name="Complemento" placeholder="Complemento">
					</div>
				  </div>		
                  				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Cidade *:</strong><br/>
										  <input type="text" class="form-control" id="Cidade" name="Cidade" placeholder="Cidade">

					</div>				  
					<div class=" col-md-6"><strong>Estado *:</strong><br/>
					  <input type="text" class="form-control" id="Estado" name="Estado" placeholder="Estado">
					</div>
				  </div>		  
				  <div class="form-group">
                  					<div class="col-md-offset-2 col-md-6"><strong>E-mail *:</strong><br/>
					<input type="text" class="form-control" id="Email" name="Email" placeholder="E-mail" >
					</div>				  


					<div class=" col-md-6"><strong>Telefone #1 *:</strong><br/>

					  <input type="text" class="form-control" id="Telefone1" name="Telefone1" placeholder="Telefone" >
					</div>

				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #2:</strong><br/>
					  <input type="text" class="form-control" id="Telefone1" name="Telefone2" placeholder="Telefone" >
					</div>				  
					<div class="col-md-6"><strong>Telefone #3:</strong><br/>
					  <input type="text" class="form-control" id="Telefone2" name="Telefone3" placeholder="Telefone" >
					</div>
				  </div>

							  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>DRT:</strong><br/>
					  <input type="text" class="form-control" id="DRT" name="DRT" placeholder="DRT" >
					</div>				  
					<div class=" col-md-6"><strong>Função:</strong><br/>
					  <input type="text" class="form-control" id="Funcao" name="Funcao" placeholder="Função">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Inscrição do INSS ou PIS/PASEP:</strong><br/>
					  <input type="text" class="form-control" id="InscricaoINSS" name="InscricaoINSS" placeholder="Inscrição no INSS ou PIS/PASEP" >
					</div>				  
					<div class=" col-md-6"><strong>OMB:</strong><br/>
					  <input type="text" class="form-control" id="OMB" name="OMB" placeholder="OMB" >
					</div>
				  </div>
				  
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observação:</strong><br/>
					 <textarea name="Observacao" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="cadastrarFisica" value="1" />
                    <input type="hidden" name="Sucesso" id="Sucesso" />
					 <input type="image" alt="GRAVAR" value="submit" class="btn btn-theme btn-lg btn-block">
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
					 <h2>Contratados - Pessoa Física</h2>
                    <p>Você está inserindo pessoas físicas para serem contratadas para o evento <strong><?php  echo $nomeEvento['nomeEvento']; ?></strong></p>

<p></p>

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            
                        <form method="POST" action="?perfil=contratados&p=fisica" class="form-horizontal" role="form">
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

<?php break;
case 'representante':

if(isset($_POST['numero'])){
	$_SESSION['numero'] = $_POST['numero'];	
}
include "../funcoes/funcoesSiscontrat.php";

if(isset($_POST['idPessoaJuridica'])){
	$pessoa = recuperaPessoa($_POST['idPessoaJuridica'],2);	
}else{
	$pessoa = recuperaPessoa($_SESSION['idPessoaJuridica'],2);	
}


if(isset($_GET['action'])){
	$action = $_GET['action'];
}else{
	$action = "edita";
	
}

switch($action){
case "edita":

	if($_POST['idPessoa'] == 0){ //mostra busca ?>		
  	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
             <h2>CADASTRO DE REPRESENTANTE LEGAL</h2>
           <p>A pessoa jurídica para quem você está cadastrando representantes legais é <strong><?php echo $pessoa['nome'];  ?></strong></p>  
					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            
                        <form method="POST" action="?perfil=contratados&p=representante&action=busca" class="form-horizontal" role="form">
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
	<?php	}else{ //mostra formulário de edição
		//Carrega edição
		

//carrega os posts
if(isset($_POST['atualizar'])){
	
$idRepresentante = $_POST['atualizar'];
$representante = addslashes($_POST['RepresentanteLegal']);
$rg = $_POST['RG'];
$nacionalidade = $_POST['Nacionalidade'];
$civil = $_POST['IdEstadoCivil'];

$sql_atualiza_dados = "UPDATE `igsis`.`sis_representante_legal` SET `RepresentanteLegal` = '$representante',`RG` = '$rg', `Nacionalidade` = '$nacionalidade', `IdEstadoCivil` = '$civil' WHERE `sis_representante_legal`.`Id_RepresentanteLegal` = '$idRepresentante'";


$query_atualiza_dados = mysqli_query($con,$sql_atualiza_dados);
	if($query_atualiza_dados){
		$mensagem = "Dados atualizados!";	
		gravarLog($sql_atualiza_dados);
	}else{
		$mensagem = "Erro ao atualizar dados.";
	}

}


	
$pessoa = siscontratDocs($_POST['idPessoa'],3);
$k = "?perfil=contratados&p=representante";
$empresa = siscontratDocs($_SESSION['idJuridico'],2);
 ?>
 	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
              <h2>CADASTRO DE REPRESENTANTE LEGAL</h2>
              <p>A pessoa jurídica para quem você está cadastrando representante legal é <strong><?php echo $empresa['Nome']; ?></strong></p>
				<p><?php if(isset($mensagem)){echo $mensagem;} ?></p>	
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=contratados&p=representante&action=edita" method="post">
				  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <input type="text" class="form-control" id="RepresentanteLegal" name="RepresentanteLegal" value="<?php echo $pessoa['Nome'] ?>">
					</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6">
					  <input type="text" class="form-control" id="RG" name="RG" placeholder="RG" value="<?php echo $pessoa['RG'] ?>">
					</div>
					<div class="col-md-6">
					  <input type="text" readonly class="form-control" id="cpf" name="CPF" placeholder="CPF" value="<?php echo $pessoa['CPF'] ?>">
					</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6">
					  <input type="text" class="form-control" id="Nacionalidade" name="Nacionalidade" placeholder="Nacionalidade" value="<?php echo $pessoa['Nacionalidade'] ?>">
					</div>
					<div class="col-md-6">
					  <select class="form-control" name="IdEstadoCivil" id="IdEstadoCivil"><option>Estado Civil</option>
                      <?php
					                   
					  geraOpcao("sis_estado_civil",$pessoa['IdEstadoCivil'],"");
					  ?> 
					 
                      </select>
					</div>
				  </div>
                  
                  <!-- Botão Gravar -->	
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="idPessoa" value="<?php echo $_POST['idPessoa'] ?>" />
                    <input type="hidden" name="atualizar" value="<?php echo $_POST['idPessoa'] ?>" />
                    
                    <input type="hidden" name="numero" value="<?php echo $_SESSION['numero'] ?>" />
                    
					 <input type="image" name="enviar" alt="atualizar" value="submit" class="btn btn-theme btn-lg btn-block">
					</div>
                    
				  </div>
				</form>
	
 <div class="form-group">
					<div class="col-md-offset-2 col-md-6">
                    <form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoPessoa" method="post">
                                        
                    <input type="hidden" name="numero" value="<?php echo $_SESSION['numero'] ?>" />
                    
					 <input type="image" name="enviar" alt="Voltar" value="submit" class="btn btn-theme btn-block">
                     </form>
					</div>
					<div class="col-md-6">
                    <form class="form-horizontal" role="form" action="?perfil=contratados&p=representante&action=edita" method="post">
					 <input type="hidden" name="idPessoa" value="0" />
					 <input type="image" name="enviar" alt="Inserir outro representante" value="submit" class="btn btn-theme btn-block">
                     </form>
					</div>
				  </div>    
    
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  
      <?php
	  var_dump($pessoa);
	   ?>
<?php
	}

?>
<?php
break;
case "busca":
	$busca = $_POST['busca'];
	$sql_busca = "SELECT * FROM sis_representante_legal WHERE CPF LIKE '%$busca%' ORDER BY RepresentanteLegal";
	$query_busca = mysqli_query($con,$sql_busca); 
	$num_busca = mysqli_num_rows($query_busca);
	if($num_busca > 0){ // Se exisitr, lista a resposta.  ?>
	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
             <h2>CADASTRO DE REPRESENTANTE LEGAL</h2>
              <p>O sistema encontrou informações sobre representantes legais com referência a <br /><strong><?php echo $_POST['busca'] ?>. </strong><br /> </p>
 

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
							<td width="20%"></td>
  							<td width="20%"></td>
						</tr>
					</thead>
					<tbody>
                    <?php
				while($descricao = mysqli_fetch_array($query_busca)){			
			echo "<tr>";
			echo "<td class='list_description'><b>".$descricao['RepresentanteLegal']."</b></td>";
			echo "<td class='list_description'>".$descricao['CPF']."</td>";
			echo "
			<td class='list_description'>
			<form method='POST' action='?'>
			<input type='hidden' name='idPessoa' value='1'>
			<input type ='submit' class='btn btn-theme btn-md btn-block' value='detalhe'></td></form>"	;
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=contratados&p=edicaoPessoa'>
			<input type='hidden' name='insereRepresentante' value='".$descricao['Id_RepresentanteLegal']."'>
			<input type='hidden' name='idPessoa' value='".$descricao['Id_RepresentanteLegal']."'>
			<input type ='submit' class='btn btn-theme btn-md btn-block' value='inserir'></td></form>"	;

			echo "</tr>";
				}
?>
						
					</tbody>
				</table>
               			</div>
            		</div>
	</section>
<?php	}else{
		?>
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
            
					<h3>CADASTRO DE REPRESENTANTE LEGAL</h3>
                    <p>Não foi encontrado nenhum registro com o seguinte CPF <?php echo $_POST['busca']; ?></p>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoPessoa" method="post">
				  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <input type="text" class="form-control" id="RepresentanteLegal" name="RepresentanteLegal" placeholder="Representante Legal">
					</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6">
					  <input type="text" class="form-control" id="RG" name="RG" placeholder="RG">
					</div>
					<div class="col-md-6">
					  <input type="text" class="form-control" id="cpf" name="CPF" placeholder="CPF" readonly="readonly" value="<?php echo $_POST['busca']; ?>" >
					</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6">
					  <input type="text" class="form-control" id="Nacionalidade" name="Nacionalidade" placeholder="Nacionalidade">
					</div>
					<div class="col-md-6">
					  <select class="form-control" name="IdEstadoCivil" id="IdEstadoCivil"><option>Estado Civil</option>
                      <?php
					  geraOpcao("sis_estado_civil","","");
					  ?>  
                      </select>
					</div>
				  </div>
                  
                  <!-- Botão Gravar -->	
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="cadastraRepresentante" value="1" />
                    <input type="hidden" name="idPessoajuridica" value="1" />
					 <input type="image" name="enviar" alt="CADASTRAR" value="submit" class="btn btn-theme btn-lg btn-block">
					</div>
                    
				  </div>
				</form>
	
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  
        
        <?php
	}
?>
	<?php 	
break;	
} //fecha a action


	
		
	?>

<?php 
break;
case "edicaoPedido":
if(isset($_POST['idPedidoContratacao'])){
$_SESSION['idPedido'] = $_POST['idPedidoContratacao'];
}

if($_SESSION['numero']){
unset($_SESSION['numero']);
}

if(isset($_POST['insereExecutante'])){ //insere IdExecutante
	$id_executante = $_POST['insereExecutante'];
	$_SESSION['idPedido'] = $_POST['idPedido'];
	$idPedido = $_SESSION['idPedido'];
	$sql_atualiza_executante = "UPDATE `igsis_pedido_contratacao` SET `IdExecutante` = '$id_executante' 
	WHERE `idPedidoContratacao` = '$idPedido';";
	$query_atualiza_executante = mysqli_query($con,$sql_atualiza_executante);	
	if($query_atualiza_executante){
		$mensagem = "Executante inserido com sucesso!";	
	}
}

if(isset($_POST['atualizar'])){
	

	$ValorIndividual = "0.00";
	$Observacao = addslashes($_POST['Observacao']);
	$parcelas = $_POST['parcelas'];
	$Verba = $_POST['verba'];
	$parecer = addslashes($_POST['parecerArtistico']);
	$justificativa = addslashes($_POST['justificativa']);
	$idPedidoContratacao = $_POST['idPedidoContratacao'];
	
	if($_POST['atualizar'] > '1'){
	
		$sql_atualizar_pedido = "UPDATE  `igsis_pedido_contratacao` SET  
`observacao` =  '$Observacao',
`parcelas` =  '$parcelas',
`parecerArtistico` =  '$parecer',
`justificativa` =  '$justificativa',

`idVerba` =  '$Verba',
`valorIndividual` =  '$ValorIndividual' WHERE  `idPedidoContratacao` = '$idPedidoContratacao';
";
	}else{
	$Valor = dinheiroDeBr($_POST['Valor']);	
	$FormaPagamento = $_POST['FormaPagamento'];
	
		$sql_atualizar_pedido = "UPDATE  `igsis_pedido_contratacao` SET  
	`valor` =  '$Valor',
`formaPagamento` =  '$FormaPagamento',
`observacao` =  '$Observacao',
`parcelas` =  '$parcelas',
`parecerArtistico` =  '$parecer',
`justificativa` =  '$justificativa',

`idVerba` =  '$Verba',
`valorIndividual` =  '$ValorIndividual' WHERE  `idPedidoContratacao` = '$idPedidoContratacao';
";

	}
	
	$query_atualizar_pedido = mysqli_query($con,$sql_atualizar_pedido);
	if($query_atualizar_pedido){
		gravarLog($sql_atualizar_pedido);
		$mensagem = "Atualizado com sucesso";	
	}else{
		$mensagem = "Erro ao atualizar(5)."	;
		
	}
	
}


include "../funcoes/funcoesSiscontrat.php";
$pedido = recuperaDados("igsis_pedido_contratacao",$_SESSION['idPedido'],"idPedidoContratacao");
$executante = siscontratDocs($pedido['IdExecutante'],1);
?>
	 <!-- Contact -->
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h2>PEDIDO DE CONTRATAÇÃO <?php if($pedido['tipoPessoa'] == 1){echo "PESSOA FÍSICA";}else{echo "PESSOA JURÍDICA";} ?> </h2>
                    <p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">
                
                				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <p class="left">
                    	<?php $evento = recuperaEvento($_SESSION['idEvento']); ?>

                        
						<strong>Setor:</strong> <?php echo $_SESSION['instituicao']; ?> - 
						<strong>Categoria de contratação:</strong> <?php recuperaModalidade($evento['ig_modalidade_IdModalidade']); ?> <br />
						<strong>Proponente:</strong>  <?php echo $_SESSION['nomeCompleto']; ?> <br />
						<strong>Objeto:</strong> <?php echo retornaTipo($evento['ig_tipo_evento_idTipoEvento']) ?> -  <?php echo $evento['nomeEvento']; ?> <br />
						<strong>Local: <?php echo listaLocais($_SESSION['idEvento']); ?></strong> <br />
                        
						<strong>Período: <?php echo retornaPeriodo($_SESSION['idEvento']); ?></strong><br /> 
                        <?php 
						$fiscal = recuperaUsuario($evento['idResponsavel']);
						$suplente = recuperaUsuario($evento['suplente']);

						$representante01 = siscontratDocs($pedido['idRepresentante01'],3);
						 ?>
						<strong>Fiscal:</strong>  <?php echo $fiscal['nomeCompleto']; ?> - <strong>Suplente:</strong>  <?php echo $suplente['nomeCompleto']; ?> 

                    </p>
					</div>
                  </div>
                  <?php if($pedido['tipoPessoa'] == 2){ ?>
                  <!-- Executante -->
                  				<div class="form-group">                  
					<div class="col-md-offset-2 col-md-8"><br/></div>
                </div> 

                  <div class="form-group"> 
					<div class="col-md-offset-2 col-md-8"><strong>Executante:</strong><br/>
		  <form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoExecutante&id_pf=<?php echo $pedido['IdExecutante']?>"  method="post">
					  <input type='text' readonly class='form-control' name='Executante' id='Executante' value="<?php echo $executante['Nome'] ?>">                    	
                    </div>
                  </div>  
                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8">

                      <input type="hidden" name="idPedido" value="<?php echo $_SESSION['idPedido']; ?>" />
                     <?php if($pedido['IdExecutante'] == NULL OR $pedido['IdExecutante'] == ""){ ?>
					 <input type="submit" class="btn btn-theme btn-med btn-block" value="Inserir executante">
                     <?php }else{ ?>
					 <input type="submit" class="btn btn-theme btn-med btn-block" value="Abrir executante">
                     <?php } ?>
                     </form>
					</div>
				  </div>
				<!-- /Executante -->
			<?php } ?>	
			<!-- Grupo -->
				<div class="form-group">                  
					<div class="col-md-offset-2 col-md-8"><br/></div>
                </div>

                  <div class="form-group"> 
					<div class="col-md-offset-2 col-md-8"><strong>Integrantes do grupo:</strong><br/>
		  <form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoGrupo"  method="post">
					 <textarea readonly name="grupo" cols="40" rows="5"><?php echo listaGrupo($pedido['idPedidoContratacao']); ?></textarea>
                                         	
                    </div>
                  </div>  
                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="idPedido" value="<?php echo $pedido['idPedidoContratacao']; ?>" >
					 <input type="submit" class="btn btn-theme btn-med btn-block" value="Editar integrantes do grupo">
                     </form>
					</div>
				  </div>
					
				  <div class="form-group">
						<div class="col-md-offset-2 col-md-8"><br /></div>
				  </div>
			<!-- /Grupo -->


				<form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoPedido" method="post">
				<?php
				$multiplo = recuperaDados("sis_verba",$pedido['idVerba'],"Id_Verba");
				 if($pedido['parcelas'] > 1 OR $multiplo['multiplo'] == '1' )
				 { ?>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Valor:</strong><br/>
					  <input type='text' disabled name="valor_parcela" id='valor' class='form-control' value="<?php echo dinheiroParaBr($pedido['valor']) ?>" >
					</div>					
		   <?php }
				 else
				{ ?>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Valor:</strong><br/>
					  <input type='text' name="Valor" id='valor' class='form-control' value="<?php echo dinheiroParaBr($pedido['valor']) ?>" >
					</div>					
				<?php } ?>

				  </div>
				  		<?php if($pedido['parcelas'] > 0){ ?>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Forma de Pagamento / Valor da Prestação de Serviço:</strong><br/>
                      <textarea  disabled name="FormaPagamento" class="form-control" cols="40" rows="5"><?php echo txtParcelas($_SESSION['idPedido'],$pedido['parcelas']); ?> 
                      
                      </textarea>
					<p>                   </p>
					</div>
				  </div>
				<?php }else{ ?>				
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Forma de Pagamento / Valor da Prestação de Serviço:</strong><br/>
                      <textarea name="FormaPagamento" class="form-control" cols="40" rows="5"><?php echo $pedido['formaPagamento'] ?></textarea>
					</div>
				  </div>
				<?php } ?>   				  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Parcelas (antes de editar as parcelas, é preciso salvar o pedido)</strong><br/>
					  	 <select class="form-control" id="parcelas" name="parcelas" >
						<option value="0" <?php if($pedido['parcelas'] == '0'){ echo "selected"; } ?> >Outros</option>
						<option value="1" <?php if($pedido['parcelas'] == '1'){ echo "selected"; } ?> >Parcela única</option>
						<option value="2" <?php if($pedido['parcelas'] == '2'){ echo "selected"; } ?> >2 parcelas</option>
						<option value="3" <?php if($pedido['parcelas'] == '3'){ echo "selected"; } ?> >3 parcelas</option>
						<option value="4" <?php if($pedido['parcelas'] == '4'){ echo "selected"; } ?> >4 parcelas</option>
						<option value="5" <?php if($pedido['parcelas'] == '5'){ echo "selected"; } ?> >5 parcelas</option>
						<option value="6" <?php if($pedido['parcelas'] == '6'){ echo "selected"; } ?> >6 parcelas</option>
						<option value="7" <?php if($pedido['parcelas'] == '7'){ echo "selected"; } ?> >7 parcelas</option>
						<option value="8" <?php if($pedido['parcelas'] == '8'){ echo "selected"; } ?> >8 parcelas</option>
						<option value="9" <?php if($pedido['parcelas'] == '9'){ echo "selected"; } ?> >9 parcelas</option>
						<option value="10" <?php if($pedido['parcelas'] == '10'){ echo "selected"; } ?> >10 parcelas</option>
						<option value="11" <?php if($pedido['parcelas'] == '11'){ echo "selected"; } ?> >11 parcelas</option>
						<option value="12" <?php if($pedido['parcelas'] == '12'){ echo "selected"; } ?> >12 parcelas</option>

					  </select>
                      
					</div>	
                    </div>
                  <?php
				  if($pedido['parcelas'] > 1)
				  { //libera a edição de parcelas
				   ?>
                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <a href="?perfil=contratados&p=edicaoParcelas" class="btn btn-theme btn-block">Editar parcelas</a>
					</div>
                    
				  </div>
			<?php } ?>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Verba:</strong><br/>
					  	 <select class="form-control" id="verba" name="verba" >
					   <?php
						geraOpcaoOrder("sis_verba",$pedido['idVerba'],"");
						?>  
					  </select>
					</div>		

				  </div>
                  <?php
				  $verbas = recuperaDados("sis_verba",$pedido['idVerba'],"Id_Verba");
				  if($verbas['multiplo'] == 1){ //libera a edição de parcelas
				   ?>
                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <a href="?perfil=contratados&p=edicaoVerbas" class="btn btn-theme btn-block">Editar verbas múltiplas</a>
					</div>
                    
				  </div>
					<?php } ?>
              <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<p><?php echo comparaValores($_SESSION['idPedido']); ?></p>
					</div>
                    
				  </div>
 
       		 <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            		<label>Justificativa*</label>
            		<textarea name="justificativa" class="form-control" rows="10" placeholder="Texto usado fins jurídicos e confecção de contratos."><?php echo $pedido["justificativa"] ?></textarea>
            	</div> 
            </div>

      		 <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            		<label>Parecer artístico*</label>
            		<textarea name="parecerArtistico" class="form-control" rows="10" placeholder="Texto usado fins jurídicos e confecção de contratos."><?php echo $pedido["parecerArtistico"] ?></textarea>
            	</div> 
            </div>

 
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observação:</strong><br/>
					   <textarea name="Observacao" class='form-control' cols="40" rows="5"><?php echo $pedido['observacao'] ?></textarea>
					</div>
				  </div>
                  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="atualizar" value="<?php echo $pedido['parcelas']; ?>" />
                    <input type="hidden" name="idPedidoContratacao" value="<?php echo $_SESSION['idPedido']; ?>" />
					 <input type="image" alt="GRAVAR" name="GRAVAR" value="submit" class="btn btn-theme btn-lg btn-block">
					</div>
                    
				  </div>
				</form>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <a href="?perfil=contratados" value="VOLTAR" class="btn btn-theme btn-lg btn-block">VOLTAR para area de pedidos de contratação</a>
					</div>
                    
				  </div>	
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  
<?php 
break;
case "edicaoExecutante":

$con = bancoMysqli(); // conecta no banco

$ultimo = $_GET['id_pf']; //recupera o id da pessoa

if(isset($_POST['idPedido'])){
	$id_pedido = $_POST['idPedido']; //recupera o id do pedido
	$mensagem = $id_pedido;
}

if($_GET['id_pf'] == "" OR $_GET['id_pf'] == NULL){
	$pagina = "busca";	
	if(isset($_POST['pesquisar'])){
		$pagina = "pesquisar";	
	}
}else{
	$pagina = "editar";
}




?>

<?php

switch($pagina){

case "busca":
?>

	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Executante - Pessoa Física</h2>
                    <p>Você está inserindo pessoas físicas para serem contratadas para o evento <strong><?php  //echo $nomeEvento['nomeEvento']; ?></strong></p>

<p></p>

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            
                        <form method="POST" action="?perfil=contratados&p=edicaoExecutante&id_pf=" class="form-horizontal" role="form">
            		<label>Insira o CPF</label>
            		<input type="text" name="busca" class="form-control" id="cpf" >
            	</div>
             </div>
				<br />             
	            <div class="form-group">
		            <div class="col-md-offset-2 col-md-8">
                	<input type="hidden" name="pesquisar" value="1" />
                	<input type="hidden" name="idPedido" value="<?php echo $_POST['idPedido']; ?>" />
    		        <input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
                    </form>
        	    	</div>
        	    </div>

            </div>
	</section>

<?php 
break;
case "pesquisar":
?>
<?php
	$idPedido = $_POST['idPedido'];
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
					 <h2>Executante - Pessoa Física</h2>
                                          
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
							<td width="15%"></td>
                            
						</tr>
					</thead>
					<tbody>
                    <?php
				while($descricao = mysqli_fetch_array($query_busca)){			
			echo "<tr>";
			echo "<td class='list_description'><b>".$descricao['Nome']."</b></td>";
			echo "<td class='list_description'>".$descricao['CPF']."</td>";
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=contratados&p=edicaoPedido' >
			<input type='hidden' name='idPedido' value='".$_POST['idPedido']."'>
			<input type='hidden' name='insereExecutante' value='".$descricao['Id_PessoaFisica']."'>
			<input type ='submit' class='btn btn-theme btn-md btn-block' value='inserir'></td></form>"	;
			echo "</tr>";
			}
?>
						
					</tbody>
				</table>
			</div>
            		</div>
                    </div>
                    
	</section>

<?php
	}else{ // se não existir o cpf, imprime um formulário.
 ?>

  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>CADASTRO DE PESSOA FÍSICA</h3>
                    <p> O CPF <?php echo $busca; ?> não está cadastrado no nosso sistema. <br />Por favor, insira as informações da Pessoa Física a ser contratada. </p>
                    <p><a href="?perfil=contratados&p=edicaoExecutante&id_pf="> Pesquisar outro CPF</a> </p>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=contratos&p=frm_edita_propostapj&id_ped=<?php echo $_SESSION['idPedido'] ?>" method="post">
				  
			 
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="Nome" placeholder="Nome" >
					</div>
				  </div>

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome Artístico:</strong><br/>
					  <input type="text" class="form-control" id="NomeArtistico" name="NomeArtistico" placeholder="Nome Artístico" >
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Tipo de documento *:</strong><br/>
					  <select class="form-control" id="tipoDocumento" name="tipoDocumento" >
					   <?php
						geraOpcao("igsis_tipo_documento","","");
						?>  
					  </select>

					</div>				  
					<div class=" col-md-6"><strong>Documento *:</strong><br/>
                      <input type="text" class="form-control" id="RG" name="RG" placeholder="Documento" >
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>CPF *:</strong><br/>
					  <input type="text" class="form-control" id="cpf" name="CPF" placeholder="CPF" value="<?php echo $busca; ?> ">
					</div>				  
					<div class=" col-md-6"><strong>CCM *:</strong><br/>
					  <input type="text" class="form-control" id="CCM" name="CCM" placeholder="CCM" >
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
 <input type="text" class="form-control" id="datepicker01" name="DataNascimento" placeholder="Data de Nascimento" >
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Nacionalidade:</strong><br/>
					   <input type="text" class="form-control" id="Nacionalidade" name="Nacionalidade" placeholder="Nacionalidade">
					</div>				  
					<div class=" col-md-6"><strong>CEP:</strong><br/>
					 					  <input type="text" class="form-control" id="CEP" name="CEP" placeholder="CEP">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Endereço *:</strong><br/>
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
                     
					<div class="col-md-offset-2 col-md-8"><strong>Complemento *:</strong><br/>
					    <input type="text" class="form-control" id="Complemento" name="Complemento" placeholder="Complemento">
					</div>
				  </div>		
                  				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Cidade *:</strong><br/>
										  <input type="text" class="form-control" id="Cidade" name="Cidade" placeholder="Cidade">

					</div>				  
					<div class=" col-md-6"><strong>Estado *:</strong><br/>
					  <input type="text" class="form-control" id="Estado" name="Estado" placeholder="Estado">
					</div>
				  </div>		  
				  <div class="form-group">
                  					<div class="col-md-offset-2 col-md-6"><strong>E-mail *:</strong><br/>
					<input type="text" class="form-control" id="Email" name="Email" placeholder="E-mail" >
					</div>				  


					<div class=" col-md-6"><strong>Telefone #1 *:</strong><br/>

					  <input type="text" class="form-control" id="Telefone1" name="Telefone1" placeholder="Telefone" >
					</div>

				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #2:</strong><br/>
					  <input type="text" class="form-control" id="Telefone1" name="Telefone2" placeholder="Telefone" >
					</div>				  
					<div class="col-md-6"><strong>Telefone #3:</strong><br/>
					  <input type="text" class="form-control" id="Telefone2" name="Telefone3" placeholder="Telefone" >
					</div>
				  </div>

							  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>DRT:</strong><br/>
					  <input type="text" class="form-control" id="DRT" name="DRT" placeholder="DRT" >
					</div>				  
					<div class=" col-md-6"><strong>Função:</strong><br/>
					  <input type="text" class="form-control" id="Funcao" name="Funcao" placeholder="Função">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Inscrição do INSS ou PIS/PASEP:</strong><br/>
					  <input type="text" class="form-control" id="InscricaoINSS" name="InscricaoINSS" placeholder="Inscrição no INSS ou PIS/PASEP" >
					</div>				  
					<div class=" col-md-6"><strong>OMB:</strong><br/>
					  <input type="text" class="form-control" id="OMB" name="OMB" placeholder="OMB" >
					</div>
				  </div>
				  
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observação:</strong><br/>
					 <textarea name="Observacao" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="cadastraExecutante" value="1" />
                    <input type="hidden" name="Sucesso" id="Sucesso" />
					 <input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
				</form>
	
    
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  



<?php } ?> 


<?php 
break;
case "editar":

	if(isset($_POST['cadastrarFisica'])){
		$idPessoaFisica = $_POST['cadastrarFisica'];
		$Nome = addslashes($_POST['Nome']);
		$NomeArtistico = addslashes($_POST['NomeArtistico']);
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
		$Funcao = $_POST['Funcao'];
		$InscricaoINSS = $_POST['InscricaoINSS'];
		$OMB = $_POST['OMB'];
		$Observacao = addslashes($_POST['Observacao']);
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
		`Funcao` = '$Funcao', 
		`InscricaoINSS` = '$InscricaoINSS', 
		`Pis` = '$Pis', 
		`OMB` = '$OMB', 
		`DataAtualizacao` = '$data', 
		`Observacao` = '$Observacao', 
		`IdUsuario` = '$idUsuario', 
		`tipoDocumento` = '$tipoDocumento' 
		WHERE `Id_PessoaFisica` = '$idPessoaFisica'";	
		
		if(mysqli_query($con,$sql_atualizar_pessoa)){
			$mensagem = "Atualizado com sucesso!";	
		}else{
			$mensagem = "Erro ao atualizar! Tente novamente.";
		}
		
	}

$fisica = recuperaDados("sis_pessoa_fisica",$ultimo,"Id_PessoaFisica");
?>
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>CADASTRO DE EXECUTANTE (PESSOA FÍSICA)</h3>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                                        </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoExecutante&id_pf=<?php echo $ultimo ?>" method="post">
				  
			 
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="Nome" placeholder="Nome" value="<?php echo $fisica['Nome']; ?>" >
					</div>
				  </div>

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome Artístico:</strong><br/>
					  <input type="text" class="form-control" id="NomeArtistico" name="NomeArtistico" placeholder="Nome Artístico" value="<?php echo $fisica['NomeArtistico']; ?>">
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
                      <input type="text" class="form-control" id="RG" name="RG" placeholder="Documento" value="<?php echo $fisica['RG']; ?>">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>CPF *:</strong><br/>
					  <input type="text" readonly class="form-control" id="cpf" name="CPF" placeholder="CPF" value="<?php echo $fisica['CPF']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>CCM *:</strong><br/>
					  <input type="text" class="form-control" id="CCM" name="CCM" placeholder="CCM" value="<?php echo $fisica['CCM']; ?>" >
					</div>
				  </div>

				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Estado civil:</strong><br/>
					  <select class="form-control" id="IdEstadoCivil" name="IdEstadoCivil" >
					   <?php
						geraOpcao("sis_estado_civil",$fisica['IdEstadoCivil'],"");
						?>  
					  </select>
					</div>				  
					<div class=" col-md-6"><strong>Data de nascimento:</strong><br/>
 <input type="text" class="form-control" id="datepicker01" name="DataNascimento" placeholder="Data de Nascimento" value="<?php echo exibirDataBr($fisica['DataNascimento']); ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Nacionalidade:</strong><br/>
					   <input type="text" class="form-control" id="Nacionalidade" name="Nacionalidade" placeholder="Nacionalidade" value="<?php echo $fisica['Nacionalidade']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>CEP:</strong><br/>
					 					  <input type="text" class="form-control" id="CEP" name="CEP" placeholder="CEP" value="<?php echo $fisica['CEP']; ?>">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Endereço *:</strong><br/>
					  <input type="text" class="form-control" id="Endereco" name="Endereco" placeholder="Endereço">
					</div>
				  </div>
                  				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
					  <input type="text" class="form-control" id="Numero" name="Numero" placeholder="Numero" value="<?php echo $fisica['Numero']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>Bairro:</strong><br/>
					  <input type="text" class="form-control" id="Bairro" name="Bairro" placeholder="Bairro">
					</div>
				  </div>
                  	 <div class="form-group">
                     
					<div class="col-md-offset-2 col-md-8"><strong>Complemento *:</strong><br/>
					    <input type="text" class="form-control" id="Complemento" name="Complemento" placeholder="Complemento" value="<?php echo $fisica['Complemento']; ?>">
					</div>
				  </div>		
                  				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Cidade *:</strong><br/>
										  <input type="text" class="form-control" id="Cidade" name="Cidade" placeholder="Cidade">

					</div>				  
					<div class=" col-md-6"><strong>Estado *:</strong><br/>
					  <input type="text" class="form-control" id="Estado" name="Estado" placeholder="Estado">
					</div>
				  </div>		  
				  <div class="form-group">
                  					<div class="col-md-offset-2 col-md-6"><strong>E-mail *:</strong><br/>
					<input type="text" class="form-control" id="Email" name="Email" placeholder="E-mail" value="<?php echo $fisica['Email']; ?>" >
					</div>				  


					<div class=" col-md-6"><strong>Telefone #1 *:</strong><br/>

					  <input type="text" class="form-control" id="Telefone1" name="Telefone1" placeholder="Telefone" value="<?php echo $fisica['Telefone1']; ?>">
					</div>

				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #2:</strong><br/>
					  <input type="text" class="form-control" id="Telefone1" name="Telefone2" placeholder="Telefone" value="<?php echo $fisica['Telefone2']; ?>">
					</div>				  
					<div class="col-md-6"><strong>Telefone #3:</strong><br/>
					  <input type="text" class="form-control" id="Telefone2" name="Telefone3" placeholder="Telefone"value="<?php echo $fisica['Telefone3']; ?>" >
					</div>
				  </div>

							  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>DRT:</strong><br/>
					  <input type="text" class="form-control" id="DRT" name="DRT" placeholder="DRT" value="<?php echo $fisica['DRT']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>Função:</strong><br/>
					  <input type="text" class="form-control" id="Funcao" name="Funcao" placeholder="Função" value="<?php echo $fisica['Funcao']; ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Inscrição do INSS ou PIS/PASEP:</strong><br/>
					  <input type="text" class="form-control" id="InscricaoINSS" name="InscricaoINSS" placeholder="Inscrição no INSS ou PIS/PASEP" value="<?php echo $fisica['InscricaoINSS']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>OMB:</strong><br/>
					  <input type="text" class="form-control" id="OMB" name="OMB" placeholder="OMB" value="<?php echo $fisica['OMB']; ?>">
					</div>
				  </div>
				  
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observação:</strong><br/>
					 <textarea name="Observacao" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="cadastrarFisica" value="<?php echo $fisica['Id_PessoaFisica'] ?>" />
                    <?php if(isset($id_pedido)){ ?>
                   <input type="hidden" name="idPedido" value="<?php echo $id_pedido ?>" />
                   <?php } ?>
                    <input type="hidden" name="Sucesso" id="Sucesso" />
					 <input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
				</form>

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
		           <form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoPedido" method="post">
      <input type="hidden" name="idPedido" value="<?php echo $_SESSION['idPedido']; ?>">
      <input type="submit" value="Voltar ao Pedido" class="btn btn-theme btn-block"></a> 
					</form>
					</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                  	  <br />
					</div>
				  </div>		

                <!-- Botão para verificar arquivos da pessoa -->
			  <div class="form-group">
               	<div class="col-md-offset-2 col-md-8">
                <form class="form-horizontal" role="form" action="?perfil=contratados&p=arqexec" method="post">
                    <input type="hidden" name="cadastrarFisica" value="<?php echo $fisica['Id_PessoaFisica'] ?>" />
					<input type="hidden" name="idPedido" value="<?php echo $id_pedido ?>" />
 					<input type="submit" value="Anexos" class="btn btn-theme btn-block">
				</form>
					</div>
                </div>
          
                <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                  	  <br />
					</div>
				  </div>	
    <?php if(isset($id_pedido)){ ?>
                          
                <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    
                     <a href="?perfil=contratados&p=edicaoExecutante&id_pf="><input type="submit" value="Mudar o executante" class="btn btn-theme btn-block"></a>
					</div>
				</div>
                   <?php } ?>

  
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  
<?php
break;
} // fecha a switch

break;

case "arqexec":
?>
<?php
$con = bancoMysqli();
$idPessoa = $_POST["cadastrarFisica"];
$idPedido = $_POST["idPedido"];

if(isset($_POST["enviar"])){


$sql_arquivos = "SELECT * FROM igsis_upload_docs";
$query_arquivos = mysqli_query($con,$sql_arquivos);
while($arq = mysqli_fetch_array($query_arquivos)){ 
	$y = $arq['idTipoDoc'];
	$x = $arq['sigla'];
	$nome_arquivo = $_FILES['arquivo']['name'][$x];
	if($nome_arquivo != ""){
	$nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
    //$ext = strtolower(substr($nome_arquivo[$i],-4)); //Pegando extensão do arquivo
      $new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
	  $hoje = date("Y-m-d H:i:s");
      $dir = '../uploadsdocs/'; //Diretório para uploads
	  
      if(move_uploaded_file($nome_temporario, $dir.$new_name)){
		  
		$sql_insere_arquivo = "INSERT INTO `igsis_arquivos_pessoa` (`idArquivosPessoa`, `idTipoPessoa`, `idPessoa`, `arquivo`, `dataEnvio`, `publicado`, `tipo`) 
		VALUES (NULL, '1', '$idPessoa', '$new_name', '$hoje', '1', '$y'); ";
		$query = mysqli_query($con,$sql_insere_arquivo);
		if($query){
		$mensagem = "Arquivo recebido com sucesso";
		}else{
		$mensagem = "Erro ao gravar no banco";
		}
		
		}else{
		 $mensagem = "Erro no upload"; 
		  
	  }
	}
	
}

}


if(isset($_POST['apagar'])){
	$idArquivo = $_POST['apagar'];
	$sql_apagar_arquivo = "UPDATE igsis_arquivos_pessoa SET publicado = 0 WHERE idArquivosPessoa = '$idArquivo'";
	if(mysqli_query($con,$sql_apagar_arquivo)){
		$arq = recuperaDados("igsis_arquivos_pessoa",$idArquivo,"idArquivosPessoa");
		$mensagem =	"Arquivo ".$arq['arquivo']."apagado com sucesso!";
		gravarLog($sql_apagar_arquivo);
	}else{
		$mensagem = "Erro ao apagar o arquivo. Tente novamente!";
	}
}
$campo = recuperaPessoa($idPessoa,1); 

?>
   
    	 <section id="enviar" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
                                        <h2><?php echo $campo["nome"] ?>  </h2>
                                        <p><?php echo $campo["tipo"] ?></p>
					 <h3>Envio de Arquivos</h3>
                     <p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
<p>Nesta página, você envia documentos digitalizados. O tamanho máximo do arquivo deve ser 60MB.</p>


<br />
<div class = "center">
<form method="POST" action="?<?php echo $_SERVER['QUERY_STRING'] ?>" enctype="multipart/form-data">
<table>
<tr>
<td width="50%"><td>
</tr>
<?php 
$sql_arquivos = "SELECT * FROM igsis_upload_docs ";
$query_arquivos = mysqli_query($con,$sql_arquivos);
while($arq = mysqli_fetch_array($query_arquivos)){ ?>

<tr>	
<td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
</tr>
	
<?php } ?>

  </table>
    <br>
    <input type="hidden" name="cadastrarFisica" value="<?php echo $idPessoa; ?>"  />
    <input type="hidden" name="idPedido" value="<?php echo $_SESSION['idPedido']; ?>"  />
    <input type="hidden" name="tipoPessoa" value="1"  />
    <input type="hidden" name="enviar" value="1"  />
    <input type="submit" class="btn btn-theme btn-lg btn-block" value='Enviar'>
</form>
</div>
<br />
<br />


					</div>
				  </div>
                  
			  </div>
			  
		</div>
	</section>

	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
 <h2>Arquivos anexados</h2>
<h5>Se na lista abaixo, o seu arquivo começar com "http://", por favor, clique, grave em seu computador, faça o upload novamente e apague a ocorrência citada.</h5>
					</div>
			<div class="table-responsive list_info">
				<?php  include "../funcoes/funcoesSiscontrat.php" ?>
			<?php $pag = "contratos"; ?>

                         <?php listaArquivosPessoaSiscontrat($idPessoa,1,$_SESSION['idPedido'],$p,$pag); ?>
                         
			</div>
         
				  </div>
			  </div>  


		</div>
	</section>
	<?php 
break;


case "edicaoGrupo":
if(isset($_GET['action'])){
	$action = $_GET['action'];	
}else{
	$action = "listar";	
	
}


switch($action){

case "listar":
$con = bancoMysqli();
$idPedido = $_POST['idPedido'];


if(isset($_POST['inserir'])){

$nome = trim($_POST['nome']);
$rg = trim($_POST['rg']);
$cpf = $_POST['cpf'];

$sql_inserir = "INSERT INTO `igsis_grupos` (`idGrupos`, `idPedido`, `nomeCompleto`, `rg`, `cpf`, `publicado`) VALUES (NULL, '$idPedido', '$nome', '$rg', '$cpf', '1')";
$query_inserir = mysqli_query($con,$sql_inserir);
if($query_inserir){
		$mensagem = "Integrante inserido com sucesso!";	
	}else{
		$mensagem = "Erro ao inserir integrante. Tente novamente.";	
	
	}	
}

if(isset($_POST['apagar'])){
	$id = $_POST['apagar'];
	$sql_apagar = "UPDATE igsis_grupos SET publicado = '0' WHERE idGrupos = '$id'";
	$query_apagar = mysqli_query($con,$sql_apagar);
	if($query_apagar){
		$mensagem = "Integrante apagado com sucesso!";	
	}else{
		$mensagem = "Erro ao apagar integrante. Tente novamente.";	
		
	}	

}

$sql_grupos = "SELECT * FROM igsis_grupos WHERE idPedido = '$idPedido' and publicado = '1'";
$query_grupos = mysqli_query($con,$sql_grupos);
$num = mysqli_num_rows($query_grupos);

?>


	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Grupos</h2>
					<h4>Integrantes de grupos</h4>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                 </div>
				  </div>
			  </div>  
	
			<?php
			if($num > 0){ 
			 ?>
			<div class="table-responsive list_info">
                  <table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td width='40%'>Nome Completo</td>
							<td>RG</td>
							<td>CPF</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php
					while($grupo = mysqli_fetch_array($query_grupos)){ 
					?>	
					<tr>
					<td><?php echo $grupo['nomeCompleto'] ?></td>
					<td><?php echo $grupo['rg'] ?></td>
					<td><?php echo $grupo['cpf'] ?></td>
					<td class='list_description'>
					<form method='POST' action='?perfil=contratados&p=edicaoGrupo'>
					<input type="hidden" name="apagar" value="<?php echo $grupo['idGrupos'] ?>" />
					<input type="hidden" name="idPedido" value="<?php echo $idPedido; ?>" >					

					<input type ='submit' class='btn btn-theme btn-block' value='apagar'></td></form>
					</tr>					
					<?php
						}
					?>
					
					
					</tbody>
					</table>
			<?php 
			}else{
			?>
                   	<div class="col-md-offset-2 col-md-8">
            		<h3>Não há integrantes de grupos inseridos. <br />
                   			
            	</div> 

			<?php 
			}
			?>


            <div class="col-md-offset-2 col-md-8">
  			<form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoGrupo&action=inserir"  method="post">
			<input type="hidden" name="idPedidoContratacao" value="<?php echo $idPedido; ?>" >
			<input type ='submit' class='btn btn-theme btn-block' value='Inserir integrante'></td></form>
			</form>		
            	        <?php 
			$pedido = recuperaDados("igsis_pedido_contratacao",$idPedido,"idPedidoContratacao");
			?>
			<br />
			<form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoPedido"  method="post">
			<input type="hidden" name="idPedidoContratacao" value="<?php echo $idPedido; ?>" >
			<input type ='submit' class='btn btn-theme btn-block' value='Voltar ao Pedido de Contratação'></td></form>
			</form>		
                
	       
	         </div>
          </div>
				   
			</div>
		</div>
	</section>

<?php 

break;
case "inserir";

?>
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
            
					<h3>CADASTRO DE INTEGRANTE DE GRUPO</h3>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoGrupo&action=listar" method="post">
				  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome completo: *</strong><br/>
					  <input type="text" class="form-control" id="RepresentanteLegal" name="nome" >
					</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>RG: *</strong><br/>
					  <input type="text" class="form-control" id="RG" name="rg" placeholder="RG">
					</div>
					<div class="col-md-6"><strong>CPF: *</strong><br/>
					  <input type="text" class="form-control" id="cpf" name="cpf"  placeholder="CPF">
					</div>
				  </div>
                  
                
                  
                  <!-- Botão Gravar -->	
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<input type="hidden" name="idPedido" value="<?php echo $_POST['idPedidoContratacao']; ?>" >					
					 <input type="submit" name="inserir" value="CADASTRAR" class="btn btn-theme btn-lg btn-block">
					</div>
                    
				  </div>
				</form>
	
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  

<?php }
break;
case "edicaoParcelas":
include "../funcoes/funcoesSiscontrat.php";
$pedido = recuperaDados("igsis_pedido_contratacao",$_SESSION['idPedido'],"idPedidoContratacao");

//verifica se há dados na tabela igsis_parcelas
$idPedido = $_SESSION['idPedido'];
$sql_verifica_parcela = "SELECT * FROM igsis_parcelas WHERE idPedido = '$idPedido'";
$query_verifica_parcela = mysqli_query($con,$sql_verifica_parcela);
$num_parcelas = mysqli_num_rows($query_verifica_parcela);
if($num_parcelas == 0){
	for($i = 1; $i <= 12; $i++){ // se não há, insere 12 parcelas vazias.
		$insert_parcela = "INSERT INTO `igsis_parcelas` (`idParcela`, `idPedido`, `numero`, `valor`, `vencimento`, `publicado`, `descricao`) VALUES (NULL, '$idPedido', '$i', '', NULL, '0', '')";
		mysqli_query($con,$insert_parcela);
	}
}

if(isset($_POST['atualizar'])){
	for($i = 1; $i <= $pedido['parcelas']; $i++){
	$valor = dinheiroDeBr($_POST['valor'.$i]);
	$data = exibirDataMysql($_POST['data'.$i]);
	$descricao = $_POST['descricao'.$i];
	$mensagem = "";
	$sql_atualiza_parcela = "UPDATE igsis_parcelas SET valor = '$valor', vencimento = '$data', descricao = '$descricao' WHERE idPedido = '$idPedido' AND numero = '$i'";
	$query_atualiza_parcela = mysqli_query($con,$sql_atualiza_parcela);
		if($query_atualiza_parcela){
			gravarLog($sql_atualiza_parcela);
			$mensagem = $mensagem." Parcela $i atualizada.<br />"; 
			$soma = somaParcela($idPedido,$pedido['parcelas']);
			$sql_atualiza_valor = "UPDATE igsis_pedido_contratacao SET valor = '$soma' WHERE idPedidoContratacao = '$idPedido'";
			$query_atualiza_valor = mysqli_query($con,$sql_atualiza_valor);
			if($query_atualiza_valor){
				gravarLog($sql_atualiza_valor);
				$mensagem = $mensagem." Valor total atualizado. ";	
			}
			
		}else{
			$mensagem = $mensagem."Erro ao atualizar parcela $i.<br />"; 	

		}
	}

	
}



?>

	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h2>PEDIDO DE CONTRATAÇÃO <?php if($pedido['tipoPessoa'] == 1){echo "PESSOA FÍSICA";}else{echo "PESSOA JURÍDICA";} ?> </h2>
                        <h5>Edição de parcelas</h5>

                    <p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">
                
                				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <p class="left">
                    	<?php $evento = recuperaEvento($_SESSION['idEvento']); ?>

                    </p>
					</div>
                  </div>

				<form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoParcelas" method="post">

				<?php
				$soma = 0;
				for($i = 1; $i <= $pedido['parcelas']; $i++){
				$sql_rec_parcela = "SELECT * FROM igsis_parcelas WHERE idPedido = '$idPedido' AND numero = '$i'";
				$query_rec_parcela = mysqli_query($con,$sql_rec_parcela);
				$parcela = mysqli_fetch_array($query_rec_parcela);
				 ?>

                  <div class="form-group">
					<div class="col-xs-6 col-sm-1"><strong>Parcela</strong><br/>
					  <input type='text' disabled name="Valor" id='valor' class='form-control' value="<?php echo $i; ?>" >
					</div>					
                    <div class="col-xs-6 col-sm-3"><strong>Valor</strong><br/>
					  <input type='text'  name="valor<?php echo $i; ?>" id='valor' class='form-control valor' value="<?php echo dinheiroParaBr($parcela['valor']); ?>">
					</div>
                    
                    <div class="col-xs-6 col-sm-3"><strong>Data:</strong><br/>
					  <input type='text' name="data<?php echo $i; ?>" id='' class='form-control datepicker' value="<?php 
					  if($parcela['vencimento'] == '0000-00-00 00:00:00' OR $parcela['vencimento'] == NULL){ 
					  echo date('d/m/Y');
					  }else{
					  echo exibirDataBr($parcela['vencimento']); 
					  } 
					  ?>">
					</div>
                    <div class="col-xs-6 col-sm-3"><strong>Descrição:</strong><br/>
					  <input type='text'  name="descricao<?php echo $i; ?>" id='' class='form-control' value="<?php echo $parcela['descricao']; ?>">
					</div>

				  </div>

                  <?php 
				  $soma = $soma + $parcela['valor'];
				  } ?>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<p><?php echo "A soma das parcelas é: ".dinheiroParaBr($soma); ?></p>
                    <p><?php echo "O valor total do contrato é: ".dinheiroParaBr($pedido['valor']); ?></p>
					</div>
                    
				  </div>	
                  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="atualizar" value="1" />
                    <input type="hidden" name="idPedidoContratacao" value="<?php echo $_SESSION['idPedido']; ?>" />
					 <input type="image" alt="GRAVAR" name="GRAVAR" value="submit" class="btn btn-theme btn-lg btn-block">
					</div>
                    
				  </div>
				</form>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <a href="?perfil=contratados&p=edicaoPedido" value="VOLTAR" class="btn btn-theme btn-lg btn-block">VOLTAR para area de pedidos de contratação</a>
					</div>
                    
				  </div>	
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  

<?php 
break;
case "edicaoVerbas":
include "../funcoes/funcoesSiscontrat.php";
$pedido = recuperaDados("igsis_pedido_contratacao",$_SESSION['idPedido'],"idPedidoContratacao");

//verifica se há dados na tabela igsis_parcelas
$idPedido = $_SESSION['idPedido'];
$pedido = recuperaDados("igsis_pedido_contratacao",$idPedido,"idPedidoContratacao");
$idVerba = $pedido['idVerba'];
$sql_verifica_parcela = "SELECT * FROM sis_verbas_multiplas WHERE idPedidoContratacao = '$idPedido'";
$query_verifica_parcela = mysqli_query($con,$sql_verifica_parcela);
$num_parcelas = mysqli_num_rows($query_verifica_parcela);
if($num_parcelas == 0){
	$idInstituicao = $_SESSION['idInstituicao'];
	$sql_verbas = "SELECT * FROM sis_verba WHERE Idinstituicao = '$idInstituicao' AND pai IS NOT NULL AND multiplo IS NULL";
	$query_verbas = mysqli_query($con,$sql_verbas);
	while($campo = mysqli_fetch_array($query_verbas)){
		$verba = $campo['Id_Verba']; 
		$insert_parcela = "INSERT INTO `sis_verbas_multiplas` (`idMultiplas`, `idPedidoContratacao`, `idVerba`, `valor`) VALUES (NULL, '$idPedido', '$verba', '');";
		mysqli_query($con,$insert_parcela);
	}
}



if(isset($_POST['atualizar'])){
	$idPedido = $_SESSION['idPedido'];
	$sql_verbas = "SELECT * FROM sis_verbas_multiplas WHERE idPedidoContratacao = '$idPedido'";
	$query_verbas = mysqli_query($con,$sql_verbas);
	while($campo = mysqli_fetch_array($query_verbas)){
		$id = $campo['idMultiplas'];
		$valor = dinheiroDeBr($_POST[$id]);
		$sql_atualiza_verba = "UPDATE sis_verbas_multiplas SET valor = '$valor' WHERE idMultiplas = '$id'";
		$query_atualiza_verba = mysqli_query($con,$sql_atualiza_verba);
		if($query_atualiza_verba){
			$soma = somaVerbas($idPedido);
			gravarLog($sql_atualiza_verba);
			$sql_atualiza_valor = "UPDATE igsis_pedido_contratacao SET valor = '$soma' WHERE idPedidoContratacao = '$idPedido'";
			$query_atualiza_valor = mysqli_query($con,$sql_atualiza_valor);

			$mensagem = "Valores atualizados";	
		}else{
			$mensagem = "Erro ao atualizar valores"; 	
		}		
	}

	
}



?>

	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
                        <h5>Edição de verbas</h5>

                    <p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">
                
                				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <p class="left">
                    	<?php $evento = recuperaEvento($_SESSION['idEvento']); ?>

                    </p>
					</div>
                  </div>

				<form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoVerbas" method="post">

				<?php
				$soma = 0;
				$idPedido = $_SESSION['idPedido'];
				$sql_recupera_verbas = "SELECT * FROM sis_verbas_multiplas WHERE idPedidoContratacao = '$idPedido'";
				$query_recupera_verbas = mysqli_query($con,$sql_recupera_verbas);
				while($campo_verba = mysqli_fetch_array($query_recupera_verbas)){
					$nome_verba = recuperaDados("sis_verba",$campo_verba['idVerba'],"Id_Verba");
				 ?>
				
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Verba</strong><br/>
					<p><?php echo $nome_verba['Verba']; ?></p>
					</div>					
                    <div class="col-md-3"><strong>Valor</strong><br/>
					  <input type='text'  name="<?php echo $campo_verba['idMultiplas'];?>" id='valor' class='form-control valor' value="<?php echo dinheiroParaBr($campo_verba['valor']);?>">
					</div>

				  </div>

                  <?php 
				  } ?>

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <p><?php echo "O valor total do contrato é: ".dinheiroParaBr(somaVerbas($idPedido)); ?></p>
					</div>
                    
				  </div>	
                  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="atualizar" value="1" />
                    <input type="hidden" name="idPedidoContratacao" value="<?php echo $_SESSION['idPedido']; ?>" />
					 <input type="image" alt="GRAVAR" name="GRAVAR" value="submit" class="btn btn-theme btn-lg btn-block">
					</div>
                    
				  </div>
				</form>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <a href="?perfil=contratados&p=edicaoPedido" value="VOLTAR" class="btn btn-theme btn-lg btn-block">VOLTAR para area de pedidos de contratação</a>
					</div>
                    
				  </div>	
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  

<?php 
break;
case "edicaoPessoa":

if(isset($_POST['cadastraRepresentante'])){
	$n = $_SESSION['numero'];
	if($n == 1){
		$campoRepresentante = "IdRepresentanteLegal1";
	}else{
		$campoRepresentante = "IdRepresentanteLegal2";
		
	}
	$representante = addslashes($_POST['RepresentanteLegal']);
	$rg = $_POST['RG'];
	$cpf = $_POST['CPF'];
	$nacionalidade = $_POST['Nacionalidade'];
	$estado_civil = $_POST['IdEstadoCivil'];
	$idPessoaJuridica = $_SESSION['idPessoaJuridica'];
	$sql_insere_representante =  "INSERT INTO `sis_representante_legal` (`Id_RepresentanteLegal`, `RepresentanteLegal`, `RG`, `CPF`, `Nacionalidade`, `IdEstadoCivil`, `idEvento`) VALUES (NULL, '$representante', '$rg', '$cpf', '$nacionalidade', '$estado_civil', NULL)";
	$con = bancoMysqli();
	$query_insere_representante = mysqli_query($con,$sql_insere_representante);
	if($query_insere_representante){
		$ultimo = recuperaUltimo("sis_representante_legal");
		$sql_atualiza_representante = "UPDATE sis_pessoa_juridica SET $campoRepresentante = '$ultimo' WHERE Id_PessoaJuridica = '$idPessoaJuridica'";

		$query_atualiza_representante = mysqli_query($con,$sql_atualiza_representante);
		if($query_atualiza_representante){
			gravarLog($sql_atualiza_representante);
			$mensagem = "Represenante legal 0".$n." atualizado com sucesso!";
		}else{
			$mensagem = "Erro(1)";
		}
		
	}else{
		$mensagem = "Erro(2)";		
	}

}



if(isset($_POST['insereRepresentante'])){
	$n = $_SESSION['numero'];
	$idRepresentante = $_POST['idPessoa'];
	$idPessoaJuridica = $_SESSION['idPessoaJuridica'];
	if($n == 1){
		$campoRepresentante = "IdRepresentanteLegal1";
	}else{
		$campoRepresentante = "IdRepresentanteLegal2";
		
	}
	$sql_atualiza_representante = "UPDATE sis_pessoa_juridica SET $campoRepresentante = '$idRepresentante' WHERE Id_PessoaJuridica = '$idPessoaJuridica' "; 	
	$query_atualiza_representante = mysqli_query($con,$sql_atualiza_representante);
	if($query_atualiza_representante){
		gravarLog($sql_atualiza_representante);
		$mensagem = "Representante legal inserido.";
		
	}else{
		$mensagem = "Erro ao inserir representante legal.";	
	}
}


	if(isset($_POST['cadastrarFisica'])){
		$idPessoaFisica = $_POST['cadastrarFisica'];
		$Nome = addslashes($_POST['Nome']);
		$NomeArtistico = addslashes($_POST['NomeArtistico']);
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
		$Funcao = $_POST['Funcao'];
		$InscricaoINSS = $_POST['InscricaoINSS'];
		$OMB = $_POST['OMB'];
		$Observacao = addslashes($_POST['Observacao']);
		$tipoDocumento = $_POST['tipoDocumento'];
		$Pis = 0;
		$data = date('Y-m-d');
		$idUsuario = $_SESSION['idUsuario'];
		
		$codBanco = $_POST['codBanco'];
		$agencia = $_POST['agencia'];
		$conta = $_POST['conta'];

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

		`codBanco` = '$codBanco', 
		`agencia` = '$agencia', 
		`conta` = '$conta', 
		

		`Numero` = '$Numero', 
		`Complemento` = '$Complemento', 
		`Telefone1` = '$Telefone1', 
		`Telefone2` = '$Telefone2',  
		`Telefone3` = '$Telefone3', 
		`Email` = '$Email', 
		`DRT` = '$DRT', 
		`Funcao` = '$Funcao', 
		`InscricaoINSS` = '$InscricaoINSS', 
		`Pis` = '$Pis', 
		`OMB` = '$OMB', 
		`DataAtualizacao` = '$data', 
		`Observacao` = '$Observacao', 
		`IdUsuario` = '$idUsuario', 
		`tipoDocumento` = '$tipoDocumento' 
		WHERE `Id_PessoaFisica` = '$idPessoaFisica'";	
		
		if(mysqli_query($con,$sql_atualizar_pessoa)){
			gravarLog($sql_atualizar_pessoa);
			$mensagem = "Atualizado com sucesso!";	
		}else{
			$mensagem = "Erro ao atualizar! Tente novamente.";
		}
		
	}

		if(isset($_POST['editaJuridica'])){
		$idJuridica = $_POST['editaJuridica'];
		$RazaoSocial = addslashes($_POST['RazaoSocial']);
		$CNPJ = $_POST['CNPJ'];
		$CCM = $_POST['CCM'];
		$CEP = $_POST['CEP'];
		$Numero = $_POST['Numero'];
		$Complemento = $_POST['Complemento'];
		$Telefone1 = $_POST['Telefone1'];
		$Telefone2 = $_POST['Telefone2'];
		$Telefone3 = $_POST['Telefone3'];
		$Email = $_POST['Email'];
		//$IdRepresentanteLegal1 = $_POST['IdRepresentanteLegal1'];
		//$IdRepresentanteLegal2 = $_POST['IdRepresentanteLegal2'];
		$Observacao = $_POST['Observacao'];
		$data = date("Y-m-d");
		$idUsuario = $_SESSION['idUsuario'];
		
		$codBanco = $_POST['codBanco'];
		$agencia = $_POST['agencia'];
		$conta = $_POST['conta'];
		
		$sql_atualizar_juridica = "UPDATE `sis_pessoa_juridica` SET `RazaoSocial` = '$RazaoSocial', `CNPJ` = '$CNPJ', `CCM` = '$CCM', `CEP` = '$CEP', `Numero` = '$Numero', `Complemento` = '$Complemento', `Telefone1` = '$Telefone1', `Telefone2` = '$Telefone2', `Telefone3` = '$Telefone3', `Email` = '$Email', `DataAtualizacao` = '$data', `Observacao` = '$Observacao', `codBanco` = '$codBanco', 
		`agencia` = '$agencia', 
		`conta` = '$conta'  WHERE `sis_pessoa_juridica`.`Id_PessoaJuridica` = '$idJuridica';";
				if(mysqli_query($con,$sql_atualizar_juridica)){
			$mensagem = "Atualizado com sucesso!";	
			gravarLog($sql_atualizar_juridica);
		}else{
			$mensagem = "Erro ao atualizar! Tente novamente.";
		}
		
		
		
		}


	if($_SESSION['idPessoaJuridica'] != NULL){
		$pedido['tipoPessoa'] = 2;
		$pedido['idPessoa'] = $_SESSION['idPessoaJuridica'];	
	}else{
		$idPedidoContratacao = $_POST['idPedidoContratacao'];
		$pedido = recuperaDados("igsis_pedido_contratacao",$idPedidoContratacao,"idPedidoContratacao");
		
	}

	switch($pedido['tipoPessoa']){
	
	case 1:
	$fisica = recuperaDados("sis_pessoa_fisica",$pedido['idPessoa'],"Id_PessoaFisica");
	 ?>
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>CADASTRO DE PESSOA FÍSICA</h3>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                                        </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoPessoa" method="post">
				  
			 
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="Nome" placeholder="Nome" value="<?php echo $fisica['Nome']; ?>" >
					</div>
				  </div>

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome Artístico:</strong><br/>
					  <input type="text" class="form-control" id="NomeArtistico" name="NomeArtistico" placeholder="Nome Artístico" value="<?php echo $fisica['NomeArtistico']; ?>">
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
                      <input type="text" class="form-control" id="RG" name="RG" placeholder="Documento" value="<?php echo $fisica['RG']; ?>">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>CPF *:</strong><br/>
					  <input type="text" class="form-control" id="cpf" name="CPF" placeholder="CPF" value="<?php echo $fisica['CPF']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>CCM *:</strong><br/>
					  <input type="text" class="form-control" id="CCM" name="CCM" placeholder="CCM" value="<?php echo $fisica['CCM']; ?>" >
					</div>
				  </div>

				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Estado civil:</strong><br/>
					  <select class="form-control" id="IdEstadoCivil" name="IdEstadoCivil" >
					   <?php
						geraOpcao("sis_estado_civil",$fisica['IdEstadoCivil'],"");
						?>  
					  </select>
					</div>				  
					<div class=" col-md-6"><strong>Data de nascimento:</strong><br/>
 <input type="text" class="form-control" id="datepicker01" name="DataNascimento" placeholder="Data de Nascimento" value="<?php echo exibirDataBr($fisica['DataNascimento']); ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Nacionalidade:</strong><br/>
					   <input type="text" class="form-control" id="Nacionalidade" name="Nacionalidade" placeholder="Nacionalidade" value="<?php echo $fisica['Nacionalidade']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>CEP:</strong><br/>
					 					  <input type="text" class="form-control" id="CEP" name="CEP" placeholder="CEP" value="<?php echo $fisica['CEP']; ?>">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Endereço *:</strong><br/>
					  <input type="text" class="form-control" id="Endereco" name="Endereco" placeholder="Endereço">
					</div>
				  </div>
                  				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
					  <input type="text" class="form-control" id="Numero" name="Numero" placeholder="Numero" value="<?php echo $fisica['Numero']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>Bairro:</strong><br/>
					  <input type="text" class="form-control" id="Bairro" name="Bairro" placeholder="Bairro">
					</div>
				  </div>
                  	 <div class="form-group">
                     
					<div class="col-md-offset-2 col-md-8"><strong>Complemento *:</strong><br/>
					    <input type="text" class="form-control" id="Complemento" name="Complemento" placeholder="Complemento" value="<?php echo $fisica['Complemento']; ?>">
					</div>
				  </div>		
                  				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Cidade *:</strong><br/>
										  <input type="text" class="form-control" id="Cidade" name="Cidade" placeholder="Cidade">

					</div>				  
					<div class=" col-md-6"><strong>Estado *:</strong><br/>
					  <input type="text" class="form-control" id="Estado" name="Estado" placeholder="Estado">
					</div>
				  </div>		  
				  <div class="form-group">
                  					<div class="col-md-offset-2 col-md-6"><strong>E-mail *:</strong><br/>
					<input type="text" class="form-control" id="Email" name="Email" placeholder="E-mail" value="<?php echo $fisica['Email']; ?>" >
					</div>				  


					<div class=" col-md-6"><strong>Telefone #1 *:</strong><br/>

					  <input type="text" class="form-control" id="Telefone1" name="Telefone1" placeholder="Telefone" value="<?php echo $fisica['Telefone1']; ?>">
					</div>

				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #2:</strong><br/>
					  <input type="text" class="form-control" id="Telefone1" name="Telefone2" placeholder="Telefone" value="<?php echo $fisica['Telefone2']; ?>">
					</div>				  
					<div class="col-md-6"><strong>Telefone #3:</strong><br/>
					  <input type="text" class="form-control" id="Telefone2" name="Telefone3" placeholder="Telefone"value="<?php echo $fisica['Telefone3']; ?>" >
					</div>
				  </div>

							  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>DRT:</strong><br/>
					  <input type="text" class="form-control" id="DRT" name="DRT" placeholder="DRT" value="<?php echo $fisica['DRT']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>Função:</strong><br/>
					  <input type="text" class="form-control" id="Funcao" name="Funcao" placeholder="Função" value="<?php echo $fisica['Funcao']; ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Inscrição do INSS ou PIS/PASEP:</strong><br/>
					  <input type="text" class="form-control" id="InscricaoINSS" name="InscricaoINSS" placeholder="Inscrição no INSS ou PIS/PASEP" value="<?php echo $fisica['InscricaoINSS']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>OMB:</strong><br/>
					  <input type="text" class="form-control" id="OMB" name="OMB" placeholder="OMB" value="<?php echo $fisica['OMB']; ?>">
					</div>
				  </div>
                  
                  <!-- Dados Bancários -->
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
					  <input type="text" class="form-control" id="agencia" name="agencia" placeholder="" value="<?php echo $fisica['agencia']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>Conta:</strong><br/>
					  <input type="text" class="form-control" id="conta" name="conta" placeholder="" value="<?php echo $fisica['conta']; ?>">
					</div>
				  </div> 
				  
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observação:</strong><br/>
					 <textarea name="Observacao" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="cadastrarFisica" value="<?php echo $fisica['Id_PessoaFisica'] ?>" />
                   <input type="hidden" name="idPedidoContratacao" value="<?php echo $_POST['idPedidoContratacao'] ?>" />
                    <input type="hidden" name="Sucesso" id="Sucesso" />
					 <input type="image" alt="GRAVAR" value="submit" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
				</form>
	
    
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  

	<?php
	break;
	case 2: 
		
		$_SESSION['idPessoaJuridica'] = $pedido['idPessoa'];
		$juridica = recuperaDados("sis_pessoa_juridica",$pedido['idPessoa'],"Id_PessoaJuridica");
	?>
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>CADASTRO DE PESSOA JURÍDICA</h3>
                                        <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">
                
                
                				                      <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Representante legal #01:</strong><br/>
					  <form class="form-horizontal" role="form"  method="post" action="?perfil=contratados&p=representante&action=edita">
					  
                      <input type='text' readonly class='form-control' name='representante01' id='Executante' value="<?php $nome1 = recuperaPessoa($juridica['IdRepresentanteLegal1'],3); echo $nome1['nome']; ?>">  
                      <input type="hidden" name="numero" value="1" />
                      <input type="hidden" name="idPessoa" value="<?php echo $juridica['IdRepresentanteLegal1'] ?>" /> 
                      <input type="hidden" name="idPessoaJuridica" value="<?php echo $juridica['Id_PessoaJuridica'] ?>" />                     
					 <input type="submit" class="btn btn-theme btn-med btn-block" value="Abrir Representante legal #01">
                     </form>

					</div>
				  </div>
					<div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                    <br />
	                </div>
					</div>



                                      <div class="form-group"> 
					<div class="col-md-offset-2 col-md-8"><strong>Representante legal #02:</strong><br/>
					         	
                    </div>
                  </div>  
                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <form class="form-horizontal" role="form"  method="post" action="?perfil=contratados&p=representante&action=edita">
                         <input type="hidden" name="numero" value="2" />
                      <input type="hidden" name="idPessoa" value="<?php echo $juridica['IdRepresentanteLegal2'] ?>" />
                       <input type="hidden" name="idPessoaJuridica" value="<?php echo $juridica['Id_PessoaJuridica'] ?>" />           											
                    <input type='text' readonly class='form-control' name='representante02' id='Executante' value="<?php $nome2 = recuperaPessoa($juridica['IdRepresentanteLegal2'],3); echo $nome2['nome']; ?>">              
					 <input type="submit" class="btn btn-theme btn-med btn-block" value="Abrir Representante legal #02">
                     </form>

					</div>
					  <div class="form-group">
					  <div class="col-md-offset-2 col-md-8">
				<br />
				<br />	
				</div>
                </div>

				<form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoPessoa" method="post">
				  
			  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Razão Social:</strong><br/>
					  <input type="text" class="form-control" id="RazaoSocial" name="RazaoSocial" placeholder="RazaoSocial" value="<?php echo $juridica['RazaoSocial']; ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>CNPJ:</strong><br/>
					  <input type="text" class="form-control" id="CNPJ" name="CNPJ" placeholder="CNPJ" value="<?php echo $juridica['CNPJ']; ?>" >
					</div>
					<div class="col-md-6"><strong>CCM:</strong><br/>
					  <input type="text" class="form-control" id="CCM" name="CCM" placeholder="CCM" value="<?php echo $juridica['CCM']; ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
                  					<div class="col-md-offset-2 col-md-6"><strong>CEP *:</strong><br/>
					  <input type="text" class="form-control" id="CEP" name="CEP" placeholder="CEP" value="<?php echo $juridica['CEP']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>Estado *:</strong><br/>
					  <input type="text" class="form-control" id="Estado" name="Estado" placeholder="Estado">
					</div>

				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Endereço *:</strong><br/>
					  <input type="text" class="form-control" id="Endereco" name="Endereco" placeholder="Endereço">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
					  <input type="text" class="form-control" id="Numero" name="Numero" placeholder="Numero" value="<?php echo $juridica['Numero']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>Complemento:</strong><br/>
					  <input type="text" class="form-control" id="Complemento" name="Complemento" placeholder="Complemento" value="<?php echo $juridica['Complemento']; ?>">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Bairro *:</strong><br/>
					  <input type="text" class="form-control" id="Bairro" name="Bairro" placeholder="Bairro">
					</div>				  
					<div class=" col-md-6"><strong>Cidade *:</strong><br/>
					  <input type="text" class="form-control" id="Cidade" name="Cidade" placeholder="Cidade">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone:</strong><br/>
					  <input type="text" class="form-control" id="Telefone1" name="Telefone1" placeholder="Telefone" value="<?php echo $juridica['Telefone1']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>Telefone:</strong><br/>
					  <input type="text" class="form-control" id="Telefone2" name="Telefone2" placeholder="Telefone" value="<?php echo $juridica['Telefone2']; ?>" >
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone:</strong><br/>
					  <input type="text" class="form-control" id="Telefone3" name="Telefone3" placeholder="Telefone" value="<?php echo $juridica['Telefone3']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>E-mail:</strong><br/>
					  <input type="text" class="form-control" id="Email" name="Email" placeholder="E-mail" value="<?php echo $juridica['Email']; ?>">
					</div>
				  </div>
				  
				  </div>
                  
                  <!-- Dados Bancários -->
                                   <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Banco:</strong><br/>
					 <select class="form-control" name="codBanco" id="codBanco">
 					<option></option>
                     <option value='32'>Banco do Brasil S.A.</option>
					<?php
					
					geraOpcao("igsis_bancos",$juridica['codBanco'],"");
					
					 ?>
                     </select>
					</div>
				  </div> 
                  
                 				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Agência</strong><br/>
					  <input type="text" class="form-control" id="agencia" name="agencia" placeholder="" value="<?php echo $juridica['agencia']; ?>">
					</div>				  
					<div class=" col-md-6"><strong>Conta:</strong><br/>
					  <input type="text" class="form-control" id="conta" name="conta" placeholder="" value="<?php echo $juridica['conta']; ?>">
					</div>
				  </div>                   
					<div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                    	<br />
                </div>
                    	<br />
					</div>
		  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observações:</strong><br/>
					 <textarea name="Observacao" class="form-control" rows="10" placeholder=""><?php echo $juridica['Observacao']; ?></textarea>
					</div>
				  </div>
				  
				  					<div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                    	<br />
                </div>
                    	<br />
					</div>
				<!-- Botão Gravar -->	
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                     <input type="hidden" name="editaJuridica" value="<?php echo $juridica['Id_PessoaJuridica'] ?>" />
                     
					 <input type="image" alt="GRAVAR" value="submit" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
				</form>
	
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  
      
	<?php
	break;
	case 3: ?>
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
            
					<h3>CADASTRO DE REPRESENTANTE LEGAL</h3>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=contratados&p=edicaoPessoa" method="post">
				  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <input type="text" class="form-control" id="RepresentanteLegal" name="RepresentanteLegal" placeholder="Representante Legal">
					</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6">
					  <input type="text" class="form-control" id="RG" name="RG" placeholder="RG">
					</div>
					<div class="col-md-6">
					  <input type="text" class="form-control" id="cpf" name="CPF" placeholder="CPF">
					</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6">
					  <input type="text" class="form-control" id="Nacionalidade" name="Nacionalidade" placeholder="Nacionalidade">
					</div>
					<div class="col-md-6">
					  <select class="form-control" name="IdEstadoCivil" id="IdEstadoCivil"><option>Estado Civil</option>
                      <?php
					  geraOpcao("sis_estado_civil","","");
					  ?>  
                      </select>
					</div>
				  </div>
                  
                  <!-- Botão Gravar -->	
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="cadastrarRepresentante" value="1" />
					 <input type="image" name="enviar" alt="CADASTRAR" value="submit" class="btn btn-theme btn-lg btn-block">
					</div>
                    
				  </div>
				</form>
	
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  

    
    
    <?php
	break;
	}

?>




<?php
break;
case "arquivos":
$idPessoa = $_REQUEST['idPessoa'];
$tipoPessoa = $_REQUEST['tipoPessoa'];

$mensagem = $idPessoa." - ".$tipoPessoa;

if(isset($_POST["enviar"])){

$sql_arquivos = "SELECT * FROM igsis_upload_docs";
$query_arquivos = mysqli_query($con,$sql_arquivos);
while($arq = mysqli_fetch_array($query_arquivos)){ 
	$y = $arq['idTipoDoc'];
	$x = $arq['sigla'];
	$nome_arquivo = $_FILES['arquivo']['name'][$x];
	if($nome_arquivo != ""){
	$nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
    //$ext = strtolower(substr($nome_arquivo[$i],-4)); //Pegando extensão do arquivo
      $new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
	  $hoje = date("Y-m-d H:i:s");
      $dir = '../uploadsdocs/'; //Diretório para uploads
	  
      if(move_uploaded_file($nome_temporario, $dir.$new_name)){
		  
		$sql_insere_arquivo = "INSERT INTO `igsis_arquivos_pessoa` (`idArquivosPessoa`, `idTipoPessoa`, `idPessoa`, `arquivo`, `dataEnvio`, `publicado`, `tipo`) 
		VALUES (NULL, '$tipoPessoa', '$idPessoa', '$new_name', '$hoje', '1', '$y'); ";
		$query = mysqli_query($con,$sql_insere_arquivo);
		if($query){
		$mensagem = "Arquivo recebido com sucesso";
		}else{
		$mensagem = "Erro ao gravar no banco";
		}
		
		}else{
		 $mensagem = "Erro no upload"; 
		  
	  }
	}
	
}

}


if(isset($_POST['apagar'])){
	$idArquivo = $_POST['apagar'];
	$sql_apagar_arquivo = "UPDATE igsis_arquivos_pessoa SET publicado = 0 WHERE idArquivosPessoa = '$idArquivo'";
	if(mysqli_query($con,$sql_apagar_arquivo)){
		$arq = recuperaDados("igsis_arquivos_pessoa",$idArquivo,"idArquivosPessoa");
		$mensagem =	"Arquivo ".$arq['arquivo']."apagado com sucesso!";
		gravarLog($sql_apagar_arquivo);
	}else{
		$mensagem = "Erro ao apagar o arquivo. Tente novamente!";
	}
}
$campo = recuperaPessoa($_REQUEST['idPessoa'],$_REQUEST['tipoPessoa']); 
?>
    
    	 <section id="enviar" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
                                        <h2><?php echo $campo["nome"] ?>  </h2>
                                        <p><?php echo $campo["tipo"] ?></p>
					 <h3>Envio de Arquivos</h3>
                     <p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
<p>Nesta página, você envia documentos digitalizados. O tamanho máximo do arquivo deve ser 60MB.</p>


<br />
<div class = "center">
<form method="POST" action="?perfil=contratados&p=arquivos&idPessoa=<?php echo $_REQUEST['idPessoa']; ?>&tipoPessoa=<?php echo $_REQUEST['tipoPessoa']; ?>" enctype="multipart/form-data">
<table>
<tr>
<td width="50%"><td>
</tr>
<?php 
$sql_arquivos = "SELECT * FROM igsis_upload_docs";
$query_arquivos = mysqli_query($con,$sql_arquivos);
while($arq = mysqli_fetch_array($query_arquivos)){ ?>

<tr>
<td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
</tr>
	
<?php } ?>

  </table>
    <br>
    <input type="hidden" name="idPessoa" value="<?php echo $_REQUEST['idPessoa']; ?>"  />
    <input type="hidden" name="tipoPessoa" value="<?php echo $_REQUEST['tipoPessoa']; ?>"  />
    <input type="hidden" name="enviar" value="1"  />
    <input type="submit" class="btn btn-theme btn-lg btn-block" value='Enviar'>
</form>
</div>


					</div>
				  </div>
                  
			  </div>
			  
		</div>
	</section>

	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
 <h2>Arquivos anexados</h2>
<h5>Se na lista abaixo, o seu arquivo começar com "http://", por favor, clique, grave em seu computador, faça o upload novamente e apague a ocorrência citada.</h5>
					</div>
			<div class="table-responsive list_info">
                         <?php listaArquivosPessoa($_POST['idPessoa'],$_POST['tipoPessoa']); ?>
			</div>
				  </div>
			  </div>  


		</div>
	</section>


<?php
break;

} //fim da switch ?>
