<?php
   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 

function bancoMysqli(){ 
	$servidor = 'localhost';
	$usuario = 'root';
	$senha = 'lic54eca';
	$banco = 'igsis';
	$con = mysqli_connect($servidor,$usuario,$senha,$banco); 
	mysqli_set_charset($con,"utf8");
	return $con;
}
$con = bancoMysqli();
function recuperaDados($tabela,$idEvento,$campo){ //retorna uma array com os dados de qualquer tabela. serve apenas para 1 registro.
	$con = bancoMysqli();
	$sql = "SELECT * FROM $tabela WHERE ".$campo." = '$idEvento' LIMIT 0,1";
	$query = mysqli_query($con,$sql);
	$campo = mysqli_fetch_array($query);
	return $campo;		
}


function recuperaVerba($idverba){ //dados da tabela sis_verba
	$con = bancoMysqli();
	$sql = "SELECT * FROM sis_verba WHERE Id_Verba = $idverba";
		$query = mysqli_query($con,$sql);
		$x = mysqli_fetch_array($query);
		$y['dotacao'] = $x['DotacaoOrcamentaria']; 
		$y['detalhamento'] = $x['DetalhamentoAcao'];
		$y['reservapj'] = $x['NumeroReservaPJ'];
		$y['linkpj'] = $x['LinkPJ'];
		$y['reservapf'] = $x['NumeroReservaPF'];
		$y['linkpf'] = $x['LinkPF'];
		
		return $y;
}


 function listaLocais($idEvento){
	$con = bancoMysqli();
	

	$sql_virada = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$idEvento' AND publicado = '1' AND virada = '1' ";
	$query_virada = mysqli_query($con,$sql_virada);
	$num = mysqli_num_rows($query_virada);
	if($num > 0){
		
		$locais = "DE ACORDO COM PROGRAMAÇÃO DO EVENTO NO PERÍODO DA VIRADA CULTURAL.";
		
	}else{
	
	$sql = "SELECT DISTINCT local FROM ig_ocorrencia WHERE idEvento = '$idEvento' AND publicado = '1'";
	$query = mysqli_query($con,$sql);	
	$locais = "";
	
	
	
	while($local = mysqli_fetch_array($query)){
		$sala = recuperaDados("ig_local",$local['local'],"idLocal");
		$instituicao = recuperaDados("ig_instituicao",$sala['idInstituicao'],"idInstituicao");
		$locais = $locais.", ".$sala['sala']." (".$instituicao['sigla'].")";
	}
	
	}
	return $locais;

}


$id = $_GET['evento'];

echo "<pre>";
$x = listaLocais($id);
var_dump($x);
echo "</pre>";

	$sql_virada = "SELECT DISTINCT local FROM ig_ocorrencia WHERE idEvento = '$idEvento' AND publicado = '1' AND virada = '1' ";
	$query_virada = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query_virada);
	
	echo $num;

?>