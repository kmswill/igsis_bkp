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
header("Content-Disposition: attachment;Filename=$NumeroProcesso - Termo de Parceria.doc");

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

<h3><center>Termo de Parceria Formalizado Entre a Prefeitura Municipal de São Paulo/Secretaria Municipal de Cultura e <?php echo $grupo; ?></center></h3>

<p align='justify'>A PREFEITURA DO MUNICÍPIO DE SÃO PAULO, por intermédio de sua SECRETARIA MUNICIPAL DE CULTURA, neste ato representado pelo Sr. AUGUSTO JOSÉ BOTELHO SCHIMIDT, CPF: 581.703.838-20, RG: 5.253.934-9, Diretor do Centro Cultural São Paulo, de agora em diante denominada simplesmente SECRETARIA e o <?php echo $grupo; ?>, representado por <?php echo $Nome; ?>, portadora da cédula de identidade RG nº.<?php echo $RG; ?>, inscrita no C.P.F. nº. <?php echo $CPF; ?>, residente e domiciliada no endereço <?php echo $Endereco; ?>, com fundamento no artigo 2º, incisos V e VIII, da Lei Municipal nº 13.278.2002, em especial a manifestação da assessoria jurídica deste departamento às fls., 25/27 e parecer da Comissão de Atividades Artísticas e Culturais instituída pela portaria nº. 024/2014/SMC.G aplicáveis à espécie, firmar Parceria mediante as seguintes cláusulas e condições que outorgam e aceitam: </p>
<br/>

<h3>CLÁUSULA PRIMEIRA</h3>

<p align='justify'>O presente tem por objetivo estabelecer parceria em comunhão de esforços, para apresentação de <?php echo $Objeto ?> no(s) local(is) <?php echo $Local ?>, no período de <?php echo $Periodo ?>, conforme proposta de fls. 02 e ofício de fls. 03/04.</p>

<h3>CLÁUSULA SEGUNDA - DAS PRERROGATIVAS DA ADMINISTRAÇÃO</h3>

<ol type="a">
<li>Conservar a autoridade normativa;</li>
<li>Exercer controle e fiscalização sobre a execução do objeto da parceria;</li>
<li>Assumir ou transferir a responsabilidade pelo presente, caso ocorra fato relevante superveniente ou paralisação do serviço;</li>
<li>Exigir relatório de atividades do projeto, que deverá ser entregue em até 60 (sessenta) dias após o término de cada período, podendo ser este prazo prorrogado a critério da Direção da Secretaria Municipal de Cultura.</li>
</ol>

<h3>CLÁUSULA TERCEIRA</h3>
<p align='justify'><strong>Caberá a <?php echo $grupo; ?>,</strong></p>

<ol type="a">
<li>Realizar a coordenação executiva do projeto, garantindo a participação de escritores e poetas para lançamentos de livros, de músicos ou bandas para pocket shows, apresentações de esquetes teatrais ou intervenções com performances literárias, entre outras atividades; </li>
<li>Providenciar a contratação e o pagamento de eventuais despesas com cachê, passagens aéreas, transporte local, hospedagem e alimentação dos artistas, produtores e demais profissionais envolvidos no projeto;</li>
<li>Responsabilizar-se pela venda, recolhimento e guarda dos valores arrecadados;</li>
<li>Providenciar o encaminhamento das informações para divulgação, incluindo releases e fotos em alta resolução com antecedência ao evento;</li>
<li>Enviar o mapa de palco e demais informações técnicas para a Coordenação de Produção do SMC com antecedência ao evento;<li>
<li>Acompanhar os grupos musicais nos dias de apresentação e entrega de lista com repertório a ser executado para a equipe de Administração de Salas da Instituição;</li>
<li>Inserir o logo da Secretaria Municipal de Cultural sob a chancela de co-realização em todo o material gráfico e eletrônico produzido pra o evento e envio da logomarca do coletivo em alta resolução;</li>
<li>Enviar as placas e modelos dos veículos que farão a carga e descarga, com antecedência ao evento;</li>
<li>Definir em conjunto com a Curadoria de Eventos da Biblioteca e Administração de Salas do SMC o acesso do público;</li>
<li>Restituir os espaços utilizados, após o término do evento, inteiramente desocupado e nas mesmas condições em que os recebeu.</li>
</ol>

<h3>CLÁUSULA QUARTA</h3>
<p align='justify'>A SMC não se responsabiliza pela guarda/segurança dos equipamentos armazenados nas salas durante as atividades.</p>

<h3>CLÁUSULA QUINTA</h3>
<p align='justify'>Caberá a Secretaria Municipal de Cultura:</p>

<ol type="a">
<li>Disponibilizar o Espaço <?php echo $Local ?>, para todo o período de <?php echo $Periodo; ?></li>
<li>Disponibilizar a infraestrutura cênica e de sonorização no Espaço <?php echo $Local; ?>, conforme mapa de palco previamente enviado;</li>
<li>Realizar o acompanhamento das equipes de Produção, Palcos e Administração de salas durante e na pré e pós-produção do evento;</li>
<li>Disponibilizar a garagem do prédio para carga e descarga de equipamentos relacionados ao evento;</li>
<li>Realizar a divulgação do evento como parte da programação nos principais meios de comunicação institucional, tais como: agenda mensal impressa, folhetos, boletim eletrônico, cartazes, site, cartazes, site e redes sociais, desde que as informações tenham sido recebidas com a antecedência requerida;</li>
<li>Inserir o logotipo do <?php echo $grupo; ?> na comunicação impressa e eletrônica da instituição;</li>
<li>Responsabilizar-se pelo pagamento ao ECAD das músicas dos saraus, cuja relação de músicas para o pagamento será informada e providenciada pelo coletivo, previamente à realização do evento;</li>
<li>Fornecer serviço geral de segurança patrimonial, limpeza e atendimento ao público no espaço;</li>
<li>Acompanhar e zelar pela observância das demais normas legais aplicáveis à espécie e pelo cumprimento das obrigações pactuadas.</li>
</ol>


<h3>CLÁUSULA SEXTA</h3>
<p align='justify'>As responsabilidades civis, penais, comerciais e outras advindas de utilização de direitos autorais e/ou patrimoniais anteriores ou posteriores a este ajuste cabem inteiramente ao <?php $grupo; ?>, em relação ao apresente, não cabendo à SECRETARIA qualquer imputação ou ônus;
A SECRETARIA não se responsabilizará em nenhuma hipótese pelos atos, contratos ou compromissos assumidos de natureza comecial, financeira, trabalhista ou de outra espécie, celebrado pelo(a) <?php $grupo; ?> , para fins de cumprimento deste termo.
</p>

<h3>CLÁUSULA SÉTIMA</h3>
<p align='justify'>As responsabilidades civis, penais, comerciais  e outras advindas de utilização de direitos  autorais e/ou patrimoniais anteriores ou posteriores a este ajuste cabem  inteiramente à Associação, em relação ao presente, não cabendo à SECRETARIA  qualquer imputação ou ônus;</p>
<p align='justify'>A SECRETARIA não se responsabilizará em nenhuma hipótese  pelos atos, contratos ou compromissos assumidos de natureza comercial,  financeira, trabalhista ou de outra espécie, celebrado pela Associação, para  fins de cumprimento deste termo.</p>

<h3>CLÁUSULA OITAVA</h3>

<p align='justify'>Na hipótese de resolução da presente Parceria por  inadimplência das obrigações assumidas pelos partícipes, ou por prejuízos  decorrentes da denúncia do presente, responderá o partícipe faltoso ou  denunciante por perdas e danos, apurados administrativa ou judicialmente.</p>

<h3>CLÁUSULA NONA</h3>
<p align='justify'>Fica eleito o Foro desta Capital, por intermédio de uma das  Varas da Fazenda Pública, para todo e qualquer procedimento oriundo desta  parceria, com a renúncia de qualquer outro, por mais especial ou privilegiado  que seja.</p>
<p align='justify'>E, para firmeza e validade de tudo quanto ficou estipulado,  lavrou-se o presente Termo de Parceria, que depois de lido e achado conforme  pela Assistência Jurídica da Secretaria Municipal de Cultura foi  assinado em 04 (quatro) vias de igual teor, pelas partes e pelas testemunhas  abaixo identificadas.</p>
</p>

<p align='justify'>-.-.-.-.-.-.-.--.-.-.-.-.-.-.-.-.-.-.</p>

<p align='justify'>São Paulo, <?php echo $dataAtual; ?></p>

<p>&nbsp;</p>

<p align='justify'>Secretaria Municipal de Cultura / <?php echo $setor; ?><br/>
AUGUSTO JOSÉ BOTELHO SCHIMIDT<br/>
CPF:581.703.838-20<br/>
RG: 5.253.934-9</p>

<br/>

<p align='justify'><?php echo $Nome; ?></p>

<p>&nbsp;</p>

<p align='justify'><?php echo $rep01Nome; ?><br/>
CPF nº <?php echo $CPF; ?><br/>
RG nº <?php echo $RG; ?>
</p>

<p>&nbsp;</p>

<p align='justify'>TESTEMUNHAS</p>

<p>&nbsp;</p>

<p align='justify'><?php echo $Fiscal; ?><br/>
RF nº <?php echo $rfFiscal; ?>
</p>

<p>&nbsp;</p>

<p align='justify'><?php echo $Suplente; ?><br/>
RF nº <?php echo $rfSuplente; ?>
</p>



</body>
</html>
