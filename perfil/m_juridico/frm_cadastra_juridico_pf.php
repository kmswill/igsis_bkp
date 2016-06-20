<?php 
$_SESSION['idPedido'] = $_GET['id_ped'];
$id_ped = $_GET['id_ped'];
$idModelo = $_GET['idModelo'];
$pedido = recuperaDados("igsis_pedido_contratacao",$_GET['id_ped'],"idPedidoContratacao");
$modelo = recuperaDados("sis_modelos_juridico", $idModelo, "idModelo");
$linha_tabelas = siscontrat($id_ped);
$fisico = siscontratDocs($linha_tabelas['IdProponente'],1);	

$fiscal=$linha_tabelas["Fiscal"];
$suplente=$linha_tabelas["Suplente"];
$rfSuplente=$linha_tabelas["RfSuplente"];
$rfFiscal=$linha_tabelas["RfFiscal"];

$ano=date('Y');


$amparo=$modelo['amparo'];

$final=$modelo['finalizacao']; 

$final = str_replace("nomeFiscal", $fiscal, $final);
$final = str_replace("rfFiscal", $rfFiscal, $final);
$final = str_replace("nomeSuplente", $suplente, $final);
$final = str_replace("rfSuplente", $rfSuplente, $final);
?>

<!-- MENU -->	
<?php include 'includes/menu.php';?>
	<html>	
	 <!-- Contact -->
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
				<h3><div class="sub-title">DESPACHO DE PESSOA FÍSICA</div></h3>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

                    			  
					
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Código do Pedido de Contratação:</strong><br/><?php echo "$id_ped";?>					  
					</div>                                        
					<div class="col-md-6"><strong>Número do Processo:</strong><br/><?php echo $pedido['NumeroProcesso']; ?>
					</div>
                  </div> 
				  <div class="form-group"> 
					<div class="col-md-offset-2 col-md-8"><strong>Contratado:</strong><br/><?php echo $fisico['Nome'];?>
                    </div>
                  </div>
				  
				  <form class="form-horizontal" role="form" action="?perfil=juridico&p=update_juridico_pf&id_ped=<?php echo $_GET['id_ped']; ?>" method="post">	
				  
                  <div class="form-group"> 
					<div class="col-md-offset-2 col-md-8"><strong>Amparo:</strong><br/>
	                <textarea name="AmparoLegal" cols="40" rows="8"> <?php echo $amparo ?></textarea>
                    </div>
                  </div>  
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Dotação Orçamentária</strong><br />
					  <input type="text" name="ComplementoDotacao" class="form-control" id="ComplementoDotacao">
					</div>
				  </div>	
                  <div class="form-group"> 
					<div class="col-md-offset-2 col-md-8"><strong>Finalização:</strong><br/>
	                <textarea name="Finalizacao" cols="40" rows="8"> <?php echo $final ?></textarea>
                    </div>
                  </div> 
                                    
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                   <input type="submit" name="enviar" value="GRAVAR" class="btn btn-theme btn-lg btn-block">					
				   </div>
                    
				  </div>
				</form>
	
	  			</div>
			
				
	  		</div>
			

	  	</div>
		</div>
	  </section>  

