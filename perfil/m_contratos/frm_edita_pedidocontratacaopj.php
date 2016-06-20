<?php 

$con = bancoMysqli();

$_SESSION['idPedido'] = $_GET['id_ped'];
$id_ped = $_GET['id_ped'];

$server = "http://".$_SERVER['SERVER_NAME']."/igsisbeta/";
$http = $server."/pdf/";
$link1=$http."rlt_pedido_contratacao_pf.php";
$link2=$http."rlt_evento_pf.php";


$ano=date('Y');



if(isset($_POST['insereExecutante'])){ //insere IdExecutante
	$id_executante = $_POST['insereExecutante'];
	$idPedido = $_SESSION['idPedido'];
	$sql_atualiza_executante = "UPDATE `igsis_pedido_contratacao` SET `IdExecutante` = '$id_executante' 
	WHERE `idPedidoContratacao` = '$idPedido';";
	$query_atualiza_executante = mysqli_query($con,$sql_atualiza_executante);	
	if($query_atualiza_executante){
		$mensagem = "Executante inserido com sucesso!";	
	}
}

if(isset($_POST['cadastraExecutante'])){
	$cpf = $_POST['CPF'];
	$verificaCPF = verificaExiste("sis_pessoa_fisica","CPF",$cpf,"");
	if($verificaCPF['numero'] > 0){ //verifica se o cpf já existe
		$mensagem = "O CPF já consta no sistema. Faça uma busca e insira diretamente.";
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
		$sql_insert_pf = "INSERT INTO `sis_pessoa_fisica` (`Id_PessoaFisica`, `Foto`, `Nome`, `NomeArtistico`, `RG`, `CPF`, `CCM`, `IdEstadoCivil`, `DataNascimento`, `LocalNascimento`, `Nacionalidade`, `CEP`, `Numero`, `Complemento`, `Telefone1`, `Telefone2`, `Telefone3`, `Email`, `DRT`, `Funcao`, `InscricaoINSS`, `Pis`, `OMB`, `DataAtualizacao`, `Observacao`, `IdUsuario`) VALUES (NULL, NULL, '$Nome', '$NomeArtistico', '$RG', '$CPF', '$CCM', '$IdEstadoCivil', '$DataNascimento', NULL, '$Nacionalidade', '$CEP', '$Numero', '$Complemento', '$Telefone1', '$Telefone2', '$Telefone3', '$Email', '$DRT', '$Funcao', '$InscricaoINSS', '$Pis', '$OMB', '$data', '$Observacao', '$idUsuario');";
		$query_insert_pf = mysqli_query($con,$sql_insert_pf);
		if($query_insert_pf){
			gravarLog($sql_insert_pf);
			$sql_ultimo = "SELECT * FROM sis_pessoa_fisica ORDER BY Id_PessoaFisica DESC LIMIT 0,1"; //recupera ultimo id
			$id_evento = mysqli_query($con,$sql_ultimo);
			$id = mysqli_fetch_array($id_evento);
			$idFisica = $id['Id_PessoaFisica'];
			$idPedido = $_SESSION['idPedido'];
			$sql_insert_pedido = "UPDATE `igsis_pedido_contratacao` SET `IdExecutante` = '$idFisica' 
	WHERE `idPedidoContratacao` = '$idPedido';";
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

if(isset($_POST['idContrato'])){
	$con = bancoMysqli();
	$idContratos = $_POST['contratos'];
	$idPedido = $_POST['idContrato'];
	$sql_atualiza_contratos = "UPDATE igsis_pedido_contratacao SET idContratos = '$idContratos' WHERE idPedidoContratacao = '$idPedido'";
	$query_atualiza_contratos = mysqli_query($con,$sql_atualiza_contratos);
	if($query_atualiza_contratos){
		$mensagem = "Responsável por contrato atualizado.";
	}else{
		$mensagem = "Erro.";
	}
	
}


if(isset($_POST['atualizar'])){ // atualiza o pedido
	$con = bancoMysqli();
	$ped = $_GET['id_ped'];
	//$valor_individual = dinheiroDeBr($_POST['ValorIndividual']);

	//$verba = $_POST['Verba'];
	$justificativa = addslashes($_POST['Justificativa']);
	$fiscal = $_POST['Fiscal'];
	$suplente  = $_POST['Suplente'];
	$parecer = addslashes($_POST['ParecerTecnico']);
	$observacao = addslashes($_POST['Observacao']);
	$parcelas = $_POST['parcelas'];

if($_POST['atualizar'] > '1'){

	$sql_atualiza_pedido = "UPDATE igsis_pedido_contratacao SET
		valorIndividual = '$valor_individual',
		`parcelas` =  '$parcelas',
		justificativa = '$justificativa',
		estado = 'Análise do Pedido',
		observacao = '$observacao',
		parecerArtistico = '$parecer'
		WHERE idPedidoContratacao = '$ped'";
	$query_atualiza_pedido = mysqli_query($con,$sql_atualiza_pedido);
	if($query_atualiza_pedido){
		$recupera = recuperaDados("igsis_pedido_contratacao",$ped,"idPedidoContratacao");
		$idEvento = $recupera['idEvento'];
		$sql_atualiza_evento = "UPDATE ig_evento SET
		idResponsavel = '$fiscal',
		suplente = '$suplente'
		WHERE idEvento = '$idEvento'";
		$query_atualiza_evento = mysqli_query($con,$sql_atualiza_evento);
		if($query_atualiza_evento){
			$mensagem = "Pedido atualizado com sucesso. <br/> <br>
			<h6>Deseja imprimir?</h6><br>
	 <div class='row'>
	<div class='col-md-offset-1 col-md-10'>
	
	
	<div class='form-group'>
    	<div class='col-md-offset-2 col-md-6'>
			<a href='$link2?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Detalhes do Evento</a>
		</div>
    	<div class='col-md-6'>
			<a href='$link1?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Pedido de Contratação</a>
		</div>
	</div>
	
	</div></div>		
	 <br /><br /></center>";
		}else{
			$mensagem = "Erro(1) ao atualizar pedido.";	
		}
		
		
	}else{
		$mensagem = "Erro(2) ao atualizar pedido.";
	}

}else{
	$valor = dinheiroDeBr($_POST['Valor']); 
	$forma_pagamento = $_POST['FormaPagamento'];
	$sql_atualiza_pedido = "UPDATE igsis_pedido_contratacao SET
		valor = '$valor',
		formaPagamento = '$forma_pagamento',
		`parcelas` =  '$parcelas',
		justificativa = '$justificativa',
		estado = 'Análise do Pedido',
		observacao = '$observacao',
		parecerArtistico = '$parecer'
		WHERE idPedidoContratacao = '$ped'";
	$query_atualiza_pedido = mysqli_query($con,$sql_atualiza_pedido);
	if($query_atualiza_pedido){
		$recupera = recuperaDados("igsis_pedido_contratacao",$ped,"idPedidoContratacao");
		$idEvento = $recupera['idEvento'];
		$sql_atualiza_evento = "UPDATE ig_evento SET
		idResponsavel = '$fiscal',
		suplente = '$suplente'
		WHERE idEvento = '$idEvento'";
		$query_atualiza_evento = mysqli_query($con,$sql_atualiza_evento);
		if($query_atualiza_evento){
			$mensagem = "Pedido atualizado com sucesso. <br/> <br>
			<h6>Deseja imprimir?</h6><br>
	 <div class='row'>
	<div class='col-md-offset-1 col-md-10'>
	
	
	<div class='form-group'>
    	<div class='col-md-offset-2 col-md-6'>
			<a href='$link2?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Detalhes do Evento</a>
		</div>
    	<div class='col-md-6'>
			<a href='$link1?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Pedido de Contratação</a>
		</div>
	</div>
	
	</div></div>		
	 <br /><br /></center>";
		}else{
			$mensagem = "Erro(1) ao atualizar pedido.";	
		}
		
		
	}else{
		$mensagem = "Erro(2) ao atualizar pedido.";
	}
	
}

}
$id_ped=$_GET['id_ped'];

$pedido = siscontrat($id_ped);


$juridico = siscontratDocs($pedido['IdProponente'],2);

$evento = recuperaDados("ig_evento",$pedido['idEvento'],"idEvento");

$executante = siscontratDocs($pedido['IdExecutante'],1);

$ped = recuperaDados("igsis_pedido_contratacao",$id_ped,"idPedidoContratacao");
$res01 = siscontratDocs($ped['idRepresentante01'],3);
$res02 = siscontratDocs($ped['idRepresentante02'],3);

?>

<!-- MENU -->	
<?php include 'includes/menu.php';?>
		
	  
	 <!-- Contact -->
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<div class="sub-title"><h2>PEDIDO DE CONTRATAÇÃO DE PESSOA JURÍDICA</h2></div>
                    <h5><?php if(isset($mensagem)){echo $mensagem;}?> </h5>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

			<!-- Coordenador de Contratos -->
							<?php 
				$coord = recuperaDados("ig_usuario",$_SESSION['idUsuario'],"idUsuario");
				if($coord['contratos'] ==  2){
				?>	
				<form class="form-horizontal" role="form" action="?perfil=contratos&p=frm_edita_pedidocontratacaopj&id_ped=<?php echo $id_ped; ?>" method="post">

			   <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Responsável pelo pedido:</strong><br/>
					   <select class="form-control" name="contratos" id="">
					   <option value='0'></option>
                       <?php  geraOpcaoContrato($ped['idContratos']); ?>
                      </select>
					</div>
				  </div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                                        <input type="hidden" name="idContrato" value="<?php echo $id_ped; ?>" />
					 <input type="submit" class="btn btn-theme  btn-block" value="Atualizar responsável pelo contrato">
					</div>
               
				  </div>
				  			</form>  
				<?php } ?>		
<!-- Fim -->		
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Código do Pedido de Contratação:</strong><br/>
					  <input  name="Id_PedidoContratacaoPJ" readonly type="text" class="form-control" id="Id_PedidoContratacaoPJ" <?php echo "value='$ano-$id_ped'"; ?> >
					</div>
                  </div>
				  <div class="form-group">                    
                    <div class=" col-md-offset-2 col-md-6"><strong>Setor:</strong> 
					  <input type="text" readonly class="form-control" value="<?php echo $pedido['Setor'];?>">
                    </div>
                    <div class="col-md-6"><strong>Categoria da Contratação:</strong> 
                     <input type="text" readonly class="form-control" value="<?php echo retornaTipo($evento['ig_tipo_evento_idTipoEvento']);?>">
					<div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                    <br />
	                </div>
					</div>

                      
                    </div>
                  </div>
                  <div class="form-group"> 
					<div class="col-md-offset-2 col-md-8"><strong>Proponente:</strong><br/>
					  <input type='text' readonly class='form-control' name='RazaoSocial' id='RazaoSocial' value="<?php echo $juridico['Nome'];?>">                    	
                    </div>
                  </div>  
                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <form class="form-horizontal" role="form"  method="post" action="?perfil=contratos&p=frm_edita_pj&id_pj=<?php echo $ped['idPessoa']; ?>">
                      <input type="hidden" name="idPedido" value="<?php echo $id_ped; ?>" />
                     
					 <input type="submit" class="btn btn-theme btn-med btn-block" value="Abrir proponente">
                     </form>

					</div>
				  </div>
					<div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                    <br />
	                </div>
					</div>



                  <div class="form-group"> 
					<div class="col-md-offset-2 col-md-8"><strong>Executante:</strong><br/>
		  <form class="form-horizontal" role="form" action="?perfil=contratos&p=frm_edita_executante&id_pf=<?php echo $pedido['IdExecutante']?>"  method="post">
					  <input type='text' readonly class='form-control' name='Executante' id='Executante' value="<?php echo $executante['Nome'] ?>">                    	
                    </div>
                  </div>  
                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8">

                      <input type="hidden" name="idPedido" value="<?php echo $id_ped; ?>" />
                     <?php if($pedido['IdExecutante'] == NULL OR $pedido['IdExecutante'] == ""){ ?>
					 <input type="submit" class="btn btn-theme btn-med btn-block" value="Inserir executante">
                     <?php }else{ ?>
					 <input type="submit" class="btn btn-theme btn-med btn-block" value="Abrir executante">
                     <?php } ?>
                     </form>

					</div>
				  </div>
					<div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                    	<br />
                </div>
                    	<br />
					</div>

                  <div class="form-group"> 
					<div class="col-md-offset-2 col-md-8"><strong>Integrantes do grupo:</strong><br/>
		  <form class="form-horizontal" role="form" action="?perfil=contratos&p=frm_grupos"  method="post">
					 <textarea readonly name="grupo" cols="40" rows="5"><?php echo listaGrupo($_SESSION['idPedido']); ?></textarea>
                                         	
                    </div>
                  </div>  
                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					 <input type="submit" class="btn btn-theme btn-med btn-block" value="Editar integrantes do grupo">
                     </form>

					</div>
				  </div>
					<div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                    	<br />
                </div>
                    	<br />
					</div>
                                      				
                  <div class="form-group">
                  
					<div class="col-md-offset-2 col-md-8"><strong>Objeto: (se for necessário alterar este item, contacte o administrador local)</strong><br/>
					  <input type="text" readonly name="Objeto" class="form-control" value="<?php echo $pedido['Objeto'];?>">
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Local:</strong><br/>
					 <input type='text' readonly name="LocalEspetaculo" class='form-control' value="<?php echo $pedido['Local'];?>">
					</div>
				  </div>
                  <form class="form-horizontal" role="form" action="?perfil=contratos&p=frm_edita_pedidocontratacaopj&id_ped=<?php echo $id_ped; ?>" method="post">
               <!--                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Valor:</strong><br/>
					  <input type='text' name="Valor" class='form-control' id='valor' value='<?php echo dinheiroParaBr($linha_tabelas['ValorGlobal']);?>'>
					</div>
                    </div>
                                 <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Forma de Pagamento:</strong><br/>
                      <textarea name="FormaPagamento" cols="40" rows="5"><?php echo "$linha_tabelas[FormaPagamento]";?></textarea>
					</div>
				  </div>-->
                  
                  
                  	<?php if($ped['parcelas'] > 1){ ?>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Valor:</strong><br/>
					  <input type='text' disabled name="valor_parcela" id='valor' class='form-control' value="<?php echo dinheiroParaBr($ped['valor']) ?>" >
					</div>					
				<?php }else{ ?>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Valor:</strong><br/>
					  <input type='text' name="Valor" id='valor' class='form-control' value="<?php echo dinheiroParaBr($ped['valor']) ?>" >
					</div>					
				<?php } ?>  

				  </div>
				  		<?php if($ped['parcelas'] > 1){ ?>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Forma de Pagamento:</strong><br/>
                      <textarea  disabled name="FormaPagamento" class="form-control" cols="40" rows="5"><?php echo txtParcelas($_SESSION['idPedido'],$ped['parcelas']); ?> 
                      
                      </textarea>
					<p>                   </p>
					</div>
				  </div>
				<?php }else{ ?>				
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Forma de Pagamento:</strong><br/>
                      <textarea name="FormaPagamento" class="form-control" cols="40" rows="5"><?php echo $ped['formaPagamento'] ?></textarea>
					</div>
				  </div>
				<?php } ?>   	

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Parcelas (antes de editar as parcelas, é preciso salvar o pedido)</strong><br/>
					  	 <select class="form-control" id="parcelas" name="parcelas" >
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
				  if($pedido['parcelas'] > 1){ //libera a edição de parcelas
				   ?>
                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <a href="?perfil=contratos&p=frm_parcelas" class="btn btn-theme btn-block">Editar parcelas</a>
					</div>
                    
				  </div>
					<?php } ?>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Verba:</strong><br/>
					   <select disabled class="form-control" name="Verba" id="Verba">
                       <?php geraOpcao("sis_verba",$pedido['Verba'],""); ?>
                      </select>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Justificativa:</strong><br/>
                      <textarea name="Justificativa" cols="40" rows="5"><?php echo $ped['justificativa'];?></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Fiscal:</strong>
					  <select class="form-control" name="Fiscal" id="inputSubject" >
					
					<?php echo opcaoUsuario($_SESSION['idInstituicao'],$evento['idResponsavel']) ?>
                    </select>	
					</div>
					<div class="col-md-6"><strong>Suplente:</strong>

                    					   				<select class="form-control" name="Suplente" id="inputSubject" >
                        
						<?php echo opcaoUsuario($_SESSION['idInstituicao'],$evento['suplente']) ?>
                        </select>	
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Parecer Técnico:</strong><br/>
					  <textarea name="ParecerTecnico" cols="40" rows="5"><?php echo $ped['parecerArtistico'];?></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observação:</strong><br/>
					   <textarea name="Observacao" cols="40" rows="5"><?php echo $pedido['Observacao'];?></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Data do Cadastro:</strong><br/>
					   <input type='text' readonly name="DataAtual" class='form-control'value="<?php echo exibirDataBr($evento['dataEnvio']);?>">
					</div>
				  </div>
                  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                                        <input type="hidden" name="atualizar" value="<?php echo $pedido['parcelas']; ?>" />
					 <input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
					</div>
                    
				  </div>
				</form>
                
                				  </div>
					<div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                    	<br />
                </div>
				</div>
                
				<div class="form-group">
			
					<div class="col-md-offset-2 col-md-8">
			 <a href="?perfil=contratos&p=evento&id_ped=<?php echo $pedido['idEvento'];  ?>" class="btn btn-theme btn-block" target="_blank" >Abrir detalhes do evento</a>	

					</div>	
			</div>
					<div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                    	<br />
                </div>
				</div>

		
				</div>				  

	  	</div>
	  </section>    
