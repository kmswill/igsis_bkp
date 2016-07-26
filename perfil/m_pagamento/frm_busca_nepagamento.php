
<?php include 'includes/menu.php';?>

<?php
if(isset($_GET['b'])){
	$b = $_GET['b'];	
}else{
	$b = 'inicial';
}

switch($b){
case 'inicial':
if(isset($_POST['pesquisar'])){
$id = trim($_POST['id']);
$evento = trim($_POST['evento']);
$fiscal = $_POST['fiscal'];
$tipo = $_POST['tipo'];
$instituicao = $_POST['instituicao'];
$estado = $_POST['estado'];
$operador = $_POST['operador'];
$juridico = $_POST['juridico'];
$processo = $_POST['NumeroProcesso'];

if($id == "" AND $evento == "" AND $fiscal == 0 AND $tipo == 0 AND $instituicao == 0 AND $estado == 0 AND $processo == 0 AND $operador == 0 AND $juridico == 0)
{ ?>
	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Busca por pedido</h2>
                    <p>É preciso ao menos um critério de busca ou você pesquisou por um pedido inexistente. Tente novamente.</p>

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            <h5><?php if(isset($mensagem)){ echo $mensagem; } ?>
                      <form method="POST" action="?perfil=pagamento&p=frm_busca_nepagamento" class="form-horizontal" role="form">
            		<label>Código do Pedido</label>
            		<input type="text" name="id" class="form-control" id="palavras" placeholder="Insira o Código do Pedido" ><br />
					<label>Número do Processo</label>
            		<input type="text" name="NumeroProcesso" class="form-control" id="palavras" placeholder="Insira o número do processo com a devida pontuação"><br />
					
            		<label>Objeto/Evento</label>
            		<input type="text" name="evento" class="form-control" id="palavras" placeholder="Insira o objeto" ><br />

     
            			          
    	        <label>Fiscal, suplente ou usuário que cadastrou o evento</label>
					<select class="form-control" name="fiscal" id="inputSubject" >
					<option value="0"></option>	
					<?php echo opcaoUsuario($_SESSION['idInstituicao'],"") ?>
                    </select>
                    <br />
                     <label>Tipo de evento</label>
                    <select class="form-control" name="tipo" id="inputSubject" >
					<option value="0"></option>		                
						<?php echo geraOpcao("ig_tipo_evento","","") ?>
                    </select>	
                    <br />
                    <label>Instituição</label>
                    <select class="form-control" name="instituicao" id="inputSubject" >
                   <option value="0"></option>
						<?php echo geraOpcao("ig_instituicao","","") ?>
                    </select>		
                    <br />
                    <label>Status do pedido</label>
                    <select class="form-control" name="estado" id="inputSubject" >
                   <option value='0'></option>


		<?php echo geraOpcao("sis_estado","","") ?>
                    </select>	
                    
                    <label>Operador do Contrato</label>
                    <select class="form-control" name="operador" id="inputSubject" >
                   <option value='0'></option>
	<?php  geraOpcaoContrato(""); ?>
                    </select>	
     <label>Tipo de Relação Jurídica</label>
                    <select class="form-control" name="juridico" id="inputSubject" >
                   <option value='0'></option>
	<?php  geraOpcao("ig_modalidade","",""); ?>
                    </select>	


            	</div>
             </div>
				<br />             
	            <div class="form-group">
		            <div class="col-md-offset-2 col-md-8">
                	<input type="hidden" name="pesquisar" value="1" />
    		        <input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
                    </form>
        	    	</div>
        	    </div>

	</section>
<?php
}
else
{
	$con = bancoMysqli();
	$sql_existe = "SELECT idPedidoContratacao,idEvento,estado FROM igsis_pedido_contratacao WHERE idEvento = '$evento' AND publicado = '1' AND estado IS NOT NULL ORDER BY idPedidoContratacao DESC";
	$query_existe = mysqli_query($con, $sql_existe);
	$num_registro = mysqli_num_rows($query_existe);
	if($id != "" AND $num_registro > 0)
	{ // Foi inserido o número do pedido
		$pedido = recuperaDados("igsis_pedido_contratacao",$id,"idPedidoContratacao");
		if($pedido['estado'] != NULL)
		{
			$evento = recuperaDados("ig_evento",$pedido['idEvento'],"idEvento"); //$tabela,$idEvento,$campo
			$usuario = recuperaDados("ig_usuario",$evento['idUsuario'],"idUsuario");
			$instituicao = recuperaDados("ig_instituicao",$evento['idInstituicao'],"idInstituicao");
			$local = listaLocais($pedido['idEvento']);
			$periodo = retornaPeriodo($pedido['idEvento']);
			$duracao = retornaDuracao($pedido['idEvento']);
			$pessoa = recuperaPessoa($pedido['idPessoa'],$pedido['tipoPessoa']);
			$fiscal = recuperaUsuario($evento['idResponsavel']);
			$suplente = recuperaUsuario($evento['suplente']);
			$protocolo = ""; //recuperaDados("sis_protocolo",$pedido['idEvento'],"idEvento");
			$operador = recuperaUsuario($pedido['idContratos']);
			if($pedido['parcelas'] > 1)
			{
				$valorTotal = somaParcela($pedido['idPedidoContratacao'],$pedido['parcelas']);
				$formaPagamento = txtParcelas($pedido['idPedidoContratacao'],$pedido['parcelas']);	
			}
			else
			{
				$valorTotal = $pedido['valor'];
				$formaPagamento = $pedido['formaPagamento'];
			}
			$x[0]['id']= $pedido['idPedidoContratacao'];
			$x[0]['NumeroProcesso'] = $pedido['NumeroProcesso'];
			$x[0]['objeto'] = retornaTipo($evento['ig_tipo_evento_idTipoEvento'])." - ".$evento['nomeEvento'];
			
			switch ($pedido['tipoPessoa']) {
				case 1: 			
				$pessoa = recuperaDados("sis_pessoa_fisica",$pedido['idPessoa'],"Id_PessoaFisica");
				$x[0]['proponente'] = $pessoa['Nome'];
				$x[0]['tipo'] = "Física";
                break;
				case 2:
				$pessoa = recuperaDados("sis_pessoa_juridica",$pedido['idPessoa'],"Id_PessoaJuridica");
				$x[0]['proponente'] = $pessoa['RazaoSocial'];
				$x[0]['tipo'] = "Jurídica";
				break;
				case 4: 			
				$pessoa = recuperaDados("sis_pessoa_fisica",$pedido['idPessoa'],"Id_PessoaFisica");
				$x[0]['proponente'] = $pessoa['Nome'];
				$x[0]['tipo'] = "Formação";
			    break;
			}
			
			$x[0]['local'] = substr($local,1);
			$x[0]['instituicao'] = $instituicao['sigla'];
			$x[0]['periodo'] = $periodo;
			$x[0]['status'] = $pedido['estado'];
			$x[0]['operador'] = $operador['nomeCompleto'];	
			$x['num'] = 1;
		}
		else
		{
			$x['num'] = 0;
		}
	}
	else
	{ //Não foi inserido o número do pedido
		if($evento != '')
		{
			$filtro_evento = " AND nomeEvento LIKE '%$evento%' OR autor LIKE '%autor%' ";
		}
		else
		{
			$filtro_evento = "";			
		}
		if($fiscal != 0)
		{
			$filtro_fiscal = " AND (idResponsavel = '$fiscal' OR suplente = '$fiscal' OR idUsuario = '$fiscal' )";	
		}
		else
		{
			$filtro_fiscal = "";	
		}
		if($tipo != 0)
		{
			$filtro_tipo = " AND ig_tipo_evento_idTipoEvento = '$tipo' ";	
		}
		else
		{
			$filtro_tipo = "";	
		}
		if($instituicao != 0)
		{
			$filtro_instituicao = " AND idInstituicao = '$instituicao' ";	
		}
		else
		{
			$filtro_instituicao = "";	
		}		
		if($estado == 0)
		{
			$filtro_status = " AND estado IS NOT NULL ";	
		}else
		{
			$filtro_status = " AND estado = '$estado'  ";	
		}
		if($processo == 0)
		{
			$filtro_processo = "";	
		}
		else
		{
			$filtro_processo = " AND igsis_pedido_contratacao.NumeroProcesso LIKE '%$processo%'  ";	
		}
		if($operador == 0)
		{
			$filtro_operador = "";	
		}
		else
		{
			$filtro_operador = " AND idContratos = '$operador'  ";	
		}
		if($juridico == 0)
		{
			$filtro_juridico = " ";	
		}
		else
		{
			$filtro_juridico = " AND ig_evento.ig_modalidade_IdModalidade = '$juridico'  ";	

		}		
		$sql_evento = "SELECT * FROM ig_evento,igsis_pedido_contratacao WHERE ig_evento.publicado = '1' AND igsis_pedido_contratacao.publicado = '1' AND ig_evento.idEvento = igsis_pedido_contratacao.idEvento $filtro_evento $filtro_fiscal $filtro_tipo $filtro_instituicao $filtro_processo $filtro_operador $filtro_juridico  AND estado IS NOT NULL ORDER BY idPedidoContratacao DESC";
		$query_evento = mysqli_query($con,$sql_evento);
		$i = 0;
		while($evento = mysqli_fetch_array($query_evento))
		{
			$idEvento = $evento['idEvento'];	
			$sql_existe = "SELECT idPedidoContratacao,idEvento,estado FROM igsis_pedido_contratacao WHERE idEvento = '$idEvento' AND publicado = '1' $filtro_status ";
			$query_existe = mysqli_query($con, $sql_existe);
			if(mysqli_num_rows($query_existe) > 0)
			{
				while($ped = mysqli_fetch_array($query_existe))
				{	
					$pedido = recuperaDados("igsis_pedido_contratacao",$ped['idPedidoContratacao'],"idPedidoContratacao");
					$evento = recuperaDados("ig_evento",$pedido['idEvento'],"idEvento"); //$tabela,$idEvento,$campo
					$usuario = recuperaDados("ig_usuario",$evento['idUsuario'],"idUsuario");
					$instituicao = recuperaDados("ig_instituicao",$evento['idInstituicao'],"idInstituicao");
					$local = listaLocais($pedido['idEvento']);
					$periodo = retornaPeriodo($pedido['idEvento']);
					$duracao = retornaDuracao($pedido['idEvento']);
					$pessoa = recuperaPessoa($pedido['idPessoa'],$pedido['tipoPessoa']);
					$fiscal = recuperaUsuario($evento['idResponsavel']);
					$suplente = recuperaUsuario($evento['suplente']);
					$protocolo = ""; //recuperaDados("sis_protocolo",$pedido['idEvento'],"idEvento");
					$operador = recuperaUsuario($pedido['idContratos']);
					if($pedido['parcelas'] > 1)
					{
						$valorTotal = somaParcela($pedido['idPedidoContratacao'],$pedido['parcelas']);
						$formaPagamento = txtParcelas($pedido['idPedidoContratacao'],$pedido['parcelas']);	
					}
					else
					{
						$valorTotal = $pedido['valor'];
						$formaPagamento = $pedido['formaPagamento'];
					}
					if($pedido['publicado'] == 1)
					{		
						$x[$i]['id']= $pedido['idPedidoContratacao'];
						$x[$i]['NumeroProcesso']= $pedido['NumeroProcesso'];
						$x[$i]['objeto'] = retornaTipo($evento['ig_tipo_evento_idTipoEvento'])." - ".$evento['nomeEvento'];
						if($pedido['tipoPessoa'] == 1)
						{
							$pessoa = recuperaDados("sis_pessoa_fisica",$pedido['idPessoa'],"Id_PessoaFisica");
							$x[$i]['proponente'] = $pessoa['Nome'];
							$x[$i]['tipo'] = "Física";
						}
						else
						{
							$pessoa = recuperaDados("sis_pessoa_juridica",$pedido['idPessoa'],"Id_PessoaJuridica");
							$x[$i]['proponente'] = $pessoa['RazaoSocial'];
							$x[$i]['tipo'] = "Jurídica";
						}
						$x[$i]['local'] = substr($local,1);
						$x[$i]['instituicao'] = $instituicao['sigla'];
						$x[$i]['periodo'] = $periodo;
						$x[$i]['status'] = $pedido['estado'];	
						$x[$i]['operador'] = $operador['nomeCompleto'];		
						$i++;
					}
				}
			}
		}
		$x['num'] = $i;
	}
} 



$mensagem = "Foram encontradas ".$x['num']." pedido(s) de contratação.";
?>
<br />
<br />
	<section id="list_items">
		<div class="container">
			 <h3>Resultado da busca</3>
             <h5>Foram encontrados <?php echo $x['num']; ?> pedidos de contratação.</h5>
             <h5><a href="?perfil=pagamento&p=frm_busca_nepagamento">Fazer outra busca</a></h5>
			<div class="table-responsive list_info">
			<?php if($x['num'] == 0){ ?>
			
			<?php }else{ ?>
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Processo</td>
							<td>Codigo do Pedido</td>
							<td>Proponente</td>
							<td>Tipo</td>
							<td>Objeto</td>
							<td>Status</td>
							<td colspan="7">GERAR</td>
						</tr>
					</thead>
					<tbody>
<?php

$data=date('Y');
for($h = 0; $h < $x['num']; $h++)
{
	$status = recuperaDados("sis_estado",$x[$h]['status'],"idEstado");
	echo '<tr><td class="list_description">'.$x[$h]['NumeroProcesso'].				'</td>';
	echo '<td class="list_description">'.$x[$h]['id'].							'</td>';
	echo '<td class="list_description">'.$x[$h]['proponente'].					'</td>';
	echo '<td class="list_description">'.$x[$h]['tipo'].						'</td>';
	echo '<td class="list_description">'.$x[$h]['objeto'].						'</td>';
	echo '<td class="list_description">'.$status['estado'].						'</td>';
	if($x[$h]['tipo'] == 'Física' OR $x[$h]['tipo'] == 'Formação' )
	{
		echo "<td><a href='?perfil=pagamento&p=frm_cadastra_notaempenho_pf&id_ped=".$x[$h]['id']."'>NOTA DE EMPENHO</a><td>";
		echo "<td><a href='?perfil=pagamento&p=frm_cadastra_pagamento_pf&id_ped=".$x[$h]['id']."'>PAGAMENTO</a><td>";
		echo "<td><a href='?perfil=pagamento&p=frm_cadastra_liquidacao&id_ped=".$x[$h]['id']."'>LIQUIDAÇÃO</a><td>";
		echo "<td><a href='?perfil=pagamento&p=frm_cadastra_emissao_nf&id_ped=".$x[$h]['id']."'>EMISSÃO N.F.</a><td>";
	}
	else
	{
		echo "<td><a href='?perfil=pagamento&p=frm_cadastra_notaempenho_pj&id_ped=".$x[$h]['id']."'>NOTA DE EMPENHO</a><td>";
		echo "<td><a href='?perfil=pagamento&p=frm_cadastra_pagamento_pj&id_ped=".$x[$h]['id']."'>PAGAMENTO</a><td>";
		echo "<td><a href='?perfil=pagamento&p=frm_cadastra_liquidacao&id_ped=".$x[$h]['id']."'>LIQUIDAÇÃO</a><td>";
		echo "<td><a href='?perfil=pagamento&p=frm_cadastra_emissao_nf&id_ped=".$x[$h]['id']."'>EMISSÃO N.F.</a><td>";
	}
	echo "</tr>";
}
?>
	
					
					</tbody>
				</table>
			<?php } ?>		
		</div>
			
		</div>
	</section>


<?php
}else{
?>
	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Busca por pedido</h2>
                    

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            <h5><?php if(isset($mensagem)){ echo $mensagem; } ?>
                        <form method="POST" action="?perfil=pagamento&p=frm_busca_nepagamento" class="form-horizontal" role="form">
            		<label>Código do Pedido</label>
            		<input type="text" name="id" class="form-control" id="palavras" placeholder="Insira o Código do Pedido" ><br />
					
					<label>Número do Processo</label>
            		<input type="text" name="NumeroProcesso" class="form-control" id="palavras" placeholder="Insira número do processo" ><br />
					
            		<label>Objeto/Evento</label>
            		<input type="text" name="evento" class="form-control" id="palavras" placeholder="Insira o objeto" ><br />

     
            			          
    	        <label>Fiscal, suplente ou usuário que cadastrou o evento</label>
					<select class="form-control" name="fiscal" id="inputSubject" >
					<option value="0"></option>	
					<?php echo opcaoUsuario($_SESSION['idInstituicao'],"") ?>
                    </select>
                    <br />
                     <label>Tipo de evento</label>
                    <select class="form-control" name="tipo" id="inputSubject" >
					<option value="0"></option>		                
						<?php echo geraOpcao("ig_tipo_evento","","") ?>
                    </select>	
                    <br />
                    <label>Instituição</label>
                    <select class="form-control" name="instituicao" id="inputSubject" >
                   <option value="0"></option>
						<?php echo geraOpcao("ig_instituicao","","") ?>
                    </select>	
                    <br />
                                        <label>Status do pedido</label>
                    <select class="form-control" name="estado" id="inputSubject" >
                   <option value=""></option>
		<?php echo geraOpcao("sis_estado","","") ?>
                    </select>	<br />
                    
	                    <label>Operador do Contrato</label>
                    <select class="form-control" name="operador" id="inputSubject" >
                   <option value='0'></option>
	<?php  geraOpcaoContrato(""); ?>
                    </select>
                    <br />	
     <label>Tipo de Relação Jurídica</label>
                    <select class="form-control" name="juridico" id="inputSubject" >
                   <option value='0'></option>
	<?php  geraOpcao("ig_modalidade","",""); ?>
                    </select>	

            	</div>
             </div>
             

				<br />             
	            <div class="form-group">
		            <div class="col-md-offset-2 col-md-8">
                	<input type="hidden" name="pesquisar" value="1" />
    		        <input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
                    </form>
        	    	</div>
        	    </div>
             </div>
	</section>               


<?php } break;
} ?>