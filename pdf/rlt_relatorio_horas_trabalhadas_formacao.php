<?php 
	session_start();
	   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 	
   
   // INSTALAÇÃO DA CLASSE NA PASTA FPDF.
   require_once("../funcoes/funcoesConecta.php");
   require_once("../funcoes/funcoesGerais.php");
   require_once("../funcoes/funcoesSiscontrat.php");
   require_once("../funcoes/funcoesFormacao.php");

   //CONEXÃO COM BANCO DE DADOS 
   $conexao = bancoMysqli(); 
   



//CONSULTA 
$id_ped=$_GET['id'];
$pedido = siscontrat($id_ped);
$id_parcela = $_GET['parcela'];

$codPed = $id_ped;
$objeto = $pedido["Objeto"];
$local = $pedido["Local"];
$justificativa = $pedido["Justificativa"];

$pedido_pessoa = siscontratDocs($pedido['IdProponente'],1);
$nome = $pedido_pessoa["Nome"];
$cpf = $pedido_pessoa["CPF"];

$parcelamento = retornaParcelaPagamento($id_ped);
$periodoParcela = $parcelamento[$id_parcela]['periodo']; 
$horas = $parcelamento[$id_parcela]['horas'];
$dataFinal = $parcelamento[$id_parcela]['vigencia_final'];

$formacao = pdfFormacao($id_ped);
$cargo = $formacao["Cargo"];
$programa = $formacao["Programa"];
$linguagem = $formacao["linguagem"];

$retornaMes = retornaMesExtenso(exibirDataMysql($dataFinal));

$dataAtual = date("d/m/Y");
$ano=date('Y');



header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Relatorio_Horas_trabalhadas_$ano-$id_ped.doc");

?>

<html>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
<body>
<style type='text/css'>
.style_01 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
@page WordSection1
	{size:842.0pt 21.0cm;
	mso-page-orientation:landscape;
	margin:15.9pt 26.1pt 15.9pt 36.0pt;
	mso-header-margin:35.45pt;
	mso-footer-margin:35.45pt;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
table {
    border-collapse: collapse;
}
</style>

<div class=WordSection1>

<p align="center"><strong>PREFEITURA  MUNICIPAL DE SÃO PAULO</strong><br />
  <strong>SECRETARIA  MUNICIPAL DE CULTURA – DIVISÃO DE FORMAÇÃO</strong><br />
  <strong>RELATÓRIO DE HORAS  TRABALHADAS </strong></p>
<p><strong>Programa:</strong> <?php echo $programa; ?>                              <strong>Linguagem:</strong> <?php echo $linguagem; ?>                                        <strong>Função:</strong> <?php echo $cargo; ?><br />
  <strong>Nome:</strong> <?php echo $nome; ?><br />
  <strong>Mês:</strong> <?php echo $retornaMes; ?></p>
<table width="100%" border="1">
  <tr>
    <td align="center" width="10%"><strong>DATA</strong></td>
    <td align="center" width="56%"><strong>ATIVIDADE DESENVOLVIDA</strong></td>
    <td align="center" width="27%"><strong>LOCAL</strong></td>
    <td align="center" width="7%"><strong>HORAS</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="right"><strong>TOTAL HORAS</strong>&nbsp;</td>
    <td align="center"></td>
  </tr>
</table>

<table width="100%" border="0">
  <tr>
    <td align="center" width="34%" height="70" valign="bottom">_______________________________________</td>
    <td align="center" width="33%" height="70" valign="bottom">_______________________________________</td>
    <td align="center" width="33%" valign="bottom" rowspan="2">
	<?php 	
		if ($programa == "Programa Vocacional - 2016") {
		echo "<IMG SRC = 'http://centrocultural.cc/igsis//pdf/img/Ass_PauloFabiano.jpg'/>";
		} else {
		echo "<IMG SRC = 'http://centrocultural.cc/igsis//pdf/img/Ass_Valdilania.jpg'/>";};
	?>
	</td>  
  </tr>
  <tr>
    <td align="center" width="34%"  valign="top"><?php echo $nome; ?></td>
    <td align="center" width="33%" valign="top"> Assinatura  Articulador/Coordenador</td>
  </tr>
</table></div>
</body>
</html>
