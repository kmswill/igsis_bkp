<?php

function gravaHistorico($idEvento,$tabela,$campo){
	$con = bancoMysqli();
	$ip = $_SERVER["REMOTE_ADDR"];
	$data = date('Y-m-d H:i:s');
	$idUsuario = $_SESSION['idUsuario'];
	$x = recuperaDados($tabela,$idEvento,$campo);
	$query = mysqli_query($con,"SHOW COLUMNS FROM $tabela");
	while ($coluna = mysqli_fetch_assoc($query)) {
		$col = $coluna["Field"];
		$col2 = $x[$col];
		$sql_insert_espec = "INSERT INTO `igsis_historico` (`idHist`, `idEvento`, `tabela`, `campo`, `data`, `valor`, `idUsuario`, `ip`) VALUES (NULL, '$idEvento', '$tabela', 	'$col', '$data', '$col2', '$idUsuario', '$ip')";
		mysqli_query($con,$sql_insert_espec);
	}
}


function reaberturaEvento($idEvento){
	$con = bancoMysqli();
	$erro = 0;
	$mensagem = "";
	$sql_reabrir = "UPDATE ig_evento SET dataEnvio = NULL WHERE idEvento = '$idEvento'";
	$query_reabrir = mysqli_query($con,$sql_reabrir);
	if($query_reabrir){
		gravarLogReabertura($idEvento,2);
		gravarLog($sql_reabrir);
		$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
		$mensagem = $mensagem."O evento ".$evento['nomeEvento']." foi reaberto.<br />";
		$sql_pedido = "UPDATE igsis_pedido_contratacao SET estado = NULL WHERE idEvento = '$idEvento'";
		$query_pedido = mysqli_query($con,$sql_pedido);
		if($query_pedido){
			$mensagem = $mensagem."Os pedidos foram reabertos.<br />";
			$sql_recupera_pedidos_abertos = "SELECT * FROM igsis_pedido_contratacao WHERE publicado = '1' AND idEvento = $idEvento AND estado IS NULL";
			$query_recupera_pedidos_abertos = mysqli_query($con,$sql_recupera_pedidos_abertos);
			$n_recupera = mysqli_num_rows($query_recupera_pedidos_abertos);
			if($n_recupera > 0){
				$mensagem = "O evento ".$evento['nomeEvento']."foi reaberto.";
				$pedidos = "";
				while($x = mysqli_fetch_array($query_recupera_pedidos_abertos)){
					$pedidos = $pedidos." ".$x['idPedidoContratacao'].","; 	
				}
				$conteudo_email = "
				Olá,<br />
				Por solicitação, o(s) pedido(s) ".trim(substr($pedidos,0,-1))." foi(foram) reaberto(s) e não aparecerá(ão) em suas listas no Módulo Contratação até que seja(m) reenviado(s).<br /><br />
				Att,<br />
				Equipe IGSIS<br />
				";
				$instituicao = 4;
				$subject = "O evento '".$evento['nomeEvento']."' foi reaberto";
				$email = "sistema.igsis@gmail.com";
				$usuario = "IGSIS";
				
					
				
			}
			
		}else{
			$erro++;	
		}
	}else{
		$erro++;
	} 
	return $erro;
}



function gravarLogReabertura($idEvento,$tipo,$idChamado = ""){ // função que trata as reaberturas
	/* tipos
		1. envio simples
		2. reabertura
		3. reenvio
	*/

	// Carrega as variáveis
	if(isset($_SESSION['idUsuario'])){
		$idUusario = $_SESSION['idUsuario'];
	}else{
		$idUsuario = 1;
	}
	$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
	$con = bancoMysqli(); // declara a conexão		
	$ip = $_SERVER["REMOTE_ADDR"];
	$data = date('Y-m-d H:i:s');
	$idUsuario = $_SESSION['idUsuario'];
	$mensagem = "";
	
	switch($tipo){
	
	case 1:
	
	// Grava um log simples do Evento
	$sql_log = "INSERT INTO `ig_log_reabertura` (`id_logReabertura`, `idChamado`, `idUsuario`, `tipoContratacao`, `idEveForm`, `idPedido`, `descricao`, `data`, `ip`) VALUES (NULL, '', '$idUsuario', '', '$idEvento', '', 'Envio', '$data', '$ip')";
	$query_log = mysqli_query($con,$sql_log);
	if($query_log){
		$sql_pedidos = "SELECT idPedidoContratacao, tipoPessoa FROM igsis_pedido_contratacao WHERE idEvento = '$idEvento' AND publicado = '1'";
		$query_pedidos = mysqli_query($con,$sql_pedidos);
		if($query_pedidos){
			$mensagem .= "Log do evento inserido com sucesso<br />";
		$num = mysqli_num_rows($query_pedidos);
		if($num > 0){
			$pedido = mysqli_fetch_array($query_pedidos);
			$idPedido = $pedido['idPedidoContratacao'];
			$tipo = $pedido['tipoPessoa'];
			$sql_log = "INSERT INTO `ig_log_reabertura` (`id_logReabertura`, `idChamado`, `idUsuario`, `tipoContratacao`, `idEveForm`, `idPedido`, `descricao`, `data`, `ip`) VALUES (NULL, '', '$idUsuario', '$tipo', '$idEvento', '$idPedido', 'Envio', '$data', '$ip')";
			$query_log = mysqli_query($con,$sql_log);
			if($query_log){
				$mensagem .= "Log do pedido inserido com sucesso <br />";
			}else{
				$mensagem .= "Erro (2)<br />";
			}
		}	
		}else{
			$mensagem .= "Erro (1)<br />";
		}
	}
	
	
	break;
	case 2:
	
	//Grava um log de reabertura
	$sql_log = "INSERT INTO `ig_log_reabertura` (`id_logReabertura`, `idChamado`, `idUsuario`, `tipoContratacao`, `idEveForm`, `idPedido`, `descricao`, `data`, `ip`) VALUES (NULL, '$idChamado', '$idUsuario', '', '$idEvento', '', 'Reabertura', '$data', '$ip')";
	$query_log = mysqli_query($con,$sql_log);
	if($query_log){
		$sql_pedidos = "SELECT idPedidoContratacao, tipoPessoa FROM igsis_pedido_contratacao WHERE idEvento = '$idEvento' AND publicado = '1'";
		$query_pedidos = mysqli_query($con,$sql_pedidos);
		if($query_pedidos){
			$mensagem .= "Log do evento inserido com sucesso<br />";
		$num = mysqli_num_rows($query_pedidos);
		if($num > 0){
			$pedido = mysqli_fetch_array($query_pedidos);
			$idPedido = $pedido['idPedidoContratacao'];
			$tipo = $pedido['tipoPessoa'];
			$idUsuario = $_SESSION['idUsuario'];
			$sql_log = "INSERT INTO `ig_log_reabertura` (`id_logReabertura`, `idChamado`, `idUsuario`, `tipoContratacao`, `idEveForm`, `idPedido`, `descricao`, `data`, `ip`) VALUES (NULL, '$idChamado', '$idUsuario', '$tipo', '$idEvento', '$idPedido', 'Reabertura', '$data', '$ip')";
			$query_log = mysqli_query($con,$sql_log);
			if($query_log){
				$mensagem .= "Log do pedido inserido com sucesso <br />";
			}else{
				$mensagem .= "Erro (3)";
			}
		}	
		}else{
			$mensagem .= "Erro (4)<br />";
		}
	}
	
	
	//Faz um histórico da IG enviada
	
	/* 
	Copia registro do evento na tabela igsis_hist_evento ok
	Verifica qual o tipo de evento ok
		Se o tipo for Cinema ok
			faz copias dos filmes na tabela igsis_hist_cinema ok
	Verifica se há uso d especificidades
			inserir dados especificos na tabela igsis_hist_especificidades	
			
	Verifica se há subevento
		Se existe subevento
			faz copias dos subeventos nas tabelas igsis_hist_sub_eventos ok
		
	Copia os registros de ocorrencia na tabela igsis_hist_ocorrencia ok
	
	Verifica se há pedido
	Se existe pedido 
		faz copias dos pedidos nas tabelas igsis_hist_pedido_contratacao
		Se pessoa fisica
			faz copias das pessoas nas tabelas igsis_hist_pessoa_fisica 
		Se pessoa juridica
			faz copias das pessoas nas tabelas igsis_hist_pessoa_juridica
		Se parcela > 1
			faz copias das parcelas na tabela igsis_hist_parcelas
		Se verba for multipla
			faz copias das verbas na tabela igsis_hist_verbas_multiplas

	
	//	Copia registro do evento na tabela igsis_hist_evento
	
	
	//Copia registro do evento na tabela igsis_hist_evento ok
	gravaHistorico($idEvento,"ig_evento","idEvento");

	//Verifica qual o tipo de evento, se o tipo for Cinema
	if($evento['ig_tipo_evento_idTipoEvento'] == 1){
	//faz copias dos filmes na tabela igsis_hist_cinema			
		gravaHistorico($idEvento,"ig_cinema","ig_evento_idEvento");
	}
	//Verifica se há uso d especificidades, inserir dados especificos na tabela igsis_hist_especificidades	
	
	switch ($evento['ig_tipo_evento_idTipoEvento']){

		case 2: // Artes Visuais
		// verifica se existe registro
		gravaHistorico($idEvento,"ig_artes_visuais","idEvento");
		break;
	
		case 3: //  Teatro e dança
		case 7:
		case 8:
		case 14:
		case 15:
		case 16:
		case 17:
		case 9:
		// verifica se existe registro
		gravaHistorico($idEvento,"ig_teatro_danca","ig_evento_idEvento");
		break;
	
		case 11: // Musica
		case 12:
		case 19:
		// verifica se existe registro
		gravaHistorico($idEvento,"ig_musica","ig_evento_idEvento");
		break;
		
		case 4: //palestras, debates e oficinas
		case 5:
		// verifica se existe registro
		gravaHistorico($idEvento,"ig_oficinas","idEvento");		
		$query = mysqli_query($con,"SHOW COLUMNS FROM ig_oficinas");
		break;
	}

	//Copia os registros de ocorrencia na tabela igsis_hist_ocorrencia ok
	$sql = "INSERT INTO `igsis_hist_ocorrencia` (`idOcorrenciaAnt`, `idTipoOcorrencia`, `ig_comunicao_idCom`, `local`, `idEvento`, `segunda`, `terca`, `quarta`, `quinta`, `sexta`, `sabado`, `domingo`, `dataInicio`, `dataFinal`, `horaInicio`, `horaFinal`, `timezone`, `diaInteiro`, `diaEspecial`, `libras`, `audiodescricao`, `valorIngresso`, `retiradaIngresso`, `localOutros`, `lotacao`, `reservados`, `duracao`, `precoPopular`, `frequencia`, `publicado`, `idSubEvento`, `idCinema`, `virada`, `dataAbertura` ) SELECT `idOcorrencia`,  `idTipoOcorrencia`, `ig_comunicao_idCom`, `local`, `idEvento`, `segunda`, `terca`, `quarta`, `quinta`, `sexta`, `sabado`, `domingo`, `dataInicio`, `dataFinal`, `horaInicio`, `horaFinal`, `timezone`, `diaInteiro`, `diaEspecial`, `libras`, `audiodescricao`, `valorIngresso`, `retiradaIngresso`, `localOutros`, `lotacao`, `reservados`, `duracao`, `precoPopular`, `frequencia`, `publicado`, `idSubEvento`, `idCinema`, `virada`, now() FROM ig_ocorrencia WHERE idEvento = '$idEvento'";
	$query = mysqli_query($con,$sql);
	if($query){
		$mensagem .= "Evento $idEvento arquivado com sucesso!<br />";
	}else{
		$mensagem .= "Erro (5).<br />";	
	}

	//Verifica se há subevento Se existe subevento 	faz copias dos subeventos nas tabelas igsis_hist_sub_eventos	
	if($evento['subEvento'] == 1){
		$sql = "INSERT INTO `igsis_hist_sub_evento` (`idSubEvento`, `idTipo`, `ig_evento_idEvento`, `titulo`, `descricao`, `publicado`, `dataAbertura`) SELECT `idSubEvento`, `idTipo`, `ig_evento_idEvento`, `titulo`, `descricao`, `publicado`, now() FROM ig_sub_evento WHERE ig_evento_idEvento = '$idEvento'";
		$query = mysqli_query($con,$sql);
		if($query){
			$mensagem .= "Evento $idEvento arquivado com sucesso!<br />";
		}else{
			$mensagem .= "Erro (5).<br />";	
		}
	}
	
	//Verifica se há pedidos
	$n_pedidos = listaPedidoContratacao($idEvento);
	if(count($n_pedidos) > 0){
			$sql = "INSERT INTO `igsis_hist_pedido_contratacao` (`idPedidoContratacaoAnt`, `idEvento`, `tipoPessoa`, `idRepresentante01`, `idPessoa`, `valor`, `valorPorExtenso`, `formaPagamento`, `idVerba`, `anexo`, `observacao`, `publicado`, `valorIndividual`, `idRepresentante02`, `instituicao`, `executante`, `NumeroProcesso`, `NumeroNotaEmpenho`, `DataEmissaoNotaEmpenho`, `DataEntregaNotaEmpenho`, `IdUsuarioContratos`, `IdAssinatura`, `IdExecutante`, `justificativa`, `parecerArtistico`, `estado`, `aprovacaoFinanca`, `parcelas`, `idContratos`, `idDetalhamentoAcao`, `DataProposta`, `DataReserva`, `DataContrato`, `AmparoLegal`, `ComplementoDotacao`, `Finalizacao`, `idPenalidade`, `DataJuridico`, `DataPublicacao`, `DataContabilidade`, `DataPagamento`, `nProcesso`, `dataAbertura`) SELECT `idPedidoContratacao`, `idEvento`, `tipoPessoa`, `idRepresentante01`, `idPessoa`, `valor`, `valorPorExtenso`, `formaPagamento`, `idVerba`, `anexo`, `observacao`, `publicado`, `valorIndividual`, `idRepresentante02`, `instituicao`, `executante`, `NumeroProcesso`, `NumeroNotaEmpenho`, `DataEmissaoNotaEmpenho`, `DataEntregaNotaEmpenho`, `IdUsuarioContratos`, `IdAssinatura`, `IdExecutante`, `justificativa`, `parecerArtistico`, `estado`, `aprovacaoFinanca`, `parcelas`, `idContratos`, `idDetalhamentoAcao`, `DataProposta`, `DataReserva`, `DataContrato`, `AmparoLegal`, `ComplementoDotacao`, `Finalizacao`, `idPenalidade`, `DataJuridico`, `DataPublicacao`, `DataContabilidade`, `DataPagamento`, `nProcesso`, now() FROM igsis_pedido_contratacao WHERE idEvento = '$idEvento'";
		$query = mysqli_query($con,$sql);
		if($query){
			$mensagem .= "Evento $idEvento arquivado com sucesso!<br />";
		}else{
			$mensagem .= "Erro (5).<br />";	
		}
		for($i = 0; $i < count($n_pedidos); $i++){
			$pedido = recuperaDados("igsis_pedido_contratacao",$n_pedidos[$i],"idPedidoContratacao");
			$ped = $pedido['idPedidoContratacao'];

			if($pedido['parcelas'] > 1){
				$sql_parcelas = "INSERT INTO `igsis_hist_parcelas` (`idParcelaAnt`, `idPedido`, `numero`, `valor`, `vencimento`, `publicado`, `descricao`, `vigencia_inicio`, `vigencia_final`, `horas`, `dataAbertura`) SELECT `idParcela`, `idPedido`, `numero`, `valor`, `vencimento`, `publicado`, `descricao`, `vigencia_inicio`, `vigencia_final`, `horas`, `dataAbertura` FROM igsis_parcelas WHERE idPedido = '$ped'";
				$query_parcelas = mysqli_query($con,$sql_parcelas);
				if($query_parcelas){
					$mensagem .= "Parcelas inseridas<br />";				
				}else{
					$mensagem .= "Erro <br />";	
				}
			}

			if($pedido['idVerba'] ==  '30' OR $pedido['idVerba'] = '69'){
				$sql_multiplas = "INSERT INTO `igsis`.`igsis_hist_verbas_multiplas` (`idMultiplas`, `idPedidoContratacao`, `idVerba`, `valor`, `dataAbertura`) SELECT `idMultiplas`, `idPedidoContratacao`, `idVerba`, `valor`, `dataAbertura` FROM sis_verbas_multiplas WHERE idPedidoContratacao = '$ped'";
				$query_multiplas = mysqli_query($con,$sql_multiplas);
				if($query_multiplas){
					$mensagem .= "Verbas Multiplas inseridas<br />";	
				}else{
					$mensagem .= "Erro <br />";	
				}
			}

			if($pedido['tipoPessoa'] == 1){
				
			}

			if($pedido['tipoPessoa'] == 2){
				
			}

			
		}

	}
	*/
	case 3:
	
	//Grava log simples
	//Faz comparações de campos
	
	break;


	}// final da swtich

return $mensagem;

} // final da função

?>
