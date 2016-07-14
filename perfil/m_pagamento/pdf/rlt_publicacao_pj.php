<?php
//require '../include/';
   require_once("../funcoes/funcoesConecta.php");
   require_once("../funcoes/funcoesGerais.php");
   require_once("../funcoes/funcoesSiscontrat.php");
//CONEXÃO COM BANCO DE DADOS 
   $conexao = bancoMysqli();
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
$Suplente = $pedido["Suplente"];
$rfFiscal = $pedido["RfFiscal"];
$Suplente = $pedido["Suplente"];
$rfSuplente = $pedido["RfSuplente"];
$setor = $pedido["Setor"];
$amparo = nl2br($pedido["AmparoLegal"]);
$dotacao = $pedido['ComplementoDotacao'];
$final = nl2br($pedido["Finalizacao"]);
$penalidade = nl2br($pedido["Penalidade"]);
$NumeroProcesso = ($pedido["NumeroProcesso"]);


//PessoaJuridica

$pjRazaoSocial = $pj["Nome"];
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
$rep01EstadoCivil = $rep01["EstadoCivil"];
$rep01Nacionalidade = $rep01["Nacionalidade"];
$rep01RG = $rep01["RG"];
$rep01CPF = $rep01["CPF"];


// Representante02

$rep02Nome = $rep02["Nome"];
$rep02EstadoCivil = $rep02["EstadoCivil"];
$rep02Nacionalidade = $rep02["Nacionalidade"];
$rep02RG = $rep02["RG"];
$rep02CPF = $rep02["CPF"];


header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$dataAtual - Processo SEI $NumeroProcesso.doc");
echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo "<p align='justify'>((TITULO))CONTRATAÇÃO DE SERVIÇOS NATUREZA  ARTÍSTICA</p>";
echo "<p align='justify'>((TEXTO))((NG))Processo SEI ".$NumeroProcesso."((CL))</p>";
echo "<p align='justify'>".$amparo."</p>";
echo "<p align='justify'>((NG))Contratado((CL)): ".$pjRazaoSocial." (CNPJ ".$pjCNPJ.").</p>";
echo "<p align='justify'>((NG))Objeto((CL)): ".$Objeto."</p>";
echo "<p align='justify'>((NG))Data / Período((CL)): ".$Periodo." - conforme proposta/cronograma  .</p>";
echo "<p align='justify'>((NG))Local((CL)): ".$Local.".</p>";
echo "<p align='justify'>((NG))Valor((CL)): ".$ValorGlobal." (".$ValorPorExtenso." ) conforme nota de reserva de recursos .</p>";
echo "<p align='justify'>((NG))Forma de Pagamento((CL)): ".$FormaPagamento."</p>";
echo "<p align='justify'>((NG))Dotação Orçamentária((CL)): ".$dotacao."</p>";
echo "<p align='justify'>".$final."</p>";
echo "</body>";
echo "</html>";
?>