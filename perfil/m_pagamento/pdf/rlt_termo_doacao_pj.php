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
   



//CONSULTA  (copia inteira em todos os docs)
$id_ped=$_GET['id'];

$ano=date('Y');
$dataAtual = date("d/m/Y");

$pedido = siscontrat($id_ped);

$pj = siscontratDocs($pedido['IdProponente'],2);
$ex = siscontratDocs($pedido['IdExecutante'],1);
$rep01 = siscontratDocs($pj['Representante01'],3);
$rep02 = siscontratDocs($pj['Representante02'],3);

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


header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$NumeroProcesso - Termo de Doação de Serviço.doc");

?>

<html>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
<body>
<style type='text/css'>
.style_01 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
</style>

<h2><center>PROCESSO Nº <?php echo $NumeroProcesso; ?> <br /></h2>
<h3><center>TERMO DE DOAÇÃO DE SERVIÇOS Nº________/<?php echo $ano; ?> </center></h3>

<p align='justify'>De acordo com o despacho proferido pelo Senhor Secretário Municipal de Cultura às fls. nº.36 do processo administrativo nº. <?php echo $NumeroProcesso; ?>,A <b>PREFEITURA DO MUNICÍPIO DE SÃO PAULO</b>, por intermédio de sua <b>SECRETARIA MUNICIPAL DE CULTURA</b>, neste ato representada  por seu titular <b>Sr. NABIL GEORGES BONDUKI</b>,Secretário Municipal de Cultura, doravante denominada <b>DONATÁRIA</b>e o grupo <b><?php echo $grupo; ?></b> por intermédio da empresa<?php echo $pjRazaoSocial; ?>, CNPJ <?php echo $pjCNPJ; ?>, sediada no endereço <?php echo $pjEndereco; ?>, representada legalmente por <?php echo $rep01Nome; ?>, portador da cédula de identidade RG/RNE nº.<?php echo $rep01RG; ?>, e do CPF nº. <?php echo $rep01CPF; ?>, denominados <b>DOADORES</b>, resolvem, com fundamento no artigo 1º do Decreto nº 40.384/2001, firmar o presente termo de doação de serviços profissionais, mediante as seguintes cláusulas e condições:</p>
<br/>

<h3>CLÁUSULA 1 - OBJETO</h3>

<p align='justify'>Doação de serviços artísticos para apresentação de <?php echo $Objeto; ?>, no período de <?php echo $Periodo; ?>, no espaço <?php echo $Local; ?>, conforme proposta de fls. 03/04</p>

<h3>CLÁUSULA 2 - OBRIGAÇÕES DOS DOADORES</h3>

<p align='justify'><b>OS DOADORES</b> compromete-se a:</p>

<ol>
<li>Executar os serviços no período e horários constantes na proposta de doação, garantindo sua qualidade e adequação aos propósitos artísticos do evento.</li>
<li>Fazer menção dos créditos da Prefeitura da Cidade de São Paulo, Secretaria Municipal de Cultural, em toda divulgação, escrita ou falada, realizada sobre o evento programado.</li>
</ol>

<h3>CLÁUSULA 3 - DOS DIREITOS E ENCARGOS DA DONATÁRIA</h3>
<p align='justify'><strong>Caberá a <?php echo $grupo; ?>,</strong></p>

<p align='justify'><b>A DONATÁRIA:</b></p>

<ol>
<li>Reserva-se o direito de registrar a imagem do evento, para efeito de documentação e publicação em qualquer mídia;</li>
<li>Deverá fornecer os equipamentos de sonorização e iluminação disponíveis do local da realização do evento, bem como providenciar a divulgação de praxe (confecção de cartaz manual e encaminhamento de release à mídia impressa e televisiva)</li>
<li>Exercer a coordenação e comunicações necessárias, bem como dirimir dúvidas, para o bom cumprimento das obrigações descritas neste termo.</li>

</ol>

<h3>CLÁUSULA 4 - DISPOSIÇÕES GERAIS</h3>
<p align='justify'><b>O DOADOR</b>, nos termos do artigo 8º do Decreto Municipal nº 40.384/01, declara, sob as penas da lei, que não está em débito com a Fazenda Municipal.</p>
<p align='justify'>Nos termos do art. 6 do Decreto nº. 54.873/2014, foi designado como fiscal do contrato o(a) Sr.(a) <?php echo $Fiscal; ?>, RF nº.<?php echo $rfFiscal; ?>, e como suplente o(a) Sr.(a) <?php echo $Suplente; ?>, RF nº<?php echo $rfSuplente; ?>.</p>
<p align='justify'>Fica eleito o foro da Fazenda Pública da Capital para qualquer procedimento judicial oriundo do presente Termo, com a renúncia de qualquer outro, por mais especial ou privilegiado que seja.</p>
<p align='justify'>E, para firmeza e validade de tudo quanto ficou estipulado, lavrou-se o presente Termo de Doação, que depois de lido e achado conforme pela Assessoria Jurídica a Secretaria Municipal de Cultura, foi assinado em 03 (três) vias de igual teor, pelas partes e pelas testemunhas abaixo identificadas.</p>
</p>

<p align='justify'>-.-.-.-.-.-.-.--.-.-.-.-.-.-.-.-.-.-.</p>

<p align='justify'>São Paulo, <?php echo $dataAtual; ?></p>

<p align='justify'>DONATÁRIA </p>

<p>&nbsp;</p>

<p align='justify'>Secretaria Municipal de Cultura / <?php echo $setor; ?><br/>
NABIL GEORGES BONDUKI<br/>
Secretário Municipal de Cultura<br/></p>

<br/>

<p align='justify'>DOADORES</p>

<p>&nbsp;</p>

<p align='justify'><?php echo $pjRazaoSocial; ?><br/>
CNPJ nº <?php echo $pjCNPJ; ?></br>

</p>

<p align='justify'>TESTEMUNHAS</p>

<p>&nbsp;</p>

<p align='justify'><?php echo $Fiscal; ?><br/>
RF nº <?php echo $rfFiscal; ?>
</p>

<p>&nbsp;</p>

<p align='justify'><?php echo $Suplente; ?><br/>
RF nº <?php echo $rfSuplente; ?>

<p>&nbsp;</p>


</body>
</html>
