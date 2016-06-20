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
$NumeroProcesso = $pedido["NumeroProcesso"];
$notaempenho = $pedido["NotaEmpenho"];
$data_entrega_empenho = exibirDataBr($pedido['EntregaNE']);
$data_emissao_empenho = exibirDataBr($pedido['EmissaoNE']);

$grupo = grupos($id_ped);
$integrantes = $grupo["texto"];

//PessoFisica

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

$codPed = "";


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

<p align='justify'>De acordo com o despacho proferido pelo Senhor Secretário Municipal de Cultura em fls. retro do processo administrativo nº. <?php echo $NumeroProesso; ?>,A <b>PREFEITURA DO MUNICÍPIO DE SÃO PAULO</b>, por intermédio de sua <b>SECRETARIA MUNICIPAL DE CULTURA</b>, neste ato representada  por seu titular <b>Sr. NABIL GEORGES BONDUKI</b>,Secretário Municipal de Cultura e <b><?php echo $Nome; ?></b>, nome artístico <?php echo $NomeArtistico; ?>, <?php echo $Nacionalidade; ?>, portador do RG/RNE <?php echo $RG; ?>, inscrito no CPF/MF sob o nº.<?php echo $CPF; ?>, residente e domiciliado no endereço <?php echo $Endereco; ?>, denominad <b>DOADOR</b>, resolvem, com fundamento no artigo 1º do Decreto nº 40.834/2001, firmar o presente termo de doação de serviços profissionais de natureza artística, mediante as seguintes cláusulas e condições: </p>
<br/>

<h3>CLÁUSULA 1 - OBJETO</h3>

<p align='justify'>Doação de serviços para realização de <?php echo $Objeto; ?>, no período de <?php echo $Periodo; ?>, no espaço <?php echo $Local; ?>.</p>

<h3>CLÁUSULA 2 - OBRIGAÇÕES DO DOADOR</h3>

<p align='justify'><b>O DOADOR</b> compromete-se a:</p>

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

<p>&nbsp;</p>

<p align='justify'>Secretaria Municipal de Cultura / <?php echo $setor; ?><br/>
NABIL GEORGES BONDUKI<br/>
Secretário Municipal de Cultura<br/></p>

<br/>

<p align='justify'>DOADORA</p>

<p>&nbsp;</p>

<p align='justify'><?php echo $Nome; ?><br/>
RG/RNE nº <?php echo $RG; ?></br>
CPF nº <?php echo $CPF; ?>
</p>

<p>&nbsp;</p>

<p align='justify'><?php echo $Fiscal; ?><br/>
RF nº <?php echo $rfFiscal; ?>
</p>

<p>&nbsp;</p>

<p align='justify'><?php echo $Suplente; ?><br/>
RF nº <?php echo $rfSuplente; ?>

</body>
</html>
