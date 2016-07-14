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


}


//CONSULTA 
$id_ped=$_GET['id'];

$linha_tabelas = siscontrat($id_ped);


$pedido = siscontrat($id_ped);
$pj = siscontratDocs($pedido['IdProponente'],2);
$ex = siscontratDocs($pedido['IdExecutante'],1);
$rep01 = siscontratDocs($pj['Representante01'],3);
$rep02 = siscontratDocs($pj['Representante02'],3);

//PessoaJuridica
$pjRazaoSocial = $pj["Nome"];
$pjNomeArtistico = $pj["NomeArtistico"];
$pjEstadoCivil = $pj["EstadoCivil"];
$pjNacionalidade = $pj["Nacionalidade"];
$pjRG = $pj["RG"];
$pjCPF = $pj["CPF"];
$pjCCM = $pj["CCM"];
$pjOMB = $pj["OMB"];
$pjDRT = $pj["DRT"];
$pjFuncao = $pj["Funcao"];
$pjEndereco = $pj["Endereco"];
$pjTelefones = $pj["Telefones"];
$pjEmail = $pj["Email"];
$pjINSS = $pj["INSS"];
$pjCNPJ = $pj['CNPJ'];


// Executante
$exNome = $ex["Nome"];
$exNomeArtistico = $ex["NomeArtistico"];
$exEstadoCivil = $ex["EstadoCivil"];
$exNacionalidade = $ex["Nacionalidade"];
$exRG = $ex["RG"];
$exCPF = $ex["CPF"];
$exCCM = $ex["CCM"];
$exOMB = $ex["OMB"];
$exDRT = $ex["DRT"];
$exFuncao = $ex["Funcao"];
$exEndereco = $ex["Endereco"];
$exTelefones = $ex["Telefones"];
$exEmail = $ex["Email"];
$exINSS = $ex["INSS"];

// Representante01
$rep01Nome = $rep01["Nome"];
$rep01RG = $rep01["RG"];
$rep01CPF = $rep01["CPF"];


// Representante02
$rep02Nome = $rep02["Nome"];
$rep02RG = $rep02["RG"];
$rep02CPF = $rep02["CPF"];

$setor = $linha_tabelas["Setor"];

$ano=date('Y');


// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

   
$x=20;
$l=7; //DEFINE A ALTURA DA LINHA   
   
   $pdf->SetXY( $x , 30 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 14);
   $pdf->Cell(180,5,utf8_decode("DECLARAÇÃO DE ISS"),0,1,'C');
   
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("Declaro sob as penas da lei que a Empresa: "."$pjRazaoSocial".", com sede em "."$pjEndereco".", CNPJ nº "."$pjCNPJ".", representada por "."$rep01Nome". ", RG nº "."$rep01RG"." e representada por "."$rep02Nome". ", RG nº "."$rep02RG".", não possui débitos perante as FAZENDAS PÚBLICAS, e em especial à PREFEITURA DO MUNICÍPIO DE SÃO PAULO."));
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("Estou ciente de que o ISS incidente sobre a contratação será retido."));
   
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("São Paulo, _______ / _______ / " .$ano."."),0,1,'L');
      
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 11);
   $pdf->Cell(165,$l,utf8_decode($rep01Nome),'T',1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 11);
   $pdf->Cell(8,$l,utf8_decode('RG:'),0,0,'L');
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(50,$l,utf8_decode($rep01RG),0,1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 11);
   $pdf->Cell(11,$l,utf8_decode('CPF:'),0,0,'L');
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(50,$l,utf8_decode($rep01CPF),0,1,'L');
   
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 11);
   $pdf->Cell(165,$l,utf8_decode($rep02Nome),'T',1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 11);
   $pdf->Cell(8,$l,utf8_decode('RG:'),0,0,'L');
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(50,$l,utf8_decode($rep02RG),0,1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 11);
   $pdf->Cell(11,$l,utf8_decode('CPF:'),0,0,'L');
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(50,$l,utf8_decode($rep02CPF),0,1,'L');
 
   
   
   
$pdf->Output();


?>