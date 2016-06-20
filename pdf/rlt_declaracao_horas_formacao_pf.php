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
    $this->Image('../visual/img/logo_sme.jpg',170,10);
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
$l=8; //DEFINE A ALTURA DA LINHA
$f=12; //DEFINE O TAMANHO DA FONTE 
   
   $pdf->SetXY( $x , 50 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 16);
   $pdf->Cell(180,5,utf8_decode("DECLARAÇÃO DE HORAS TRABALHADAS"),0,1,'C');
   
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', $f);
   $pdf->Cell(180,$l,utf8_decode("Processo nº: ".$NumeroProcesso),0,1,'R');
   
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', $f);
   $pdf->Cell(15,$l,'Nome:',0,0,'L');
   $pdf->SetFont('Arial','', $f);
   $pdf->MultiCell(166,$l,utf8_decode($Nome));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', $f);
   $pdf->Cell(16,$l,utf8_decode("Objeto: "),0,0,'L');
   $pdf->SetFont('Arial','', $f);
   $pdf->MultiCell(164,$l,utf8_decode($Objeto));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', $f);
   $pdf->Cell(14,$l,utf8_decode("Local: "),0,0,'L');
   $pdf->SetFont('Arial','', $f);
   $pdf->Cell(150,$l,utf8_decode($Local),0,1,'L');
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', $f);
   $pdf->Cell(25,$l,utf8_decode("Período de: "),0,0,'L');
   $pdf->SetFont('Arial','', $f);
   $pdf->Cell(110,$l,utf8_decode($periodoParcela),0,1,'L');
         
   $pdf->Ln();
   $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', $f);
   $pdf->MultiCell(180,$l,utf8_decode("Eu, _______________________________________________________________________, responsável pelo(a)    (     ) Núcleo de Ação Cultural 	(     ) Gestão      do equipamento acima  citado declaro para os devidos fins que o artista acima descrito cumpriu _______ horas, no período informado  realizando atividades internas e externas  relacionadas às demandas deste equipamento."));   
      
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', $f);
   $pdf->Cell(180,$l,utf8_decode("São Paulo, ".$dataPagamento."."),0,1,'C');
   
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', $f);
   $pdf->Cell(180,$l,utf8_decode("Assinatura e carimbo do responsável"),'T',1,'C');
   
   
ob_start (); 
  
$pdf->Output();


?>