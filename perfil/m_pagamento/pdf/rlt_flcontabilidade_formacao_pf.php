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
$pedido = siscontrat($id_ped);
$id_parcela = $_GET['parcela'];

$codPed = $id_ped;
$objeto = $pedido["Objeto"];
$local = $pedido["Local"];
$justificativa = $pedido["Justificativa"];

$pedido_pessoa = siscontratDocs($pedido['IdProponente'],1);
$nome = $pedido_pessoa["Nome"];
$cpf = $pedido_pessoa["CPF"];

//$horas = retornaCargaHoraria($id_ped,$id_parcela);

$parcelamento = retornaParcelaPagamento($id_ped);
$periodoParcela = $parcelamento[$id_parcela]['periodo']; 
$horas = $parcelamento[$id_parcela]['horas'];

$dataAtual = date("d/m/Y");
$ano=date('Y');

  
 ?>
 
 
<html>
<head> 
<meta http-equiv=\"Content-Type\" content=\"text/html. charset=Windows-1252\">

<style>

.texto{
 	width: 900px;
 	border: solid;
 	padding: 20px;
 	font-size: 13px;
 	font-family: Arial, Helvetica, sans-serif;
	text-align:justify;
}
</style>
<script src="include/dist/ZeroClipboard.min.js"></script>
</head>

 <body>

  
<?php

$sei = 
  "<p>&nbsp;</p>".
  "<p><strong>SMC - CONTABILIDADE</strong></p>".
  "<p><strong>Sr.(a) Contador(a)</strong></p>".
  "<p>&nbsp;</p>". 
  "<p>&nbsp;</p>".
  "<p><strong>Nome:</strong> ".$nome."</p>".
  "<p><strong>CPF:</strong> ".$cpf."</p>".
  "<p><strong>Objeto:</strong> ".$objeto."</p>".
  "<p><strong>Locais:</strong> ".$local."</p>".
  "<p><strong>Período:</strong> ".$periodoParcela."</p>". 
  "<p>&nbsp;</p>".
  "<p align='justify'>Com base na Confirmação de Serviços (Documento SEI link ), atesto que foi efetivamente cumprido ".$horas." horas de trabalho durante o período supra citado.</p>".
  "<p align='justify'>Encaminhamos o presente para as providências necessárias relativas ao pagamento da parcela do referido processo.</p>".
  "<p>&nbsp;</p>".
  "<p>&nbsp;</p>"

?>

<div align="center">
 <div id="texto" class="texto"><?php echo $sei; ?></div>
</div> 

 <p>&nbsp;</p>
 
 <div align="center"><button id="botao-copiar" data-clipboard-target="texto"><img src="img/copy-icon.jpg"> CLIQUE AQUI PARA COPIAR O TEXTO</button>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <a href="http://sei.prefeitura.sp.gov.br" target="_blank">
 <button>CLIQUE AQUI PARA ACESSAR O <img src="img/sei.jpg"></button></a>
</div>
         
<script>
var client = new ZeroClipboard();
client.clip(document.getElementById("botao-copiar"));
client.on("aftercopy", function(){
    alert("Copiado com sucesso!");
});
</script>

  </body>
  </html>