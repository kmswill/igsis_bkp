<?php
@ini_set('display_errors', '1');
error_reporting(E_ALL); 
ini_set('max_execution_time', 300);

require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";
require "../funcoes/funcoesSiscontrat.php";

$con = bancoMysqli(); 

$idEvento = $_GET['id'];


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
	$ip = $_SERVER["REMOTE_ADDR"];
	$data = date('Y-m-d H:i:s');
	$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
	$con = bancoMysqli(); // declara a conexão		

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
			faz copias dos subeventos nas tabelas igsis_hist_sub_eventos
		
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
	*/
	
	//	Copia registro do evento na tabela igsis_hist_evento
	$sql = "INSERT INTO `igsis_hist_evento` (`idEventoAnt`, `ig_produtor_idProdutor`, `ig_tipo_evento_idTipoEvento`, `ig_programa_idPrograma`, `projetoEspecial`, `nomeEvento`, `projeto`, `memorando`, `idResponsavel`, `suplente`, `autor`, `fichaTecnica`, `faixaEtaria`, `sinopse`, `releaseCom`, `parecerArtistico`, `confirmaFinanca`, `confirmaDiretoria`, `confirmaComunicacao`, `confirmaDocumentacao`, `confirmaProducao`, `numeroProcesso`, `publicado`, `idUsuario`, `ig_modalidade_IdModalidade`, `linksCom`, `subEvento`, `dataEnvio`, `justificativa`, `idInstituicao`, `ocupacao`) SELECT `idEvento`, `ig_produtor_idProdutor`, `ig_tipo_evento_idTipoEvento`, `ig_programa_idPrograma`, `projetoEspecial`, `nomeEvento`, `projeto`, `memorando`, `idResponsavel`, `suplente`, `autor`, `fichaTecnica`, `faixaEtaria`, `sinopse`, `releaseCom`, `parecerArtistico`, `confirmaFinanca`, `confirmaDiretoria`, `confirmaComunicacao`, `confirmaDocumentacao`, `confirmaProducao`, `numeroProcesso`, `publicado`, `idUsuario`, `ig_modalidade_IdModalidade`, `linksCom`, `subEvento`, `dataEnvio`, `justificativa`, `idInstituicao`, `ocupacao` FROM ig_evento WHERE idEvento = '$idEvento'";
	$query = mysqli_query($con,$sql);
	if($query){
		$mensagem .= "Evento $idEvento arquivado com sucesso!<br />";
	}else{
		$mensagem .= "Erro (5).<br />";	
	}
	
	//Verifica qual o tipo de evento, se o tipo for Cinema
	if($evento['ig_tipo_evento_idTipoEvento	'] == 1){
		//faz copias dos filmes na tabela igsis_hist_cinema			
		$sql_cinema = "INSERT INTO `igsis_hist_cinema` (`idCinemaAnt`, `ig_pais_idPais`, `ig_evento_idEvento`, `titulo`, `tituloOriginal`, `anoProducao`, `genero`, `bitola`, `direcao`, `sinopse`, `minutagem`, `linkTrailer`, `elenco`, `ig_pais_IdPais_2`, `publicado`, `indicacaoEtaria`) SELECT `idCinema`, `idCinemaAnt`, `ig_pais_idPais`, `ig_evento_idEvento`, `titulo`, `tituloOriginal`, `anoProducao`, `genero`, `bitola`, `direcao`, `sinopse`, `minutagem`, `linkTrailer`, `elenco`, `ig_pais_IdPais_2`, `publicado`, `indicacaoEtaria` FROM ig_cinema WHERE ig_evento_idEvento = '$idEvento'";		
		$query_cinema = mysqli_query($con,$sql_cinema);
		if($query_cinema){
			$mensagem .= "Filme arquivado com sucesso!<br />";
		}else{
			$mensagem .= "Erro (6).<br />";		
		}
	}

	//Verifica se há uso d especificidades, inserir dados especificos na tabela igsis_hist_especificidades	
	
	switch ($evento['ig_tipo_evento_idTipoEvento']){

		case 2: // Artes Visuais
		// verifica se existe registro
		$artes = recuperaDados("ig_artes_visuais",$idEvento,"idEvento");		
		if($artes != NULL){
			$query = mysql_query("SHOW COLUMNS FROM ig_artes_visuais");
			while ($coluna = mysql_fetch_assoc($query)) {
				$col = $coluna["Field"];
				$col2 = $artes[$col];
				$sql_insert_espec = "INSERT INTO `igsis_hist_especificidades` (`idEspecificidade`, `idEvento`, `tabela`, `campo`, `data`, `valor`, `idUsuario`, `ip`) VALUES (NULL, '$idEvento', 'ig_artes_visuais', '$col', '$data', '$col2', '$idUsuario', '$ip')";
			}
		}
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
		$teatro = recuperaDados("ig_teatro_danca",$idEvento,"ig_evento_idEvento");		
		$query = mysql_query("SHOW COLUMNS FROM ig_teatro_danca");
		while ($coluna = mysql_fetch_assoc($query)) {
			$col = $coluna["Field"];
			$col2 = $teatro[$col];
			$sql_insert_espec = "INSERT INTO `igsis_hist_especificidades` (`idEspecificidade`, `idEvento`, `tabela`, `campo`, `data`, `valor`, `idUsuario`, `ip`) VALUES (NULL, '$idEvento', 'ig_teatro_danca', '$col', '$data', '$col2', '$idUsuario', '$ip')";
		}
		break;
	
		case 11: // Musica
		case 12:
		case 19:
		// verifica se existe registro
		$musica = recuperaDados("ig_musica",$idEvento,"ig_evento_idEvento");		
		$query = mysql_query("SHOW COLUMNS FROM ig_musica");
		while ($coluna = mysql_fetch_assoc($query)) {
			$col = $coluna["Field"];
			$col2 = $musica[$col];
			$sql_insert_espec = "INSERT INTO `igsis_hist_especificidades` (`idEspecificidade`, `idEvento`, `tabela`, `campo`, `data`, `valor`, `idUsuario`, `ip`) VALUES (NULL, '$idEvento', 'ig_musica', '$col', '$data', '$col2', '$idUsuario', '$ip')";
		}
		break;
		
		case 4: //palestras, debates e oficinas
		case 5:
		// verifica se existe registro
		$oficinas = recuperaDados("ig_oficinas",$idEvento,"idEvento");		
		$query = mysql_query("SHOW COLUMNS FROM ig_oficinas");
		while ($coluna = mysql_fetch_assoc($query)) {
			$col = $coluna["Field"];
			$col2 = $oficinas[$col];
			$sql_insert_espec = "INSERT INTO `igsis_hist_especificidades` (`idEspecificidade`, `idEvento`, `tabela`, `campo`, `data`, `valor`, `idUsuario`, `ip`) VALUES (NULL, '$idEvento', 'ig_musica', '$col', '$data', '$col2', '$idUsuario', '$ip')";
		}
		break;
	}


	case 3:
	
	//Grava log simples
	//Faz comparações de campos
	
	break;


	}// final da swtich

return $mensagem;

} // final da função
 
$artes = recuperaDados("ig_artes_visuais",$idEvento,"idEvento");	
var_dump($artes);
 
?>

