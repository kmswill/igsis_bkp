<?php
session_start();

   @ini_set('display_errors', '1');
	ini_set('max_execution_time', 600);
	error_reporting(E_ALL); 
		

//if(isset($_SESSION['idUsuario'])){
//require '../include/';
   require_once("../funcoes/funcoesConecta.php");
   require_once("../funcoes/funcoesGerais.php");
   require_once("../funcoes/funcoesSiscontrat.php");
   require_once("../funcoes/funcoesSiscontrat.php");
   require_once("../funcoes/funcoesControle.php");
   require_once("../include/phpexcel/Classes/PHPExcel.php");


//CONEXÃO COM BANCO DE DADOS 
   $con = bancoMysqli();

//Atualiza tabela igsis_pedido_contratacao com numero sei sem caracteres
$sql_atualiza_sei = "SELECT idPedidoContratacao,NumeroProcesso FROM igsis_pedido_contratacao WHERE publicado = '1' AND (nProcesso IS NULL OR nProcesso = '') ";
$query_atualiza_sei = mysqli_query($con,$sql_atualiza_sei);
while($atualiza_sei = mysqli_fetch_array($query_atualiza_sei)){
	$idPedido = $atualiza_sei['idPedidoContratacao'];
	$n_processo = trim(soNumero($atualiza_sei['NumeroProcesso']));
	$sql_update_sei = "UPDATE igsis_pedido_contratacao SET nProcesso = '$n_processo' WHERE idPedidoContratacao = '$idPedido'";
	mysqli_query($con,$sql_update_sei);
}


if(isset($_GET['rel'])){
	$p = $_GET['rel'];	
}else{
	$p = 'menu';	
}

switch($p){

case 'menu':
?>
<a href="?rel=seivalido" target="_blank">Número de SEI válidos em IGSIS e SOF</a><br />
<a href="?rel=seinvalido" target="_blank">Número de SEI conflitantes</a><br />
<a href="?rel=nosei" target="_blank">Pedidos sem número SEI</a><br />


<?php


break;
case 'seivalido':

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties

$objPHPExcel->getProperties()->setCreator("Sistema IGSIS");
$objPHPExcel->getProperties()->setLastModifiedBy("Sistema IGSIS");
$objPHPExcel->getProperties()->setTitle("Relatório IGSIS Controle Orçamentário");
$objPHPExcel->getProperties()->setSubject("Relatório IGSIS Controle Orçamentário");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema IGSIS");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Orçamento");

// Nome dos campos
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Número de Pedido (IGSIS)')
            ->setCellValue('B1', 'Evento (IGSIS)')
            ->setCellValue('C1', 'Projeto (IGSIS)')
            ->setCellValue('D1', 'Processo SEI (SOF/IGSIS)')
            ->setCellValue('E1', 'Responsável/Fiscal (IGSIS)')
            ->setCellValue('F1', 'Suplente (IGSIS)')
            ->setCellValue('G1', 'Locais (IGSIS)')
            ->setCellValue('H1', 'Proponente (IGSIS)/ Razão Social (SOF)')
            ->setCellValue('I1', 'Status (IGSIS)')
            ->setCellValue('J1', 'Data Inicial (IGSIS)')
            ->setCellValue('K1', 'Data Final (IGSIS)')
            ->setCellValue('L1', 'Valor (IGSIS)')
            ->setCellValue('M1', 'Valor (SOF)')
            ->setCellValue('N1', 'Tipo de pessoa (IGSIS)')
            ->setCellValue('O1', 'Empenho (SOF)')
            ->setCellValue('P1', 'Data do Empenho (SOF))')
            ->setCellValue('Q1', 'Verba (IGSIS)')
            ->setCellValue('R1', 'Dotação (SOF)')
            ->setCellValue('S1', 'Liquidado (SOF)')
            ->setCellValue('T1', 'Valor a liquidar (SOF)')
            ->setCellValue('U1', 'Pago (SOF)')
            ->setCellValue('V1', 'Descrição (SOF)')

			;
	//Colorir a primeira fila
	$objPHPExcel->getActiveSheet()->getStyle('A1:V1')->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E0EEEE')
            ),
        )
);


		

// Inserir dados (SEI Válido)			
$sql_sei =  "SELECT 
	igsis_pedido_contratacao.idPedidoContratacao, 
	igsis_pedido_contratacao.idEvento,
	igsis_pedido_contratacao.tipoPessoa, 
	igsis_pedido_contratacao.idPessoa, 
	igsis_pedido_contratacao.idVerba, 
	igsis_pedido_contratacao.estado, 
	igsis_pedido_contratacao.valor,
	igsis_6354.empenho,	
	igsis_6354.data_empenho,	
	igsis_6354.dotacao,	
	igsis_6354.liquidado,	
	igsis_6354.valor_a_liquidar,	
	igsis_6354.pago,	
	igsis_6354.valor,
	igsis_6354.descricao,	
	igsis_pedido_contratacao.NumeroProcesso
	FROM igsis_pedido_contratacao,igsis_6354 WHERE
	igsis_pedido_contratacao.publicado = '1' 
	AND igsis_pedido_contratacao.valor <> '0' 
	AND igsis_pedido_contratacao.tipoPessoa <> '4' 
	AND igsis_pedido_contratacao.nProcesso LIKE igsis_6354.processo  
	
	ORDER BY igsis_pedido_contratacao.idPedidoContratacao DESC";
	
	
	
$query_sei = mysqli_query($con,$sql_sei);
$i = 2;
while($pedido = mysqli_fetch_array($query_sei)){
	if($pedido['idVerba'] == 30 OR $pedido['idVerba'] == 69){
		$idPed = $pedido['idPedidoContratacao'];
		
		$sql_verba = "SELECT * FROM sis_verbas_multiplas WHERE idPedidoContratacao = '$idPed' AND valor > '0'";
		$query_verba = mysqli_query($con,$sql_verba);
		while($v = mysqli_fetch_array($query_verba)){

		$x = recuperaDados("igsis_pedido_contratacao",$pedido['idPedidoContratacao'],"idPedidoContratacao");
		$evento = recuperaDados("ig_evento",$pedido['idEvento'],"idEvento"); //$tabela,$idEvento,$campo
		$fiscal = recuperaDados("ig_usuario",$evento['idResponsavel'],"idUsuario");
		$suplente = recuperaDados("ig_usuario",$evento['suplente'],"idUsuario");
		$locais = listaLocais($pedido['idEvento']);
		$projeto = recuperaDados("ig_projeto_especial",$evento['projetoEspecial'],"idProjetoEspecial");
		$pessoa = siscontratDocs($pedido['idPessoa'],$pedido['tipoPessoa']);
		$verba = recuperaDados("sis_verba",$v['idVerba'],"Id_Verba");
		$estado = retornaEstado($pedido['estado']);
		$data = retornaData($pedido['idEvento']);
		$val = $v['valor'];
		if($pedido['tipoPessoa'] == 1){
			$tipo = "PESSOA FÍSICA";
		}else{
			$tipo = "PESSOA JURÍDICA";
		}

			$a = "A".$i;
			$b = "B".$i;
			$c = "C".$i;
			$d = "D".$i;
			$e = "E".$i;
			$f = "F".$i;
			$g = "G".$i;
			$h = "H".$i;
			$I = "I".$i;
			$j = "J".$i;
			$k = "K".$i;
			$l = "L".$i;
			$m = "M".$i;
			$n = "N".$i;
			$o = "O".$i;
			$p = "P".$i;
			$q = "Q".$i;			
			$r = "R".$i;			
			$s = "S".$i;			
			$t = "T".$i;
			$u = "U".$i;
			$v = "V".$i;			


$objPHPExcel->setActiveSheetIndex(0)
	
            ->setCellValue($a, $pedido[0])
            ->setCellValue($b, $evento['nomeEvento'])
            ->setCellValue($c, $projeto['projetoEspecial'])
            ->setCellValue($d, $pedido['NumeroProcesso'])
            ->setCellValue($e, $fiscal['nomeCompleto'])
            ->setCellValue($f, $suplente['nomeCompleto'])
            ->setCellValue($g, $locais)
            ->setCellValue($h, $pessoa['Nome'])
            ->setCellValue($I, $estado)
            ->setCellValue($j, $data['inicio'])
            ->setCellValue($k, $data['final'])
            ->setCellValue($l, $val)
            ->setCellValue($m, $pedido[13])
            ->setCellValue($n, $tipo)
            ->setCellValue($o, $pedido[7])
            ->setCellValue($p, $pedido[8])
            ->setCellValue($q, $verba['Verba']." (VM)")
            ->setCellValue($r, $pedido[9])
            ->setCellValue($s, $pedido[10])
            ->setCellValue($t, $pedido[11])
            ->setCellValue($u, $pedido[12])
            ->setCellValue($v, $pedido[14]);
	
	//Colorir erros
	// Valores IGSIS e SOF não batem
	if($pedido[13] != $pedido[6]){
	$objPHPExcel->getActiveSheet()->getStyle($l.":".$m)->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF3333')
            ),
        )
);
	}
	//Verbas erradas
	if(trim($pedido['idVerba']) == '' OR
	$pedido['idVerba'] == NULL OR
	$pedido['idVerba'] == 1 OR
	$pedido['idVerba'] == 6 OR 
	$pedido['idVerba'] == 2 OR
	$pedido['idVerba'] == 8 
	
	
	){
	$objPHPExcel->getActiveSheet()->getStyle($q)->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFF00')
            ),
        )
);
	}

				
			
			$i++;
					 
		}
	
	}else{
		$x = recuperaDados("igsis_pedido_contratacao",$pedido['idPedidoContratacao'],"idPedidoContratacao");
		$evento = recuperaDados("ig_evento",$pedido['idEvento'],"idEvento"); //$tabela,$idEvento,$campo
		$fiscal = recuperaDados("ig_usuario",$evento['idResponsavel'],"idUsuario");
		$suplente = recuperaDados("ig_usuario",$evento['suplente'],"idUsuario");
		$locais = listaLocais($pedido['idEvento']);
		$projeto = recuperaDados("ig_projeto_especial",$evento['projetoEspecial'],"idProjetoEspecial");
		$pessoa = siscontratDocs($pedido['idPessoa'],$pedido['tipoPessoa']);
		$verba = recuperaDados("sis_verba",$pedido['idVerba'],"Id_Verba");
		$estado = retornaEstado($pedido['estado']);
		$data = retornaData($pedido['idEvento']);
		if($pedido['tipoPessoa'] == 1){
			$tipo = "PESSOA FÍSICA";
		}else{
			$tipo = "PESSOA JURÍDICA";
		}

			$a = "A".$i;
			$b = "B".$i;
			$c = "C".$i;
			$d = "D".$i;
			$e = "E".$i;
			$f = "F".$i;
			$g = "G".$i;
			$h = "H".$i;
			$I = "I".$i;
			$j = "J".$i;
			$k = "K".$i;
			$l = "L".$i;
			$m = "M".$i;
			$n = "N".$i;
			$o = "O".$i;
			$p = "P".$i;
			$q = "Q".$i;			
			$r = "R".$i;			
			$s = "S".$i;			
			$t = "T".$i;
			$u = "U".$i;
			$v = "V".$i;			


$objPHPExcel->setActiveSheetIndex(0)
	
            ->setCellValue($a, $pedido[0])
            ->setCellValue($b, $evento['nomeEvento'])
            ->setCellValue($c, $projeto['projetoEspecial'])
            ->setCellValue($d, $pedido['NumeroProcesso'])
            ->setCellValue($e, $fiscal['nomeCompleto'])
            ->setCellValue($f, $suplente['nomeCompleto'])
            ->setCellValue($g, $locais)
            ->setCellValue($h, $pessoa['Nome'])
            ->setCellValue($I, $estado)
            ->setCellValue($j, $data['inicio'])
            ->setCellValue($k, $data['final'])
            ->setCellValue($l, $pedido[6])
            ->setCellValue($m, $pedido[13])
            ->setCellValue($n, $tipo)
            ->setCellValue($o, $pedido[7])
            ->setCellValue($p, $pedido[8])
            ->setCellValue($q, $verba['Verba'])
            ->setCellValue($r, $pedido[9])
            ->setCellValue($s, $pedido[10])
            ->setCellValue($t, $pedido[11])
            ->setCellValue($u, $pedido[12])
            ->setCellValue($v, $pedido[14]);
	
	//Colorir erros
	// Valores IGSIS e SOF não batem
	if($pedido[13] != $pedido[6]){
	$objPHPExcel->getActiveSheet()->getStyle($l.":".$m)->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF3333')
            ),
        )
);
	}
	//Verbas erradas
	if(trim($pedido['idVerba']) == '' OR
	$pedido['idVerba'] == NULL OR
	$pedido['idVerba'] == 1 OR
	$pedido['idVerba'] == 6 OR 
	$pedido['idVerba'] == 2 OR
	$pedido['idVerba'] == 8 
	
	
	){
	$objPHPExcel->getActiveSheet()->getStyle($q)->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFF00')
            ),
        )
);
	}

				
			
			$i++;
	}
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('SEI Válido');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet


foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
        $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
    } 





	
// Cria uma planilha nova	
$objPHPExcel->createSheet();

// Add some data to the second sheet, resembling some different data types
$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setWrapText(true);

$men_sof = recuperaAtualizacao('sof');
$men_igsis = "Planilha gerada em ".date("d/m/Y")." às ".date("H:i")."";

$objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A1', $men_igsis)
            ->setCellValue('A2', $men_sof)
            ->setCellValue('A3', 'Legendas das células')
            ->setCellValue('A4', 'Conflito de Valores SOF/IGSIS')
            ->setCellValue('A5', 'Possível erro na indicação de verba')
			;
$objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF3333')
            ),
        )
);
$objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFF00')
            ),
        )
);


$objPHPExcel->getActiveSheet()->setTitle('Informações');
foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
        $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
    } 

$objPHPExcel->setActiveSheetIndex(0);
ob_end_clean();
    ob_start();
	
$nome_arquivo = date("Y-m-d")."_integracao_sei_sof.xls";
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: text/html; charset=ISO-8859-1');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$nome_arquivo.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


///////////////////////////////////////////////////////////////////////////////////////////////


break;
case 'seinvalido':
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties

$objPHPExcel->getProperties()->setCreator("Sistema IGSIS");
$objPHPExcel->getProperties()->setLastModifiedBy("Sistema IGSIS");
$objPHPExcel->getProperties()->setTitle("Relatório IGSIS Controle Orçamentário");
$objPHPExcel->getProperties()->setSubject("Relatório IGSIS Controle Orçamentário");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema IGSIS");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Orçamento");


// Nome dos campos
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Número de Pedido (IGSIS)')
            ->setCellValue('B1', 'Evento (IGSIS)')
            ->setCellValue('C1', 'Projeto (IGSIS)')
            ->setCellValue('D1', 'Processo SEI (SOF/IGSIS)')
            ->setCellValue('E1', 'Responsável/Fiscal (IGSIS)')
            ->setCellValue('F1', 'Suplente (IGSIS)')
            ->setCellValue('G1', 'Locais (IGSIS)')
            ->setCellValue('H1', 'Proponente (IGSIS)/ Razão Social (SOF)')
            ->setCellValue('I1', 'Status (IGSIS)')
            ->setCellValue('J1', 'Data Inicial (IGSIS)')
            ->setCellValue('K1', 'Data Final (IGSIS)')
            ->setCellValue('L1', 'Valor (IGSIS)')
            ->setCellValue('M1', 'Valor (SOF)')
            ->setCellValue('N1', 'Tipo de pessoa (IGSIS)')
            ->setCellValue('O1', 'Empenho (SOF)')
            ->setCellValue('P1', 'Data do Empenho (SOF))')
            ->setCellValue('Q1', 'Verba (IGSIS)')
            ->setCellValue('R1', 'Dotação (SOF)')
            ->setCellValue('S1', 'Liquidado (SOF)')
            ->setCellValue('T1', 'Valor a liquidar (SOF)')
            ->setCellValue('U1', 'Pago (SOF)')
            ->setCellValue('V1', 'Descrição (SOF)')

			;
	//Colorir a primeira fila
	$objPHPExcel->getActiveSheet()->getStyle('A1:V1')->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E0EEEE')
            ),
        )
);


		

		
// Inserir dados (SEI Não Válidos no SOF)			
// recupera os pedidos de contratação com nProcessos válidos
$sql_01 =  "SELECT idPedidoContratacao,nProcesso, parcelas, idVerba FROM igsis_pedido_contratacao WHERE publicado = '1' AND tipoPessoa <> '4' AND nProcesso IS NOT NULL AND nProcesso <> '' AND valor <> 0";
$query_01 = mysqli_query($con,$sql_01);

if($query_01){
			$i = 2;

	while($x = mysqli_fetch_row($query_01)){
		$nProcesso = $x[1];
		$idPedido = $x[0];
		// Busca na tabela SOF Processos que batem a IGSIS
		$sql_02 = "SELECT processo FROM igsis_6354 WHERE processo LIKE '$nProcesso'";
		$query_02 = mysqli_query($con,$sql_02);	
		$num_02 = mysqli_num_rows($query_02);
		if($num_02 == 0){
			$sql_sei = "SELECT idPedidoContratacao, idEvento, idPessoa, tipoPessoa, idVerba, estado, valor, NumeroProcesso FROM igsis_pedido_contratacao WHERE idPedidoContratacao = '$idPedido' LIMIT 0,1";
			$query_sei = mysqli_query($con,$sql_sei);
			$pedido = mysqli_fetch_array($query_sei);
			//$x = siscontrat($pedido['idPedidoContratacao']);
			if($pedido['idVerba'] != 30 AND $pedido['idVerba'] != 69){
			
			$evento = recuperaDados("ig_evento",$pedido['idEvento'],"idEvento"); //$tabela,$idEvento,$campo
			$projeto = recuperaDados("ig_projeto_especial",$evento['projetoEspecial'],"idProjetoEspecial");
			$fiscal = recuperaDados("ig_usuario",$evento['idResponsavel'],"idUsuario");
			$suplente = recuperaDados("ig_usuario",$evento['suplente'],"idUsuario");
			$locais = listaLocais($pedido['idEvento']);
			$pessoa = siscontratDocs($pedido['idPessoa'],$pedido['tipoPessoa']);
			$verba = recuperaDados("sis_verba",$pedido['idVerba'],"Id_Verba");
			$estado = retornaEstado($pedido['estado']);
			$data = retornaData($pedido['idEvento']);
			if($pedido['tipoPessoa'] == 1){
				$tipo = "PESSOA FÍSICA";
			}else{
				$tipo = "PESSOA JURÍDICA";
			}
			
			$a = "A".$i;
			$b = "B".$i;
			$c = "C".$i;
			$d = "D".$i;
			$e = "E".$i;
			$f = "F".$i;
			$g = "G".$i;
			$h = "H".$i;
			$I = "I".$i;
			$j = "J".$i;
			$k = "K".$i;
			$l = "L".$i;
			$m = "M".$i;
			$n = "N".$i;
			$o = "O".$i;
			$p = "P".$i;
			$q = "Q".$i;			
			$r = "R".$i;			
			$s = "S".$i;			
			$t = "T".$i;
			$u = "U".$i;
			$v = "V".$i;			
			
			
			$objPHPExcel->setActiveSheetIndex(0)
				
						->setCellValue($a, $pedido['idPedidoContratacao'])
						->setCellValue($b, $evento['nomeEvento'])
						->setCellValue($c, $projeto['projetoEspecial'])
						->setCellValue($d, $pedido['NumeroProcesso'])
						->setCellValue($e, $fiscal['nomeCompleto'])
						->setCellValue($f, $suplente['nomeCompleto'])
						->setCellValue($g, $locais)
			            ->setCellValue($j, $data['inicio'])
			            ->setCellValue($k, $data['final'])
						->setCellValue($h, $pessoa['Nome'])
						->setCellValue($I, $estado)
						->setCellValue($l, $pedido['valor'])
						->setCellValue($n, $tipo)
						->setCellValue($q, $verba['Verba']);
						
			
				//Verbas erradas
			if(trim($pedido['idVerba']) == '' OR
				$pedido['idVerba'] == NULL OR
				$pedido['idVerba'] == 1 OR
				$pedido['idVerba'] == 6 OR 
				$pedido['idVerba'] == 2 OR
				$pedido['idVerba'] == 8 
				)
			{
				$objPHPExcel->getActiveSheet()->getStyle($q)->applyFromArray(
					array('fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'FFFF00')
						),
					)
				);
			}
		$i++;			
			}else{
			$id = $pedido['idPedidoContratacao'];
			$sql_verba = "SELECT * FROM sis_verbas_multiplas WHERE idPedidoContratacao = '$id' AND valor > '0'";
			$query_verba = mysqli_query($con,$sql_verba);
			while($verba_multipla = mysqli_fetch_array($query_verba)){ 	
			$evento = recuperaDados("ig_evento",$pedido['idEvento'],"idEvento"); //$tabela,$idEvento,$campo
			$projeto = recuperaDados("ig_projeto_especial",$evento['projetoEspecial'],"idProjetoEspecial");
			$fiscal = recuperaDados("ig_usuario",$evento['idResponsavel'],"idUsuario");
			$suplente = recuperaDados("ig_usuario",$evento['suplente'],"idUsuario");
			$locais = listaLocais($pedido['idEvento']);
			$pessoa = siscontratDocs($pedido['idPessoa'],$pedido['tipoPessoa']);
			$verba = recuperaDados("sis_verba",$verba_multipla['idVerba'],"Id_Verba");
			$estado = retornaEstado($pedido['estado']);
			$data = retornaData($pedido['idEvento']);
			if($pedido['tipoPessoa'] == 1){
				$tipo = "PESSOA FÍSICA";
			}else{
				$tipo = "PESSOA JURÍDICA";
			}
			
			$a = "A".$i;
			$b = "B".$i;
			$c = "C".$i;
			$d = "D".$i;
			$e = "E".$i;
			$f = "F".$i;
			$g = "G".$i;
			$h = "H".$i;
			$I = "I".$i;
			$j = "J".$i;
			$k = "K".$i;
			$l = "L".$i;
			$m = "M".$i;
			$n = "N".$i;
			$o = "O".$i;
			$p = "P".$i;
			$q = "Q".$i;			
			$r = "R".$i;			
			$s = "S".$i;			
			$t = "T".$i;
			$u = "U".$i;
			$v = "V".$i;			
			
			
			$objPHPExcel->setActiveSheetIndex(0)
				
						->setCellValue($a, $pedido['idPedidoContratacao'])
						->setCellValue($b, $evento['nomeEvento'])
						->setCellValue($c, $projeto['projetoEspecial'])
						->setCellValue($d, $pedido['NumeroProcesso'])
						->setCellValue($e, $fiscal['nomeCompleto'])
						->setCellValue($f, $suplente['nomeCompleto'])
						->setCellValue($g, $locais)
			            ->setCellValue($j, $data['inicio'])
			            ->setCellValue($k, $data['final'])
						->setCellValue($h, $pessoa['Nome'])
						->setCellValue($I, $estado)
						->setCellValue($l, $verba_multipla['valor'])
						->setCellValue($n, $tipo)
						->setCellValue($q, $verba['Verba']." (VM)");
						
			
				//Verbas erradas
			if(trim($pedido['idVerba']) == '' OR
				$pedido['idVerba'] == NULL OR
				$pedido['idVerba'] == 1 OR
				$pedido['idVerba'] == 6 OR 
				$pedido['idVerba'] == 2 OR
				$pedido['idVerba'] == 8 
				)
			{
				$objPHPExcel->getActiveSheet()->getStyle($q)->applyFromArray(
					array('fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'FFFF00')
						),
					)
				);
			}
		$i++;			
			}
	
	
	
				
		}
		}
		

	} 

} 
	
	

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Pedidos com SEI mas sem SOF');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet


foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
        $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
    } 


/////////////////////////// Nova tabela ////////////////////////

$objPHPExcel->createSheet();


// Nome dos campos
$objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A1', 'Número de Pedido (IGSIS)')
            ->setCellValue('B1', 'Evento (IGSIS)')
            ->setCellValue('C1', 'Projeto (IGSIS)')
            ->setCellValue('D1', 'Processo SEI (SOF/IGSIS)')
            ->setCellValue('E1', 'Responsável/Fiscal (IGSIS)')
            ->setCellValue('F1', 'Suplente (IGSIS)')
            ->setCellValue('G1', 'Locais (IGSIS)')
            ->setCellValue('H1', 'Proponente (IGSIS)/ Razão Social (SOF)')
            ->setCellValue('I1', 'Status (IGSIS)')
            ->setCellValue('J1', 'Data Inicial (IGSIS)')
            ->setCellValue('K1', 'Data Final (IGSIS)')
            ->setCellValue('L1', 'Valor (IGSIS)')
            ->setCellValue('M1', 'Valor (SOF)')
            ->setCellValue('N1', 'Tipo de pessoa (IGSIS)')
            ->setCellValue('O1', 'Empenho (SOF)')
            ->setCellValue('P1', 'Data do Empenho (SOF))')
            ->setCellValue('Q1', 'Verba (IGSIS)')
            ->setCellValue('R1', 'Dotação (SOF)')
            ->setCellValue('S1', 'Liquidado (SOF)')
            ->setCellValue('T1', 'Valor a liquidar (SOF)')
            ->setCellValue('U1', 'Pago (SOF)')
            ->setCellValue('V1', 'Descrição (SOF)')

			;
	//Colorir a primeira fila
	$objPHPExcel->getActiveSheet()->getStyle('A1:V1')->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E0EEEE')
            ),
        )
);


// Inserir dados (SEI não validados na IGSIS)
// recupera todos os processo da  
$k = 0;
$sql_01 = "SELECT processo FROM igsis_6354";
$query_01 = mysqli_query($con,$sql_01);
$i = 2;
if($query_01){
	while($x = mysqli_fetch_row($query_01)){
		$processo = $x[0];
		//Busca na tabela IGSIS Processos que batem com o SOF
		$sql_02 = "SELECT idPedidoContratacao FROM igsis_pedido_contratacao WHERE nProcesso LIKE '$processo'";
		$query_02 = mysqli_query($con,$sql_02);	
		$num_02 = mysqli_num_rows($query_02);
		if($num_02 == 0){

			$sql_sei = "SELECT * FROM igsis_6354 WHERE processo = '$processo'";
			$query_sei = mysqli_query($con,$sql_sei);
			while($pedido = mysqli_fetch_array($query_sei)){
			
			$a = "A".$i;
			$b = "B".$i;
			$c = "C".$i;
			$d = "D".$i;
			$e = "E".$i;
			$f = "F".$i;
			$g = "G".$i;
			$h = "H".$i;
			$I = "I".$i;
			$j = "J".$i;
			$k = "K".$i;
			$l = "L".$i;
			$m = "M".$i;
			$n = "N".$i;
			$o = "O".$i;
			$p = "P".$i;
			$q = "Q".$i;			
			$r = "R".$i;			
			$s = "S".$i;			
			$t = "T".$i;
			$u = "U".$i;
			$v = "V".$i;			
			
			
			$objPHPExcel->setActiveSheetIndex(1)
				
						->setCellValue($d, $pedido['processo'])
						->setCellValue($h, $pedido['razao_social'])
						->setCellValue($m, $pedido['valor'])
						->setCellValue($o, $pedido['empenho'])
						->setCellValue($p, $pedido['data_empenho'])
						->setCellValue($r, $pedido['dotacao'])
						->setCellValue($s, $pedido['liquidado'])
						->setCellValue($t, $pedido['valor_a_liquidar'])
						->setCellValue($u, $pedido['pago'])
						->setCellValue($v, $pedido['descricao']);
						
			

			}
			$i++;



		}
		
	}
}

$objPHPExcel->getActiveSheet()->setTitle('Processos SOF sem IGSIS');
foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
        $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
    } 

	
// Cria uma planilha nova	
$objPHPExcel->createSheet();

// Add some data to the second sheet, resembling some different data types
$objPHPExcel->setActiveSheetIndex(2);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setWrapText(true);

$men_sof = "Pedidos com SEI mas sem SOF : são pedidos que constam 
no sistema IGSIS, possuem Número SEI mas não estão listados 
no sistema SOF. Das causas possíveis, podemos listar: 
+ o Processo SEI ainda não chegou na contabilidade; 
+ o Processo SEI está incorreto na IGSIS;
+ o Processo SEI foi cancelado; 	
 ";

$men_sof_2 = "Processos SOF sem IGSIS: são processos na contabilidade
que possuem Número SEI mas não estão listados na IGSIS. Das causas
possíveis, podemos listar:
+ o processo não foi feito a partir de um pedido de contratação da IGSIS;
+ o Processo SEI está incorreto na IGSIS;
+ o processo se iniciou antes de 04/01/2016, data de implementação da IGSIS;
";
$men_igsis = "Planilha gerada em ".date("d/m/Y")." às ".date("H:i")."";

$objPHPExcel->setActiveSheetIndex(2)
            ->setCellValue('A1', $men_igsis)
            ->setCellValue('A2', $men_sof)
            ->setCellValue('A3', $men_sof_2)
            ->setCellValue('A4', 'Legendas das células')
            ->setCellValue('A5', 'Conflito de Valores SOF/IGSIS')
            ->setCellValue('A6', 'Possível erro na indicação de verba')
			;
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF3333')
            ),
        )
);
$objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFF00')
            ),
        )
);


$objPHPExcel->getActiveSheet()->setTitle('Informações');
foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
        $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
    } 

$objPHPExcel->setActiveSheetIndex(0);
ob_end_clean();
    ob_start();
	
$nome_arquivo = date("Y-m-d")."_discrepancias.xls";
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: text/html; charset=ISO-8859-1');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$nome_arquivo.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;



break;
case 'nosei':

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties

$objPHPExcel->getProperties()->setCreator("Sistema IGSIS");
$objPHPExcel->getProperties()->setLastModifiedBy("Sistema IGSIS");
$objPHPExcel->getProperties()->setTitle("Relatório IGSIS Controle Orçamentário");
$objPHPExcel->getProperties()->setSubject("Relatório IGSIS Controle Orçamentário");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema IGSIS");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Orçamento");

// Nome dos campos
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Número de Pedido (IGSIS)')
            ->setCellValue('B1', 'Evento (IGSIS)')
            ->setCellValue('C1', 'Projeto (IGSIS)')
            ->setCellValue('D1', 'Responsável/Fiscal (IGSIS)')
            ->setCellValue('E1', 'Suplente (IGSIS)')
            ->setCellValue('F1', 'Locais (IGSIS)')
            ->setCellValue('G1', 'Proponente (IGSIS)/ Razão Social (SOF)')
            ->setCellValue('H1', 'Status (IGSIS)')
            ->setCellValue('I1', 'Valor (IGSIS)')
            ->setCellValue('J1', 'Tipo de pessoa (IGSIS)')
            ->setCellValue('K1', 'Verba (IGSIS)')
			
			;
			
	//Colorir a primeira fila
	$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E0EEEE')
            ),
        )
);			
// Inserir dados (SEI Válido)			
$sql_sei = "SELECT * FROM igsis_pedido_contratacao WHERE publicado = '1' AND valor <> '0' AND tipoPessoa <> '4' AND (nProcesso IS NULL OR nProcesso = '') AND estado IS NOT NULL  ORDER BY idPedidoContratacao";
$query_sei = mysqli_query($con,$sql_sei);
$i = 2;
while($pedido = mysqli_fetch_array($query_sei)){
		//$x = siscontrat($pedido['idPedidoContratacao']);
		$evento = recuperaDados("ig_evento",$pedido['idEvento'],"idEvento"); //$tabela,$idEvento,$campo
		$projeto = recuperaDados("ig_projeto_especial",$evento['projetoEspecial'],"idProjetoEspecial");
		$fiscal = recuperaDados("ig_usuario",$evento['idResponsavel'],"idUsuario");
		$suplente = recuperaDados("ig_usuario",$evento['suplente'],"idUsuario");
		$locais = listaLocais($pedido['idEvento']);
		
		$pessoa = siscontratDocs($pedido['idPessoa'],$pedido['tipoPessoa']);
		$verba = recuperaDados("sis_verba",$pedido['idVerba'],"Id_Verba");
		$estado = retornaEstado($pedido['estado']);
		if($pedido['tipoPessoa'] == 1){
			$tipo = "PESSOA FÍSICA";
		}else{
			$tipo = "PESSOA JURÍDICA";
		}

			$a = "A".$i;
			$b = "B".$i;
			$c = "C".$i;
			$d = "D".$i;
			$e = "E".$i;
			$f = "F".$i;
			$g = "G".$i;
			$h = "H".$i;
			$I = "I".$i;
			$j = "J".$i;
			$k = "K".$i;
		


$objPHPExcel->setActiveSheetIndex(0)
	
            ->setCellValue($a, $pedido['idPedidoContratacao'])
            ->setCellValue($b, $evento['nomeEvento'])
            ->setCellValue($c, $projeto['projetoEspecial'])
            ->setCellValue($d, $fiscal['nomeCompleto'])
            ->setCellValue($e, $suplente['nomeCompleto'])
            ->setCellValue($f, $locais)
            ->setCellValue($g, $pessoa['Nome'])
            ->setCellValue($h, $estado)
            ->setCellValue($I, $pedido['valor'])
            ->setCellValue($j, $tipo)
            ->setCellValue($k, $verba['Verba']);
			
				//Verbas erradas
	if(trim($pedido['idVerba']) == '' OR
	$pedido['idVerba'] == NULL OR
	$pedido['idVerba'] == 1 OR
	$pedido['idVerba'] == 6 OR 
	$pedido['idVerba'] == 2 OR
	$pedido['idVerba'] == 8 
	
	
	){
	$objPHPExcel->getActiveSheet()->getStyle($k)->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFF00')
            ),
        )
);
	}
			
			$i++;

}
$objPHPExcel->getActiveSheet()->setTitle('Pedidos de Contratação sem SEI');
foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
        $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
    } 



	
// Cria uma planilha nova	
$objPHPExcel->createSheet();

// Add some data to the second sheet, resembling some different data types
$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setWrapText(true);

$men_sof = recuperaAtualizacao('sof');
$men_igsis = "Planilha gerada em ".date("d/m/Y")." às ".date("H:i")."";

$objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A1', $men_igsis)
            ->setCellValue('A2', $men_sof)
            ->setCellValue('A3', 'Legendas das células')
            ->setCellValue('A4', 'Conflito de Valores SOF/IGSIS')
            ->setCellValue('A5', 'Possível erro na indicação de verba')
			;
$objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF3333')
            ),
        )
);
$objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFF00')
            ),
        )
);


$objPHPExcel->getActiveSheet()->setTitle('Informações');
foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
        $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
    } 

$objPHPExcel->setActiveSheetIndex(0);
ob_end_clean();
    ob_start();
	
$nome_arquivo = date("Y-m-d")."_pedidos_sem_sei.xls";
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: text/html; charset=ISO-8859-1');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$nome_arquivo.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

break;





}
//}else{
//	echo "No access";	
//}
?>