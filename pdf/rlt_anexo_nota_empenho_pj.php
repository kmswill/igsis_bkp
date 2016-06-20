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
$final = nl2br($pedido["Finalizacao"]);
$penalidade = nl2br($pedido["Penalidade"]);
$NumeroProcesso = $pedido["NumeroProcesso"];

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

   
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$NumeroProcesso em $dataAtual.doc");
echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";

echo "<p><b>CONTRATANTE:</b> "."$setor"."</p>";
echo "<p align='justify'><b>CONTRATADO(S):</b>".$exNome." (CPF ".$exCPF."), nome artístico ´´".$exNomeArtistico."´´ e demais integrantes relacionados na declaração de exclusividade , por intermédio de ".$pjRazaoSocial.", CNPJ ("."$pjCNPJ"."), legalmente representada por ".$rep01Nome." CPF (".$rep01CPF.").</p>";
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