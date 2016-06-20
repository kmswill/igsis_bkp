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
$estado = $_POST['estado'];
$processo = $_POST['NumeroProcesso'];
$proponente = $_POST['proponente'];

if($id == "" AND $estado == 0 AND $processo == 0 AND $proponente == "" )
{ ?>
	<section id="services" class="home-section bg-white">
		<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">
			<div class="section-heading">
				<h2>Busca Formação</h2>
				<p>É preciso ao menos um critério de busca ou você pesquisou por um pedido inexistente. Tente novamente.</p>
			</div>
		  </div>
	    </div>
		<div class="row">
        <div class="form-group">
        <div class="col-md-offset-2 col-md-8">
            <h5><?php if(isset($mensagem)){ echo $mensagem; } ?>
            <form method="POST" action="?perfil=formacao&p=frm_busca_pagamento" class="form-horizontal" role="form">
            <label>Código do Pedido</label>
				<input type="text" name="id" class="form-control" id="palavras" placeholder="Insira o Código do Pedido" ><br />
			<label>Número do Processo</label>
				<input type="text" name="NumeroProcesso" class="form-control" id="palavras" placeholder="Insira o número do processo com a devida pontuação"><br />
			<label>Proponente</label>
				<input type="text" name="proponente" class="form-control" id="palavras" placeholder="Insira o nome do proponente" ><br />
    	    <label>Status do pedido</label>
				<select class="form-control" name="estado" id="inputSubject" >
				<option value='0'></option>
				<?php echo geraOpcao("sis_estado","","") ?>
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
	$sql_existe = "SELECT * FROM igsis_pedido_contratacao, sis_formacao, sis_pessoa_fisica WHERE sis_formacao.idPedidoContratacao = igsis_pedido_contratacao.idPedidoContratacao AND igsis_pedido_contratacao.idPessoa = sis_pessoa_fisica.Id_PessoaFisica AND igsis_pedido_contratacao.publicado = '1' AND tipoPessoa = '4' AND estado IS NOT NULL ORDER BY igsis_pedido_contratacao.idPedidoContratacao DESC";
	$query_existe = mysqli_query($con, $sql_existe);
	$num_registro = mysqli_num_rows($query_existe);
	if($id != "" AND $num_registro > 0) // Foi inserido o número do pedido
	{
		$pedido = recuperaDados("igsis_pedido_contratacao",$id,"idPedidoContratacao");
		if($pedido['estado'] != NULL)
		{
			$pessoa = recuperaPessoa($pedido['idPessoa'],4);
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
			$pessoa = recuperaDados("sis_pessoa_fisica",$pedido['idPessoa'],"Id_PessoaFisica");
			$x[0]['proponente'] = $pessoa['Nome'];
			$x[0]['status'] = $pedido['estado'];
			$x['num'] = 1;
		}
		else
		{
			$x['num'] = 0;		
		}
	}
	else
	{ //Não foi inserido o número do pedido
		
		if($estado == 0)
		{
			$filtro_status = " AND estado IS NOT NULL ";	
		}
		else
		{
			$filtro_status = " AND igsis_pedido_contratacao.estado = '$estado'  ";	
		}	
		if($processo == 0)
		{
			$filtro_processo = "";	
		}
		else
		{
			$filtro_processo = " AND igsis_pedido_contratacao.NumeroProcesso LIKE '%$processo%'  ";	
		}
		if($proponente == '')
		{
			$filtro_proponente = "";
		}
		else
		{
			$filtro_proponente = " AND sis_pessoa_fisica.Nome LIKE '%$proponente%' ";
		}
		$sql_evento = "SELECT igsis_pedido_contratacao.NumeroProcesso, igsis_pedido_contratacao.estado, sis_pessoa_fisica.Nome, igsis_pedido_contratacao.idPedidoContratacao FROM sis_formacao,igsis_pedido_contratacao, sis_pessoa_fisica WHERE sis_formacao.publicado = '1' AND igsis_pedido_contratacao.publicado = '1' AND sis_formacao.idPedidoContratacao = igsis_pedido_contratacao.idPedidoContratacao AND igsis_pedido_contratacao.idPessoa = sis_pessoa_fisica.Id_PessoaFisica $filtro_processo $filtro_proponente $filtro_status ORDER BY sis_pessoa_fisica.Nome";
		$query_evento = mysqli_query($con,$sql_evento);
		$i = 0;
		while($evento = mysqli_fetch_array($query_evento))
		{
			//$sql_existe = "SELECT sis_formacao.idPedidoContratacao FROM igsis_pedido_contratacao, sis_formacao WHERE sis_formacao.idPedidoContratacao = igsis_pedido_contratacao.idPedidoContratacao AND igsis_pedido_contratacao.publicado = '1' $filtro_status ";
			//$query_existe = mysqli_query($con, $sql_existe);
			if(mysqli_num_rows($query_evento) > 0)
			{
					$pedido = recuperaDados("igsis_pedido_contratacao",$evento['idPedidoContratacao'],"idPedidoContratacao");
					$pessoa = recuperaPessoa($pedido['idPessoa'],4);
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
		
						$x[$i]['id']= $pedido['idPedidoContratacao'];
						$x[$i]['NumeroProcesso']= $pedido['NumeroProcesso'];
						$pessoa = recuperaDados("sis_pessoa_fisica",$pedido['idPessoa'],"Id_PessoaFisica");
						$x[$i]['proponente'] = $pessoa['Nome'];
						$x[$i]['status'] = $pedido['estado'];	
						$i++;
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
             <h5><a href="?perfil=formacao&p=frm_busca_pagamento">Fazer outra busca</a></h5>
			<div class="table-responsive list_info">
			<?php if($x['num'] == 0){ ?>
			
			<?php }else{ ?>
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Processo</td>
							<td>Codigo do Pedido</td>
							<td>Proponente</td>
							<td>Status</td>
						</tr>
					</thead>
					<tbody>
<?php

$data=date('Y');
for($h = 0; $h < $x['num']; $h++)
 {
	 //$pessoa = recuperaDados("sis_pessoa_fisica",$pedido['idPessoa'],"Id_PessoaFisica");
	 $status = recuperaDados("sis_estado",$x[$h]['status'],"idEstado");
	 //$ped = siscontrat($pedido['idPedidoContratacao']);	 

	echo "<tr><td class='lista'> <a href='?perfil=formacao&p=frm_cadastra_pagamento_pf&id_ped=".$x[$h]['id']."'>".$x[$h]['NumeroProcesso']."</a></td>";
	
	echo '<td class="list_description">'.$x[$h]['id'].		  '</td>';
	echo '<td class="list_description">'.$x[$h]['proponente'].'</td> ';
	echo '<td class="list_description">'.$status['estado'].	  '</td> ';
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
					 <h2>Busca Formação</h2>
                    

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            <h5><?php if(isset($mensagem)){ echo $mensagem; } ?>
                        <form method="POST" action="?perfil=formacao&p=frm_busca_pagamento" class="form-horizontal" role="form">
            		<label>Código do Pedido</label>
            		<input type="text" name="id" class="form-control" id="palavras" placeholder="Insira o Código do Pedido" ><br />
					
					<label>Número do Processo</label>
            		<input type="text" name="NumeroProcesso" class="form-control" id="palavras" placeholder="Insira número do processo" ><br />
					
					<label>Proponente</label>
					<input type="text" name="proponente" class="form-control" id="palavras" placeholder="Insira o nome do proponente" ><br />
 
					<label>Status do pedido</label>
                    <select class="form-control" name="estado" id="inputSubject" >
                   <option value=""></option>
					<?php echo geraOpcao("sis_estado","","") ?>
                    </select>	<br />

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


<?php } ?>

<?php
break;
case 'periodo': //
?>
<?php

break;

} // fim da switch

 ?>