<!DOCTYPE html>
<?php
//Imprime erros com o banco
@ini_set('display_errors', '1');
error_reporting(E_ALL);

//carrega as funcoes gerais
require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php"; 



?>

<html>
  <head>
    <title>IGSIS - Secretaria Municipal de Cultural - São Paulo</title>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- css -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/style.css" rel="stylesheet" media="screen">
	<link href="color/default.css" rel="stylesheet" media="screen">


  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<?php include "../include/script.php"; ?>
      </head>
  <body>
  	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
	                <h5>Eventos cadastrados - Programação Fevereiro/2016 - até 27/11/2015 - www.centrocultural.cc/igsis</h5>
                </div>
            </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Cod.</td>
   							<td>Nome do evento</td>
							<td>Tipo de evento</td>
							<td>Responsável</td>
							<td>Local/Periodo</td>
							<td>Verba/Relação jurídica</td>
							<td>Data do envio</td>

   							<td>Status</td>

						</tr>
					</thead>
					<tbody>
					<?php 
					$con = bancoMysqli();
					$sql = $sql = "SELECT * FROM ig_protocolo,ig_evento WHERE ig_evento.idEvento = ig_protocolo.ig_evento_idEvento AND ig_evento.idInstituicao = '5' AND ig_evento.dataEnvio IS NOT NULL ORDER BY ig_protocolo.idProtocolo DESC LIMIT 0,10
				";	$query = mysqli_query($con,$sql);
					while($evento = mysqli_fetch_array($query) ){
						$tipo = recuperaDados("ig_tipo_evento",$evento['ig_tipo_evento_idTipoEvento'],"idTipoEvento");
						$pessoa = recuperaDados("ig_usuario",$evento['idResponsavel'],"idUsuario");
						$contrato = recuperaDados("ig_modalidade",$evento['ig_modalidade_IdModalidade'],"idModalidade");
					?>

	<td class="list_description"><?php echo $evento['idProtocolo']; ?></td> 
	<td class="list_description"><?php echo $evento['nomeEvento']; ?></td> 
	<td class="list_description"><?php echo $tipo['tipoEvento']; ?></td> 
	<td class="list_description"><?php echo $pessoa['nomeCompleto']; ?></td> 
	<td class="list_description"><?php echo retornaPeriodo($evento['idEvento']); ?></td> 
	<td class="list_description"><?php echo $contrato['modalidade'];  ?></td> 
	<td class="list_description"><?php echo exibirDataBr($evento['dataEnvio']) ?></td> 
	<td class="list_description"></td> 
	</tr>
					<?php } ?>
					
					</tbody>
				</table>
			</div>
		</div>
	</section>
  	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>2015 @ Informações Gerais CCSP + Siscontrat DEC / Secretaria Municipal de Cultura / Prefeitura de São Paulo</p>
				</div>
				<div class="col-md-12">

				</div>
			</div>		
		</div>	
	</footer>
	 
	 <!-- js -->
    <!--<script src="js/jquery.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.smooth-scroll.min.js"></script>
	<script src="js/jquery.dlmenu.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/custom.js"></script>
  	</body>
</html>