	<div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Open Menu</button>
						<ul class="dl-menu">
							<li>
								<a href="?perfil=controle&p=visaogeral">Visão Geral</a>
							</li>
							<li><a href="?perfil=controle&p=verbas">Valores de verbas</a></li>
							<li><a href="?perfil=controle&p=pedidos">Pedidos de contratação</a></li>
							<li><a href="?perfil=controle&p=relatorios">Relatórios</a></li>
   							<li><a href="?perfil=controle">Instituições, usuários e espaços</a></li>
                         					<li><a href="#">+ opções</a>   
                             <ul class="dl-submenu">
                                        <li selected><a href="?perfil=evento&p=basica">Início</a></li>
                                        <li><a href="?secao=perfil">Carregar módulo</a></li>
                                        <li><a href="../include/logoff.php">Sair</a></li>
                                    </ul>
                            </li>   
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
require_once("../funcoes/funcoesVerifica.php");
require_once("../funcoes/funcoesSiscontrat.php");
require_once("../funcoes/funcoesFinanca.php");
require_once("../funcoes/funcoesControle.php");
$con = bancoMysqli();
if(isset($_GET['p'])){
	$p = $_GET['p'];	
}else{
	$p = "inicio";
}
switch($p){
case 'inicio':

?>



<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                <h2>Controle Orçamentário</h2>
	                <h5>Escolha uma opção</h5>
                </div>
            </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="?perfil=controle&p=visaogeral" class="btn btn-theme btn-lg btn-block">Visão Geral</a>
   	            <a href="?perfil=controle&p=verbas" class="btn btn-theme btn-lg btn-block">Valores de verbas</a>
	            <a href="?perfil=controle&p=pedidos" class="btn btn-theme btn-lg btn-block">Pedidos de contratação</a>
	            <a href="?perfil=controle&p=relatorios" class="btn btn-theme btn-lg btn-block">Relatórios</a>
   	           
            </div>
          </div>
        </div>
    </div>
</section>   
<?php 
break;
case 'pedidos':
if(isset($_POST['aprova'])){
	$idPedido = $_POST['idPedido'];
	if($_POST['aprova'] == 1){
	$status = 0;
	$estado = 1;	
	}else{
	$status = 1;
	$estado = 2;
	}
	
	$sql_aprova = "UPDATE igsis_pedido_contratacao SET aprovacaoFinanca = '$status', estado = '$estado' WHERE idPedidoContratacao = '$idPedido'";
	$query_aprova = mysqli_query($con,$sql_aprova);
	if($query_aprova){
		if($status == 0){
			$mensagem = "Pedido $idPedido NÃO APROVADO";	
		}else{
			$mensagem = "Pedido $idPedido APROVADO";
		}	
	}
}

if(isset($_GET['f'])){
	$f = $_GET['f'];	
	if($f == 1){
		$filtro = " AND aprovacaoFinanca = '1' ";
	}else{
		$filtro = " AND aprovacaoFinanca IS NULL ";
	}
}else{
	$filtro = "";
	$f = 2;	//2 é todos
}


?> 
<br />
<br />
<br />
	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                <h2>Pedidos de contratação</h2>
	                <h5><?php if(isset($mensagem)){ echo $mensagem; } ?></h5>
                </div>
            </div>    
            <!--     <div class="form-group">
                         <div class="col-md-offset-2 col-md-8">
                            	<label>Nome do Projeto especial</label>
            	<select class="form-control" name="filtro" id="inputSubject" >
					<option value="1"></option>
					<?php echo geraOpcaoVerba($_SESSION['idUsuario'],"") ?>
                </select> 	<br />
                </div>
            </div>
                        <div class="form-group">
	            <div class="col-md-offset-2 col-md-8">
                	<input type="hidden" name="atualizar" value="1" />
    		        <input type="submit" class="btn btn-theme btn-lg btn-block" value="Aplicar Filtro">
                    <br /><br />
            	</div>
            </div> -->
           <div class="form-group">
	            <div class="col-md-offset-2 col-md-8">
   				<p>* Prazo é o número de dias restantes para o início do contrato.</p>
                <?php 
				switch($f){
				case 0:
				?>
                <h5>[ <a href="?perfil=controle&p=pedidos">Todos os Pedidos</a> ] [ <a href="?perfil=controle&p=pedidos&f=1">Pedidos Aprovados</a> ] [ Pedidos Não aprovados ]</h5><?php
				
				break;
				case 1:
				?>
                <h5>[ <a href="?perfil=controle&p=pedidos">Todos os Pedidos</a> ] [ Pedidos Aprovados ] [ <a href="?perfil=controle&p=pedidos&f=0">Pedidos Não aprovados</a> ]</h5><?php
				
				break;
				case 2:
				?>
                <h5>[ Todos os Pedidos ] [ <a href="?perfil=controle&p=pedidos&f=1">Pedidos Aprovados</a> ] [ <a href="?perfil=controle&p=pedidos&f=0">Pedidos Não aprovados</a> ]</h5><?php
				
				break;			
				?>
				<?php } ?>
            	</div>
            </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
							<td>Cod.</td>
							<td>Envio</td>
   							<td>Tipo Pessoa</td>
							<td>Proponente</td>
							<td>Objeto</td>
							<td width="15%">Local/Periodo</td>
							<td>Verba</td>
							<td>Valor</td>
                            <td>Prazo*</td>
							<td>Aprovado?</td>
   							<td></td>

						</tr>
					</thead>
					<tbody>
<?php
$con = bancoMysqli();
$verbas = sqlVerbaIn($_SESSION['idUsuario']);
$idInstituicao = $_SESSION['idInstituicao'];
$sql = "SELECT igsis_pedido_contratacao.idPedidoContratacao, igsis_pedido_contratacao.tipoPessoa, igsis_pedido_contratacao.idPessoa, igsis_pedido_contratacao.aprovacaoFinanca, ig_evento.dataEnvio, ig_evento.idEvento	 FROM igsis_pedido_contratacao,ig_evento WHERE igsis_pedido_contratacao.publicado = '1' $filtro AND idVerba IN($verbas) AND igsis_pedido_contratacao.estado IS NOT NULL AND ig_evento.idEvento = igsis_pedido_contratacao.idEvento ORDER BY ig_evento.dataEnvio DESC";

$query = mysqli_query($con,$sql);
$num_total = mysqli_num_rows($query);

//paginacao 
$itensPorPagina = 50;
$num_paginas = ($num_total/$itensPorPagina) - 1;

if(isset($_GET['pag'])){
	$pag = $_GET['pag'] - 1;
	$reg = ($pag * $itensPorPagina);
}else{
	$reg = 0;
}


if($num_total <= $itensPorPagina){
	$query_pagina = $query;
}else{
	$sql_pagina =  "SELECT igsis_pedido_contratacao.idPedidoContratacao, igsis_pedido_contratacao.tipoPessoa, igsis_pedido_contratacao.idPessoa, igsis_pedido_contratacao.aprovacaoFinanca, ig_evento.dataEnvio, ig_evento.idEvento FROM igsis_pedido_contratacao,ig_evento WHERE igsis_pedido_contratacao.publicado = '1' $filtro AND idVerba IN($verbas) AND igsis_pedido_contratacao.estado IS NOT NULL AND ig_evento.idEvento = igsis_pedido_contratacao.idEvento ORDER BY ig_evento.dataEnvio DESC LIMIT $reg,$itensPorPagina";	
	$query_pagina = mysqli_query($con,$sql_pagina);
}




$data=date('Y');
while($linha_tabela_pedido_contratacao = mysqli_fetch_array($query_pagina))
 {
	$pedido = siscontrat($linha_tabela_pedido_contratacao['idPedidoContratacao']);
	$pessoa = siscontratDocs($linha_tabela_pedido_contratacao['idPessoa'],$linha_tabela_pedido_contratacao['tipoPessoa']);
	echo "<tr><td class='lista'> <a href='?perfil=controle&p=detalhe&pedido=".$linha_tabela_pedido_contratacao['idPedidoContratacao']."' target='_blank'>".$linha_tabela_pedido_contratacao['idPedidoContratacao']."</a></td>";
	echo '<td class="list_description">'.exibirDataBr($linha_tabela_pedido_contratacao['dataEnvio']).					'</td> ';
	echo '<td class="list_description">'.retornaPessoa($pedido['TipoPessoa']).					'</td> ';
	echo '<td class="list_description">'.$pessoa['Nome'].						'</td> ';
	echo '<td class="list_description">'.$pedido['Objeto'].				'</td> ';
	echo '<td class="list_description">'.resumoOcorrencias($linha_tabela_pedido_contratacao['idEvento']).'</td> ';
	echo '<td class="list_description">'.retornaVerba($pedido['Verba']).						'</td> ';
	echo '<td class="list_description">'.dinheiroParaBr($pedido['ValorGlobal']).						'</td> ';
	echo '<td class="list_description">'.prazoOrcamento($pedido['idEvento']).						'</td> ';
	
	/*
	if(prazoOrcamento($pedido['idEvento']) >= 10){
	
	echo '<td class="list_description">'; 
    echo "<form method='POST' action='?".$_SERVER['QUERY_STRING']."'>
		<input type='hidden' name='aprova' value='".$linha_tabela_pedido_contratacao['aprovacaoFinanca']."' >
		<input type='hidden' name='idPedido' value='".$linha_tabela_pedido_contratacao['idPedidoContratacao']."' >
		<input type ='submit' class='btn btn-theme  btn-block' value='";
	if($linha_tabela_pedido_contratacao['aprovacaoFinanca'] == 1){echo "SIM'";}else{ echo "NÃO' style='background:red; '";}  
		echo "></form>	</td> </tr>";
		}
	}
	
	if(prazoOrcamento($pedido['idEvento']) < 10 AND $linha_tabela_pedido_contratacao['aprovacaoFinanca'] == 1){
		echo '<td class="list_description">'; 
		echo "SIM";  
		echo "</td> </tr>";
	}

	if(prazoOrcamento($pedido['idEvento']) < 10 AND $linha_tabela_pedido_contratacao['aprovacaoFinanca'] == 0){
		echo '<td class="list_description">'; 
		echo "CANCELADO";  
		echo "</td> </tr>";
	}

	*/
	
	echo '<td class="list_description">'; 
    echo "<form method='POST' action='?".$_SERVER['QUERY_STRING']."'>
		<input type='hidden' name='aprova' value='".$linha_tabela_pedido_contratacao['aprovacaoFinanca']."' >
		<input type='hidden' name='idPedido' value='".$linha_tabela_pedido_contratacao['idPedidoContratacao']."' >
		<input type ='submit' class='btn btn-theme  btn-block' value='";
	if($linha_tabela_pedido_contratacao['aprovacaoFinanca'] == 1){echo "SIM'";}else{ echo "NÃO' style='background:red; '";}  
	echo "></form>	</td> </tr>";
}
?>
	
					
					</tbody>
				</table>
                <p>
                <?php for($i = 1; $i <= $num_paginas ;$i++){
					echo "<a href='?perfil=controle&p=pedidos&pag=$i' >[ ".$i." ]</a>";	
				}?>
                </p>
			</div>
		</div>
	</section>


   <?php 
   break;
   case "visaogeral":
   
   if(isset($_GET['pes'])){
		$pes = $_GET['pes'];   
   }else{
		$pes = "1";	   
  }
?>
<br /><br /><br /><br />
<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                
                <h2>Visão Geral de Gastos</h2>
	                <h6>Contratações artísticas com notas de empenho emitidas</h6>
                    <p><?php if(isset($mensagem)){ echo $mensagem; } ?></p>
    
                </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
                        <td>Pessoa Física</td>
							<td>Empenhados</td>
                            <td>Pedidos</td>
							<td>Orçamento</td>
   							<td>Restante</td>
                            <td>Dotação</td>
						</tr>
					</thead>
					<tbody>

<?php
$con = bancoMysqli();
$idUsuario = $_SESSION['idUsuario'];
$n_verba = sqlVerbaIn($idUsuario);
$sql_verba = "SELECT * FROM sis_verba WHERE Id_Verba IN ($n_verba) ORDER BY Verba ASC";
$query_verba = mysqli_query($con,$sql_verba);
while($verba = mysqli_fetch_array($query_verba)){
	$orcamento = $verba['pf'];	
	$restante = $orcamento - somaPedidos($verba['Id_Verba'],1) - somaSof($verba['Id_Verba'],1);
	$dotacao = recuperaDados("ig_detalhamento_acao",$verba['DotacaoOrcamentaria'],"idDetalhamentoAcao");	
?>
<tr>
<td><?php echo $verba['Verba']; ?></td>
<td><?php echo dinheiroParaBr(somaSof($verba['Id_Verba'],1)); ?></td>
<td><?php echo dinheiroParaBr(somaPedidos($verba['Id_Verba'],1)); ?></td>
<td><?php echo dinheiroParaBr($orcamento);?></td>
<td><?php echo dinheiroParaBr($restante); ?></td>
<td><?php echo $dotacao['cod']; ?></td>

</tr>

<?php } ?>
	
				
					</tbody>
				</table>

			</div>
			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
                        <td>Pessoa Jurídica</td>
							<td>Empenhados</td>
                            <td>Pedidos</td>
							<td>Orçamento</td>
   							<td>Restante</td>
                            <td>Dotação</td>
						</tr>
					</thead>
					<tbody>

<?php
$con = bancoMysqli();
$idUsuario = $_SESSION['idUsuario'];
$n_verba = sqlVerbaIn($idUsuario);
$sql_verba = "SELECT * FROM sis_verba WHERE Id_Verba IN ($n_verba) ORDER BY Verba ASC";
$query_verba = mysqli_query($con,$sql_verba);
while($verba = mysqli_fetch_array($query_verba)){
	$orcamento = $verba['pj'];
	$somaPedidos = somaPedidos($verba['Id_Verba'],2);
	$somaSof = 	somaSof($verba['Id_Verba'],2);
	$restante = $orcamento - $somaSof - $somaPedidos;
	$dotacao = recuperaDados("ig_detalhamento_acao",$verba['DotacaoOrcamentaria'],"idDetalhamentoAcao");	
?>
<tr>
<td><?php echo $verba['Verba']; ?></td>
<td><?php echo dinheiroParaBr(somaSof($verba['Id_Verba'],2)); ?></td>
<td><?php echo dinheiroParaBr(somaPedidos($verba['Id_Verba'],2)); ?></td>
<td><?php echo dinheiroParaBr($orcamento);?></td>
<td><?php echo dinheiroParaBr($restante); ?></td>
<td><?php echo $dotacao['cod']; ?></td>

</tr>

<?php } ?>
	
				
					</tbody>
				</table>

			</div>
			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
                        <td>Verba Pai Pessoa Física</td>
							<td>Empenhados</td>
							<td>Orçamento</td>
   							<td>Restante</td>
                            <td></td>
						</tr>
					</thead>
					<tbody>

<?php
$con = bancoMysqli();
$idUsuario = $_SESSION['idUsuario'];
$sql_verba = "SELECT * FROM igsis_controle_orcamento WHERE idUsuario = '$idUsuario'";
$query_verba = mysqli_query($con,$sql_verba);
$verba_antiga = "";
while($x = mysqli_fetch_array($query_verba)){
	$verba = recuperaDados("sis_verba",$x['idVerba'],"Id_Verba");
	$verbaPai = recuperaDados("sis_verba",$verba['pai'],"Id_Verba");
	if($verba_antiga != $verba['pai']){ ?>
<tr>
<td><?php echo $verbaPai['Verba']; ?></td>
<td></td>
<td><?php echo dinheiroParaBr(somaVerbaPai($verba['pai'],1)); ?></td>
<td></td>
<td><?php echo $dotacao['cod']; ?></td>

</tr>		
			
<?php 
	$verba_antiga = $verba['pai'];	
	}

}




?>
	
				
					</tbody>
				</table>

			</div>
            			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
                        <td>Verba Pai Pessoa Jurídica</td>
							<td>Empenhados</td>
							<td>Orçamento</td>
   							<td>Restante</td>
                            <td></td>
						</tr>
					</thead>
					<tbody>

<?php
$con = bancoMysqli();
$idUsuario = $_SESSION['idUsuario'];
$sql_verba = "SELECT * FROM igsis_controle_orcamento WHERE idUsuario = '$idUsuario'";
$query_verba = mysqli_query($con,$sql_verba);
$verba_antiga = "";
while($x = mysqli_fetch_array($query_verba)){
	$verba = recuperaDados("sis_verba",$x['idVerba'],"Id_Verba");
	$verbaPai = recuperaDados("sis_verba",$verba['pai'],"Id_Verba");
	if($verba_antiga != $verba['pai']){ ?>
<tr>
<td><?php echo $verbaPai['Verba']; ?></td>
<td><?php echo dinheiroParaBr(somaEmpenhadosVerbaPai($verba['pai'],2)); ?></td>
<td><?php echo dinheiroParaBr(somaVerbaPai($verba['pai'],2)); ?></td>
<td>
<?php 
$restante = somaVerbaPai($verba['pai'],2) - somaEmpenhadosVerbaPai($verba['pai'],2);

echo dinheiroParaBr($restante); ?>

</td>
<td><?php //echo $dotacao['cod']; ?></td>

</tr>		
			
<?php 
	$verba_antiga = $verba['pai'];	
	}

}




?>
	
				
					</tbody>
				</table>

			</div>
            </div>            
		</div>
	</section>
    
   <?php 
   break;
   case "relatorios":
   
?>
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                <h2>Controle Orçamentário</h2>
	                <h5>Para entender melhor o funcionamento das planilhas, <br /> <a href="http://www.centrocultural.cc/igsis/manual/index.php/tipo-de-relatorios/" target="_blank">clique aqui para ler o manual</a>.</h5>
                    
                </div>
            </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
   	            <a href="../pdf/relatorios.php?rel=seivalido" target="_blank" class="btn btn-theme btn-lg btn-block">Relatório Integração IGSIS/SOF</a>
   	            <a href="../pdf/relatorios.php?rel=seinvalido" target="_blank" class="btn btn-theme btn-lg btn-block">Relatório de Discrepâncias</a>
   	            <a href="../pdf/relatorios.php?rel=nosei" target="_blank" class="btn btn-theme btn-lg btn-block">Relatórios Pedidos de Contratação sem SEI</a>                
            </div>
          </div>
        </div>
    </div>
</section>  



<?php 
   break;
   case "verbas":
   if(isset($_POST['atualizar'])){
		$idVerba = $_POST['idVerba'];		   
		$pj = dinheiroDeBr($_POST['pj']);		   
		$pf = dinheiroDeBr($_POST['pf']);		   
		$premio = dinheiroDeBr($_POST['premio']);
		$sql_atualiza_verba = "UPDATE sis_verba SET
		pf = '$pf',
		pj = '$pj',
		premio = '$premio'
		WHERE Id_Verba = '$idVerba'";
		$con = bancoMysqli();
		$query_atualiza_verba = mysqli_query($con,$sql_atualiza_verba);
		if($query_atualiza_verba){
			$mensagem = "Valores atualizados!";
		}else{
			$mensagem = "Erro ao atualizar valores.";	
		}		   

   }
   
?>
	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                
                <h2>Valores de Verbas</h2>
	                <h6>Exercício 2016 em Reais</h6>
                    <p><?php if(isset($mensagem)){ echo $mensagem; } ?></p>
    
                </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
                        	<td></td>
							<td>Verba</td>
							<td>Pessoa Física</td>
							<td>Pessoa Jurídica</td>
							<td>Prêmio</td>
							<td>Total</td>
  							<td></td>
						</tr>
					</thead>
					<tbody>
<?php
$con = bancoMysqli();
$idUsuario = $_SESSION['idUsuario'];
$n_verba = sqlVerbaIn($idUsuario);
$sql = "SELECT * FROM sis_verba WHERE Id_Verba IN($n_verba) ORDER BY Verba ASC ";
$query = mysqli_query($con,$sql);

while($verba = mysqli_fetch_array($query)){
	
?>

<tr>
<form action="?perfil=controle&p=verbas" method="post">
<td><?php echo $verba['Id_Verba']; ?></td>
<td><?php echo $verba['Verba']; ?></td>
<td><input type="text" name="pf" class="valor" value="<?php echo dinheiroParaBr($verba['pf']); ?>"/></td>
<td><input type="text" name="pj" class="valor" value="<?php echo dinheiroParaBr($verba['pj']); ?>"/></td>
<td><input type="text" name="premio" class="valor" value="<?php echo dinheiroParaBr($verba['premio']); ?>"/></td>

<td><?php echo dinheiroParaBr($verba['premio'] + $verba['pj'] + $verba['pf']) ; ?></td>
<td>
<input type="hidden" name="idVerba" value="<?php echo $verba['Id_Verba']; ?>" />
<input type="hidden" name="atualizar" value="<?php echo $verba['Id_Verba']; ?>" />
<input type ='submit' class='btn btn-theme  btn-block' value='atualizar'></td>
</form>

</tr>
	
    <?php } ?>
<tr>
<td>Total:</td>    
<td><?php echo dinheiroParaBr(somaVerba($_SESSION['idInstituicao'],"pf")) ?></td>    
<td><?php echo dinheiroParaBr(somaVerba($_SESSION['idInstituicao'],"pj"))?></td>    
<td><?php echo dinheiroParaBr(somaVerba($_SESSION['idInstituicao'],"premio"))?></td>    
<td><strong><?php echo dinheiroParaBr(somaVerba($_SESSION['idInstituicao'],"pf") + somaVerba($_SESSION['idInstituicao'],"pj") + somaVerba($_SESSION['idInstituicao'],"premio")); ?></strong></td>
</tr>					
					</tbody>
				</table>

			</div>

            </div>            
		</div>
	</section>

<?php 
break;
case "detalhe":
$pedido = siscontrat($_GET['pedido']);
$pessoa = recuperaPessoa($pedido['IdProponente'],$pedido['TipoPessoa']);
$ped = recuperaDados("igsis_pedido_contratacao",$_GET['pedido'],"idPedidoContratacao");
?>
	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					                     

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
			<div class="table-responsive list_info" >
            <h4><?php echo $pedido['Objeto'] ?></h4>
            <p align="left">
			Número do pedido: <strong>2016-<?php echo $_GET['pedido'] ?></strong> <br />
			Tipo de pessoa: <strong><?php echo $pessoa['tipo']; ?></strong> <br />
 			Nome / Razão Social: <strong><?php echo $pessoa['nome']; ?> (<?php echo $pessoa['numero']; ?>)</strong> <br />
   			Relação Jurídica: <strong><?php echo recuperaModalidade($pedido['CategoriaContratacao']); ?> </strong> <br />
   			Período: <strong><?php echo $pedido['Periodo']; ?> </strong> <br />
   			Local: <strong><?php echo $pedido['Local']; ?> </strong> <br />
   			Verba: <strong><?php echo retornaVerba($pedido['Verba']); ?> </strong> <br />
   			Valor: <strong>R$ <?php echo dinheiroParaBr($pedido['ValorGlobal']); ?> </strong> <br />
   			Forma de Pagamento: <strong><?php echo nl2br($pedido['FormaPagamento']); ?> </strong> <br />	
 			Aprovação Finança: <strong><?php if($ped['aprovacaoFinanca'] == 1){ echo "Aprovado";}else{ echo "NÃO Aprovado";} ?></strong>
                  </p>      

	         <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <?php if($ped['tipoPessoa'] == 2){ ?>
			 <a href="?perfil=contratos&p=frm_edita_propostapj&id_ped=<?php echo $_GET['pedido'];  ?>" class="btn btn-theme btn-block" target="_blank" >Abrir o pedido no Módulo Contratos*</a>
             <?php } else if($ped['tipoPessoa'] == 1){ ?>
			 <a href="?perfil=contratos&p=frm_edita_propostapf&id_ped=<?php echo $_GET['pedido'];  ?>" class="btn btn-theme btn-block" target="_blank" >Abrir o pedido no Módulo Contratos*</a>
             
             <?php } ?>
             </div>	
			</div>
					<div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                    	<br />
                </div>
				</div>

			  <div class="table-responsive list_info" >


</div>
</div>
            </div>
</section>
	
	
<?php   
break;
case "planilha":

$tipo_pessoa = $_POST['tipo_pessoa']; 
if($tipo_pessoa == 0){
	$men_pessoa = "Pessoa: física e jurídica <br />";	
}else{
	$pessoa = " AND igsis_pedido_contratacao.tipoPessoa = '$tipo_pessoa' ";
	if($tipo_pessoa == 1){
		$men_pessoa = "Pessoa: física<br />";
	}else{
		$men_pessoa = "Pessoa: jurídica<br />";
		
	}
}

$data_final  = exibirDataMysql($_POST['data_final']);
$data_inicial  = exibirDataMysql($_POST['data_inicial']); 
if(($_POST['data_inicial'] != "") AND ($_POST['data_inicial'] != "")){
	$data = "BETWEEN ig_evento.dataEnvio = '$data_inicial' AND ig_evento.dataEnvio = '$data_final' ";
	$men_data = "Data de envio: entre ".exibirDataBr($data_inicial)." e ".exibirDataBr($data_final)."<br />";
}else{
	$men_data = "Data de envio: sem data definida.<br />";

}

//refazer	
  $valor_de  = dinheiroDeBr($_POST['valor_de']); 
  $valor_ate  = dinheiroDeBr($_POST['valor_ate']);
if((($valor_de != "") OR $valor_de != '0.00') AND (($data_ate != "") OR ($data_ate != '0.00'))){
	$valor = "AND igsis_pedido_contratacao.valor >= '$valor_de' AND igsis_pedido_contratacao.valor <= '$valor_ate' ";
	$men_valor = "Valores: entre ".dinheiroParaBr($valor_de)." e ".dinheiroParaBr($valor_ate)."<br />";
}else{
	$men_valor = "Valores: sem valores definidos.<br />";

}



  $tipo_evento = $_POST['tipo_evento'];
if($tipo_evento != "0"){
  $tipo = "AND ig_evento.ig_tipo_evento_idTipoEvento = '$tipo_evento' ";
  $men_tipo = "Tipo de vento: ".$tipo_evento;
}else{
  $men_tipo = "Tipo de evento: não definido.";
	
}

  $verba = $_POST['verba'];
if($tipo_evento != "0"){
  $responsavel = $_POST['responsavel'];
  $men_resp = "Responsável: ".$responsavel;
}else{
  $men_resp = "Responsável: não definido.";
	
}  
  

$sql_filtro = "SELECT * FROM igsis_pedido_contratacao, ig_evento WHERE ig_pedido_contratacao.idEvento = ig_evento.idEvento $valor $data $tipo";

?>
<br />
<br />
<br />
	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                <h2>Relatório de Pedidos de contratação</h2>
	                <h6>Você filtrou por: <br /><?php echo $men_pessoa; echo $men_data; echo $men_valor; echo $men_tipo ?></h6>
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
<?php
$idInstituicao = $_SESSION['idInstituicao'];
$sql = "SELECT idPedidoContratacao, tipoPessoa, idPessoa FROM igsis_pedido_contratacao WHERE publicado = '1' AND instituicao = '$idInstituicao'";
$query = mysqli_query($con,$sql);

$data=date('Y');
while($linha_tabela_pedido_contratacao = mysqli_fetch_array($query))
 {
	$pedido = siscontrat($linha_tabela_pedido_contratacao['idPedidoContratacao']);
	$pessoa = siscontratDocs($linha_tabela_pedido_contratacao['idPessoa'],$linha_tabela_pedido_contratacao['tipoPessoa']);
	echo "<tr><td class='lista'> <a href=''>".$linha_tabela_pedido_contratacao['idPedidoContratacao']."</a></td>";
	echo '<td class="list_description">'.retornaPessoa($pedido['TipoPessoa']).					'</td> ';
	echo '<td class="list_description">'.$pessoa['Nome'].						'</td> ';
	echo '<td class="list_description">'.$pedido['Objeto'].				'</td> ';
	echo '<td class="list_description">'.$pedido['Local'].						'</td> ';
	echo '<td class="list_description">'.retornaVerba($pedido['Verba']).						'</td> ';
	echo '<td class="list_description">'.dinheiroParaBr($pedido['ValorGlobal']).						'</td> ';

	echo '<td class="list_description">OK						</td> </tr>';
	}

?>
	
					
					</tbody>
				</table>
			</div>
		</div>
	</section>
<?php if($_SESSION['perfil'] == 1){?>    
<?php var_dump($_POST); ?>
<?php var_dump($sql_filtro); ?>
<?php } ?>
<?php


}
   ?> 
