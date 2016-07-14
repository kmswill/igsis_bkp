<?php 
   
   // INSTALAÇÃO DA CLASSE NA PASTA FPDF.
	require_once("../include/lib/fpdf/fpdf.php");
   require_once("../funcoes/funcoesConecta.php");
   require_once("../funcoes/funcoesGerais.php");
   require_once("../funcoes/funcoesSiscontrat.php");

   //CONEXÃO COM BANCO DE DADOS 
   $conexao = bancoMysqli(); 
   
// logo da instituição 
session_start();


  
class PDF extends FPDF
{
// Page header
function Header()
{	
    // Logo
    $this->Image('../pdf/img/fac_pf.jpg',15,10,180);
    
    // Line break
    $this->Ln(20);
}

}



//CONSULTA 
$id_ped=$_GET['id'];

$ano=date('Y');

$pedido = siscontrat($id_ped);
$pessoa = siscontratDocs($pedido['IdProponente'],1);
$enderecoCEP = enderecoCEP($pessoa['CEP']);

$rua = $enderecoCEP["rua"]; 
$bairro = $enderecoCEP["bairro"];
$cidade = $enderecoCEP["cidade"];
$estado = $enderecoCEP["estado"];

$Nome = $pessoa["Nome"];
$RG = $pessoa["RG"];
$CPF = $pessoa["CPF"];
$CCM = $pessoa["CCM"];
$Endereco = $pessoa["Endereco"];
$NumEndereco = $pessoa["NumEndereco"];
$Complemento = $pessoa["Complemento"];
$cep = $pessoa["CEP"];
$Telefone01 = $pessoa["Telefone01"];
$banco = $pessoa["Banco"];
$agencia = $pessoa["Agencia"];
$conta = $pessoa["Conta"];
$codbanco = $pessoa["CodigoBanco"];
$cbo = $pessoa["cbo"];
$INSS = $pessoa["INSS"];
$DataNascimento = exibirDataBr($pessoa["DataNascimento"]);


// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

   
$x=20;
$l=7; //DEFINE A ALTURA DA LINHA   
   
   $pdf->SetXY( $x , 40 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

   $pdf->SetXY(113, 40);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(10,$l,utf8_decode('X'),0,0,'L');

   $pdf->SetXY($x, 40);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(53,$l,utf8_decode($CPF),0,0,'L');
   
   $pdf->SetXY(155, 40);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(53,$l,utf8_decode($CCM),0,0,'L');
   
   $pdf->SetXY($x, 55);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(160,$l,utf8_decode($Nome),0,0,'L');
   
   $pdf->SetXY($x, 68);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(160,$l,utf8_decode("$rua".", "."$NumEndereco".", "."$Complemento"),0,0,'L');
   
   $pdf->SetXY($x, 82);
   $pdf->SetFont('Arial','', 9);
   $pdf->Cell(68,$l,utf8_decode($bairro),0,0,'L');
   $pdf->Cell(88,$l,utf8_decode($cidade),0,0,'L');
   $pdf->Cell(5,$l,utf8_decode($estado),0,0,'L');
   
   $pdf->SetXY($x, 96);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(33,$l,utf8_decode($cep),0,0,'L');
   $pdf->Cell(57,$l,utf8_decode($Telefone01),0,0,'L');
   $pdf->Cell(15,$l,utf8_decode($codbanco),0,0,'L');
   $pdf->Cell(35,$l,utf8_decode($agencia),0,0,'L');
   $pdf->Cell(37,$l,utf8_decode($conta),0,0,'L');
   
   $pdf->SetXY($x, 107);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(87,$l,utf8_decode($INSS),0,0,'L');
   $pdf->Cell(52,$l,utf8_decode($DataNascimento),0,0,'L');
   $pdf->Cell(33,$l,utf8_decode($cbo),0,0,'L');
   
   $pdf->SetXY($x, 122);
   $pdf->SetFont('Arial','', 9);
   $pdf->Cell(87,$l,utf8_decode($Nome),0,0,'L');
   $pdf->Cell(50,$l,utf8_decode($RG),0,0,'L');


$pdf->Output();


?>