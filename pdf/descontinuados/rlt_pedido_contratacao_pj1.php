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

$pedido = siscontrat($id_ped);
$pj = siscontratDocs($pedido['IdProponente'],2);

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
$dataAtual = exibirDataBr($pedido["DataCadastro"]);
$setor = $pedido["Setor"];

//PessoaJuridica
$pjRazaoSocial = $pj["Nome"];
$pjCNPJ = $pj['CNPJ'];
$pjTelefones = $pj["Telefones"];
$pjEmail = $pj["Email"];
  
 ?>
 
 
<html>
<head> 
<meta http-equiv=\"Content-Type\" content=\"text/html. charset=Windows-1252\">

<style>

.texto{
 	width: 900px;
 	border: solid;
 	padding: 20px;
 	font-size: 12px;
 	font-family: Arial, Helvetica, sans-serif;
	text-align:justify;
}
</style>
<script src="include/dist/ZeroClipboard.min.js"></script>
</head>

 <body>

  
<?php

$sei = 
"<p align='center'><strong>PEDIDO DE  CONTRATAÇÃO DE PESSOA JURÍDICA </strong></p>".
"<p>&nbsp;</p>".
"<p><strong>Pedido de Contratação nº:</strong> "."$ano-$id_ped"."</p>".
"<p><strong>Setor  solicitante:</strong> "."$setor"."</p>".
"<p>&nbsp;</p>".
"<p><strong>Razão Social:</strong> "."$pjRazaoSocial"." <br />".
  "<strong>CNPJ:</strong> "."$pjCNPJ"."<br />".
   "<strong>Telefone:</strong> "."$pjTelefones"."<br />".
   "<strong>E-mail:</strong> "."$pjEmail"."</p>".
"<p>&nbsp;</p>".
"<p><strong>Objeto:</strong> "."$Objeto"."</p>".
"<p><strong>Data / Período:</strong> "."$Periodo"."</p>".
"<p><strong>Tempo Aproximado de Duração do Espetáculo:</strong> "."$Duracao"."utos </p>".
"<p><strong>Carga Horária:</strong> "."$CargaHoraria"."</p>".
"<p align='justify'><strong>Local:</strong> "."$Local"."</p>".
"<p><strong>Valor: </strong> R$ "."$ValorGlobal"."  ("."$ValorPorExtenso". " )</p>".
"<p align='justify'><strong>Forma de Pagamento:</strong> "."$FormaPagamento "."</p>".
"<p align='justify'><strong>Justificativa: </strong> "."$Justificativa"."</p>".
"<p align='justify'><strong>Fiscal: </strong> "."$Fiscal"."</p>".
"<p align='justify'><strong>Suplente: </strong> "."$Suplente"."</p>";

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