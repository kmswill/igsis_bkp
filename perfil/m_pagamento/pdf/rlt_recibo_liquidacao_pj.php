<?php 
   
   // INSTALAÇÃO DA CLASSE NA PASTA FPDF.
	require_once("../include/lib/fpdf/fpdf.php");
	
   //require '../include/';
   require_once("../funcoes/funcoesConecta.php");
   require_once("../funcoes/funcoesGerais.php");
   require_once("../funcoes/funcoesSiscontrat.php");

   //CONEXÃO COM BANCO DE DADOS 
   $conexao = bancoMysqli();

   
class PDF extends FPDF
{
// Page header
function Header()
{
	session_start();
	$inst = recuperaDados("ig_instituicao",$_SESSION['idInstituicao'],"idInstituicao");
	$logo = "../visual/img/".$inst['logo']; 
    // Logo
    $this->Image($logo,20,20,50);
    // Move to the right
    $this->Cell(80);
    $this->Image('../visual/img/logo_smc.jpg',170,10);
    // Line break
    $this->Ln(20);
}

}


//CONSULTA  (copia inteira em todos os docs)
$id_ped=$_GET['id'];

$ano=date('Y');

$pedido = siscontrat($id_ped);
$pj = siscontratDocs($pedido['IdProponente'],2);
$ex = siscontratDocs($pedido['IdExecutante'],1);
$rep01 = siscontratDocs($pj['Representante01'],3);
$rep02 = siscontratDocs($pj['Representante02'],3);

$codPed = $id_ped;
$objeto = $pedido["Objeto"];
$NumeroProcesso = $pedido["NumeroProcesso"];
$extratoLiquidacao = $pedido["extratoLiquidacao"];
$retencoesINSS = $pedido["retencoesINSS"];
$retencoesISS = $pedido["retencoesISS"];
$retencoesIRRF = $pedido["retencoesIRRF"];


//PessoaJuridica
$pjRazaoSocial = $pj["Nome"];
$pjCCM = $pj["CCM"];
$pjINSS = $pj["INSS"];
$pjCNPJ = $pj['CNPJ'];

$codPed = "";

// Executante
$exNome = $ex["Nome"];
$exRG = $ex["RG"];
$exCPF = $ex["CPF"];
$exCCM = $ex["CCM"];
$exINSS = $ex["INSS"];

// Representante01
$rep01Nome = $rep01["Nome"];


// Representante02
$rep02Nome = $rep02["Nome"];


$setor = $pedido["Setor"];


// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

   
$x=20;
$l=6; //DEFINE A ALTURA DA LINHA   
   
   $pdf->SetXY( $x , 45 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 14);
   $pdf->Cell(180,5,utf8_decode("RECIBO DE ENTREGA DE NOTA DE LIQUIDAÇÃO"),0,1,'C');
   
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(180,$l,utf8_decode("Recebi nesta data, da Secretaria Municipal de Cultura, cópias dos seguintes documentos, conforme consta no processo nº: ".$NumeroProcesso.""));
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(10,5,utf8_decode("(    )"),0,0,'C');
   $pdf->MultiCell(170,$l,utf8_decode("Extrato de Liquidação e Pagamento nº: ".$extratoLiquidacao));
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(10,5,utf8_decode("(    )"),0,0,'C');
   $pdf->MultiCell(170,$l,utf8_decode("Retenções de I.N.S.S. - Guia de Recolhimento ou Depósito da Prefeitura do Município de São Paulo nº: ".$retencoesINSS));
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(10,5,utf8_decode("(    )"),0,0,'C');
   $pdf->MultiCell(180,$l,utf8_decode("Retenções de I.S.S. - Documento de Arrecadação de Tributos Imobiliários - DARM n.º: ".$retencoesISS));
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(10,5,utf8_decode("(    )"),0,0,'C');
   $pdf->MultiCell(170,$l,utf8_decode("Retenções de I.R.R.F. - Guia Recibo de Recolhimento ou Depósito nº: ".$retencoesIRRF));
   
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(180,$l,utf8_decode("Em, ______ de _______________________ de ".$ano."."));
   
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(180,$l,utf8_decode("Assinatura: ____________________________________________"));
   
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 11);
   $pdf->Cell(27,$l,utf8_decode('Razão Social:'),0,0,'L');
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(150,$l,utf8_decode($pjRazaoSocial),0,1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 11);
   $pdf->Cell(14,$l,utf8_decode('CNPJ:'),0,0,'L');
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(150,$l,utf8_decode($pjCNPJ),0,1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 11);
   $pdf->Cell(12,$l,utf8_decode('CCM:'),0,0,'L');
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(150,$l,utf8_decode($pjCCM),0,1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 11);
   $pdf->Cell(37,$l,utf8_decode('Responsável (eis):'),0,0,'L');
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(143,$l,utf8_decode($rep01Nome),0,1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 11);
   $pdf->Cell(37,$l,'',0,0,'L');
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(143,$l,utf8_decode($rep02Nome),0,1,'L');
   
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   
   
$pdf->Output();


?>