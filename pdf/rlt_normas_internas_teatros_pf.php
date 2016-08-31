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


//var_dump($_SESSION);
  
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



//CONSULTA 
$id_ped=$_GET['id'];
$ano=date('Y');

$pedido = siscontrat($id_ped);
$pessoa = siscontratDocs($pedido['IdProponente'],1);

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
$Suplente = $pedido["Suplente"];

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


// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

   
$x=20;
$l=4.3; //DEFINE A ALTURA DA LINHA   
   
   $pdf->SetXY( $x , 35 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 12);
   $pdf->Cell(180,$l,utf8_decode('NORMAS INTERNAS PARA DISPONIBILIZAÇÃO DO USO DO TEATRO DISTRITAL'),0,1,'C');
  
   $pdf->Ln();
  
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(180,$l,utf8_decode("
1.	Cumprir rigorosamente as datas e horários estabelecidos em conjunto com a Coordenação de Produção da Coordenadoria dos Centros Culturais.

2.	Dar início às apresentações no horário estabelecido com tolerância máxima de 15 minutos, salvo motivo de força maior.

3.	ECAD - A produção do show deve encaminhar o repertório junto com as demais documentações necessárias para que a Coordenação de Produção da Coordenadoria dos Centros Culturais providencie o pagamento. Em caso de autoria própria e / ou domínio público as produções dos shows devem dirigir-se ao ECAD e apresentar repertório (nome da música, autor e se é domínio público) que será executado, para posteriormente, entregar a liberação ao DEC (junto com toda a documentação necessária para contratação).

4.	SBAT - A produção do espetáculo deve encaminhar a liberação do autor ou do seu representante junto com as demais documentações necessárias à Coordenadoria de Produção para inserção do percentual no borderô.

5.	O Usuário deverá trazer uma lista de material que será conferida por um funcionário do Teatro, quando da entrada para a montagem e na saída (após a desmontagem).

6.	A montagem, operação e desmontagem de equipamentos de sonorização e iluminação deverão ser realizadas sempre com o acompanhamento dos técnicos autorizados pela coordenação do Teatro. Não será permitida a presença de convidados na cabine de luz e bilheteria.

7.	Utilizar o palco e áreas de guarda de objetos, quando houver, em comum acordo com os demais grupos em cartaz no teatro. Assim, os cenários e objetos de cena de cada espetáculo deverão ser removidos do palco pelo grupo ou seus assistentes para isso designados logo após o término do mesmo, permitindo a montagem e realização dos outros espetáculos. Equipamentos não disponíveis no Teatro e necessários à realização do evento são de responsabilidade do contratado.

8.	Do mesmo modo, a montagem da luz deverá ser planejada de modo a atender todos os espetáculos em cartaz no mesmo período, minimizando a montagem e desmontagem diária desses equipamentos. Para isso, deverá ser agendada pelo coordenador do teatro uma reunião técnica antes do início de cada temporada com os grupos e seus técnicos para o acerto do uso dos equipamentos.

9.	O palco e os camarins deverão estar liberados até 30 minutos após o término do espetáculo. O elenco deverá deixar os camarins limpos e organizados. É proibido fumar nos camarins e no palco (exceto nos casos em que as cenas do espetáculo exigirem).

10.	Retirar os materiais de cena e figurinos até 24 horas, após o último espetáculo apresentado, sob pena de estes serem removidos sem prévio aviso para o local de conveniência da coordenação do Teatro, sem a responsabilidade da mesma por eventuais danos ou perdas. 

11.	É expressamente proibidos o uso de confetes, serpentinas (inclusive em spray), bolinhas de isopor e bebidas alcoólicas no saguão, platéia, palco e camarins (exceto nos casos em que o espetáculo exigir e com autorização prévia da coordenação dos teatros distritais).  Caso contrário o espetáculo será interrompido imediatamente, sem direito a qualquer indenização.

12.	O usuário deverá reparar, de imediato, qualquer dano causado ao Teatro, inclusive no que diz respeito à substituição de lâmpadas queimadas, manutenção de mesa de iluminação e refletores, e substituição de gelatinas, deixando o mesmo nas mesmas condições que o encontrou quando do início do termo do contrato. No caso em que diversos grupos estiverem em cartaz no mesmo período, os custos dos reparos deverão ser rateados entre eles.
"));
 

//	QUEBRA DE PÁGINA
$pdf->AddPage('','');

$pdf->SetXY( $x , 35 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->MultiCell(180,$l,utf8_decode("13.	A Cia. deverá designar uma pessoa para atuar na Bilheteria durante toda a temporada, cabendo a esta a responsabilidade exclusiva pela venda dos ingressos.

13.1 A Bilheteria deverá abrir 1 (uma) hora antes do início de cada espetáculo.

13.2 Após o término de cada espetáculo um servidor designado pela Coordenação do Teatro efetuará o fechamento do borderô com o bilheteiro responsável.

13.3 Caberá a Cia. efetuar o repasse do percentual do FEPAC e a Coordenação do Teatro caberá o recolhimento do valor.

14.	Evitar a venda ou distribuição de ingressos que excedam a lotação, conforme previsto no item b artigo 7º do Decreto nº 23.470, de 19 de fevereiro de 1987.

14.1. Em havendo contratação pela Secretaria de Cultura de empresa prestadora de serviços de gerenciamento da bilheteria, caberá a esta efetuar a venda dos ingressos. 

14.2. A Coordenadoria dos Centros Culturais reserva-se o direito de disponibilizar 6 (seis) ingressos por apresentação, que não poderão ser comercializados pela Cia. Sendo que haverá comunicado com antecedência quando da utilização desses ingressos. Caso não haja manifestação por parte da SMC a comercialização desses ingressos será livre.

15.	Os preços máximos dos ingressos, conforme Portaria 88/2009/SMC de 20/06/2009, serão de:
- Espetáculos Adultos, Dança e Show Musical: R$ 20,00 (vinte reais)
- Espetáculos Infantis: R$ 15,00 (quinze reais)
- Temporada com preços populares, conforme Comunicado nº nº 001/2015-SMC/SP: R$ 10,00 (dez reais).
 
16.	O telefone do Teatro é para uso da Administração, poderá ser usado pelo elenco para telefonemas úteis e rápidos com prévia autorização do Coordenador.

17.	A colocação de faixas, placas ou cartazes, além dos demais materiais de divulgação da peça, deverão estar de acordo com a legislação específica vigente, sob orientações dos coordenadores do teatro e da subprefeitura da região.

18.	Deverá ser fixado, em lugar visível e de fácil acesso, à entrada do Teatro, informação destacada quanto à natureza do espetáculo e a respectiva abrangência de faixa etária do mesmo.

19.	A realização de qualquer tipo de degustação ou coquetel nas dependências do Teatro deverá ser autorizada pela Coordenação de Produção da Coordenadoria dos Centros Culturais da Secretaria Municipal de Cultura com antecedência de, no mínimo, uma semana da data do mesmo.

20.	Não será permitida a entrada de qualquer elemento da Companhia em cartaz, fora do seu horário de apresentação ou ensaio, sem o conhecimento e a prévia autorização da Coordenação do Teatro.

21.	O usuário, conjuntamente com a coordenação do Teatro, deverá zelar pela conservação do Teatro e seus bens. 
"));
   
   $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(180,$l,utf8_decode("São Paulo, _________ de _____________________________ de ").$ano.".",0,0,'L');
   
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   
   
//RODAPÉ PERSONALIZADO
   $pdf->SetXY($x,268);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(100,$l,utf8_decode($Nome),'T',1,'L');
   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(100,$l,"RG: ".$RG,0,0,'L');

   

$pdf->Output();


?>