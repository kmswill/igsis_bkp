<!-- MENU -->	
<?php include 'includes/menu.php';?>
<?php 
require "../funcoes/funcoesAdministrador.php";
if(isset($_GET['pag'])){
	$pag = $_GET['pag'];	
}else{
	$pag = "inicial";	
}

switch($pag){
	case "inicial":
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
					$sql_busca = "SELECT * FROM igsis_chamado, ig_evento WHERE igsis_chamado.idEvento = ig_evento.idEvento ORDER BY idChamado DESC";
					$query_busca = mysqli_query($con,$sql_busca);
						while($chamado = mysqli_fetch_array($query_busca)){ 
						$tipo = recuperaDados("igsis_tipo_chamado",$chamado['tipo'],"idTipoChamado");
						$usuario = recuperaDados("ig_usuario",$chamado['idUsuario'],"idUsuario");
						
						?>
						
					<tr>
					<td><?php echo $chamado['idChamado']; ?></td>
					<td><a href="?perfil=contratos&p=frm_chamados&pag=editar&id=<?php echo $chamado['idChamado'] ?>" target="_blank" ><?php echo $tipo['chamado']." - ".$chamado['titulo']; ?>
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

	case "editar":
	?>


 <?php
$idChamado = $_GET['id'];	

// Atualiza o banco com as informações do post
if(isset ($_POST ['atualizar'])) {
		$idChamado = $_POST['idChamado'];
		$titulo = $_POST ['listaTitulo'];
		$status = $_POST ['estado'];
		$nota = $_POST ['nota'];
		//$nome = $_POST ['nomeCompleto'];
		
		$sql_atualizar = "UPDATE `igsis_chamado` SET
		`titulo`= '$titulo',
		`estado`= '$status',
		`nota`= '$nota'
			WHERE `idChamado` ='$idChamado'";
		
		$con = bancoMysqli();
		if(mysqli_query($con,$sql_atualizar)){
			$mensagem = "Atualizado com Sucesso.";
			gravarLog($sql_atualizar);
		} else {
			$mensagem = "Erro ao gravar atualização... Tente novamente.";
		}
}
	$recuperaChamado = recuperaDados("igsis_chamado",$idChamado,"idChamado");
	$recuperaUser = recuperaDados("ig_usuario",$recuperaChamado['idUsuario'],"idUsuario");
	$recuperaEvento = recuperaDados("ig_evento",$recuperaChamado['idEvento'],"idEvento");
	?>
<section id="chamado" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-4 col-md-6">
                <div class="text-hide">
                    <h3>CHAMADO</h3>
					<h3><?php if(isset($mensagem)){echo $mensagem;} ?></h3>
                </div>
            </div>
    	</div>
					<div class="row">
        <div class="col-md-offset-0 col-md-12">
	<form method="POST" action="?perfil=contratos&p=frm_chamados&pag=editar&id=<?php echo $idChamado; ?>" class="form-horizontal" role="form">
			<div class=form-group">
				<div class="col-md-offset-2 col-md-8">
                		<label>ID Chamado:</label>		<!-- // numero do chamado !-->		
                		<input type="text" readonly name="idChamado" class="form-control"id="idChamado" value="<?php echo $recuperaChamado['idChamado'] ?>" /> 
				</div> 
						<div class="col-md-offset-2 col-md-8">
						<label>Nome do Evento:</label>
                			<input readonly name="nomeEvento" class="form-control" id="nomeEvento" value="<?php echo $recuperaEvento['nomeEvento'] ?>"/>  </div>
			</div> 	
        <div class="form-group">
			<div  class="col-md-offset-2 col-md-4">					
           		<label>Titulo chamado:</label> 
				<input readonly name="tipoChamado" class="form-control" value="<?php echo $recuperaChamado['titulo']?>"/>
			</div>  
			<div class="col-md-offset- col-md-4">	
           		<label>Data do chamado:</label>
        	<input type="text" readonly name="data" onblur="validate()" class="form-control"id="data" value="<?php echo $recuperaChamado['data'] ?>" />
			</div>	
				<div  class="col-md-offset-2 col-md-8">
						<label>Tipo chamado:</label>
                		<select disabled name="listaTitulo" class="form-control">
						<?php geraTituloChamado("igsis_tipo_chamado",$recuperaChamado ['titulo'],""); ?>	</select>	
                	</div>   
		</div>	
			<div class="form-group">
				<div class="col-md-offset-2 col-md-4">	
                	<label>Criado por:</label>
					<input readonly name="nomeCompleto" class="form-control" id="nomeCompleto" value="<?php echo $recuperaUser['nomeCompleto'] ?>"/>
                </div> 
				<div class="col-md-offset-0 col-md-6">
					<label>Email:</label>
                	<input readonly name="email" class="form-control" id="email" value="<?php echo $recuperaUser['email'] ?>"/>
				</div>	
			</div>
				
				<!-- Usuário que preencheou o chamado !--> 
				<div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            		<label>Descrição:</label>
            		<textarea readonly name="descricao" class="form-control" rows="10"> <?php echo $recuperaChamado['descricao'] ?></textarea>
            	</div>  	<div class="col-md-offset-2 col-md-8">
            		<label>Justificativa:</label>
            		<textarea name="justificativa" readonly class="form-control" rows="10"> <?php echo $recuperaChamado['justificativa'] ?></textarea>
            	</div> <!-- Preenchemento feito pelo usuário !-->  
            </div>
					<div class="col-md-offset-2 col-md-8">	
                		<label>Status:</label>
                		<select name="estado" class="form-control"  >
						<?php geraStatusChamado("igsis_tipo_chamado",$recuperaChamado['estado'],""); ?> </select>                </div> 
				 <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            		<label>Notas adicionais:</label>
            		<textarea name="nota" class="form-control" rows="10"><?php echo $recuperaChamado['nota'] ?></textarea>
            	</div> <!-- Fim de Preenchemento !-->  
            </div>
		<div class=form-group">
			<div class="col-md-offset-4 col-md-4">
                    	<input type="hidden" name="carregaChamado" value="<?php echo $idChamado ?>"  />
						<input type="hidden" name="atualizar" value="1" />
                		<input type="submit" class="btn btn-theme btn-lg btn-block" value="	concluir"  />
					</div>
						</div> 
		</form>				
		
		
			<form method="POST" action="?perfil=contratos&p=frm_chamados" class="form-horizontal"  role="form">
				<div class="col-md-offset-4 col-md-4">
					<input type="submit" class="btn btn-theme btn-lg btn-blcok" value="Lista de chamados" />
					</div>

				</form>
			</div> 
			</div>
		</div>
	
</section>   




<?php
break;
case "evento":
$idEvento = $_GET['idEvento'];
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
					$sql_busca = "SELECT * FROM igsis_chamado, ig_evento WHERE igsis_chamado.idEvento = ig_evento.idEvento AND ig_evento.idEvento = '$idEvento' ORDER BY idChamado DESC";
					$query_busca = mysqli_query($con,$sql_busca);
						while($chamado = mysqli_fetch_array($query_busca)){ 
						$tipo = recuperaDados("igsis_tipo_chamado",$chamado['tipo'],"idTipoChamado");
						$usuario = recuperaDados("ig_usuario",$chamado['idUsuario'],"idUsuario");
						
						?>
						
					<tr>
					<td><?php echo $chamado['idChamado']; ?></td>
					<td><a href="?perfil=contratos&p=frm_chamados&pag=editar&id=<?php echo $chamado['idChamado'] ?>" target="_blank" ><?php echo $tipo['chamado']." - ".$chamado['titulo']; ?>
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

} ?>