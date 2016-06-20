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
    $this->Image('../pdf/img/fac_pj.jpg',15,10,180);
    
    // Line break
    $this->Ln(20);
}

}



//CONSULTA 
$id_ped=$_GET['id'];

$ano=date('Y');

$pedido = siscontrat($id_ped);
$pj = siscontratDocs($pedido['IdProponente'],2);
$ex = siscontratDocs($pedido['IdExecutante'],1);
$rep01 = siscontratDocs($pj['Representante01'],3);
$rep02 = siscontratDocs($pj['Representante02'],3);
$enderecoCEP = enderecoCEP($pj['CEP']);


//endereço
$rua = $enderecoCEP["rua"]; 
$bairro = $enderecoCEP["bairro"];
$cidade = $enderecoCEP["cidade"];
$estado = $enderecoCEP["estado"];


//PessoaJuridica
$pjRazaoSocial = $pj["Nome"];
$pjCNPJ = $pj['CNPJ'];
$pjCCM = $pj["CCM"];
$pjEndereco = $pj["Endereco"];
$pjNumEndereco = $pj["NumEndereco"];
$pjComplemento = $pj["Complemento"];
$pjcep = $pj["CEP"];
$pjTelefone01 = $pj["Telefone01"];
$banco = $pj["Banco"];
$agencia = $pj["Agencia"];
$conta = $pj["Conta"];
$codbanco = $pj["CodigoBanco"];


// Representante01
$rep01Nome = $rep01["Nome"];
$rep01RG = $rep01["RG"];
$rep01CPF = $rep01["CPF"];



// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

   
$x=20;
$l=7; //DEFINE A ALTURA DA LINHA   
   
   $pdf->SetXY( $x , 40 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

   $pdf->SetXY(112, 44);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(10,$l,utf8_decode('X'),0,0,'L');

   $pdf->SetXY($x, 45);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(53,$l,utf8_decode($pjCNPJ),0,0,'L');
   
   $pdf->SetXY(150, 45);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(53,$l,utf8_decode($pjCCM),0,0,'L');
   
   $pdf->SetXY($x, 60);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(160,$l,utf8_decode($pjRazaoSocial),0,0,'L');
   
   $pdf->SetXY($x, 75);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(160,$l,utf8_decode("$rua".", "."$pjNumEndereco".", "."$pjComplemento"),0,0,'L');
   
   $pdf->SetXY($x, 90);
   $pdf->SetFont('Arial','', 9);
   $pdf->Cell(65,$l,utf8_decode($bairro),0,0,'L');
   $pdf->Cell(83,$l,utf8_decode($cidade),0,0,'L');
   $pdf->Cell(5,$l,utf8_decode($estado),0,0,'L');
   
   $pdf->SetXY($x, 105);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(33,$l,utf8_decode($pjcep),0,0,'L');
   $pdf->Cell(45,$l,utf8_decode($pjTelefone01),0,0,'L');
   
   $pdf->SetXY(98, 107);
   $pdf->Cell(15,$l,utf8_decode($codbanco),0,0,'L'); 
   $pdf->Cell(40,$l,utf8_decode($agencia),0,0,'L');
   $pdf->Cell(37,$l,utf8_decode($conta),0,0,'L');
   
   $pdf->SetXY($x, 127);
   $pdf->SetFont('Arial','', 9);
   $pdf->Cell(80,$l,utf8_decode($rep01Nome),0,0,'L');
   $pdf->Cell(50,$l,utf8_decode($rep01RG),0,0,'L');


$pdf->Output();


?>