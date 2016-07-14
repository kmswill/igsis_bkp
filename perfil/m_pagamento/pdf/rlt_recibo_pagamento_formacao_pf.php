<?php 
   
      
   // INSTALAÇÃO DA CLASSE NA PASTA FPDF.
	require_once("../include/lib/fpdf/fpdf.php");
	
   //require '../include/';
   require_once("../funcoes/funcoesConecta.php");
   require_once("../funcoes/funcoesGerais.php");
   require_once("../funcoes/funcoesSiscontrat.php");
   require_once("../funcoes/funcoesFormacao.php");

   //CONEXÃO COM BANCO DE DADOS 
   $conexao = bancoMysqli();

   
class PDF extends FPDF
{
// Page header
function Header()
{
	session_start();
	$inst = recuperaDados("ig_instituicao",$_SESSION['idInstituicao'],"idInstituicao");
	//$logo = "../visual/img/".$inst['logo']; 
    // Logo
   	//$this->Image($logo,20,20,50);
    // Move to the right
    $this->Cell(80);
    $this->Image('../visual/img/logo_smc.jpg',170,10);
    // Line break
    $this->Ln(20);
}

}


//CONSULTA 
$id_ped=$_GET['id'];
$id_parcela = $_GET['parcela'];

$pedido = siscontrat($id_ped);
$pessoa = siscontratDocs($pedido['IdProponente'],1);
$parcelamento = retornaParcelaPagamento($id_ped);
$procpagto = pdfFormacao($id_ped);

$id = $pedido['idEvento'];
$Objeto = $pedido["Objeto"];
$Periodo = $pedido["Periodo"];
$CargaHoraria = $pedido["CargaHoraria"];
$Local = $pedido["Local"];
$NumeroProcesso = $pedido["NumeroProcesso"];

$Nome = $pessoa["Nome"];
$NomeArtistico = $pessoa["NomeArtistico"];
$EstadoCivil = $pessoa["EstadoCivil"];
$Nacionalidade = $pessoa["Nacionalidade"];
$DataNascimento = exibirDataBr($pessoa["DataNascimento"]);
$RG = $pessoa["RG"];
$CPF = $pessoa["CPF"];
$CCM = $pessoa["CCM"];
$OMB = $pessoa["OMB"];
$DRT = $pessoa["DRT"];
$cbo = $pessoa["cbo"];
$Funcao = $pessoa["Funcao"];
$Endereco = $pessoa["Endereco"];
$Telefones = $pessoa["Telefones"];
$Email = $pessoa["Email"];
$INSS = $pessoa["INSS"];

$numeroProcessoPagamento = $procpagto["processoPagamento"];

$valorParcela = $parcelamento[$id_parcela]['valor'];
$ValorPorExtenso = valorPorExtenso(dinheiroDeBr($parcelamento[$id_parcela]['valor']));
$periodoParcela = $parcelamento[$id_parcela]['periodo']; 
$dataPagamento = $parcelamento[$id_parcela]['pagamento'];

$ano=date('Y');


// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

   
$x=20;
$l=7; //DEFINE A ALTURA DA LINHA  
$f=12; //DEFINE O TAMANHO DA FONTE 
   
   $pdf->SetXY( $x , 35 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 18);
   $pdf->Cell(180,5,utf8_decode("RECIBO"),0,1,'C');
   
   $pdf->Ln();
      
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', $f);
   $pdf->Cell(15,$l,'Nome:',0,0,'L');
   $pdf->SetFont('Arial','', $f);
   $pdf->MultiCell(166,$l,utf8_decode($Nome));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', $f);
   $pdf->Cell(16,$l,'Objeto:',0,0,'L');
   $pdf->SetFont('Arial','', $f);
   $pdf->MultiCell(164,$l,utf8_decode($Objeto));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', $f);
   $pdf->Cell(16,$l,'C.C.M.:',0,0,'L');
   $pdf->SetFont('Arial','', $f);
   $pdf->MultiCell(164,$l,utf8_decode($CCM));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', $f);
   $pdf->Cell(9,$l,utf8_decode('RG:'),0,0,'L');
   $pdf->SetFont('Arial','', $f);
   $pdf->Cell(60,$l,utf8_decode($RG),0,0,'L');
   $pdf->SetFont('Arial','B', $f);
   $pdf->Cell(12,$l,utf8_decode('CPF:'),0,0,'L');
   $pdf->SetFont('Arial','', $f);
   $pdf->Cell(33,$l,utf8_decode($CPF),0,1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', $f);
   $pdf->Cell(22,$l,utf8_decode('Endereço:'),0,0,'L');
   $pdf->SetFont('Arial','', $f);
   $pdf->MultiCell(160,$l,utf8_decode($Endereco));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', $f);
   $pdf->Cell(20,$l,utf8_decode('Telefone:'),0,0,'L');
   $pdf->SetFont('Arial','', $f);
   $pdf->Cell(142,$l,utf8_decode($Telefones),0,1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', $f);
   $pdf->Cell(16,$l,utf8_decode('E-mail:'),0,0,'L');
   $pdf->SetFont('Arial','', $f);
   $pdf->Cell(152,$l,utf8_decode($Email),0,1,'L');
         
   $pdf->Ln();
   $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', $f);
   $pdf->MultiCell(180,$l,utf8_decode("Atesto que recebi da Prefeitura do Múnicípio de São Paulo - Secretaria Municipal de Cultura a importância de R$ ".$valorParcela." (".$ValorPorExtenso." ) referente ao período de ".$periodoParcela." da ".$Objeto.""));   
      
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', $f);
   $pdf->MultiCell(180,$l,utf8_decode("São Paulo, _______ de ________________________ de ".$ano."."));
   
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', $f);
   $pdf->MultiCell(180,$l,utf8_decode("OBSERVAÇÃO: A validade deste recibo está condicionada ao respectivo depósito do pagamento na conta corrente indicada pelo Artista."));
   
   
//RODAPÉ PERSONALIZADO
   $pdf->SetXY($x,255);
   $pdf->SetFont('Arial','', 12);
   $pdf->Cell(100,$l,utf8_decode($Nome),'T',1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 12);
   $pdf->Cell(100,$l,"RG: ".$RG,0,0,'L');
   
ob_start (); 
  
$pdf->Output();


?>