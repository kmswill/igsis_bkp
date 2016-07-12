<?php
//require '../include/';
   require_once("../funcoes/funcoesConecta.php");
   require_once("../funcoes/funcoesGerais.php");
   require_once("../funcoes/funcoesSiscontrat.php");
   require_once("../funcoes/funcoesFormacao.php");
   
//CONEXÃO COM BANCO DE DADOS 
   $conexao = bancoMysqli();
//CONSULTA 
$id_ped=$_GET['id'];
$ano=date('Y');
$pedido = siscontrat($id_ped);
$pessoa = siscontratDocs($pedido['IdProponente'],1);
$setor = $pedido["Setor"];
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
$NumeroProcesso = $pedido["NumeroProcesso"];
$Fiscal = $pedido["Fiscal"];
$rfFiscal = $pedido["RfFiscal"];
$Suplente = $pedido["Suplente"];
$rfSuplente = $pedido["RfSuplente"];
$amparo = nl2br($pedido["AmparoLegal"]);
$dotacao = $pedido['ComplementoDotacao'];
$final = nl2br($pedido["Finalizacao"]);
$penalidade = nl2br($pedido["Penalidade"]);
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
   
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$dataAtual - Processo SEI $NumeroProcesso.doc");
echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo "<p align='justify'>((TITULO))CONTRATAÇÃO DE SERVIÇOS NATUREZA  ARTÍSTICA</p>";
echo "<p align='justify'>((TEXTO))((NG))Processo SEI ".$NumeroProcesso."((CL))</p>";
echo "<p align='justify'>".$amparo."</p>";
echo "<p align='justify'>((NG))Contratado((CL)): ".$Nome.", CPF (".$CPF.").</p>";
echo "<p align='justify'>((NG))Objeto((CL)): ".$Objeto."</p>";
echo "<p align='justify'>((NG))Data / Período((CL)): ".$Periodo." - conforme proposta/cronograma  .</p>";
echo "<p align='justify'>((NG))Local((CL)): ".$Local.".</p>";
echo "<p align='justify'>((NG))Valor((CL)): ".$ValorGlobal." (".$ValorPorExtenso." ) conforme nota de reserva de recursos .</p>";
echo "<p align='justify'>((NG))Forma de Pagamento((CL)): ".$FormaPagamento."</p>";
echo "<p align='justify'>((NG))Dotação Orçamentária((CL)): ".$dotacao."</p>";
echo "<p align='justify'>".$final."</p>";
echo "</body>";
echo "</html>";

$ocor = listaOcorrenciasContrato($id);

	for($i = 0; $i < $ocor['numero']; $i++){
	
	$tipo = $ocor[$i]['tipo'];
	$dia = $ocor[$i]['data'];
	$hour = $ocor[$i]['hora'];
	$lugar = $ocor[$i]['espaco'];
echo " no dia ".$dia." às ".$hour." no local ".$lugar.",";
}
echo ".</p>";

echo "<p align='justify'>II – Autorizo a emissão de nota de empenho onerando a dotação orçamentária nº ".$dotacao." no valor total citado, conforme reserva;</p>";
echo "<p align='justify'>III – Fica dispensada a averiguação de responsabilidade funcional, em razão da imprevisibilidade do ocorrido e pela ação em prol do interesse público.</p>";

echo "</body>";
echo "</html>";
?>