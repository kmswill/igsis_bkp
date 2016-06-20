<?php include 'includes/menu.php';?>
<?php
require "./../funcoes/funcoesAdministrador.php"; //chamar funcoes do administrador
//require "./../funcoes/funcoesSiscontrat.php"; //chamar funcoes do administrador

if(isset($_POST['apagar'])){
	$idEvento = $_POST['apagar'];
	$sql_reabrir = "UPDATE ig_evento SET publicado = '0' WHERE idEvento = '$idEvento'";
	$query_reabrir = mysqli_query($con,$sql_reabrir);
	if($query_reabrir){
		$sql_pedido = "UPDATE igsis_pedido_contratacao SET publicado = '0' WHERE idEvento = '$idEvento'";
		$query_pedido = mysqli_query($con,$sql_pedido);
		if($query_pedido){
			$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
			$mensagem = "Evento ".$evento['nomeEvento']."($idEvento) apagado com sucesso";	
		}
	} 
	
}



if(isset($_POST['reabertura'])){
	$con = bancoMysqli();
	$idEvento = $_POST['reabertura'];
	$mensagem = "";
	$sql_reabrir = "UPDATE ig_evento SET dataEnvio = NULL WHERE idEvento = '$idEvento'";
	$query_reabrir = mysqli_query($con,$sql_reabrir);
	if($query_reabrir){
		gravarLog($sql_reabrir);
		$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
		$mensagem = $mensagem."O evento ".$evento['nomeEvento']." foi reaberto.<br />";
		$sql_pedido = "UPDATE igsis_pedido_contratacao SET estado = NULL WHERE idEvento = '$idEvento'";
		$query_pedido = mysqli_query($con,$sql_pedido);
		if($query_pedido){
			$mensagem = $mensagem."Os pedidos foram reabertos.<br />";
			$sql_recupera_pedidos_abertos = "SELECT * FROM igsis_pedido_contratacao WHERE publicado = '1' AND idEvento = $idEvento AND estado IS NULL";
			$query_recupera_pedidos_abertos = mysqli_query($con,$sql_recupera_pedidos_abertos);
			$n_recupera = mysqli_num_rows($query_recupera_pedidos_abertos);
			if($n_recupera > 0){
				$mensagem = "O evento ".$evento['nomeEvento']."foi reaberto.";
				$pedido = "";
				while($x = mysqli_fetch_array($query_recupera_pedidos_abertos)){
					$pedidos = $pedidos." ".$x['idPedidoContratacao'].","; 	
				}
				$conteudo_email = "
				Olá,<br />
				Por solicitação, o(s) pedido(s) ".trim(substr($pedidos,0,-1))." foi(foram) reaberto(s) e não aparecerá(ão) em suas listas no Módulo Contratação até que seja(m) reenviado(s).<br /><br />
				Att,<br />
				Equipe IGSIS<br />
				";
				$instituicao = 4;
				$subject = "O evento '".$evento['nomeEvento']."' foi reaberto";
				$email = "sistema.igsis@gmail.com";
				$usuario = "IGSIS";
				
					
				$email_envia = enviarEmailContratos($conteudo_email, $instituicao, $subject, $email, $idEvento);
			}
			if($email_envia){
				$mensagem = $mensagem."<br />Foram enviadas notificações à área de Contratos.";	
			}	
			
		}
	} 
	
}

						if(isset($_GET['order'])){
							switch($_GET['order']){
						
							case "dataEnvio":
								$order = " ORDER BY dataEnvio DESC";
								$mensagem .= "<br /> Ordenados pelas últimas datas de envio.<br />(Reaberturas de IGs geram novas datas de envio mas não Números de Evento.)";	
							break;
						
							case "idEvento":
								$order = " ORDER BY idEvento DESC";	
								$mensagem .= "<br /> Ordenados pelo número de Evento";	
					
							
								
							}	
						}else{
							$order = " ORDER BY idEvento DESC ";	
							$mensagem .= "<br /> Ordenados pelo últimos números de Evento";	

						}

?>
<section id="list_items" class="home-section bg-white">
		 <div class="form-group">
            <div class="col-md-offset-2 col-md-8">		
			<h2>Lista de eventos</h2>
			
  	        </div>
				</div> 
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					
					</div> <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
					</div>
				  </div>
				  
			<div class="table-responsive list_info">
<?php 
						$con = bancoMysqli();
						$idInsituicao = $_SESSION['idInstituicao'];
						$sql_lista = "SELECT * FROM ig_evento WHERE publicado = '1' AND dataEnvio IS NOT NULL $order";
						$query_lista = mysqli_query($con,$sql_lista);
						$num = mysqli_num_rows($query_lista);
?>
			<h5><?php echo $num ?> eventos enviados.</h5>
             <p><a href="?perfil=admin&p=reabertura">Ordenar pelos últimos Números de Evento</a> | <a href="?perfil=admin&p=reabertura&order=dataEnvio">Ordenar pelas últimas datas de envio</a></p>
            <table class='table table-condensed'>
					<thead>					
					<tr class='list_menu'> 
							<td>ID</td>
							<td>Evento</td>
  							<td>Tipo</td>
                            <td>Instituição</td>
							<td>Data/Período</td>
                            <td>Pedido</td>
                            <td width="7%"></td>
                            <td width="7%"></td>
                            <td width="7%"></td>
						 </tr>	
					</thead>
					<tbody>
                        <?php 
						

						while($campo = mysqli_fetch_array($query_lista)){
		$protocolo = recuperaDados("ig_protocolo",$campo['idEvento'],"ig_evento_idEvento");
		$chamado = recuperaAlteracoesEvento($campo['idEvento']);
		$instituicao = recuperaDados("ig_instituicao",$campo['idInstituicao'],"idInstituicao");	
			echo "<tr>";
			echo "<td class='list_description'><a href='?perfil=detalhe&evento=".$campo['idEvento']."' target='_blank'>".$campo['idEvento']."</a>
			</td>";
			echo "<td class='list_description'>".$campo['nomeEvento']." ["; 
			if($chamado['numero'] == '0'){
				echo "0";
			}else{
			echo "<a href='?perfil=chamado&p=evento&id=".$campo['idEvento']."' target='_blank'>".$chamado['numero']."</a>";	
			}
				
			echo "]</td>";
			echo "<td class='list_description'>".retornaTipo($campo['ig_tipo_evento_idTipoEvento'])."</td>";
			echo "<td class='list_description'>".$instituicao['instituicao']."</td>";
			echo "<td class='list_description'>".retornaPeriodo($campo['idEvento'])."</td>";
			echo "<td class='list_description'>".substr(retornaPedidos($campo['idEvento']),7)."</td>";
			echo "<td class='list_description'>
			<form method='POST' action='?perfil=contratos&p=frm_reabertura'>
			<input type='hidden' name='reabertura' value='".$campo['idEvento']."' >
			<input type ='submit' class='btn btn-theme  btn-block' value='reabrir'></td></form>"	;
			echo "<td class='list_description'>
			<form method='POST' action='?perfil=contratos&p=frm_reabertura'>
			<input type='hidden' name='apagar' value='".$campo['idEvento']."' >
			<input type ='submit' class='btn btn-theme  btn-block' value='Apagar'></td></form>"	;
			echo "<td class='list_description'>
			<form method='POST' action='?perfil=evento&p=basica' target='_blank'>
			<input type='hidden' name='carregar' value='".$campo['idEvento']."' >
			<input type ='submit' class='btn btn-theme  btn-block' value='Carregar'></td></form>"	;
			echo "</tr>";	
						}
?>
                        </tbody>
				</table>
			</div>
		</div>
</section>
