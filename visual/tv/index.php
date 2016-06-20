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
  <div id="bar">
  <p id="p-bar"><img src="images/logo_pequeno.png" /><?php echo saudacao(); ?>, </p>
  </div>
	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                <h2>Pedidos de contratação</h2>
	                <h5>Escolha uma opção</h5>
                </div>
            </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
							<td>Cod.</td>
   							<td>Tipo Pessoa</td>
							<td>Proponente</td>
							<td>Objeto</td>
							<td>Local/Periodo</td>
							<td>Verba</td>
							<td>Valor</td>

   							<td>Status</td>

						</tr>
					</thead>
					<tbody>
<tr><td class='lista'> <a href=''>".$linha_tabela_pedido_contratacao['idPedidoContratacao']."</a></td>";
	echo '<td class="list_description">'.retornaPessoa($pedido['TipoPessoa']).					'</td> ';
	echo '<td class="list_description">'.$pessoa['Nome'].						'</td> ';
	echo '<td class="list_description">'.$pedido['Objeto'].				'</td> ';
	echo '<td class="list_description">'.$pedido['Local'].						'</td> ';
	echo '<td class="list_description">'.retornaVerba($pedido['Verba']).						'</td> ';
	echo '<td class="list_description">'.dinheiroParaBr($pedido['ValorGlobal']).						'</td> ';

	echo '<td class="list_description">OK						</td> </tr>';
	
					
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
