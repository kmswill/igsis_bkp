<?php 
   
   // INSTALAÇÃO DA CLASSE NA PASTA FPDF.
	require_once("../include/lib/fpdf/fpdf.php");
	
   //require '../include/';
   require_once("../funcoes/funcoesConecta.php");
   require_once("../funcoes/funcoesGerais.php");
   require_once("../funcoes/funcoesSiscontrat.php");
   
   //CONEXÃO COM BANCO DE DADOS 
   $conexao = bancoMysqli(); 
   

session_start();

class PDF extends FPDF
{
// Page header
function Header()
{

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



//CONSULTA 
$id_ped=$_GET['id'];

$ano=date('Y');

$pedido = siscontrat($id_ped);
$pj = siscontratDocs($pedido['IdProponente'],2);

$Objeto = $pedido["Objeto"];
$Periodo = $pedido["Periodo"];
$Duracao = $pedido["Duracao"];
$CargaHoraria = $pedido["CargaHoraria"];
$Local = $pedido["Local"];
$ValorGlobal = dinheiroParaBr($pedido["ValorGlobal"]);
$ValorPorExtenso = valorPorExtenso($pedido["ValorGlobal"]);
$FormaPagamento = $pedido["FormaPagamento"];
$Justificativa = $pedido["Justificativa"];
$Fiscal = $pedido["Fiscal"];
$Suplente = $pedido["Suplente"];
$dataAtual = exibirDataBr($pedido["DataCadastro"]);
$setor = $pedido["Setor"];

//PessoaJuridica
$pjRazaoSocial = $pj["Nome"];
$pjCNPJ = $pj['CNPJ'];
$pjTelefones = $pj["Telefones"];
$pjEmail = $pj["Email"];





// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

   
$x=20;
$l=7; //DEFINE A ALTURA DA LINHA   
   
   
   $pdf->SetXY( $x , 40 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 12);
   $pdf->Cell(180,5,utf8_decode('PEDIDO DE CONTRATAÇÃO DE PESSOA JURÍDICA'),0,1,'C');
   
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(100,$l,"","R",0,'R');
   $pdf->Cell(70,5,utf8_decode("Código do Pedido de Contratação"),"T",0,'C');
   $pdf->Cell(10,$l,"","L",1,'R');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 12);
   $pdf->Cell(100,$l,"","R",0,'R');
   $pdf->Cell(70,7,utf8_decode("$ano-$id_ped"),"B",0,'C');
   $pdf->Cell(10,$l,"","L",0,'R');
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(30,$l,'Setor solicitante:',0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(150,$l,utf8_decode($setor));
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(25,$l,utf8_decode('Razão Social:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(155,$l,utf8_decode($pjRazaoSocial));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(13,$l,utf8_decode('CNPJ:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(50,$l,utf8_decode($pjCNPJ),0,0,'L');
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(17,$l,utf8_decode('Telefone:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(65,$l,utf8_decode($pjTelefones),0,1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(13,$l,utf8_decode('E-mail:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(60,$l,utf8_decode($pjEmail),0,1,'L');
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(15,$l,'Objeto:',0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(165,$l,utf8_decode($Objeto));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(27,$l,utf8_decode('Data / Período:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(153,$l,utf8_decode($Periodo));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(82,$l,utf8_decode('Tempo Aproximado de Duração do Espetáculo:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(98,$l,utf8_decode("$Duracao"." minutos"));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(27,$l,utf8_decode('Carga Horária:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(180,$l,$CargaHoraria);
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(13,$l,'Local:',0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(167,$l,utf8_decode($Local));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(13,$l,'Valor:',0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(167,$l,utf8_decode("R$ "."$ValorGlobal"."  ("."$ValorPorExtenso". " )"));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(40,$l,'Forma de Pagamento:',0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(140,$l,utf8_decode($FormaPagamento));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(25,$l,'Justificativa:',0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(145,$l,utf8_decode($Justificativa));
   
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
    
//RODAPÉ PERSONALIZADO
   
   $pdf->SetXY($x,265);
   $pdf->SetFont('Arial','', 12);
   $pdf->Cell(80,$l,"Data: "."$dataAtual",0,0,'C');
   $pdf->Cell(10,$l,'',0,0,'C');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(80,$l,'ASSINATURA','T',0,'C');
     
   
   
$pdf->Output();


?>