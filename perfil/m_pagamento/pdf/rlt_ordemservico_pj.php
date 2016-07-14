<?php 
	session_start();
	   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 	
   
   // INSTALAÇÃO DA CLASSE NA PASTA FPDF.
	require_once("../include/lib/fpdf/fpdf.php");
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
	$inst = recuperaDados("ig_instituicao",$_SESSION['idInstituicao'],"idInstituicao");	$logo = "img/".$inst['logo']; // Logo
    $this->Image($logo,20,20,50);
    // Move to the right
    $this->Cell(80);
    $this->Image('../visual/img/logo_smc.jpg',170,10);
    // Line break
    $this->Ln(20);
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


// Page footer
/*
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
*/

//INSERIR ARQUIVOS

function ChapterBody($file)
{
    // Read text file
    $txt = file_get_contents($file);
    // Arial 10
    $this->SetFont('Arial','',10);
    // Output justified text
    $this->MultiCell(0,5,$txt);
    // Line break
    $this->Ln();
}

function PrintChapter($file)
{
    $this->ChapterBody($file);
}

}


//CONSULTA  (copia inteira em todos os docs)
$id_ped=$_GET['id'];

$ano=date('Y');

$dataAtual = date("d/m/Y");

$pedido = siscontrat($id_ped);

$pj = siscontratDocs($pedido['IdProponente'],2);
$ex = siscontratDocs($pedido['IdExecutante'],1);
$rep01 = siscontratDocs($pj['Representante01'],3);
$rep02 = siscontratDocs($pj['Representante02'],3);

$id = $pedido['idEvento'];
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
$rfFiscal = $pedido["RfFiscal"];
$Suplente = $pedido["Suplente"];
$rfSuplente = $pedido["RfSuplente"];
$NumeroProcesso = $pedido["NumeroProcesso"];
$notaempenho = $pedido["NotaEmpenho"];
$data_entrega_empenho = exibirDataBr($pedido['EntregaNE']);
$data_emissao_empenho = exibirDataBr($pedido['EmissaoNE']);

$grupo = grupos($id_ped);
$integrantes = $grupo["texto"];

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

$codPed = "";

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
$rep01NomeArtistico = $rep01["NomeArtistico"];
$rep01EstadoCivil = $rep01["EstadoCivil"];
$rep01Nacionalidade = $rep01["Nacionalidade"];
$rep01RG = $rep01["RG"];
$rep01CPF = $rep01["CPF"];
$rep01CCM = $rep01["CCM"];
$rep01OMB = $rep01["OMB"];
$rep01DRT = $rep01["DRT"];
$rep01Funcao = $rep01["Funcao"];
$rep01Endereco = $rep01["Endereco"];
$rep01Telefones = $rep01["Telefones"];
$rep01Email = $rep01["Email"];
$rep01INSS = $rep01["INSS"];


// Representante02

$rep02Nome = $rep02["Nome"];
$rep02NomeArtistico = $rep02["NomeArtistico"];
$rep02EstadoCivil = $rep02["EstadoCivil"];
$rep02Nacionalidade = $rep02["Nacionalidade"];
$rep02RG = $rep02["RG"];
$rep02CPF = $rep02["CPF"];
$rep02CCM = $rep02["CCM"];
$rep02OMB = $rep02["OMB"];
$rep02DRT = $rep02["DRT"];
$rep02Funcao = $rep02["Funcao"];
$rep02Endereco = $rep02["Endereco"];
$rep02Telefones = $rep02["Telefones"];
$rep02Email = $rep02["Email"];
$rep02INSS = $rep02["INSS"];

// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

   
$x=20;
$l=6; //DEFINE A ALTURA DA LINHA   

	//Executante
   
   $pdf->SetXY( $x , 40 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 12);
   $pdf->Cell(180,$l,utf8_decode('ORDEM DE EXECUÇÃO DE SERVIÇO'),0,1,'C');
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 12);
   $pdf->Cell(23,$l,utf8_decode('Ordem n°:'),0,0,'L');
   $pdf->SetFont('Arial','', 12);
   $pdf->Cell(170,$l,utf8_decode('__________ / '.$ano),0,1,'L');
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(180,$l,utf8_decode('AUTORIZAÇÃO'),0,1,'C');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(23,$l,utf8_decode('Emanada de:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(170,$l,utf8_decode('DIVISÃO ADMINISTRATIVA'),0,1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(27,$l,utf8_decode('Suporte Legal:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(153,$l,utf8_decode('Artigo 25, inciso III, da Lei Federal nº. 8.666/93 e alterações posteriores e artigo 1° da Lei Municipal n° 13.278/02, nos termos dos artigos 16 e 17 do Decreto n°. 44.279/03.'));
      
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(23,$l,utf8_decode('Processo nº:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(90,$l,utf8_decode($NumeroProcesso),0,0,'L');
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(10,$l,utf8_decode('Data:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(50,$l,utf8_decode($dataAtual),0,1,'L');
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(180,$l,utf8_decode('PRESTADOR E/OU EXECURTOR DO SERVIÇO'),0,1,'C');
      
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(33,$l,'Nome da empresa:',0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(155,$l,utf8_decode($pjRazaoSocial));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(10,$l,utf8_decode('CCM:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(65,$l,utf8_decode($pjCCM),0,0,'L');
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(12,$l,utf8_decode('CNPJ:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(65,$l,utf8_decode($pjCNPJ),0,1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(20,$l,utf8_decode('Endereço:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(160,$l,utf8_decode($pjEndereco));

	//Representante01
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(28,$l,'Representante:',0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(155,$l,utf8_decode($rep01Nome));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(23,$l,utf8_decode('Estado Civil:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(67,$l,utf8_decode($rep01EstadoCivil),0,0,'L');
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(27,$l,utf8_decode('Nacionalidade:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(16,$l,utf8_decode($rep01Nacionalidade),0,1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(8,$l,utf8_decode('RG:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(82,$l,utf8_decode($rep01RG),0,0,'L');
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(10,$l,utf8_decode('CPF:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(48,$l,utf8_decode($rep01CPF),0,1,'L');

	// Representante02
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(28,7,'Representante:',0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(155,7,utf8_decode($rep02Nome));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(23,$l,utf8_decode('Estado Civil:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(67,$l,utf8_decode($rep02EstadoCivil),0,0,'L');
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(27,$l,utf8_decode('Nacionalidade:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(16,$l,utf8_decode($rep02Nacionalidade),0,1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(8,$l,utf8_decode('RG:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(82,$l,utf8_decode($rep02RG),0,0,'L');
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(10,$l,utf8_decode('CPF:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(48,$l,utf8_decode($rep02CPF),0,1,'L');
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(180,$l,utf8_decode('SERVIÇO'),0,1,'C');
     
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(180,$l,utf8_decode("Especificações: Contratação dos serviços profissionais de natureza artística de: ".$integrantes." através da empresa "."$pjRazaoSocial".", CNPJ nº "."$pjCNPJ". ", representada por "."$rep01Nome". ", RG nº "."$rep01RG".", para apresentação de "."$Objeto".", no(s) local(is)"."$Local"." no perído de "."$Periodo"." conforme cronograma."));		
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(180,$l,utf8_decode("Fica prevista a possibilidade de sessões extras do espetáculo, nas mesmas condições aqui propostas, a critério da Curadoria e desde que haja compatibilidade com a programação, relativamente à datas e horários."));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(180,$l,utf8_decode("Fica designado como fiscal do contrato o(a) Sr(a) ".$Fiscal.", RF nº ".$rfFiscal." e como suplente, Sr(a) ".$Suplente.", RF nº ".$rfSuplente.", da Secretaria Municipal de Cultura."));
   
   $pdf->Ln();
    
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(180,$l,utf8_decode('RECURSOS FINANCEIROS'),0,1,'C');
   
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(18,$l,utf8_decode('Dotação:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(75,$l,utf8_decode(""),0,0,'L');
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(41,$l,utf8_decode('Unidade Orçamentária:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(17,$l,utf8_decode(""),0,1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 11);
   $pdf->Cell(41,$l,utf8_decode('Nota de Empenho nº:'),0,0,'L');
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(52,$l,utf8_decode($notaempenho),0,0,'L');
   $pdf->SetFont('Arial','B', 11);
   $pdf->Cell(24,$l,utf8_decode('Emitida em:'),0,0,'L');
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(60,$l,utf8_decode($data_emissao_empenho),0,1,'L');
   
//	QUEBRA DE PÁGINA
$pdf->AddPage('','');
$pdf->SetXY( $x , 40 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(180,$l,utf8_decode('PAGAMENTO'),0,1,'C');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(180,$l,utf8_decode("O pagamento do cachê corresponderá a reversão integral da renda obtida na bilheteria à contratada, deduzidos os impostos e taxas pertinentes."));
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(180,$l,utf8_decode('PENALIDADES'),0,1,'C');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(180,$l,utf8_decode("- Declaro estar ciente da penalidade de multa de 10% (dez por cento) para casos de infração de cláusula contratual e/ou inexecução parcial do ajuste, e de 30% (trinta por cento)  para casos de inexecução total do ajuste. O valor da multa será calculado sobre o valor do contrato ou sobre o valor integral da venda de todos os ingressos disponíveis.
 - Declaro estar ciente que no caso de haver atraso de até 30 minutos será aplicada multa de 5% sobre o valor do contrato ou sobre o valor integral da venda de todos os ingressos disponíveis, por dia de apresentação. Ultrapassado esse tempo, e independentemente da aplicação da penalidade, fica a critério da Diretoria autorizar a realização do evento, visando evitar prejuízos à grade de programação. Não sendo autorizada a realização do evento, será considerada inexecução parcial do ajuste, limitado a dois dias de ocorrência.  Havendo o terceiro atraso na temporada, será considerada inexecução total do contrato e deverá ser rescindido o ajuste, com aplicação da multa por inexecução total de 30% sobre o valor do contrato ou sobre o valor integral da venda de todos os ingressos disponíveis, acumulada com a multa de 20% do valor do contrato por rescisão contratual por culpa do contratado.
- Multa de 10% sobre o valor do contrato ou sobre o valor integral da venda de todos os ingressos disponíveis, em função da falta de regularidade fiscal da contratada, bem como, pela verificação de que possui pendências junto ao Cadastro Informativo Municipal – CADIN Municipal.
- As penalidades previstas serão aplicadas sem prejuízo das demais sanções previstas na legislação que rege a matéria."));

   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(180,$l,utf8_decode('CANCELAMENTO'),0,1,'C');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(180,$l,utf8_decode("ESTA O.E.S. PODERÁ SER CANCELADA NO INTERESSE DA ADMINISTRAÇÃO, DEVIDAMENTE JUSTIFICADA OU EM VIRTUDE DA INEXECUÇÃO TOTAL OU PARCIAL DO SERVIÇO SEM PREJUÍZO DE MULTA."));
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(180,$l,utf8_decode('FORO'),0,1,'C');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(180,$l,utf8_decode("FICA ELEITO O FORO DESTA COMARCA PARA TODO E QUALQUER PROCEDIMENTO JUDICIAL ORIUNDO DESTA ORDEM DE EXECUÇÃO DE SERVIÇOS."));
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(180,$l,utf8_decode('OBSERVAÇÕES'),0,1,'C');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(180,$l,utf8_decode("-	Compete à contratada a realização do espetáculo, e a fazer constar o crédito - PMSP/SECRETARIA MUNICIPAL DE CULTURA - CENTRO CULTURAL SÃO PAULO, em toda divulgação escrita ou falada, realizada sobre o espetáculo programado.
-	A  empresa contratada fica sujeita ao atendimento do disposto nas Leis Municipais nºs 10.973/91, regulamentada pelo DM 30.730/91; 11.113/91; 11.357/93; 12.975/2000 e Portaria 66/SMC/2007: Leis Estaduais nº 7.844/92 regulamentada pelo Decreto Estadual nº 35.606/92; 10.858/2001, alterada pela Lei Estadual 14.729/2012; Medida Provisória Federal 12.933/2013 e Lei Federal 10.741/2003 (estatuto do idoso).
-	A contratada é responsável por qualquer prejuízo ou dano causado ao patrimônio municipal ou a bens de terceiros que estejam sob a guarda do Centro Cultural São Paulo.
-	Quaisquer outras despesas não ressalvadas aqui serão de responsabilidade da contratada, que se compromete a adotar as providências necessárias junto à SBAT.
-	As providências administrativas para liberação da autorização do ECAD serão de responsabilidade da contratada, sendo que eventuais pagamentos serão efetuados pela SMC.
-	A Municipalidade não é responsável por qualquer material ou equipamento que não lhe pertença utilizado no espetáculo, devendo esse material ser retirado no seu término.
-	A renda integral apurada na bilheteria, com ingressos vendidos ao preço único de R$ 20,00 (vinte reais), será revertida à contratada, por intermédio da Empresa Brasileira de Comercialização de Ingressos Ltda, que também confeccionará os ingressos, já deduzidos os impostos e taxas pertinentes, podendo ter preços reduzidos em face de promoções realizadas pela produção do evento.
-	Compete, ainda, à Municipalidade, o fornecimento da sonorização necessária à realização dos espetáculos e os equipamentos de iluminação disponíveis na Sala Jardel Filho, assim como providências quanto à divulgação de praxe (confecção de cartaz a ser afixado na Rua Interna do Centro Cultural São Paulo e encaminhamento de release à mídia impressa e televisiva).
-	Serão reservados ingressos aos funcionários da PMSP até 10% (dez por cento) da lotação da sala.
-	A contratada se compromete a realizar o espetáculo para um número mínimo de 10 (dez) pagantes."));
   
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(180,$l,utf8_decode("ACEITO  AS  CONDIÇÕES  DESTA O.E.S. PARA  TODOS  OS EFEITOS DE  DIREITO"));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(25,$l,utf8_decode('Local e data:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(160,$l,utf8_decode('São Paulo, '.$dataAtual),0,1,'L');
   
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(120,$l,utf8_decode($pjRazaoSocial),'T',1,'L');
   $pdf->SetX($x);
   $pdf->Cell(120,$l,utf8_decode('CNPJ '.$pjCNPJ),0,0,'L');
   
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(180,$l,utf8_decode("Com competência delegada pela Portaria nº. 19/2006- SMC/G, determino a execução do serviço na forma desta O.E.S."));
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(25,$l,utf8_decode('Local e data:'),0,0,'L');
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(160,$l,utf8_decode('São Paulo, '.$dataAtual),0,1,'L');
   
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 10);
   $pdf->Cell(120,$l,utf8_decode('DIRETOR'),'T',0,'L');
    
   
   $pdf->Ln();
    

  


   

//for($i=1;$i<=20;$i++)
   // $pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();


?>