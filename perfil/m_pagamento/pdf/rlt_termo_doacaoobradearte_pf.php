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
header("Content-Disposition: attachment;Filename=$NumeroProcesso - Termo Doação Obra de Arte.doc");

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

<p align='justify'>A <b>PREFEITURA DO MUNICÍPIO DE SÃO PAULO</b>, por intermédio de sua <b>SECRETARIA MUNICIPAL DE CULTURA</b>, neste ato representada  por seu titular <b>Sr. NABIL GEORGES BONDUKI</b>,Secretário Municipal de Cultura, doravante denominada <b>DONATÁRIA</b> e o(a) Sr(a).<?php echo $Nome; ?>, <?php echo $Nacionalidade; ?>, portador da cédula de identidade RG/RNE <?php echo $RG; ?>, inscrito no CPF/MF sob o nº.<?php echo $CPF; ?>, residente no endereço <?php echo $Endereco; ?>, telefone: <?php echo $Telefones; ?>, email: <?php echo $Email; ?> doravante denominado <b>DOADOR</b>, com fundamento no artigo 1º do Decreto nº 40.834/2001, firmar o presente <b>TERMO DE DOAÇÃO</b>, mediante as seguintes cláusulas e condições: </p>
<br/>

<h3>CLÁUSULA 1 - OBJETO</h3>

<p align='justify'>O objeto do presente ajuste consiste no recebimento em doação da obra de arte abaixo descrita, de autoria e propriedade do(a) Sr(a). <?php echo $Nome; ?>, para integrar o acervo da Coleção de Arte da Cidade, da Secretaria Municipal de Cultura.</p>

<p align='justify'><b>Artista:</b><?php echo $NomeArtistico; ?></p>
<p align='justify'></p><b>Título:</b>
<p align='justify'></p><b>Data:</b>
<p align='justify'></p><b>Técnica:</b>
<p align='justify'></p><b>Suporte:</b>
<p align='justify'></p><b>Dimensões:</b>
<p align='justify'></p><b>Categoria:</b>
<p align='justify'></p><<b>Valor:</b>
<br />

<h3>CLÁUSULA 2 - OBRIGAÇÕES DA DONATÁRIA</h3>

<p align='justify'><b>O DOADOR</b> compromete-se a:</p>

<ol>
<li>Receber o bem, objeto da presente doação, preservá-lo, mantendo o bom estado de conservação;</li>

</ol>

<h3>CLÁUSULA 3 - DISPOSIÇÕES GERAIS</h3>

<ol>
<li>A presente doação não acarretará ônus para a Municipalidade.</li>
<li>A <b>DONATÁRIA</b> fica autorizada a reproduzir, por processo fotográfico ou digital, e a utilizar, sem qualquer ônus, as imagens da obra de arte doada em anúncio, catálogo, exposição, folder e outras publicações e quaisquer outras modalidades de utilização existentes ou que venham a existir, sem fins lucrativos, nos eventos promovidos e/ou produzidos pela Secretaria Municial de Cultura/Prefeitura Municipal de São Paulo. Essa autorização terá validade a partir da presente assinatura e vigorará pelo prazo previsto no artigo 41 da Lei Federal nº 9.610/98.</li>
<li>Fica eleito o foro da Comarca da Capital, através de uma de suas varas da Fazenda Pública, para qualquer procedimento judicial oriundo do presente Termo, com a renúncia de qualquer outro, por mais especial ou privilegiado que seja.</li>
<p align='justify'>E por estarem justas e pactudas firmam as Partes o presente Termo, em 4 (quatro) vias de igual teor, forma e data para um só efeito na presença das testemunhas abaixo.</p>
</ol>

<p align='justify'>São Paulo, <?php echo $dataAtual; ?></p>

<p align='justify'>DONATÁRIA:</p>

<p>&nbsp;</p>

<p align='justify'>Secretaria Municipal de Cultura / <?php echo $setor; ?><br/>
NABIL GEORGES BONDUKI<br/>
Secretário Municipal de Cultura<br/></p>

<br/>

<p align='justify'>DOADOR:</p>

<p>&nbsp;</p>

<p align='justify'><?php echo $Nome; ?><br/>
RG/RNE nº <?php echo $RG; ?></br>
CPF nº <?php echo $CPF; ?>
</p>

<p>&nbsp;</p>

<p align='justify'>TESTEMUNHAS:</p>

<p align='justify'><?php echo $Fiscal; ?><br/>
RF nº <?php echo $rfFiscal; ?>
</p>

<p>&nbsp;</p>

<p align='justify'><?php echo $Suplente; ?><br/>
RF nº <?php echo $rfSuplente; ?>

</body>
</html>
