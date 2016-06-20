<?php

function recuperaVerbaNome($id){
	$con = bancoMysqli();
	$sql = "SELECT verba FROM sis_verba WHERE Id_Verba = '$id' LIMIT 0,1";
	$query = mysqli_query($con,$sql);
	$verba = mysqli_fetch_array($query);
	return $verba;
}

function atualizaNprocesso(){
	$con = bancoMysqli();
	$sql_atualiza_sei = "SELECT idPedidoContratacao,NumeroProcesso FROM igsis_pedido_contratacao WHERE publicado = '1' AND (nProcesso IS NULL OR nProcesso = '') ";
	$query_atualiza_sei = mysqli_query($con,$sql_atualiza_sei);
	while($atualiza_sei = mysqli_fetch_array($query_atualiza_sei)){
		$idPedido = $atualiza_sei['idPedidoContratacao'];
		$n_processo = trim(soNumero($atualiza_sei['NumeroProcesso']));
		$sql_update_sei = "UPDATE igsis_pedido_contratacao SET nProcesso = '$n_processo' WHERE idPedidoContratacao = '$idPedido'";
		if(mysqli_query($con,$sql_update_sei)){
			return TRUE;	
		}
	}
}

function atualizaNotaEmpenho(){
	$con = bancoMysqli();
	$sql_atualiza_empenho = "SELECT igsis_pedido_contratacao.idPedidoContratacao, igsis_pedido_contratacao.nProcesso, igsis_6354.empenho FROM igsis_pedido_contratacao, igsis_6354 WHERE igsis_pedido_contratacao.publicado = '1' AND igsis_pedido_contratacao.nProcesso = igsis_6354.processo";
	$query_atualiza_empenho = mysqli_query($con,$sql_atualiza_empenho);
	while($pedido = mysqli_fetch_array($query_atualiza_empenho)){
		$ped = $pedido['idPedidoContratacao'];
		$processo = $pedido['nProcesso'];
		$empenho = $pedido['empenho'];
		$data = $pedido['data_empenho'];
		$sql_atualiza = "UPDATE igsis_pedido_contratacao SET NumeroNotaEmpenho = '$empenho',
		DataEmissaoNotaEmpenho = '$data' 
		WHERE idPedidoContratacao = '$ped'";
	}
}

function somaVerba($idInstituicao,$pessoa){
	$con = bancoMysqli();
	$sql = "SELECT * FROM sis_verba WHERE idInstituicao = '$idInstituicao' AND pai IS NOT NULL";
	$query = mysqli_query($con,$sql);
	$total = 0;
	while($valor = mysqli_fetch_array($query)){
		$total = $total + $valor[$pessoa];
	}
	return $total;		
	
}

function somaPedido($idInstituicao,$pessoa){
	$con = bancoMysqli();
	$sql = "SELECT * FROM igsis_pedido_contratacao,ig_evento,ig_usuario WHERE igsis_pedido_contratacao.idEvento = ig_evento.idEvento AND ig_evento.idUsuario = ig_usuario.idUsuario AND ig_usuario.idInstituicao = '$idInstituicao' AND igsis_pedido_contratacao.tipoPessoa = '$pessoa' AND igsis_pedido_contratacao.publicado = '1'"; //recupera todos os pedidos pessoa física
	$query = mysqli_query($con,$sql);
	$total = 0;
	while($valor = mysqli_fetch_array($query)){
		$total = $total + $valor['valor'];	
	}	
	return $total;
}

function sunVerba($idVerba,$tipoPessoa){
	$con = bancoMysqli();
	$sql = "SELECT * FROM igsis_pedido_contratacao WHERE idVerba = '$idVerba' AND publicado = '1' AND tipoPessoa = '$tipoPessoa' AND NumeroNotaEmpenho <> '' AND NumeroNotaEmpenho <> NULL";
	$query = mysqli_query($con,$sql);	
	$valor = 0;
	while ($verba = mysqli_fetch_array($query)){
		$idPedido = $verba['idPedidoContratacao'];
		$valor = $valor + $verba['valor'];
		$sql_multipla = "SELECT * FROM sis_verbas_multiplas WHERE idPedidoContratacao = '$idPedido' AND idVerba = '$idVerba'";
		$query_mulitpla = mysqli_query($con,$sql_multipla);
		while($multipla = mysqli_fetch_array($query_mulitpla)){
			$valor = $valor + $multipla['valor'];
		} 
		
	}	
	
	return $valor;
	
	
}

function geraOpcaoVerba($idUsuario,$selected){
	$con = bancoMysqli();
	$sql = "SELECT * FROM igsis_controle_orcamento WHERE idUsuario = '$idUsuario'";
	$query = mysqli_query($con,$sql);
	while($verba = mysqli_fetch_array($query)){
		$ver = recuperaDados("sis_verba",$verba['idVerba'],"Id_Verba");
		if($verba['idVerba'] == $selected){
			echo "<option value='".$verba['idVerba']."' selected >".$ver['Verba']."</option>";	
		}else{
			echo "<option value='".$verba['idVerba']."' >".$ver['Verba']."</option>";				
		}	
	}
	

}

function sqlVerbaIn($idUsuario){
	$con = bancoMysqli();
	$sql = "SELECT verba FROM ig_usuario WHERE idUsuario = '$idUsuario'";
	$query = mysqli_query($con,$sql);
	while($verba = mysqli_fetch_array($query)){
		$verbaTxt = $verba['verba'];
	}
	return $verbaTxt;
}

function somaVerbaPai($idVerba,$tipoPessoa){
	$con = bancoMysqli();
	if($tipoPessoa == 1){
		$pessoa = "pf";	
	}else{
		$pessoa = "pj";	
	}
	$sql = "SELECT * FROM sis_verba WHERE pai = '$idVerba'";
	$query = mysqli_query($con,$sql);
	$total = 0;
	while($verba = mysqli_fetch_array($query)){
		$total = $total + $verba[$pessoa];
	}	
	
	return $total;
	
}

function somaEmpenhadosVerbaPai($pai,$tipo){
	$con = bancoMysqli();
	if($tipo == 1){
		$pessoa = "pf";	
	}else{
		$pessoa = "pj";	
	}
	$sql = "SELECT * FROM sis_verba WHERE pai = '$pai'";
	$query = mysqli_query($con,$sql);
	$total = 0;
	while($verba = mysqli_fetch_array($query)){
		$total = $total + sunVerba($verba['Id_Verba'],$tipo);
	}	
	return $total;
}

/*
function somaPedido($verba,$tipo){
	$con = bancoMysqli();
	$sql = "SELECT * FROM igsis_pedido_contratacao WHERE idVerba = '$idVerba' AND publicado = '1' AND tipoPessoa = '$tipoPessoa' AND NumeroNotaEmpenho <> '' AND NumeroNotaEmpenho IS NOT NULL";
	$query = mysqli_query($con,$sql);	
	$valor = 0;
	while ($verba = mysqli_fetch_array($query)){
		$idPedido = $verba['idPedidoContratacao'];
		$valor = $valor + $verba['valor'];
		$sql_multipla = "SELECT * FROM sis_verbas_multiplas WHERE idPedidoContratacao = '$idPedido' AND idVerba = '$idVerba'";
		$query_mulitpla = mysqli_query($con,$sql_multipla);
		while($multipla = mysqli_fetch_array($query_mulitpla)){
			$valor = $valor + $multipla['valor'];
		} 
		
	}	
	
	return $valor;
}
*/

function somaSof($verba,$pessoa){
	$con = bancoMysqli();
	atualizaNprocesso(); // atualiza os campos n_processo da tabela igsis_pedido_contratacao 
	// recupera todos os pedidos válidos, com processos SEI inseridos
	$sql_verba = "SELECT 
	igsis_pedido_contratacao.idPedidoContratacao, 
	igsis_pedido_contratacao.nProcesso,
	igsis_6354.empenho,
    igsis_6354.data_empenho,
    igsis_6354.valor
	FROM igsis_pedido_contratacao, igsis_6354 
	WHERE igsis_pedido_contratacao.publicado = '1' AND
	igsis_pedido_contratacao.nProcesso = igsis_6354.processo AND
	igsis_6354.cancelamento = '0' AND
	igsis_pedido_contratacao.idVerba = '$verba' AND
	igsis_pedido_contratacao.tipoPessoa = '$pessoa'
	";
	$query_verba = mysqli_query($con,$sql_verba);
	$total = 0;
	$processo = "";
	while($pedido = mysqli_fetch_array($query_verba)){
		// verifica se existe o processo na tabela igsis_6354
		if($pedido['nProcesso'] != $processo){
			$total = $total + $pedido['valor'];
			$processo = $pedido['nProcesso'];		
		}
	}
	return $total;
}

function somaPedidos($verba,$tipo){
	$con = bancoMysqli();
	$sql = "SELECT valor FROM igsis_pedido_contratacao WHERE publicado = '1' AND idVerba ='$verba' AND tipoPessoa = '$tipo' AND (NumeroNotaEmpenho = '' OR NumeroNotaEmpenho IS NULL) AND estado IS NOT NULL";
	$query = mysqli_query($con,$sql);
	$total = 0;
	while($soma = mysqli_fetch_array($query)){
		$total = $total + $soma['valor'];	
	}
	return $total;  

	
}



?>