<?php include 'includes/menu.php';?>

<?php

function dataTime($data){
	$x = explode("/",$data);
	$dia = $x[0];
	$mes = $x[1];
	$ano = $x[2];

$data_nova = mktime(0,0,0, $mes, $dia, $ano);	

return $data_nova;

	
}

if(isset($_POST['inicio']) AND $_POST['inicio'] != "")
{
	if($_POST['final'] == "")
	{
		$mensagem = "É preciso informar a data final da busca";	
	}
	else
	{
		if(dataTime($_POST['inicio']) > dataTime($_POST['final']))
		{
			$mensagem = "A data final da busca deve ser maior que a data inicio";	
			$data_inicio = date('Y-m-d',strtotime($data_inicio));
			$data_final = date('Y-m-d', strtotime($data_final));
		}
		else
		{
			$data_inicio = exibirDataMysql($_POST['inicio']);
			$data_final = exibirDataMysql($_POST['final']);
			$mensagem = "Filtro aplicado: eventos entre ".$_POST['inicio']." e ".$_POST['final'];
		}
	}
}
else
	{
		$data_inicio = "";
		$data_final = "";
		$mensagem = "É preciso informar a data inicial da busca";	
	}
	$con = bancoMysqli();
	$sql_busca = "SELECT * FROM ig_evento, igsis_pedido_contratacao WHERE ig_evento.publicado = '1' AND igsis_pedido_contratacao.publicado = '1' AND ig_evento.idEvento = igsis_pedido_contratacao.idEvento AND ig_evento.dataEnvio >= '$data_inicio' AND ig_evento.dataEnvio <= '$data_final' ORDER BY ig_evento.dataEnvio";
	$query_busca = mysqli_query($con,$sql_busca);
	$i = 0;
	while($busca = mysqli_fetch_array($query_busca))
	{
		$pedido = recuperaDados("igsis_pedido_contratacao",$busca['idPedidoContratacao'],"idPedidoContratacao");
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
		}else
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
			$x[$i]['dataEnvio'] = exibirDataBr($evento['dataEnvio']);
			$x[$i]['instituicao'] = $instituicao['sigla'];
			$x[$i]['periodo'] = $periodo;
			$x[$i]['status'] = $pedido['estado'];	
			$x[$i]['operador'] = $operador['nomeCompleto'];		
			$i++;
		}
	}
	$x['num'] = $i;

$mensagem = "Foram encontradas ".$x['num']." pedido(s) de contratação.";
?>
<br />
<br />
	<section id="list_items">
		<div class="container">
			 <h3>Resultado da busca</3>
             <h5>Foram encontrados <?php echo $x['num']; ?> pedidos de contratação.</h5>
             <h5><a href="?perfil=contratos&p=frm_busca_dataenvio">Fazer outra busca</a></h5>
			<div class="table-responsive list_info">
			<?php if($x['num'] == 0){ ?>
			
			<?php }else{ ?>
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Codigo do Pedido</td>
							<td>Processo</td>
							<td>Proponente</td>
							<td>Tipo</td>
							<td>Objeto</td>
							<td>Data de Cadastro</td>
                            <td>Instituição</td>
							<td>Periodo</td>
							<td>Status</td>
   							<td>Operador</td>
						</tr>
					</thead>
					<tbody>
<?php

	$data=date('Y');
	for($h = 0; $h < $x['num']; $h++)
	{
		$status = recuperaDados("sis_estado",$x[$h]['status'],"idEstado");
		if($x[$h]['tipo'] == 'Física')
		{
			echo "<tr><td class='lista'> <a href='?perfil=contratos&p=frm_edita_propostapf&id_ped=".$x[$h]['id']."'>".$x[$h]['id']."</a></td>";
		}
		else
		{
			echo "<tr><td class='lista'> <a href='?perfil=contratos&p=frm_edita_propostapj&id_ped=".$x[$h]['id']."'>".$x[$h]['id']."</a></td>";	
		}
		echo '<td class="list_description">'.$x[$h]['NumeroProcesso'].		'</td>';
		echo '<td class="list_description">'.$x[$h]['proponente'].					'</td> ';
		echo '<td class="list_description">'.$x[$h]['tipo'].					'</td> ';
		echo '<td class="list_description">'.$x[$h]['objeto'].						'</td> ';
		echo '<td class="list_description">'.$x[$h]['dataEnvio'].				'</td> ';
		echo '<td class="list_description">'.$x[$h]['instituicao'].				'</td> ';
		echo '<td class="list_description">'.$x[$h]['periodo'].						'</td> ';
		echo '<td class="list_description">'.$status['estado'].						'</td> ';
		echo '<td class="list_description">'.$x[$h]['operador'].						'</td> </tr>';
	}
?>
					</tbody>
				</table>
			<?php } ?>		
		</div>
			
		</div>
	</section>
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
                        <form method="POST" action="?perfil=contratos&p=frm_busca_dataenvio" class="form-horizontal" role="form">
                <div class="form-group">
                	<div class="col-md-offset-2 col-md-6">
               			 <label>Data início *</label>
                		<input type="text" name="inicio" class="form-control" id="datepicker01" placeholder="">
               		 </div>
                	<div class=" col-md-6">
                		<label>Data encerramento *</label>
                		<input type="text" name="final" class="form-control" id="datepicker02"  placeholder="">
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
	</section>               