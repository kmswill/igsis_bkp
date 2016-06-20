<?php
// Funções específicas do módulo Formação
function retornaPrograma($id){
	$programa = recuperaDados("sis_formacao_programa",$id,"Id_Programa");
	return $programa['Programa'];	
}
function retornaCargo($id){
	$programa = recuperaDados("sis_formacao_cargo",$id,"Id_Cargo");
	return $programa['Cargo'];	
}
function retornaStatus($id){
	if($id != 0){
		return "Ativo";
	}else{
		return "Inativo";	
	}	
}
/*function retornaCargaHoraria($idPedido,$parcelas){
	$con = bancoMysqli();
	$sql = "SELECT * FROM igsis_parcelas WHERE idPedido = '$idPedido' ORDER BY numero ASC";
	$query = mysqli_query($con,$sql);
	$i= 1;
	while($hora = mysqli_fetch_array($query)){
		$carga[$i] = $hora['horas'];
		$i++;
	}
	
	$total = 0;
	
	for($i = 1; $i <= $parcelas; $i++){
		$total = $total + $carga[$i];
	}
	return $total;
}
*/
function retornaPeriodoFormacao($idPedido,$parcelas){
	$con = bancoMysqli();
	$sql1 = "SELECT * FROM igsis_parcelas WHERE idPedido = '$idPedido' AND valor > '0' ORDER BY vigencia_inicio ASC LIMIT 0,1";
	$sql2 = "SELECT * FROM igsis_parcelas WHERE idPedido = '$idPedido' AND valor > '0' ORDER BY vigencia_final DESC LIMIT 0,1";
	$query1 = mysqli_query($con,$sql1);
	$query2 = mysqli_query($con,$sql2);
	$data1 = mysqli_fetch_array($query1);
	$data2 = mysqli_fetch_array($query2);
	
	$periodo = "De ".exibirDataBr($data1['vigencia_inicio'])." a ".exibirDataBr($data2['vigencia_final']);
	
	
	return $periodo;
	
}
function pdfFormacao($idPedido){
	$con = bancoMysqli();
	$sql = "SELECT * FROM sis_formacao WHERE idPedidoContratacao = '$idPedido'";
	$query = mysqli_query($con,$sql);
	$formacao = mysqli_fetch_array($query);
	$cargo = recuperaDados("sis_formacao_cargo",$formacao['IdCargo'],"Id_Cargo");
	$programa = recuperaDados("sis_formacao_programa",$formacao['IdPrograma'],"Id_Programa");
	$linguagem = recuperaDados("sis_formacao_linguagem",$formacao['IdLinguagem'],"Id_Linguagem");
	
	
	$x['Cargo'] = $cargo['Cargo'];
	$x['Programa'] = $programa['Programa'];
	$x['descricaoPrograma'] = $programa['descricao'];
	$x['edital'] = $programa['edital'];
	$x['linguagem'] = $linguagem['Linguagem'];
	$x['processoPagamento'] = $formacao['NumeroProcessoPagamento'];
	return $x;
	
}

function retornaProgramaFormcao($id){
	$con = bancoMysqli();
	$x = recuperaDados("sis_formacao_programa",$id,"Id_Programa");
	return $x['Programa'];	
}

?>