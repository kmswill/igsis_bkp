<?php
//require '../include/';
   require_once("../funcoes/funcoesConecta.php");
   require_once("../funcoes/funcoesGerais.php");
   require_once("../funcoes/funcoesSiscontrat.php");

//CONEXÃO COM BANCO DE DADOS 
   $conexao = bancoMysqli();


//CONSULTA 
$id_ped=$_GET['id'];
$ano=date('Y');
$dataAtual = date("d/m/Y");

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
$Fiscal = $pedido["Fiscal"];
$rfFiscal = $pedido["RfFiscal"];
$Suplente = $pedido["Suplente"];
$rfSuplente = $pedido["RfSuplente"];
$amparo = nl2br($pedido["AmparoLegal"]);
$final = nl2br($pedido["Finalizacao"]);
$penalidade = nl2br($pedido["Penalidade"]);
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


   
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$NumeroProcesso em $dataAtual.doc");
echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";

echo "<p align='justify'><b>CONTRATANTE:</b> "."SMC / $setor"."</p>";
echo "<p align='justify'><b>CONTRATADO(S):</b> Contratação de <b>"."$Nome"."</b>, CPF "."$CPF"." e demais integrantes relacionados na declaração de exclusividade.</p>";
echo "<p align='justify'><b>EVENTO/SERV:</b> Apresentação do "."$Objeto".", conforme segue:<br>
"."$Local"." <br>
TEMPO APROX. "."$Duracao"."utos cada apresentação.</p>";
echo "<p align='justify'><b>DATA/PERÍODO: </b>"."$Periodo".".</p>";
echo "<p align='justify'><b>VALOR TOTAL DA CONTRATAÇÃO:</b> "."R$ $ValorGlobal"."  "."($ValorPorExtenso)"."<br> Quaisquer despesas aqui não ressalvadas, bem como direitos autorais, serão de responsabilidade do(a) contratado(a).</p>";
echo "<p align='justify'><b>CONDIÇÕES DE PAGAMENTO: </b>"."$FormaPagamento".".</p>";
echo "<p align='justify'>O pagamento será efetuado por crédito em conta corrente no BANCO DO BRASIL, em  conformidade com o Decreto 51.197/2010, publicado no DOC de 23.01.2010.<br/>
De acordo com a Portaria nº 5/2012 de SF, haverá compensação financeira, se houver atraso no pagamento do valor devido, por culpa exclusiva do Contratante, dependendo de requerimento a ser formalizado pelo Contratado.</p>";
echo "<p align='justify'><b>FISCALIZAÇÃO DO CONTRATO NA SMC: </b>Servidor "."$Fiscal"." - RF "."$rfFiscal"." como fiscal do contrato e Sr(a) " ."$Suplente"." - RF "."$rfSuplente"." como substitut(o)a.<br> 
<b> De acordo com a Portaria nº 5/2012 de SF, haverá compensação financeira, se houver atraso no pagamento do valor devido, por culpa exclusiva do Contratante, dependendo de requerimento a ser formalizado pelo Contratado.</b> </p>";
echo "<p align='justify'><b>PENALIDADES:</b> ".$penalidade.".</p>";
echo "<p align='justify'><b>RESCISÃO CONTRATUAL: </b> DESPACHO - Dar-se-á caso ocorra quaisquer dos atos cabíveis descritos na legislação vigente.<br>
* Contratação, por inexigibilidade da licitação, com fundamento no artigo 25, Inciso III, da Lei Federal nº. 8.666/93, e alterações posteriores, e artigo 1º da Lei Municipal nº. 13.278/02, nos termos dos artigos 16 e 17 do Decreto Municipal nº. 44.279/03.</p>
<b> ** OBS.: ESTE EMPENHO SUBSTITUI O CONTRATO, CONFORME ARTIGO 62 DA LEI FEDERAL Nº. 8.666/93.</b>
</p>";
echo "<p align='justify'><b>DESPACHO</b><br>".$amparo."</p>";
echo "</body>";
echo "</html>";
?>