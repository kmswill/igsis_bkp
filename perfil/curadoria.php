<?php 
if(isset($_GET['p'])){
	$p = $_GET['p'];	
}else{
	$p = "inicio";	
}
?>

	<div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Open Menu</button>
						<ul class="dl-menu">
							<li>
								<a href="?secao=inicio">Início</a>
							</li>
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
switch($p){
case "inicio":
?>

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                <h2>Gerência de programação e curadoria</h2>
	                <h5>Escolha uma opção</h5>
                </div>
            </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="?perfil=curadoria&p=visaogeral" class="btn btn-theme btn-lg btn-block">Visão Geral</a>
	            <a href="?perfil=curadoria" class="btn btn-theme btn-lg btn-block">Eventos e pedidos em aberto</a>
  	            <a href="?perfil=curadoria" class="btn btn-theme btn-lg btn-block">Orçamentos</a>
            </div>
          </div>
        </div>
    </div>
</section>    
<?php 
break;
case "visaogeral": // mostra todos as igs a preencher
?>

	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Todos os eventos</h2>
					<h4>Selecione o evento para carregar.</h4>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
					</div>
				  </div>
			  </div>  

			<div class="table-responsive list_info">
            <?php 
 	$con = bancoMysqli();
	$idInstituicao = $_SESSION['idInstituicao'];
	if(isset($_GET['f'])){
		if($_GET['f'] == 'dataEnvio'){
			$filtro = " AND dataEnvio IS NOT NULL "; 	
		}else{
			$filtro = " AND dataEnvio IS NULL ";			
		}
		
		
	}else{
		$filtro = "";
	}
	

	if(isset($_POST['projeto'])){
		$projeto = $_POST['projeto'];
		$proj = " AND projetoEspecial = '$projeto' ";	
	}else{
		$proj = "";	
	}
	
	if($_SESSION['idUsuario'] == '390'){ //resolver depois como uma pessoa pode estar em duas instituições ou mais
		$sql = "SELECT * FROM ig_evento WHERE publicado = 1 AND (idInstituicao = '4' OR idInstituicao = '7') AND nomeEvento <> '' $filtro $proj ORDER BY idEvento DESC";
	}else{	
		$sql = "SELECT * FROM ig_evento WHERE publicado = 1 AND idInstituicao = '$idInstituicao' AND nomeEvento <> '' $filtro $proj ORDER BY idEvento DESC";
	}
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query); ?>
	<p>Foram encontrados <?php echo $num ?> evento(s) -  [ <a href="?perfil=curadoria&p=visaogeral">Todos os eventos</a> ] [ <a href="?perfil=curadoria&p=visaogeral&f=dataEnvio">Eventos enviados</a> ] [ <a href="?perfil=curadoria&p=visaogeral&f=nE">Eventos não-enviados</a> ]</p>

	<p>
        <form method="POST" action="?perfil=curadoria&p=visaogeral" class="form-horizontal" role="form">

    <select class="form-control" name="projeto" id="inputSubject" >
                    <option value="1"></option>
					<?php echo geraOpcao("ig_projeto_especial","","") ?>
                    </select><input type="submit" value="filtrar" />
                    </form>
 </p>
<?php
	echo "<table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td>Nome do evento</td>
							<td>Tipo de evento</td>
  							<td>Data/Período</td>
							<td>Usuário</td>
							<td>Status</td>
							<td width='10%'>Contrato</td>
						</tr>
					</thead>
					<tbody>";
					$total = 0;
	while($campo = mysqli_fetch_array($query)){
			$usuario = recuperaUsuario($campo['idUsuario']);
			
			if($campo['dataEnvio'] == NULL){
				$status = "Não enviado";	
			}else{
				$status = "Enviado";	
			}
			
			echo "<tr>";
			echo "<td class='list_description'><a href='?perfil=detalhe&evento=".$campo['idEvento']."' target='_blank'>".$campo['nomeEvento']."</a></td>";
			echo "<td class='list_description'>".retornaTipo($campo['ig_tipo_evento_idTipoEvento'])."</td>";
			echo "<td class='list_description'>".retornaPeriodo($campo['idEvento'])."</td>";
			echo "<td class='list_description'>".$usuario['nomeCompleto']."</td>"	;
			echo "<td class='list_description'>".$status."</td>"	;
			
			echo "
			<td class='list_description'>".dinheiroParaBr(infoContrato($campo['idEvento']))."
			
			</td>"	;
			echo "</tr>";		
		$val = 	infoContrato($campo['idEvento']);		
		$total = $total + $val;

			}
	echo "					</tbody>
				</table>";
	
	?>
	<h5>Total: <?php echo dinheiroParaBr($total); ?></h5>
			</div>
		</div>
	</section> <!--/#list_items-->




<?php 
} // fim da switch $p
?>