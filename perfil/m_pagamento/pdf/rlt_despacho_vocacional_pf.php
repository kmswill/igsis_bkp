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
$linha_tabelas = siscontrat($id_ped);

$codPed = $id_ped;
$objeto = $linha_tabelas["Objeto"];
$local = $linha_tabelas["Local"];
$carga = $linha_tabelas["CargaHoraria"];
$ValorGlobal = $linha_tabelas["ValorGlobal"];
$ValorPorExtenso = valorPorExtenso($linha_tabelas["ValorGlobal"]); 
$periodo = $linha_tabelas["Periodo"];
$duracao = $linha_tabelas["Duracao"];
$dataAtual = date("d/m/Y");
$NumeroProcesso = $linha_tabelas["NumeroProcesso"];
$FormaPagamento = $linha_tabelas["FormaPagamento"];
$assinatura = $linha_tabelas["Assinatura"];
$cargo = $linha_tabelas["Cargo"];
$amparo = nl2br($linha_tabelas["AmparoLegal"]);
$final = nl2br($linha_tabelas["Finalizacao"]);
$dotacao = $linha_tabelas["ComplementoDotacao"];

$linha_tabelas_pessoa = siscontratDocs($linha_tabelas['IdProponente'],1);
$nome = $linha_tabelas_pessoa["Nome"];
$cpf = $linha_tabelas_pessoa["CPF"];

$setor = $linha_tabelas["Setor"];

$ano=date('Y');

$id = $linha_tabelas['idEvento'];
$ocor = listaOcorrenciasContrato($id);
$tudo = "";

for($i = 0; $i < $ocor['numero']; $i++)
	{
	$dia = $ocor[$i]['data'];
	$hour = $ocor[$i]['hora'];
	$lugar = $ocor[$i]['espaco'];
	$tudo = $tudo . $ocor[$i]['espaco']."<br>" . $ocor[$i]['data']. " às ". $ocor[$i]['hora']."<br>"."<br>";
	}
	
  
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
  "<p>&nbsp;</p>".
  "<p align='justify'>"."$amparo"."</p>".
  "<p>&nbsp;</p>".
  "<p><strong>Contratado:</strong> "."$nome".", CPF ("."$cpf".")</p>".
  "<p><strong>Objeto:</strong> "."$objeto"."</p>".
  "<p><strong>Data / Período:</strong> "."$periodo"."</p>".
  "<p><strong>Locais:</strong> ".$local."</p>".
  "<p><strong>Carga Horária:</strong> ".$carga."</p>".
  "<p><strong> Valor:</strong> "."R$ $ValorGlobal"."  "."($ValorPorExtenso)"."</p>".
  "<p><strong>Forma de Pagamento:</strong> "."$FormaPagamento"."</p>".
  "<p><strong>Dotação Orçamentária:</strong> "."$dotacao"."</p>".
  "<p>&nbsp;</p>".
  "<p align='justify'>"."$final"."</p>".
  "<p>&nbsp;</p>".
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