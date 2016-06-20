<?php include 'includes/menu_administrativo.php';?>
<?php
$pedido = recuperaDados("igsis_pedido_contratacao",$_SESSION['idPedido'],"idPedidoContratacao");
$idPedido = $_SESSION['idPedido'];
$con = bancoMysqli();

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
			$mensagem = $mensagem." Parcela $i atualizada.<br />"; 
			$soma = somaParcela($idPedido,$pedido['parcelas']);
			$sql_atualiza_valor = "UPDATE igsis_pedido_contratacao SET valor = '$soma' WHERE idPedidoContratacao = '$idPedido'";
			$query_atualiza_valor = mysqli_query($con,$sql_atualiza_valor);
			if($query_atualiza_valor){
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
                    	<?php //$evento = recuperaEvento($_SESSION['idEvento']); ?>

                    </p>
					</div>
                  </div>

				<form class="form-horizontal" role="form" action="?perfil=contratos&p=frm_parcelas" method="post">

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
                    <div class="col-xs-6 col-sm-2"><strong>Valor</strong><br/>
					  <input type='text'  name="valor<?php echo $i; ?>" id='valor' class='form-control valor' value="<?php echo dinheiroParaBr($parcela['valor']); ?>">
					</div>
                    
                    <div class="col-xs-6 col-sm-2"><strong>Horas</strong><br/>
					  <input type='text'  name="valor<?php echo $i; ?>" id='valor' class='form-control valor' value="<?php echo dinheiroParaBr($parcela['valor']); ?>">
					</div>
                    
                    <div class="col-xs-6 col-sm-2"><strong>Data Inicial:</strong><br/>
					  <input type='text' name="data<?php echo $i; ?>" id='' class='form-control datepicker' value="<?php echo exibirDataBr($parcela['vencimento']); ?>">
					</div>
                    
                    <div class="col-xs-6 col-sm-2"><strong>Data Final:</strong><br/>
					  <input type='text' name="data<?php echo $i; ?>" id='' class='form-control datepicker' value="<?php echo exibirDataBr($parcela['vencimento']); ?>">
					</div>
                    
                    <div class="col-xs-6 col-sm-2"><strong>Data Pagamento:</strong><br/>
					  <input type='text' name="data<?php echo $i; ?>" id='' class='form-control datepicker' value="<?php echo exibirDataBr($parcela['vencimento']); ?>">
					</div>
				  </div>

                  <?php 
				  $soma = $soma + $parcela['valor'];
				  } ?>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<p><?php echo "A soma das parcelas é: ".dinheiroParaBr($soma); ?></p>
                    <p>O período de contratação é: De $variavel à $variavel </p>
                   
					</div>
                    
				  </div>	
                  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="atualizar" value="1" />
                    <input type="hidden" name="idPedidoContratacao" value="<?php echo $_SESSION['idPedido']; ?>" />
					 <input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
                    
				  </div>
				</form>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <?php
					if($pedido['tipoPessoa'] == '1'){
						$pfpj = 'pf';	
					}else{
						$pfpj = 'pj';	

					}
					 ?>
                    <a href="?perfil=contratos&p=frm_edita_pedidocontratacao<?php echo $pfpj ?>&id_ped=<?php echo $_SESSION['idPedido']; ?>" value="VOLTAR" class="btn btn-theme btn-lg btn-block">VOLTAR para area de pedidos de contratação</a>
					</div>
                    
				  </div>	
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  
