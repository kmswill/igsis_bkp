<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Formulário enviado!</title>
<link rel="stylesheet" href="jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="igccsp.css">

<script type="text/javascript" src="js/dalert.jquery.js"></script>
<!-- Inclusão do Jquery -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" ></script>
<!-- Inclusão do Jquery Validate -->
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.6/jquery.validate.js" ></script>
<!--<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>-->


</head>

<body>
	<div class = "center">
      


    	    <div id = "logo"><img src="img/logo.png" /></div>
    	<!-- Início: Caixa -->
    	
    	<div id="caixa">
<?php
require 'conecta_mysql.php';
@ini_set('display_errors', '1');
error_reporting(E_ALL);

$pg01_evento = addslashes(htmlentities($_POST['pg01_evento']));
$pg02_autor = addslashes(htmlentities($_POST['pg02_autor']));
$pg02_ficha = addslashes(htmlentities($_POST['pg02_ficha']));
$pg02_etaria = $_POST['pg02_etaria'];
$pg02_duracao = $_POST['pg02_duracao'];
$pg03_sinopse = addslashes(htmlentities($_POST['pg03_sinopse']));
$pg03_release = addslashes(htmlentities($_POST['pg03_release']));
$pg04_resp_externo = $_POST['pg04_resp_externo'];
$pg04_tel = $_POST['pg04_tel'];
$pg04_email = $_POST['pg04_email'];
$pg04_carros = addslashes(htmlentities($_POST['pg04_carros']));
$pg04_equipe = addslashes(htmlentities($_POST['pg04_equipe']));
$tipo_pessoa01 = $_POST['tipo_pessoa01'];
$cpf_cnpj01 = $_POST['cpf_cnpj01'];
$nome01 = $_POST['nome01'];
$representante01 = $_POST['representante01'];
$rg01 = $_POST['rg01'];
$cpf_representante01 = $_POST['cpf_representante01'];
$atividade01 = $_POST['atividade01'];
$email01 = $_POST['email01'];
$telefone01 = $_POST['telefone01'];
$endereco01 = addslashes(htmlentities($_POST['endereco01']));
$agencia01 = $_POST['agencia01'];
$conta01 =$_POST['conta01'];
$instituicao =$_POST['instituicao'];

$insert = "INSERT INTO `ig_formulario` (`id`, `pg01_evento`, `pg02_autor`, `pg02_ficha`, `pg02_etaria`, `pg02_duracao`, `pg03_sinopse`, `pg03_release`, `pg04_resp_externo`, `pg04_tel`, `pg04_email`, `pg04_carros`, `pg04_equipe`, `tipo_pessoa01`, `cpf_cnpj01`, `nome01`, `representante01`, `rg01`, `cpf_representante01`, `atividade01`, `email01`, `telefone01`, `endereco01`, `valor01`, `agencia01`, `conta01`, `instituicao`) VALUES (NULL, '$pg01_evento', '$pg02_autor', '$pg02_ficha', '$pg02_etaria', '$pg02_duracao', '$pg03_sinopse', '$pg03_release', '$pg04_resp_externo', '$pg04_tel', '$pg04_email', '$pg04_carros', '$pg04_equipe', '$tipo_pessoa01', '$cpf_cnpj01', '$nome01', '$representante01', '$rg01', '$cpf_representante01', '$atividade01', '$email01', '$telefone01', '$endereco01', NULL, '$agencia01', '$instituicao')";

if(mysql_query($insert)){
	$sql_ultimo = "SELECT * FROM ig_formulario ORDER BY id DESC LIMIT 1";
	$id_evento = mysql_query($sql_ultimo);
	$id = mysql_fetch_array($id_evento);
	$evento = $id['id'];

	echo "Formulário enviado com sucesso. O protocolo gerado é <b>".$evento."</b>. Informe este número ao responsável com o qual está em contato.<br /><br />";
	
	}else{
	
	echo "Erro ao enviar o formulário. Tente novamente. ";
		
	}
	

?>




<?php 

// DEFINIÇÕES 
// Numero de campos de upload 
$numeroCampos = 10; 
// Tamanho máximo do arquivo (em bytes) 
$tamanhoMaximo = 1000000; 
// Extensões aceitas 
$extensoes = array(".doc", ".txt", ".pdf", ".docx",".jpg",".zip",".rar"); 
// Caminho para onde o arquivo será enviado 
$caminho = "uploads/"; 
// Substituir arquivo já existente (true = sim; false = nao) 
$substituir = false;   
for ($i = 0; $i < $numeroCampos; $i++) {   
// Informações do arquivo enviado 
$nomeArquivo = $_FILES["arquivo"]["name"][$i]; 
$tamanhoArquivo = $_FILES["arquivo"]["size"][$i]; 
$nomeTemporario = $_FILES["arquivo"]["tmp_name"][$i];   
// Verifica se o arquivo foi colocado no campo 
if (!empty($nomeArquivo)) {   $erro = false;   
// Verifica se o tamanho do arquivo é maior que o permitido 
if ($tamanhoArquivo > $tamanhoMaximo) { 
	$erro = "O arquivo " . $nomeArquivo . " não deve ultrapassar " . $tamanhoMaximo. " bytes"; 
	} 
// Verifica se a extensão está entre as aceitas 
elseif (!in_array(strrchr($nomeArquivo, "."), $extensoes)) {
	 $erro = "A extensão do arquivo <b>" . $nomeArquivo . "</b> não é válida"; } 
 // Verifica se o arquivo existe e se é para substituir 
 elseif (file_exists($caminho . $nomeArquivo) and !$substituir) {
	  $erro = "O arquivo <b>" . $nomeArquivo . "</b> já existe"; }   
  // Se não houver erro 
  if (!$erro) { // Move o arquivo para o caminho definido 
  move_uploaded_file($nomeTemporario, ($caminho . $nomeArquivo)); 
  // Mensagem de sucesso 
  $query_arquivos = "INSERT INTO `ig_form_arquivos` (`id_arquivos`, `nome`, `evento_id`) VALUES (NULL, '$nomeArquivo', '$evento');";
  mysql_query($query_arquivos);
  echo $evento;

  echo "O arquivo <b>".$nomeArquivo."</b> foi enviado com sucesso. <br />"; 
  } 

  
  // Se houver erro 
  else { 
  // Mensagem de erro 
  echo $erro . "<br />"; } } }
  
   ?> 
   

</div>
        <? include "rodape.php"; 
		mysql_close();
		?>  
</div>
</body>
</html>