<?php
function atualizaStatus($idPedido){
	$con = bancoMysqli();
	$pedido = recuperaDados("igsis_pedido_contratacao",$idPedido,"idPedidoContratacao");
	
	//Inicio do algorítimo
	
	if($pedido['estado'] == 11){  //Se estão nesses estados, não haverá atualização
		
		$txt = "Não houve atualização de status (1)";

		
	}else{ // Esses estados restantes permitem alteração automática
	
		if(trim($pedido['NumeroNotaEmpenho']) != "" && $pedido['NumeroNotaEmpenho'] != NULL){ // Se há um Número de Empenho Válido

			$sql = "UPDATE igsis_pedido_contratacao SET estado = '10' WHERE idPedidoContratacao = '$idPedido'";
			
			$txt = "O pedido $idPedido mudou seu status para 10 (2)";
			
			
		}else{ // Se não há um Número de Empenho Válido
			
			if(trim($pedido['DataReserva']) != "" && $pedido['DataReserva'] != NULL && $pedido['DataReserva'] != '0000-00-00'){ //Se há um pedido de reserva

				$sql = "UPDATE igsis_pedido_contratacao SET estado = '6' WHERE idPedidoContratacao = '$idPedido'";

				$txt = "O pedido $idPedido mudou seu status para 6 (3)";
				
				
			}else{ // Se não há um Pedido de Reserva

				if(trim($pedido['DataProposta']) != "" && $pedido['DataProposta'] != NULL && $pedido['DataProposta'] != '0000-00-00'){ //Se já foi gerado uma Proposta

					$sql = "UPDATE igsis_pedido_contratacao SET estado = '5' WHERE idPedidoContratacao = '$idPedido'";

					$txt = "O pedido $idPedido mudou seu status para 5 (4)";


				}else{ //Caso não tenha sido gerado uma Proposta
					
					if($pedido['NumeroProcesso'] != NULL && trim($pedido['NumeroProcesso']) != ""){ // Caso possua um Número de Processo SEI
					
						$sql = "UPDATE igsis_pedido_contratacao SET estado = '4' WHERE idPedidoContratacao = '$idPedido'";

						$txt = "O pedido $idPedido mudou seu status para 4 (5)";

					
					}else{ // Caso não possua ainda um Número de Processo SEI
						
						if(trim($pedido['DataContrato']) != "" && $pedido['DataContrato'] != NULL && $pedido['DataContrato'] != '0000-00-00'){ //Caso o contrato tenha visto						
							$sql = "UPDATE igsis_pedido_contratacao SET estado = '3' WHERE idPedidoContratacao = '$idPedido'";
			
							$txt = "O pedido $idPedido mudou seu status para 3 (6)";

							
						}else{
							
							$txt =  "Não houve atualização de status (7)";
						}
					
						
					}
					
				}
				
			}
			
		}
	
		
	}
	
	if(isset($sql)){
		$query = mysqli_query($con,$sql);
		if($query){
			return $txt;	
		}else{
			return "Erro ao atualizar status";	
		}
		
	}
}



if(isset($_GET['arquivo'])){
	$arquivo = $_GET['arquivo'];
require "../funcoes/funcoesSiscontrat.php";
}

if(isset($_GET['evento'])){
	$idEvento = $_GET['evento'];	
}


?>

	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h3>Teste</h3>
					<?php
					/*
					$con = bancoMysqli();
					$sql = "SELECT * FROM igsis_pedido_contratacao WHERE publicado = '1'";
					$query = mysqli_query($con,$sql);
					while($pedido = mysqli_fetch_array($query)){
						$idPedido = $pedido['idPedidoContratacao'];
						echo "O pedido $idPedido tem o estado ".$pedido['estado'].".<br />";
						$txt = atualizaStatus($idPedido);
						echo $txt."<br /><br />";
					}
					*/
					
					$x = atualizarAgenda($idEvento);
					echo $x;
					var_dump($x);
					?>



					</div>
				  </div>
			  </div>
			  
		</div>
	</section>