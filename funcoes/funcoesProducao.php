<?php 
/*
function verificaAcesso($usuario,$pagina){
	$sql = "SELECT * FROM ig_usuario,ig_papelusuario WHERE ig_usuario.idUsuario = $usuario AND ig_usuario.ig_papelusuario_idPapelUsuario = ig_papelusuario.idPapelUsuario LIMIT 0,1";
	$query = mysql_query($sql);
	$verifica = mysql_fetch_array($query);
	if($verifica["$pagina"] == 1){
		return 1;
	}else{
		return 0;
	}
}
*/

function verificaStatus($idEvento,$idUsuario){
	$con = bancoMysqli();
	$sql = "SELECT * FROM igsis_verifica_producao WHERE idEvento = '$idEvento' AND idUsuario = '$idUsuario'";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0){
		$x = mysqli_fetch_array($query);
		return $x['status'];
	}else{
		return 0;
	}
}

?>