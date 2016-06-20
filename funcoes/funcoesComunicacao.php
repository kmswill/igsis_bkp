<?php 

function listaCom($st,$intituicao,$num_registro,$pagina,$ordem){
	$con = bancoMysqli();

	//tratamento dos parametros
	$status = "";


	switch($st){
	case "todos":
		$status = "";
	break;
	case "editado":
		$status = " AND editado = '1' ";
	break;
	case "revisado":
		$status = " AND revisado = '1' ";
	break;
	case "site":
		$status = " AND site = '1' ";
	break;
	case "publicacao":
		$status = " AND publicacao = '1' ";
	break;
	}

	
	$sql_busca_dic = "SELECT * FROM ig_comunicacao WHERE ig_evento_idEvento IS NOT NULL $status ORDER BY idCom $ordem LIMIT 0,$num_registro";
	$query_busca_dic = mysqli_query($con,$sql_busca_dic);
	$i = 0;
		while($dic = mysqli_fetch_array($query_busca_dic)){ 
			$evento = recuperaDados("ig_evento",$evento['ig_evento_idEvento'],"idEvento");
			$usuario = recuperaUsuario($event['idUsuario']);
			
			$x[$i]['nomeEvento'] = $dic['nomeEvento'];
			$x[$i]['protocoloIg'] = retornaProtoEvento($dic['ig_evento_idEvento']);
			$x[$i]['idUsuario'] = $usuario['nomeCompleto'];
			$x[$i]['nomeEvento'] = retornaPeriodo($dic['ig_evento_idEvento']);
			$x[$i]['idEvento'] = $dic['idEvento'];
		}
	return $x;
}

function geraServico($idEvento){
	$con = bancoMysqli();
	$sql = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$idEvento' ORDER BY  idTipoOcorrencia";
	$query = mysqli_query($con,$sql);
	$x = "";
	while($ocorrencia = mysqli_fetch_array($query)){
			$retirada = recuperaDados("ig_retirada",$ocorrencia['retiradaIngresso'],"idRetirada");
			if($ocorrencia['idTipoOcorrencia'] == '3' OR 
			$ocorrencia['dataInicio'] == $ocorrencia['dataFinal'] ){
			$local = recuperaDados("ig_local",$ocorrencia['local'],"idLocal");	
			$instituicao = recuperaDados("ig_instituicao",$local['idInstituicao'],"idInstituicao");
			
			
			$x = $x."| ".$local['sala']."(".$instituicao['instituicao'].") .Dia ".substr(exibirDataBr($ocorrencia['dataInicio']),0,5).", ".substr(($ocorrencia['horaInicio']),0,2)."h<br />";
			}
			if($ocorrencia['idTipoOcorrencia'] == '6' ){
			$local = recuperaDados("ig_local",$ocorrencia['local'],"idLocal");	
			$instituicao = recuperaDados("ig_instituicao",$local['idInstituicao'],"idInstituicao");
			$sub = recuperaDados("ig_sub_evento",$ocorrencia['idSubEvento'],"idSubEvento");
			$x = $x."| ".$sub['titulo']." - ".$local['sala']." .Dia ".substr(exibirDataBr($ocorrencia['dataInicio']),0,5).", ".substr(($ocorrencia['horaInicio']),0,2)."h<br />";
			}
			if($ocorrencia['idTipoOcorrencia'] == '4' ){
			$local = recuperaDados("ig_local",$ocorrencia['local'],"idLocal");
			$instituicao = recuperaDados("ig_instituicao",$local['idInstituicao'],"idInstituicao");
			$semana = "";
			if($ocorrencia['segunda'] == 1){
				$semana = $semana."segunda,";
			}
			if($ocorrencia['terca'] == 1){
				$semana = $semana." terça,";
			}
			if($ocorrencia['quarta'] == 1){
				$semana = $semana." quarta,";
			}
			if($ocorrencia['quinta'] == 1){
				$semana = $semana." quinta,";
			}
			if($ocorrencia['sexta'] == 1){
				$semana = $semana." sexta,";
			}
			if($ocorrencia['sabado'] == 1){
				$semana = $semana."	sábado,";
			}
			if($ocorrencia['domingo'] == 1){
				$semana = $semana." domingo,";
			}


			
			$x = $x."| ".$local['sala']."(".$instituicao['instituicao'].") .De ".substr(exibirDataBr($ocorrencia['dataInicio']),0,5)." a ".substr(exibirDataBr($ocorrencia['dataFinal']),0,5)." ".trim(substr($semana,0, -1))." , ".substr(($ocorrencia['horaInicio']),0,2)."h<br />";
			}
			$x = $x."Retirada de ingresso: ".$retirada['retirada']." Valor: ".dinheiroParaBr($ocorrencia['valorIngresso'])."<br />
			Duração: ".$ocorrencia['duracao']. "min. <br />";
	}
	return $x;
}

function listaFilmesCom($idEvento){ //lista ocorrencias de determinado evento
	$sql = "SELECT * FROM ig_cinema WHERE ig_evento_idEvento = '$idEvento' AND publicado = 1";
	$con = bancoMysqli();
	$query = mysqli_query($con,$sql);
	while($campo = mysqli_fetch_array($query)){
			if($campo['tituloOriginal'] != ""){
				$tituloOriginal = $campo['tituloOriginal'];	
			}else{
				$tituloOriginal = "";
			}
			
			if(($campo['ig_pais_IdPais_2'] != 0) OR ($campo['ig_pais_IdPais_2'] != NULL)){
				$coproducao = " / ".$campo['ig_pais_IdPais_2'];
			}else{
				$coproducao = "";	
			}
			
			
			$filme = "<b>".$campo['titulo']."</b><br />
			(".$tituloOriginal." - ".retornaPais($campo['ig_pais_idPais'])." - ".retornaPais($campo['ig_pais_IdPais_2'])." - ".$campo['anoProducao']." - ".$campo['minutagem']."min. - ".$campo['bitola']." ) <br />
			Direção: ".$campo['direcao']."<br />". 
			"Sinopse: ".$campo['sinopse']."<br /><br />";
			
			
			echo $filme;	
			listaOcorrenciasCinemaCom($campo['idCinema']);	
			echo "<br /><br />";
			
					
	}
}
function listaOcorrenciasCinemaCom($idCinema){ //lista ocorrencias de determinado evento
	$sql = "SELECT * FROM ig_ocorrencia WHERE idCinema = '$idCinema' AND publicado = 1 ORDER BY dataInicio";
	$con = bancoMysqli();
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0){

	while($campo = mysqli_fetch_array($query)){
			$tipo_de_evento = retornaTipoOcorrencia($campo['idTipoOcorrencia']); // retorna o tipo de ocorrência
			if($campo['idSubEvento'] != NULL){
				$sub = recuperaDados("ig_sub_evento",$campo['idSubEvento'],"idSubEvento");
			}else{
				$sub['titulo'] = "";		
			}
			if($campo['dataFinal'] == '0000-00-00'){
				$data = exibirDataBr($campo['dataInicio'])." - ".diasemana($campo['dataInicio']); //precisa tirar a hora para fazer a função funcionar
					$semana = "";
			}else{
				$data = "De ".exibirDataBr($campo['dataInicio'])." a ".exibirDataBr($campo['dataFinal']);
				if($campo['segunda'] == 1){$seg = "segunda";}else{$seg = "";}
				if($campo['terca'] == 1){$ter = "terça";}else{$ter = "";}
				if($campo['quarta'] == 1){$qua = "quarta";}else{$qua = "";}
				if($campo['quinta'] == 1){$qui = "quinta";}else{$qui = "";}
				if($campo['sexta'] == 1){$sex = " sexta";}else{$sex = "";}
				if($campo['sabado'] == 1){$sab = " sábado";}else{$sab = "";}
				if($campo['domingo'] == 1){$dom = " domingo";}else{$dom = "";}
				$semana = "(".$seg." ".$ter." ".$qua." ".$qui." ".$sex." ".$sab." ".$dom.")";	
			}
			
			if($campo['diaEspecial'] == 1){
				if($campo['libras'] == 1){$libras = "Tradução em libras";}else{$libras = "";}
				if($campo['audiodescricao'] == 1){$audio = "Audiodescrição";}else{$audio = "";}
				if($campo['precoPopular'] == 1){$popular = "Preço popular";}else{$popular = "";}
				
				$dia_especial =	" - Dia especial:".$libras." ".$audio." ".$popular;
			}else{
				$dia_especial = "";
			}
			
			//recuperaDados($tabela,$idEvento,$campo)
			$hora = exibirHora($campo['horaInicio']);
			$duracao = recuperaDuracao($campo ['duracao']);
			$retirada = recuperaIngresso($campo['retiradaIngresso']);
			$valor = dinheiroParaBr($campo['valorIngresso']);
			$local = recuperaDados("ig_local",$campo['local'],"idLocal");
			$espaco = $local['sala'];
			$inst = recuperaDados("ig_instituicao",$local['idInstituicao'],"idInstituicao");
			$instituicao = $inst['instituicao'];
			$id = $campo['idOcorrencia'];
			
			
			$ocorrencia = "$tipo_de_evento $dia_especial ".
			$sub['titulo']
			."<br />
			Data: $data $semana <br />
			Horário: $hora<br />
			Duração: $duracao <br />
			Local: $espaco - $instituicao<br />
			Retirada de ingresso: $retirada  - Valor: $valor <br /></br><br />";  
			echo $ocorrencia;
					
		}
	}
}



?>

