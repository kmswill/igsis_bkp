<?php

$_SESSION['idPedido'] = $_GET['id_ped'];
$id_ped = $_GET['id_ped'];

$server = "http://".$_SERVER['SERVER_NAME']."/igsisbeta/";
$http = $server."/pdf/";
$link1=$http."rlt_pedido_contratacao_pf.php";
$link2=$http."rlt_evento_pf.php";



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

	$verba = $_POST['Verba'];
	$justificativa = addslashes($_POST['Justificativa']);
	$fiscal = $_POST['Fiscal'];
	$suplente  = $_POST['Suplente'];
	$parecer = addslashes($_POST['ParecerTecnico']);
	$observacao = addslashes($_POST['Observacao']);
	$parcelas = $_POST['parcelas'];

if($_POST['atualizar'] > '1'){

	$sql_atualiza_pedido = "UPDATE igsis_pedido_contratacao SET
		idVerba = '$verba',
		`parcelas` =  '$parcelas',
		justificativa = '$justificativa',
		observacao = '$observacao',
		estado = 'Análise do Pedido',
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
	
	<form class='form-horizontal' role='form'>
	
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
		idVerba = '$verba',
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
			$mensagem = "Pedido atualizado com sucesso. <br/> <br><br>
			<h6>O que deseja imprimir?</h6><br>
	 <div class='row'>
	<div class='col-md-offset-1 col-md-10'>
	
	<form class='form-horizontal' role='form'>
	
	<div class='form-group'>
    	<div class='col-md-offset-2 col-md-8'>
			<a href='$link2?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Detalhes do Evento</a>
		</div>
	</div>
	
	<br/>
	
	<div class='form-group'>
    	<div class='col-md-offset-2 col-md-8'>
			<a href='$link1?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Pedido de Contratação</a>
		</div>
	</div>
	
	</div></div>		
	 <br /></center>";
		}else{
			$mensagem = "Erro(1) ao atualizar pedido.";	
		}
		
		
	}else{
		$mensagem = "Erro(2) ao atualizar pedido.";
	}
	
}

}
$ano=date('Y');
$id_ped = $_GET['id_ped'];	
$linha_tabelas = siscontrat($id_ped);
$fisico = siscontratDocs($linha_tabelas['IdProponente'],1);		
$evento = recuperaDados("ig_evento",$linha_tabelas['idEvento'],"idEvento");
$pedido = recuperaDados("igsis_pedido_contratacao",$_GET['id_ped'],"idPedidoContratacao");
?>

<!-- MENU -->	
<?php include 'includes/menu.php';?>
		
	  
	 <!-- Contact -->
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h2>PEDIDO DE CONTRATAÇÃO DE PESSOA FÍSICA</h2>
                    <h4><?php if(isset($mensagem)){ echo $mensagem; } ?></h4>
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
					  <input  name="Id_PedidoContratacaoPF" readonly type="text" class="form-control" id="Id_PedidoContratacaoPF" value="<?php echo $ano."-".$id_ped; ?>" >
					</div>
                  </div>
				  <div class="form-group">                    
                    <div class=" col-md-offset-2 col-md-6"><strong>Setor:</strong> 
					  <input type="text" readonly class="form-control" value="<?php echo $linha_tabelas['Setor'];?>">
                    </div>
                    <div class="col-md-6"><strong>Categoria da Contratação:</strong> 
                    <input type="text" readonly class="form-control" value="<?php echo retornaTipo($evento['ig_tipo_evento_idTipoEvento']);?>">
                      
                    </div>
                  </div>
                  <div class="form-group"> 
					<div class="col-md-offset-2 col-md-8"><strong>Proponente:</strong><br/>
					  <input type='text' readonly class='form-control' name='nome' id='nome' value='<?php echo $fisico['Nome'];?>'>                    	
                    </div>
                  </div>  
                  	<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <form class="form-horizontal" role="form" action="<?php echo "?perfil=contratos&p=frm_edita_pf&id_pf=".$linha_tabelas['IdProponente']; ?>" method="post">
                      <input type="hidden" name="idPedido" value="<?php echo $id_ped; ?>" />
                     
					 <input type="submit" class="btn btn-theme btn-med btn-block" value="Abrir proponente">
                     </form>

					</div>
				  </div>
				  
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><br /></div>
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
						<div class="col-md-offset-2 col-md-8"><br /></div>
				  </div>
				  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Objeto:</strong><br/>
					  <input type="text" readonly name="Objeto" class="form-control"  value="<?php echo $linha_tabelas['Objeto'];?>">
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Local:</strong><br/>
					 <input type='text' readonly name="LocalEspetaculo" class='form-control' value="<?php echo $linha_tabelas['Local'];?>">
					</div>
				  </div>
             
                  

   
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Período:</strong><br/>
					   <input type='text' readonly name="Periodo" class='form-control' <?php echo "value='$linha_tabelas[Periodo]'";?>>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Duração: </strong>
					   <input type='text' readonly name="Duracao" class='form-control' <?php echo "value='$linha_tabelas[Duracao]'";?>>
					</div>
					<div class="col-md-6"><strong>Carga Horária:</strong><br/>
					   <input type='text' readonly name="CargaHoraria" class='form-control' <?php //echo "value='$linha_tabelas[CargaHoraria]'";?>>
					</div>
				  </div>
                  <form class="form-horizontal" role="form" action="?perfil=contratos&p=frm_edita_pedidocontratacaopf&id_ped=<?php echo $id_ped; ?>" method="post">
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
                  	<?php if($pedido['parcelas'] > 1){ ?>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Valor:</strong><br/>
					  <input type='text' disabled name="valor_parcela" id='valor' class='form-control' value="<?php echo dinheiroParaBr($pedido['valor']) ?>" >
					</div>					
				<?php }else{ ?>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Valor:</strong><br/>
					  <input type='text' name="Valor" id='valor' class='form-control' value="<?php echo dinheiroParaBr($pedido['valor']) ?>" >
					</div>					
				<?php } ?>                    
                    

				  </div>
				  		<?php if($pedido['parcelas'] > 1){ ?>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Forma de Pagamento:</strong><br/>
                      <textarea  disabled name="FormaPagamento" class="form-control" cols="40" rows="5"><?php echo txtParcelas($_SESSION['idPedido'],$pedido['parcelas']); ?> 
                      
                      </textarea>
					<p>                   </p>
					</div>
				  </div>
				<?php }else{ ?>				
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Forma de Pagamento:</strong><br/>
                      <textarea name="FormaPagamento" class="form-control" cols="40" rows="5"><?php echo $pedido['formaPagamento'] ?></textarea>
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
                       <?php geraOpcao("sis_verba",$linha_tabelas['Verba'],"") ?>
                      </select>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Justificativa:</strong><br/>
                      <textarea name="Justificativa" cols="40" rows="5"><?php echo $pedido['justificativa']; ?></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Fiscal:</strong>
                    
					   <!--<input type='text' name="Fiscal" class='form-control' value="<?php echo $linha_tabelas['Fiscal'];?>">-->
                       <select class="form-control" name="Fiscal" id="Fiscal">
					<?php opcaoUsuario($_SESSION['idInstituicao'],$evento['idResponsavel']); ?>
						</select>
					</div>
					<div class="col-md-6"><strong>Suplente:</strong>


				   <!--<input type='text' name="Suplente" class='form-control' value="<?php echo $linha_tabelas['Suplente'];?>">-->
                       <select class="form-control" name="Suplente" id="Fiscal">
					<?php opcaoUsuario($_SESSION['idInstituicao'],$evento['suplente']); ?>
						</select>

					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Parecer Técnico:</strong><br/>
					  <textarea name="ParecerTecnico" cols="40" rows="5"><?php echo $pedido['parecerArtistico']; ?></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observação:</strong><br/>
					   <input type='text' name="Observacao" class='form-control' <?php echo "value='$linha_tabelas[Observacao]'";?>>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Data do Cadastro:</strong><br/>
					   <input type='text' readonly name="DataAtual" class='form-control' value="<?php echo exibirDataBr($linha_tabelas['DataCadastro']);?>">
					</div>
				  </div>
                  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="atualizar" value="<?php echo $pedido['parcelas']; ?>" />
					 <input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
					</div>
                    
				  </div>
				</form>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
			 <a href="?perfil=contratos&p=evento&id_ped=<?php echo $pedido['idEvento'];  ?>" class="btn btn-theme btn-block" target="_blank" >Abrir detalhes do evento</a>	

					</div>
                    
				  </div>

	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  
