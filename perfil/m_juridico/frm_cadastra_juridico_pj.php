<?php 
$_SESSION['idPedido'] = $_GET['id_ped'];
$id_ped = $_GET['id_ped'];
$pedido = recuperaDados("igsis_pedido_contratacao",$_GET['id_ped'],"idPedidoContratacao");
$linha_tabelas = siscontrat($id_ped);
$fisico = siscontratDocs($linha_tabelas['IdProponente'],2);	

$fiscal=$linha_tabelas["Fiscal"];
$suplente=$linha_tabelas["Suplente"];
$suplenteRf=$linha_tabelas["RfSuplente"];
$fiscalRf=$linha_tabelas["RfFiscal"];

$ano=date('Y');


$amparo="I – À vista dos elementos constantes do presente, em especial o Parecer da Comissão de Atividades Artísticas e Culturais n° , diante da competência a mim delegada pela Portaria nº 19/2006-SMC/G, AUTORIZO, com fundamento no artigo 25, inciso III, da Lei Federal nº 8.666/93, a contratação nas condições abaixo estipuladas, observada a legislação vigente e demais cautelas legais:";

$final="II - Nos termos do art. 6º do Decreto nº 54.873/2014, designo o(a) servidor(a) ".$fiscal.", RF ".$fiscalRf.", como fiscal do contrato e o(a) ".$suplente.", RF ".$suplenteRf.", como seu substituto.
III -  Autorizo a emissão da competente nota de empenho de acordo com o Decreto Municipal nº 56.779/2016 e demais normas de execução orçamentárias vigentes.
IV - Publique-se e encaminhe-se à CAF/Contabilidade para as providências cabíveis." ; 
				

?>

<!-- MENU -->	
<?php include 'includes/menu.php';?>
	<html>	
	 <!-- Contact -->
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
				<h3><div class="sub-title">DESPACHO DE PESSOA JURÍDICA</div></h3>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">
				
				  <div class="form-group"> 
					<div class="col-md-offset-2 col-md-8"><h5><?php echo $linha_tabelas['Objeto'];?></h5>
					<a class="btn btn-theme btn-lg btn-block" href="?perfil=detalhes_contrato&id_ped=<?php echo "$id_ped";?>" target="_blank">Detalhes do Evento</a>
                    </div>
                  </div>
				  
				  <div class="form-group"> 
					<div class="col-md-offset-2 col-md-8"><br/>
                    </div>
                  </div>	

                    <form class="form-horizontal" role="form" action="?perfil=juridico&p=update_juridico_pj&id_ped=<?php echo $_GET['id_ped']; ?>" method="post">				  
					
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
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Objeto:</strong><br/><?php echo $linha_tabelas['Objeto'];?>
					</div>
				  </div>	
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Valor:</strong><br/><?php echo $linha_tabelas['ValorGlobal'];?>					  
					</div>                                        
					<div class="col-md-6"><strong>Período:</strong><br/><?php echo $linha_tabelas['Periodo']; ?>
					</div>
                  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Forma de Pagamento:</strong><br/><?php echo $linha_tabelas['FormaPagamento'];?>
					</div>
				  </div>
				  
				  
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

