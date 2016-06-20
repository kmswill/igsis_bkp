<?php

//require '../include/';
   require_once("../funcoes/funcoesConecta.php");
   require_once("../funcoes/funcoesGerais.php");
   require_once("../funcoes/funcoesSiscontrat.php");

//CONEXÃO COM BANCO DE DADOS 
   $conexao = bancoMysqli();

//CONSULTA 
$id_ped=$_GET['id'];
$linha_tabelas = siscontrat($id_ped);
$pf = siscontratDocs($linha_tabelas['IdProponente'],1);

$codPed = $id_ped;
$objeto = $linha_tabelas["Objeto"];
$local = $linha_tabelas["Local"];
$ValorGlobal = $linha_tabelas["ValorGlobal"];
$ValorPorExtenso = valorPorExtenso($linha_tabelas["ValorGlobal"]); 
$periodo = $linha_tabelas["Periodo"];
$duracao = $linha_tabelas["Duracao"];
$dataAtual = date("d/m/Y");
$NumeroProcesso = $linha_tabelas["NumeroProcesso"];
$assinatura = $linha_tabelas["Assinatura"];
$cargo = $linha_tabelas["Cargo"];
$amparo = $linha_tabelas["AmparoLegal"];
$final = $linha_tabelas["Finalizacao"];
$complementoDotacao = $linha_tabelas["ComplementoDotacao"];

$Nome = $pf["Nome"];
$CPF = $pf["CPF"];

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
  "<p><strong>INTERESSADO:</strong> "."$Nome"."</span></p>".
  "<p><strong>ASSUNTO:</strong> "."$objeto"."  </p>".
  "<p>&nbsp;</p>".
  "<p><strong>".$setor."</strong></p>".
  "<p>Sr(a) Diretor(a)</p>".
  "<p>&nbsp;</p>".
  "<p>Trata-se de proposta de contratação de serviços de natureza artística para <strong>".$objeto."</strong> conforme parecer da Comissão de Atividades Artísticas e Culturais, que ratifica o pedido, sustentando que “o espetáculo é composto por profissionais consagrados pelo público e pela crítica especializada, estando o cachê proposto de acordo com os praticados no mercado e pagos por esta Secretaria para artistas do mesmo renome”, tendo em vista, vale dizer, os <strong>artigos 25, III e 26, §único, II e III da Lei Federal n° 8.666/93, c/c artigos 16 e 17 do Decreto Municipal n° 44.279/03.</strong></p>".
  "<p align='justify'>Assim sendo, pela competência, encaminhamos-lhe o presente para deliberação final de V.Sa., ressaltando que as certidões referentes à regularidade fiscal da contratada encontram-se em ordem.</p>".
  "<p>&nbsp;</p>". 
  "<p>&nbsp;</p>".
  "<p align='center'>São Paulo, ".$dataAtual."</p>".
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