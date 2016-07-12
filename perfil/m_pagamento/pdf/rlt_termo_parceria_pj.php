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

//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=termo de parceria.doc");

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

<h2><center>TERMO DE PARCERIA Nº__________ / <?php echo $ano; ?><br />
PROCESSO Nº <?php echo $NumeroProcesso; ?></center></h2>

<h3><center>Termo de Parceria Formalizado Entre a Prefeitura Municipal de São Paulo/Secretaria Municipal de Cultura e a Empresa <?php echo $pjRazaoSocial; ?></center></h3>

<p align='justify'>A PREFEITURA DO MUNICÍPIO DE SÃO PAULO, por intermédio de sua SECRETARIA MUNICIPAL DE CULTURA, neste ato representado pelo Sr. AUGUSTO JOSÉ BOTELHO SCHIMIDT, CPF: 581.703.838-20, RG: 5.253.934-9, Diretor do Centro Cultural São Paulo, de agora em diante denominada simplesmente SECRETARIA e a empresa <?php echo $pjRazaoSocial; ?>,  estabelecida no endereço <?php echo $pjEndereco; ?>, CNPJ nº <?php echo $pjCNPJ; ?>, neste ato legalmente representada por <?php echo $rep01Nome; ?>, CPF nº <?php echo $rep01CPF; ?>, RG nº <?php echo $rep01RG; ?> e por <?php echo $rep02Nome; ?>, CPF nº <?php echo $rep02CPF; ?>, RG nº <?php echo $rep02RG; ?>, com fundamento no artigo 2º, incisos V e VIII, da Lei Municipal nº 8.204/75, Decreto Municipal nº. 51.300/10, combinados com o artigo 116, da Lei Federal nº 8.666/93 e alterações posteriores e artigo 1º da Lei Municipal nº 13.278/2002, em especial a manifestação da assessoria jurídica deste departamento às fls., 35/37 e parecer da Comissão de Atividades Artísticas e Culturais instituída pela portaria nº. 024/2014/SMC.G às fls., 33/34, bem como as demais disposições legais e regularmente aplicáveis à espécie, firmar Parceria mediante as seguintes cláusulas e condições que outorgam e aceitam:</p>

<br/>

<h3>CLÁUSULA PRIMEIRA</h3>

<p align='justify'>O presente tem por objetivo estabelecer parceria em comunhão de esforços, para apresentação de <?php echo  $Objeto ?>, no(s) local(is) <?php echo $Local ?> no perído de <?php echo $Periodo; ?> conforme cronograma, além de eventuais outros projetos de interesse da SMC, nas diversas áreas da cultura.</p>

<p>a. Esta parceria deverá vigorar pelo período mínimo de __ anos;</p>

<p align='justify'>
<?php

$ocor = listaOcorrenciasContrato($id);

	for($i = 0; $i < $ocor['numero']; $i++){
	
	$tipo = $ocor[$i]['tipo'];
	$dia = $ocor[$i]['data'];
	$hour = $ocor[$i]['hora'];
	$lugar = $ocor[$i]['espaco'];
echo "Data: ".$dia." às ".$hour."<br/>Local: ".$lugar."<br/><br/>";
}
?>
</p>

<h3>CLÁUSULA SEGUNDA</h3>

<ol type="a">
<li>Conservar a autoridade normativa;</li>
<li>Exercer controle e fiscalização sobre a execução do objeto da parceria;</li>
<li>Assumir ou transferir a responsabilidade pelo presente, caso ocorra fato relevante superveniente ou paralisação do serviço;</li>
<li>Exigir relatório de atividades do projeto, que deverá ser entregue em até 60 (sessenta) dias após o término de cada período, podendo ser este prazo prorrogado a critério da Direção da Secretaria Municipal de Cultura.</li>
</ol>

<h3>CLÁUSULA TERCEIRA</h3>
<p align='justify'><strong>Caberá à empresa <?php echo $pjRazaoSocial; ?>,</strong></p>

<ul>
<li>Enviar solicitações de espaços da Secretaria Municipal de Cultura com pelo menos 90 (noventa) dias de antecedência;</li>
<li>Confirmar a utilização da infraestrutura necessária para o evento com pelo menos 20 (vinte) dias de antecedência da atividade;</li>
<li>Enviar as informações referentes ao evento com 60 (sessenta) dias de antecedência para inserção na intranet e nos meios de divulgação impressa e eletrônica da SMC.</li>
</ul>

<h3>CLÁUSULA QUARTA</h3>
<p align='justify'>A SMC não se responsabiliza pela guarda/segurança dos equipamentos armazenados nas salas durante as atividades.</p>

<h3>CLÁUSULA QUINTA</h3>
<p align='justify'>Caberá a Secretaria Municipal de Cultura:</p>

<ul>
<li>Ceder os espaços para realização do evento, programação voltada ao seu público alvo, conforme calendário descrito no ítem b da cláusula primeira;</li>
<li>Fornecer infraestrutura técnica para o evento; como mesas, cadeiras, sonorização com microfones, tela, Datashow e/ou televisão, além do notebook;</li>
<li>Avaliar os outros projetos encaminhados á Direção da SMC, conforme natureza do evento e quantidade de público, incluindo negociação das condições que deverão ser previamente aprovadas;</li>
</ul>


<h3>CLÁUSULA SEXTA</h3>
<p align='justify'>Com relação a isenção de preço público, será necessária avaliação prévia por parte da Direção Geral, Jurídico e Produção do Centro Cultural São Paulo.</p>



<h3>CLÁUSULA SÉTIMA</h3>
<p align='justify'>As responsabilidades civis, penais, comerciais  e outras advindas de utilização de direitos  autorais e/ou patrimoniais anteriores ou posteriores a este ajuste cabem  inteiramente à Associação, em relação ao presente, não cabendo à SECRETARIA  qualquer imputação ou ônus;</p>
<p align='justify'>A SECRETARIA não se responsabilizará em nenhuma hipótese  pelos atos, contratos ou compromissos assumidos de natureza comercial,  financeira, trabalhista ou de outra espécie, celebrado pela Associação, para  fins de cumprimento deste termo.</p>

<h3>CLÁUSULA OITAVA</h3>

<p align='justify'>Constituem motivos para a rescisão da parceria o  inadimplemento de cláusulas, especificações ou prazos previstos no presente  termo.</p>

<h3>CLÁUSULA NONA</h3>
<p align='justify'>Na hipótese de resolução da presente Parceria por  inadimplência das obrigações assumidas pelos partícipes, ou por prejuízos  decorrentes da denúncia do presente, responderá o partícipe faltoso ou  denunciante por perdas e danos, apurados administrativa ou judicialmente.</p>

<h3>CLÁUSULA DÉCIMA</h3>
<p align='justify'>Fica eleito o Foro desta Capital, por intermédio de uma das  Varas da Fazenda Pública, para todo e qualquer procedimento oriundo desta  parceria, com a renúncia de qualquer outro, por mais especial ou privilegiado  que seja.</p>
<p align='justify'>E, para firmeza e validade de tudo quanto ficou estipulado,  lavrou-se o presente Termo de Parceria, que depois de lido e achado conforme  pela Assistência Jurídica da Secretaria Municipal de Cultura foi  assinado em 03 (três) vias de igual teor, pelas partes e pelas testemunhas  abaixo identificadas.</p>

<p align='justify'>-.-.-.-.-.-.-.--.-.-.-.-.-.-.-.-.-.-.</p>

<p align='justify'>São Paulo, <?php echo $dataAtual; ?></p>

<p>&nbsp;</p>

<p align='justify'>Secretaria Municipal de Cultura / <?php echo $setor; ?><br/>
AUGUSTO JOSÉ BOTELHO SCHIMIDT<br/>
CPF:581.703.838-20<br/>
RG: 5.253.934-9</p>

<br/>

<p align='justify'><?php echo $pjRazaoSocial; ?></p>

<p>&nbsp;</p>

<p align='justify'><?php echo $rep01Nome; ?><br/>
CPF nº <?php echo $rep01CPF; ?><br/>
RG nº <?php echo $rep01RG; ?>
</p>

<p>&nbsp;</p>

<p align='justify'><?php echo $rep02Nome; ?><br/>
CPF nº <?php echo $rep02CPF; ?><br/>
RG nº <?php echo $rep02RG; ?>
</p>

<p>&nbsp;</p>

<p align='justify'>TESTEMUNHAS</p>

</body>
</html>
