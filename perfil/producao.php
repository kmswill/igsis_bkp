	<div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Open Menu</button>
						<ul class="dl-menu">
							<li>
								<a href="?perfil=producao&p=lista">Lista de eventos</a></li>
								<li><a href="?perfil=producao&p=chamados">Lista de chamados</a></li>
							
							<li><a href="?secao=perfil">Perfil de acesso</a></li>
							<li><a href="?secao=ajuda">Ajuda</a></li>
                            <li><a href="../include/logoff.php">Sair</a></li>
							<!--<li>
								<a href="#">Sub Menu</a>
								<ul class="dl-submenu">
									<li><a href="#">Sub menu</a></li>
									<li><a href="#">Sub menu</a></li>
								</ul>
							</li>-->
						</ul>
					</div><!-- /dl-menuwrapper -->
	</div>	

<?php
require "../funcoes/funcoesProducao.php";

$con = bancoMysqli();
if(isset($_GET['p']))
{
	$p = $_GET['p'];	
}
else
{
	$p = "inicio";
}
switch($p)
{
	case "inicio":	
?>

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
	                <h4>Escolha uma opção</h4>
                </div>
            </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="?perfil=producao&p=lista" class="btn btn-theme btn-lg btn-block">Listar os eventos da instituição</a>
	            <a href="?perfil=producao&p=chamados" class="btn btn-theme btn-lg btn-block">Listar últimos chamados da instituição</a>

            </div>
          </div>
        </div>
    </div>
</section>   

<?php 
break;
	case "lista":
	if(isset($_GET['order']))
	{
		$ordem = $_GET['order'];
	}
	else
	{
		$ordem = "idEvento";
	}

	if(isset($_POST['aprova']))
	{
		$idEvento = $_POST['idEvento'];
		if($_POST['aprova'] == 1)
		{
			$status = 0;	
		}
		else
		{
			$status = 1;
		}
		$idUsuario = $_SESSION['idUsuario'];
		$idInstituicao = $_SESSION['idInstituicao'];
		$sql = "SELECT * FROM igsis_verifica_producao WHERE idEvento = '$idEvento' AND idUsuario = '$idUsuario'";
		$query = mysqli_query($con,$sql);
		$num = mysqli_num_rows($query);
		if($num > 0)
		{
			$sql_aprova = "UPDATE igsis_verifica_producao SET status = '$status' WHERE idEvento = '$idEvento' AND idUsuario = '$idUsuario'" ;
		}
		else
		{
			$sql_aprova = "INSERT INTO igsis_verifica_producao (idEvento, idUsuario, idInstituicao, status) VALUES ('$idEvento', '$idUsuario', '$idInstituicao', '$status')";
		}

		$query_aprova = mysqli_query($con,$sql_aprova);
		if($query_aprova)
		{
			if($status == 0)
			{
				$mensagem = "Evento $idEvento com atribuição NOVO/NÃO VERIFICADO";	
			}
			else
			{
				$mensagem = "Evento $idEvento VERIFICADO";
			}	
		}
	}

?>
<br />
<br />
<br />
<br />

	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                <h2>Eventos</h2>
	                <h5>Por ordem decrescente de data de início</h5>
					<?php
					if($ordem == "dataEnvio")
					{ ?>
						<h5><a href="?perfil=producao&p=lista&order=dataInicio">Ordenar por período de realização</a></h5>
					<?php 
					}
					else
					{ ?>
						<h5><a href="?perfil=producao&p=lista&order=dataEnvio">Ordenar por envio</a></h5>
			  <?php } ?>	
					</div>
            </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
							<td width="30%">Nome do Evento</td>
							<td width="20%">Tipo</td>
							<td width="20%">Local</td>
							<td width="20%">Data/Periodo</td>
   							<td>Status</td>
						</tr>
<?php

	$ocorrencia = listaOcorrenciasInstituicao($_SESSION['idInstituicao'],$ordem);


	$data=date('Y');
	if($ocorrencia['num'] > 0)
	{
		for($i = 0; $i < $ocorrencia['num']; $i++)
		{
			$evento = recuperaDados("ig_evento",$ocorrencia[$i]['idEvento'],"idEvento");	
			$chamado = recuperaAlteracoesEvento($ocorrencia[$i]['idEvento']);
			$status = verificaStatus($ocorrencia[$i]['idEvento'],$_SESSION['idUsuario']); 
			echo "<tr><td class='lista'> <a href='?perfil=producao&p=detalhe&action=evento&id_ped=".$ocorrencia[$i]['idEvento']."' target='_blank' >".$evento['nomeEvento']."</a>"; ?>
			 [<?php 
			if($chamado['numero'] == '0')
			{
				echo "0";
			}
			else
			{
				echo "<a href='?perfil=chamado&p=evento&id=".$ocorrencia[$i]['idEvento']."' target='_blank'>".$chamado['numero']."</a>";	
			}
							
							?>]
			<?php echo "          
			</td>";
			echo '<td class="list_description">'.retornaTipo($evento['ig_tipo_evento_idTipoEvento']).'</td> ';
			echo '<td class="list_description">'.substr(listaLocais($ocorrencia[$i]['idEvento']),1).'</td> ';
			echo '<td class="list_description">'.retornaPeriodo($ocorrencia[$i]['idEvento']).'</td> ';


			echo '<td class="list_description">'; 
			echo "<form method='POST' action='?perfil=producao&p=lista'>
			<input type='hidden' name='aprova' value='".$status."' >
			<input type='hidden' name='idEvento' value='".$evento['idEvento']."' >
			<input type ='submit' class='btn btn-theme  btn-block' value='";
			if($status == 1)
			{
				echo "OK'";
			}
			else
			{ 
				echo "NOVO' style='background: red;'";
			}  	
			echo "></form>	</td> </tr>";
		}
	}
	var_dump($status);
	?>	
		
						
						</tbody>
					</table> 	
				</div>
			</div>
		</section>
	<?php
break;
case "chamados":
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Chamado</h2>
					<h4></h4>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                 </div>
				  </div>
			  </div>  
			
			<div class="table-responsive list_info">
                  <table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td width='10%'>ID</td>
							<td>Chamado</td>
							<td>Data do envio</td>
							<td>Usuário</td>
						</tr>
					</thead>
					<tbody>
					<?php
					$con = bancoMysqli();
					$idInstituicao = $_SESSION['idInstituicao'];
					$sql_busca = "SELECT * FROM igsis_chamado, ig_evento WHERE igsis_chamado.idEvento = ig_evento.idEvento AND idInstituicao = '$idInstituicao' ORDER BY idChamado DESC";
					$query_busca = mysqli_query($con,$sql_busca);
						while($chamado = mysqli_fetch_array($query_busca)){ 
						$tipo = recuperaDados("igsis_tipo_chamado",$chamado['tipo'],"idTipoChamado");
						$usuario = recuperaDados("ig_usuario",$chamado['idUsuario'],"idUsuario");
						
						?>
						
					<tr>
					<td><?php echo $chamado['idChamado']; ?></td>
					<td><a href="?perfil=chamado&p=detalhe&id=<?php echo $chamado['idChamado'] ?>" ><?php echo $tipo['chamado']." - ".$chamado['titulo']; ?>
                    <?php
					if($chamado['idEvento'] != NULL){
							$evento = recuperaDados("ig_evento",$chamado['idEvento'],"idEvento");
							echo "<br />".$evento['nomeEvento'];
						}
	                ?>
                    </a></td>
					<td><?php echo exibirDataHoraBr($chamado['data']) ?></td>
					<td><?php echo $usuario['nomeCompleto'] ?></td>
					</tr>					
					<?php
						}
					?>
					
					
					</tbody>
					</table>
				   
			</div>
		</div>
	</section>
<?php
break;
case "detalhe": 
if(isset($_GET['id_ped'])){
$evento = recuperaDados("ig_evento",$_GET['id_ped'],"idEvento");
}


if(isset($_GET['action'])){
	$action = $_GET['action'];
}else{
	$action = "evento";
}
?>
 	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2><?php echo $evento['nomeEvento'] ?></h2>
					<h4></h4>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                 </div>
				  </div>
			  </div>  
<?php
$chamado = recuperaAlteracoesEvento($_GET['id_ped']);	
switch($action){
case "evento":

 ?>
			  <h5>Dados do evento | <a href="?perfil=producao&p=detalhe&action=servicos&id_ped=<?php echo $_GET['id_ped']; ?>">Solicitação de serviços</a>  | <?php 
					if($chamado['numero'] == '0'){
						echo "Chamados [0]";
					}else{
						echo "<a href='?perfil=chamado&p=evento&id=".$_GET['id_ped']."' target='_blank'>Chamados [".$chamado['numero']."]</a>";	
					}
					
					?> </h5>
			<div class="table-responsive list_info" >
            <h4></h4>
            <p align="left">
              <?php descricaoEvento($_GET['id_ped']); ?>
                  </p>      
            <h5>Ocorrências</h5>
            <?php echo resumoOcorrencias($_GET['id_ped']); ?><br /><br />
            <?php listaOcorrenciasTexto($_GET['id_ped']); ?>
			<h5>Especificidades</h5>
			<div class="left">
            <?php descricaoEspecificidades($_GET['id_ped'],$evento['ig_tipo_evento_idTipoEvento']); ?>
			</div>

			<h5>Sub-eventos</h5>
			<div class="left">
            <?php listaSubEventosCom($_GET['id_ped'],$evento['ig_tipo_evento_idTipoEvento']); ?>
			</div>

            <h4></h4>
            <div class="left">
            <?php if($evento['ig_tipo_evento_idTipoEvento'] == 1){?>
            <h5>Grade de filmes</h5>
            <?php gradeFilmes($_GET['id_ped']); ?><br /><br />            
            <?php } ?>
            <h5>Previsão de serviços externos</h5>
            <?php listaServicosExternos($_GET['id_ped']); ?><br /><br />

			<h5>Serviços Internos</h5>
			<?php listaServicosInternos($_GET['id_ped']) ?>
			<br />
			<h5>Arquivos Anexos</h5>
			<?php listaArquivosDetalhe($_GET['id_ped']); ?>
			<br />
			</div>	
</div>			
			<?php
break;
case "pedidos":
$pedido = listaPedidoContratacao($_GET['id_ped']);
?>
			  <h5> <a href="?perfil=producao&p=detalhe&action=pedidos&id_ped=<?php echo $_GET['id_ped']; ?>">Dados do evento </a>|<a href="?perfil=producao&p=detalhe&action=servicos&id_ped=<?php echo $_GET['id_ped']; ?>">Solicitação de serviços</a> | Pedidos de contratação</h5>
			  <div class="table-responsive list_info" >
            <h4><?php echo $evento['nomeEvento'] ?></h4>

			  <?php for($i = 0; $i < count($pedido); $i++){
			$dados = siscontrat($pedido[$i]);
			$pessoa = siscontratDocs($dados['IdProponente'],$dados['TipoPessoa']);
			?>
            <p align="left">
			Nome ou Razão Social: <b><?php echo $pessoa['Nome'] ?></b><br />
			Tipo de pessoa: <b><?php echo retornaTipoPessoa($dados['TipoPessoa']);?></b><br />
			Dotação: <b><?php echo retornaVerba($dados['Verba']);?></b><br />
			Valor:<b>R$ <?php echo dinheiroParaBr($dados['ValorGlobal']);?></b><br />		
			 </p>      
<?php } // fechamento do for ?>

 
			<?php
break;
case "servicos":

?>    
			  <h5> <a href="?perfil=producao&p=detalhe&action=evento&id_ped=<?php echo $_GET['id_ped']; ?>">Dados do evento </a>| Solicitação de serviços  </h5>
			<div class="table-responsive list_info" >
            <h4><?php echo $evento['nomeEvento'] ?></h4>
            <div class="left">
            
            <h5>Previsão de serviços externos</h5>
            <?php listaServicosExternos($_GET['id_ped']); ?><br /><br />

			<h5>Serviços Internos</h5>
			<?php listaServicosInternos($_GET['id_ped']) ?>

            </div>
<?php
break;
 } // fecha a switch action ?>	
<?php
break;
?>


<?php } ?>