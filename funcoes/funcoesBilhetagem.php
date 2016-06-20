<?php 

// função que retorna um booleano se há necessidade de confecção de ingresso
function bilhetagem($idEvento){
	$con = bancoMysqli();
	$sql = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$idEvento' AND 
	( 
	retiradaIngresso = '2' OR
	retiradaIngresso = '3' OR
	retiradaIngresso = '4' OR
	retiradaIngresso = '7' OR
	retiradaIngresso = '5' 
	)
	";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0){
		return TRUE;	
	}else{
		return FALSE;		
	}	
	
}

?>

