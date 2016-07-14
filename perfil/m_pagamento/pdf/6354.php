<?php
session_start();

   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 	

//if(isset($_SESSION['idUsuario'])){
//require '../include/';
   require_once("../funcoes/funcoesConecta.php");
   require_once("../funcoes/funcoesGerais.php");
   require_once("../funcoes/funcoesSiscontrat.php");
   require_once("../funcoes/funcoesSiscontrat.php");
   require_once("../include/phpexcel/Classes/PHPExcel.php");


//CONEXÃO COM BANCO DE DADOS 
   $con = bancoMysqli();

//Atualiza tabela igsis_pedido_contratacao com numero sei sem caracteres
$sql_atualiza_sei = "SELECT * FROM igsis_pedido_contratacao WHERE publicado = '1'";
$query_atualiza_sei = mysqli_query($con,$sql_atualiza_sei);
while($atualiza_sei = mysqli_fetch_array($query_atualiza_sei)){
	$idPedido = $atualiza_sei['idPedidoContratacao'];
	$n_processo = trim(soNumero($atualiza_sei['NumeroProcesso']));
	$sql_update_sei = "UPDATE igsis_pedido_contratacao SET nProcesso = '$n_processo' WHERE idPedidoContratacao = '$idPedido'";
	mysqli_query($con,$sql_update_sei);
}


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties

$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
$cacheSettings = array( ' memoryCacheSize ' => '8MB');
PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

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
            ->setCellValue('J1', 'Valor (IGSIS)')
            ->setCellValue('K1', 'Valor (SOF)')
            ->setCellValue('L1', 'Tipo de pessoa (IGSIS)')
            ->setCellValue('M1', 'Empenho (SOF)')
            ->setCellValue('N1', 'Data do Empenho (SOF))')
            ->setCellValue('O1', 'Verba (IGSIS)')
            ->setCellValue('P1', 'Dotação (SOF)')
            ->setCellValue('Q1', 'Liquidado (SOF)')
            ->setCellValue('R1', 'Valor a liquidar (SOF)')
            ->setCellValue('S1', 'Pago (SOF)')
            ->setCellValue('T1', 'Descrição (SOF)')

			;
	//Colorir a primeira fila
	$objPHPExcel->getActiveSheet()->getStyle('A1:T1')->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E0EEEE')
            ),
        )
);


		

// Inserir dados (SEI Válido)			
$sql_sei = "SELECT * FROM igsis_pedido_contratacao,igsis_6354 WHERE igsis_pedido_contratacao.publicado = '1' AND igsis_pedido_contratacao.valor <> '0' AND igsis_pedido_contratacao.tipoPessoa <> '4' AND igsis_pedido_contratacao.nProcesso LIKE igsis_6354.processo  ORDER BY igsis_pedido_contratacao.idPedidoContratacao";
$query_sei = mysqli_query($con,$sql_sei);
$i = 2;
while($pedido = mysqli_fetch_array($query_sei)){
		$x = siscontrat($pedido['idPedidoContratacao']);
		$evento = recuperaDados("ig_evento",$pedido['idEvento'],"idEvento"); //$tabela,$idEvento,$campo
		$projeto = recuperaDados("ig_projeto_especial",$evento['projetoEspecial'],"idProjetoEspecial");
		$pessoa = siscontratDocs($pedido['idPessoa'],$pedido['tipoPessoa']);
		$verba = recuperaDados("sis_verba",$pedido['idVerba'],"Id_Verba");
		$estado = retornaEstado($x['Status']);
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


$objPHPExcel->setActiveSheetIndex(0)
	
            ->setCellValue($a, $pedido['idPedidoContratacao'])
            ->setCellValue($b, $evento['nomeEvento'])
            ->setCellValue($c, $projeto['projetoEspecial'])
            ->setCellValue($d, $x['NumeroProcesso'])
            ->setCellValue($e, $x['Fiscal'])
            ->setCellValue($f, $x['Suplente'])
            ->setCellValue($g, $x['Local'])
            ->setCellValue($h, $pessoa['Nome'])
            ->setCellValue($I, $estado)
            ->setCellValue($j, $pedido['valor'])
            ->setCellValue($k, $pedido[48])
            ->setCellValue($l, $tipo)
            ->setCellValue($m, $pedido['empenho'])
            ->setCellValue($n, $pedido['data_empenho'])
            ->setCellValue($o, $verba['Verba'])
            ->setCellValue($p, $pedido['dotacao'])
            ->setCellValue($q, $pedido['liquidado'])
            ->setCellValue($r, $pedido['valor_a_liquidar'])
            ->setCellValue($s, $pedido['pago'])
            ->setCellValue($t, $pedido['descricao']);
			
	//Colorir erros
	// Valores IGSIS e SOF não batem
	if($pedido['48'] != $pedido['valor']){
	$objPHPExcel->getActiveSheet()->getStyle($j.":".$k)->applyFromArray(
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
	$objPHPExcel->getActiveSheet()->getStyle($o)->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFF00')
            ),
        )
);
	}

				
			
			$i++;

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
            ->setCellValue('J1', 'Valor (IGSIS)')
            ->setCellValue('K1', 'Valor (SOF)')
            ->setCellValue('L1', 'Tipo de pessoa (IGSIS)')
            ->setCellValue('M1', 'Empenho (SOF)')
            ->setCellValue('N1', 'Data do Empenho (SOF))')
            ->setCellValue('O1', 'Verba (IGSIS)')
            ->setCellValue('P1', 'Dotação (SOF)')
            ->setCellValue('Q1', 'Liquidado (SOF)')
            ->setCellValue('R1', 'Valor a liquidar (SOF)')
            ->setCellValue('S1', 'Pago (SOF)')
            ->setCellValue('T1', 'Descrição (SOF)')

			;
	//Colorir a primeira fila
	$objPHPExcel->getActiveSheet()->getStyle('A1:T1')->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E0EEEE')
            ),
        )
);


		

// Inserir dados (SEI Válido)			
$sql_sei = "SELECT * FROM igsis_pedido_contratacao,igsis_6354 WHERE igsis_pedido_contratacao.publicado = '1' AND igsis_pedido_contratacao.valor <> '0' AND igsis_pedido_contratacao.tipoPessoa <> '4' AND igsis_pedido_contratacao.nProcesso NOT LIKE igsis_6354.processo  ORDER BY igsis_pedido_contratacao.idPedidoContratacao";
$query_sei = mysqli_query($con,$sql_sei);
$i = 2;
while($pedido = mysqli_fetch_array($query_sei)){
		$x = siscontrat($pedido['idPedidoContratacao']);
		$evento = recuperaDados("ig_evento",$pedido['idEvento'],"idEvento"); //$tabela,$idEvento,$campo
		$projeto = recuperaDados("ig_projeto_especial",$evento['projetoEspecial'],"idProjetoEspecial");
		$pessoa = siscontratDocs($pedido['idPessoa'],$pedido['tipoPessoa']);
		$verba = recuperaDados("sis_verba",$pedido['idVerba'],"Id_Verba");
		$estado = retornaEstado($x['Status']);
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


$objPHPExcel->setActiveSheetIndex(1)
	
            ->setCellValue($a, $pedido['idPedidoContratacao'])
            ->setCellValue($b, $evento['nomeEvento'])
            ->setCellValue($c, $projeto['projetoEspecial'])
            ->setCellValue($d, $x['NumeroProcesso'])
            ->setCellValue($e, $x['Fiscal'])
            ->setCellValue($f, $x['Suplente'])
            ->setCellValue($g, $x['Local'])
            ->setCellValue($h, $pessoa['Nome'])
            ->setCellValue($I, $estado)
            ->setCellValue($j, $pedido['valor'])
            ->setCellValue($k, $pedido[48])
            ->setCellValue($l, $tipo)
            ->setCellValue($m, $pedido['empenho'])
            ->setCellValue($n, $pedido['data_empenho'])
            ->setCellValue($o, $verba['Verba'])
            ->setCellValue($p, $pedido['dotacao'])
            ->setCellValue($q, $pedido['liquidado'])
            ->setCellValue($r, $pedido['valor_a_liquidar'])
            ->setCellValue($s, $pedido['pago'])
            ->setCellValue($t, $pedido['descricao']);
			
	//Colorir erros
	// Valores IGSIS e SOF não batem
	if($pedido['48'] != $pedido['valor']){
	$objPHPExcel->getActiveSheet()->getStyle($j.":".$k)->applyFromArray(
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
	$objPHPExcel->getActiveSheet()->getStyle($o)->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFF00')
            ),
        )
);
	}

				
			
			$i++;

}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Conflitos entre SEI e SOF');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet


foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
        $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
    } 









// Cria uma planilha nova	
$objPHPExcel->createSheet();

// Add some data to the second sheet, resembling some different data types
$objPHPExcel->setActiveSheetIndex(2);
// Nome dos campos
$objPHPExcel->setActiveSheetIndex(2)
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
		$x = siscontrat($pedido['idPedidoContratacao']);
		$evento = recuperaDados("ig_evento",$pedido['idEvento'],"idEvento"); //$tabela,$idEvento,$campo
		$projeto = recuperaDados("ig_projeto_especial",$evento['projetoEspecial'],"idProjetoEspecial");
		$pessoa = siscontratDocs($pedido['idPessoa'],$pedido['tipoPessoa']);
		$verba = recuperaDados("sis_verba",$pedido['idVerba'],"Id_Verba");
		$estado = retornaEstado($x['Status']);
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
		


$objPHPExcel->setActiveSheetIndex(2)
	
            ->setCellValue($a, $pedido['idPedidoContratacao'])
            ->setCellValue($b, $evento['nomeEvento'])
            ->setCellValue($c, $projeto['projetoEspecial'])
            ->setCellValue($d, $x['Fiscal'])
            ->setCellValue($e, $x['Suplente'])
            ->setCellValue($f, $x['Local'])
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
	$objPHPExcel->getActiveSheet()->getStyle($o)->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFF00')
            ),
        )
);
	}
			
			$i++;

}
foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
        $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
    } 


// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('Pedidos sem SEI');
	
// Cria uma planilha nova	
$objPHPExcel->createSheet();

// Add some data to the second sheet, resembling some different data types
$objPHPExcel->setActiveSheetIndex(3);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setWrapText(true);

$men_sof = recuperaAtualizacao('sof');
$men_igsis = "Planilha gerada em ".date("d/m/Y")." às ".date("H:i")."";

$objPHPExcel->setActiveSheetIndex(3)
            ->setCellValue('A1', $men_igsis)
            ->setCellValue('A2', $men_sof)
            ->setCellValue('A3', 'Legendas das células')
            ->setCellValue('A4', 'Conflito de Valores SOF/IGSIS')
            ->setCellValue('A5', 'Possível erro na indicação de verba verba')
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
	
	$nome_arquivo = date("Y-m-d")."_igsis_relatorio.xls";
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
//}else{
//	echo "No access";	
//}
?>