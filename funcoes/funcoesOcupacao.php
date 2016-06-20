<?php
function listaOcorrenciasOcupacao($idEvento){ //lista ocorrencias de determinado evento
	$sql = "SELECT * FROM ig_ocorrencia WHERE idEvento = '$idEvento' AND publicado = '1' AND idTipoOcorrencia <> '5' ORDER BY dataInicio";
	$con = bancoMysqli();
	$query = mysqli_query($con,$sql);
	echo "<table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td>Ocorrência</td>
							<td width='10%'></td>
							<td width='10%'></td>
							<td width='10%'></td>
						</tr>
					</thead>
					<tbody>";
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
			
			
			$ocorrencia = "<div class='left'>$tipo_de_evento $dia_especial ".
			$sub['titulo']
			."<br />
			Data: $data $semana <br />
			Horário: $hora<br />
			Duração: $duracao<br />
			Local: $espaco - $instituicao<br />
			Retirada de ingresso: $retirada  - Valor: $valor <br /></br>";  
			
					
			echo "<tr>";
			echo "<td class='list_description'>".$ocorrencia."</td>";
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=ocupacao&p=ocorrencias&action=editar'>
			<input type='hidden' name='id' value='$id' />
			<input type ='submit' class='btn btn-theme btn-block' value='Editar'></td></form>"	;

			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=ocupacao&p=ocorrencias&action=listar'>
			<input type='hidden' name='duplicar' value='".$campo['idOcorrencia']."' />
			<input type ='submit' class='btn btn-theme btn-block' value='Duplicar'></td></form>"	;
			
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=ocupacao&p=ocorrencias&action=listar'>
			<input type='hidden' name='apagar' value='".$campo['idOcorrencia']."' />
			<input type ='submit' class='btn btn-theme  btn-block' value='Apagar'></td></form>"	;
			echo "</tr>";		
	}
	echo "					</tbody>
				</table>";
}

function listaEventosGravadosOcupacao($idUsuario){ //tabela para gerenciar eventos em aberto
	$con = bancoMysqli();
	$sql = "SELECT * FROM ig_evento WHERE idUsuario = $idUsuario AND publicado = 1 AND dataEnvio IS NULL";
	$query = mysqli_query($con,$sql);
	echo "<table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td>Nome do evento</td>
							<td>Tipo de evento</td>
  							<td>Data/Período</td>
							<td width='10%'></td>
							<td width='10%'></td>
						</tr>
					</thead>
					<tbody>";
	while($campo = mysqli_fetch_array($query)){
			echo "<tr>";
			echo "<td class='list_description'>".$campo['nomeEvento']."</td>";
			echo "<td class='list_description'>".retornaTipo($campo['ig_tipo_evento_idTipoEvento'])."</td>";
			echo "<td class='list_description'>".retornaPeriodo($campo['idEvento'])."</td>";
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=ocupacao&p=basica'>
			<input type='hidden' name='carregar' value='".$campo['idEvento']."' />
			<input type ='submit' class='btn btn-theme btn-block' value='carregar'></td></form>"	;
			
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=ocupacao&p=carregar'>
			<input type='hidden' name='apagar' value='".$campo['idEvento']."' />
			<input type ='submit' class='btn btn-theme  btn-block' value='apagar'></td></form>"	;
			echo "</tr>";		
	}
	echo "					</tbody>
				</table>";
}

function atualizarAgendaOcupacao($idEvento){
	$con = bancoMysqli();
	
	// apaga da agenda as ocorrencias com os idEvento 
	$sql_limpa = "DELETE FROM igsis_agenda WHERE idEvento = '$idEvento'";
	mysqli_query($con,$sql_limpa);

$sql_pesquisar = "SELECT ig_ocorrencia.idEvento, dataInicio, idTipoOcorrencia, local, horaInicio, idInstituicao, dataFinal, segunda, terca, quarta, quinta, sexta, sabado, domingo, idOcorrencia, idCinema FROM ig_ocorrencia, ig_evento WHERE ig_evento.publicado = '1' AND ig_evento.idInstituicao IS NOT NULL AND ig_evento.publicado = '1' AND ig_evento.idEvento = ig_ocorrencia.idEvento AND ig_ocorrencia.publicado = '1' AND ig_evento.idEvento = '$idEvento' ORDER BY dataInicio, horaInicio";
$query_pesquisar = mysqli_query($con,$sql_pesquisar);
$data = "";
$data_antigo = "1";
while($evento = mysqli_fetch_array($query_pesquisar)){
	$inst = recuperaDados("ig_local",$evento['local'],"idLocal");
	$idInst = $inst['idInstituicao'];
	$idEvento = $evento['idEvento'];
	$dataInicio = $evento['dataInicio'];
	$dataFinal = $evento['dataFinal'];
	$local = $evento['local'];
	$idTipo = $evento['idTipoOcorrencia'];
	$hora = $evento['horaInicio'];
	$idInstituicao = $idInst;
	$segunda = $evento['segunda'];
	$terca = $evento['terca'];
	$quarta = $evento['quarta'];
	$quinta = $evento['quinta'];
	$sexta = $evento['sexta'];
	$sabado = $evento['sabado'];
	$domingo = $evento['domingo'];
	$idOcorrencia = $evento['idOcorrencia'];
	$idCinema = $evento['idCinema'];

	$mensagem = "";
	
	if($dataFinal == '0000-00-00' OR $dataFinal == $dataInicio){ //Evento de data única

	$sql = "INSERT INTO `igsis_agenda` (`idAgenda`, `idEvento`, `data`, `hora`, `idLocal`, `idInstituicao`, `idTipo`, `idOcorrencia`, `idCinema`) 
	VALUES (NULL, '$idEvento', '$dataInicio', '$hora', '$local', '$idInstituicao', '$idTipo', '$idOcorrencia', '$idCinema');";
		$query = mysqli_query($con,$sql);
		if($query){
			$mensagem = $mensagem."Data importada na agenda.<br />";	
		}else{
			$mensagem - $mensagem."Erro.<br />";
		}		
	}else{ // Evento de tempoarada
		while(strtotime($dataInicio) <=  strtotime($dataFinal)){
			$semana = diaSemanaBase($dataInicio);
			
			switch($semana){
			case 'segunda':
			if($segunda == '1'){
	$sql = "INSERT INTO `igsis_agenda` (`idAgenda`, `idEvento`, `data`, `hora`, `idLocal`, `idInstituicao`, `idTipo`, `idOcorrencia`, `idCinema`) 
	VALUES (NULL, '$idEvento', '$dataInicio', '$hora', '$local', '$idInstituicao', '$idTipo', '$idOcorrencia', '$idCinema');";

				$query = mysqli_query($con,$sql);
				if($query){
			$mensagem = $mensagem."Data importada na agenda.<br />";
				}else{
					$mensagem - $mensagem."Erro.<br />";	
				}		
				
			}
			break;
			case 'terca':
			
			if($terca == '1'){
	$sql = "INSERT INTO `igsis_agenda` (`idAgenda`, `idEvento`, `data`, `hora`, `idLocal`, `idInstituicao`, `idTipo`, `idOcorrencia`, `idCinema`) 
	VALUES (NULL, '$idEvento', '$dataInicio', '$hora', '$local', '$idInstituicao', '$idTipo', '$idOcorrencia', '$idCinema');";

				$query = mysqli_query($con,$sql);
				if($query){
			$mensagem = $mensagem."Data importada na agenda.<br />";;	
				}else{
					$mensagem - $mensagem."Erro.<br />";	
				}		
				
			}
			break;
			case 'quarta':
			if($quarta == '1'){
	$sql = "INSERT INTO `igsis_agenda` (`idAgenda`, `idEvento`, `data`, `hora`, `idLocal`, `idInstituicao`, `idTipo`, `idOcorrencia`, `idCinema`) 
	VALUES (NULL, '$idEvento', '$dataInicio', '$hora', '$local', '$idInstituicao', '$idTipo', '$idOcorrencia', '$idCinema');";

				$query = mysqli_query($con,$sql);
				if($query){
			$mensagem = $mensagem."Data importada na agenda.<br />";
				}else{
					$mensagem - $mensagem."Erro.<br />";	
				}		
				
			}
			break;
			case 'quinta':
			if($quinta == '1'){
	$sql = "INSERT INTO `igsis_agenda` (`idAgenda`, `idEvento`, `data`, `hora`, `idLocal`, `idInstituicao`, `idTipo`, `idOcorrencia`, `idCinema`) 
	VALUES (NULL, '$idEvento', '$dataInicio', '$hora', '$local', '$idInstituicao', '$idTipo', '$idOcorrencia', '$idCinema');";

				$query = mysqli_query($con,$sql);
				if($query){
			$mensagem = $mensagem."Data importada na agenda.<br />";
				}else{
					$mensagem - $mensagem."Erro.<br />";	


				}		
				
			}
			break;
			case 'sexta':
			if($sexta == '1'){
	$sql = "INSERT INTO `igsis_agenda` (`idAgenda`, `idEvento`, `data`, `hora`, `idLocal`, `idInstituicao`, `idTipo`, `idOcorrencia`, `idCinema`) 
	VALUES (NULL, '$idEvento', '$dataInicio', '$hora', '$local', '$idInstituicao', '$idTipo', '$idOcorrencia', '$idCinema');";

				$query = mysqli_query($con,$sql);
				if($query){
			$mensagem = $mensagem."Data importada na agenda.<br />";	
				}else{
					$mensagem - $mensagem."Erro.<br />";	
				}		
				
			}
			break;
			case 'sabado':
			if($sabado == '1'){

	$sql = "INSERT INTO `igsis_agenda` (`idAgenda`, `idEvento`, `data`, `hora`, `idLocal`, `idInstituicao`, `idTipo`, `idOcorrencia`, `idCinema`) 
	VALUES (NULL, '$idEvento', '$dataInicio', '$hora', '$local', '$idInstituicao', '$idTipo', '$idOcorrencia', '$idCinema');";
				$query = mysqli_query($con,$sql);
				if($query){
			$mensagem = $mensagem."Data importada na agenda.<br />";
				}else{
					$mensagem - $mensagem."Erro.<br />";	
				}		
				
			}
			break;
			case 'domingo':
			
			if($domingo == '1'){

	$sql = "INSERT INTO `igsis_agenda` (`idAgenda`, `idEvento`, `data`, `hora`, `idLocal`, `idInstituicao`, `idTipo`, `idOcorrencia`, `idCinema`) 
	VALUES (NULL, '$idEvento', '$dataInicio', '$hora', '$local', '$idInstituicao', '$idTipo', '$idOcorrencia', '$idCinema');";
				$query = mysqli_query($con,$sql);
				if($query){
			$mensagem = $mensagem."Data importada na agenda.<br />";
				}else{
					$mensagem - $mensagem."Erro.<br />";	
				}		
				
			}
			break;
		}// fim da switch



			$dataInicio = date('Y-m-d', strtotime("+1 days",strtotime($dataInicio)));
		}
		
	}
	
	
 	
}	

return $mensagem;	
}

?>