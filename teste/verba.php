<?php


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

$id = $_GET['verba'];

echo "<pre>";
$x = recuperaVerba($id);
var_dump($x);
echo "</pre>";

?>