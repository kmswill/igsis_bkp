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
dataReserva($id_ped);
$linha_tabelas = siscontrat($id_ped);

$codPed = $id_ped;
$objeto = $linha_tabelas["Objeto"];
$ValorGlobal = $linha_tabelas["ValorGlobal"];
$ValorPorExtenso = valorPorExtenso($linha_tabelas["ValorGlobal"]); 
$periodo = $linha_tabelas["Periodo"];
$duracao = $linha_tabelas["Duracao"];
$dataAtual = date("d/m/Y");
$NumeroProcesso = $linha_tabelas["NumeroProcesso"];
$assinatura = $linha_tabelas["Assinatura"];
$cargo = $linha_tabelas["Cargo"];

$linha_tabelas_pessoa = siscontratDocs($linha_tabelas['IdProponente'],1);
$nome = $linha_tabelas_pessoa["Nome"];
$cpf = $linha_tabelas_pessoa["CPF"];

$setor = $linha_tabelas["Setor"];

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
  "<p><strong>Do processo nº:</strong> "."$NumeroProcesso"."</p>".
  "<p>&nbsp;</p>".
  "<p><strong>INTERESSADO:</strong> "."$nome"."  </span></p>".
  "<p><strong>ASSUNTO:</strong> "."$objeto"."  </p>".
  "<p>&nbsp;</p>".
  "<p><strong>CONTABILIDADE</strong></p>".
  "<p><strong>Sr(a). Responsável</strong></p>".
  "<p>&nbsp;</p>".
  "<p>AUTORIZO que os recursos da presente contratação, devem onerar a Nota de Reserva com Transferência de Recursos de SME nº 30.785 (documento SEI <a href='https://sei.prefeitura.sp.gov.br/sei/controlador.php?acao=protocolo_visualizar&id_protocolo=422349&infra_sistema=100000100&infra_unidade_atual=110002301&infra_hash=a4c309856585e315a7d0bca29d90ca6e6ec1b8958e05c7b62ee5bb59256f5e6f'>0394867</a> que consta no processo <a href='https://sei.prefeitura.sp.gov.br/sei/controlador.php?acao=protocolo_visualizar&id_protocolo=385739&infra_sistema=100000100&infra_unidade_atual=110002301&infra_hash=8ff805099a17d954f6da9121c8f1426b56dadd015973bfe99efa13386abe9592'>6025.2016/0001674-2</a> para realização da Virada Cultural 2016 nos CEUs).</p>".
  "<p>&nbsp;</p>".
  "<p> Valor: "."R$ $ValorGlobal"."  "."($ValorPorExtenso)"."</p>".
  "<p>&nbsp;</p>".
  "<p><strong>Detalhamento da ação:</strong> Virada Cultural 2016 – CEUs</p>".
  "<p>&nbsp;</p>".
  "<p>Após, enviar para SMC - Assessoria Jurídica para prosseguimento.</p>".
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