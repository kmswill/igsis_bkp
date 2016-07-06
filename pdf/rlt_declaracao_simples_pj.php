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

// Simple table
function BasicTable($header, $data)
{
    // Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

// Simple table
function Cabecalho($header, $data)
{
    // Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Data

}

// Simple table
function Tabela($header, $data)
{
    //Data
    foreach($data as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Data

}



}


//CONSULTA 
$id_ped=$_GET['id'];

$pedido = siscontrat($id_ped);
$Objeto = $pedido["Objeto"];
$ValorGlobal = dinheiroParaBr($pedido["ValorGlobal"]);
$ValorPorExtenso = valorPorExtenso($pedido["ValorGlobal"]);
$Local = $pedido["Local"];

$grupo = grupos($id_ped);
/*
echo "<pre>";
var_dump($grupo);
echo "</pre>";
*/


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

$setor = $pedido["Setor"];

$ano=date('Y');


// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

   
$x=20;
$l=6; //DEFINE A ALTURA DA LINHA   
   
   $pdf->SetXY( $x , 15 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 14);
   $pdf->Cell(180,5,utf8_decode("DECLARAÇÃO SIMPLES"),0,1,'C');
   
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("Ilmo. Senhor (a)"));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("Secretario (a) Municipal de Cultura"));
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode(""."$pjRazaoSocial".", com sede à "."$pjEndereco".", inscrita no CNPJ sob o nº "."$pjCNPJ"." DECLARA à Prefeitura de São Paulo, para fins de não incidência na fonte do Imposto sobre a Renda da Pessoa Jurídica (IRPJ), da Contribuição Social sobre o Lucro Líquido (CSLL), da Contribuição para o Financiamento da Seguridade Social (Cofins), e da Contribuição para o PIS/Pasep, a que se refere o art. 64 da Lei nº 9.430, de 27 de dezembro de 1996, que é regularmente inscrita no Regime Especial Unificado de Arrecadação de Tributos e Contribuições devidos pelas Microempresas e Empresas de Pequeno Porte - Simples Nacional, de que trata o art. 12 da Lei Complementar nº 123, de 14 de dezembro de 2006."));
      
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("Para esse efeito, a declarante informa que:"));
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("I - preenche os seguintes requisitos:"));
   
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("(a) conserva em boa ordem, pelo prazo de cinco anos, contado da data da emissão, os documentos que comprovam a origem de suas receitas e a efetivação de suas despesas, bem assim a realização de quaisquer outros atos ou operações que venham a modificar sua situação patrimonial;"));
   
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("(b) cumpre as obrigações acessórias a que está sujeita, em conformidade com a legislação pertinente;"));
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("II - o signatário é representante legal desta empresa, assumindo o compromisso de informar à Secretaria da Receita Federal do Brasil e à entidade pagadora, imediatamente, eventual desenquadramento da presente situação e está ciente de que a falsidade na prestação destas informações, sem prejuízo do disposto no art. 32 da Lei nº 9.430, de 1996, o sujeitará, juntamente com as demais pessoas que para ela concorrem, às penalidades previstas na legislação criminal e tributária, relativas à falsidade ideológica (art. 299 do Código Penal) e ao crime contra a ordem tributária (art. 1º da Lei nº 8.137, de 27 de dezembro de 1990)."));
   
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
	 

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("São Paulo, _______ / _______ / " .$ano."."),0,1,'L');
   
   //RODAPÉ PERSONALIZADO
   $pdf->SetXY($x,262);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(85,$l,utf8_decode($rep01Nome),'T',0,'L');
   $pdf->Cell(85,$l,utf8_decode($rep02Nome),'T',1,'L');
   
      
  
   
   
$pdf->Output();


?>