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
$pj = siscontratDocs($linha_tabelas['IdProponente'],2);
$ex = siscontratDocs($linha_tabelas['IdExecutante'],1);
$rep01 = siscontratDocs($pj['Representante01'],3);
$rep02 = siscontratDocs($pj['Representante02'],3);

$setor = $linha_tabelas["Setor"];

$ano=date('Y');

$codPed = $id_ped;
$objeto = $linha_tabelas["Objeto"];
$local = $linha_tabelas["LocalJuridico"];
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
$complementoDotacao = $linha_tabelas["ComplementoDotacao"];

//PessoaJuridica

$pjRazaoSocial = $pj["Nome"];
$pjEndereco = $pj["Endereco"];
$pjTelefones = $pj["Telefones"];
$pjEmail = $pj["Email"];
$pjINSS = $pj["INSS"];
$pjCNPJ = $pj['CNPJ'];


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
$rep01EstadoCivil = $rep01["EstadoCivil"];
$rep01Nacionalidade = $rep01["Nacionalidade"];
$rep01RG = $rep01["RG"];
$rep01CPF = $rep01["CPF"];


// Representante02
$rep02Nome = $rep02["Nome"];
$rep02EstadoCivil = $rep02["EstadoCivil"];
$rep02Nacionalidade = $rep02["Nacionalidade"];
$rep02RG = $rep02["RG"];
$rep02CPF = $rep02["CPF"];

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
  "<p><strong>Contratado:</strong> ".$exNome." (CPF ".$exCPF."), nome artístico ´´".$exNomeArtistico."´´ e demais integrantes relacionados na declaração de exclusividade , por intermédio de ".$pjRazaoSocial.", CNPJ ("."$pjCNPJ"."), legalmente representada por ".$rep01Nome." CPF (".$rep01CPF.").</p>".
  "<p><strong>Objeto:</strong> "."$objeto"."</p>".
  "<p><strong>Data / Período:</strong> "."$periodo"." - conforme cronograma</p>".
  "<p><br><strong>Locais e Horários:</strong><br><br> ".$tudo."</p>".
  "<p><strong>Valor:</strong> "."R$ $ValorGlobal"."  "."($ValorPorExtenso )"."</p>".
  "<p><strong>Forma de Pagamento:</strong> "."$FormaPagamento"."</p>".
  "<p><strong>Dotação Orçamentária:</strong> "."$complementoDotacao"."</p>".
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