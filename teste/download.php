<?php
   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 	
	
	require_once("../funcoes/funcoesVerifica.php");
	require_once("../funcoes/funcoesSiscontrat.php");
	require_once("../funcoes/funcoesFinanca.php");
	require_once("../funcoes/funcoesConecta.php");
	require_once("../funcoes/funcoesGerais.php");

	$diretorio = "/var/www/igsis/uploads/";

	$id = $_GET['idEvento'];

$con = bancoMysqli();	
	
 // Instancia a Classe Zip
 $zip = new ZipArchive();
  // Cria o Arquivo Zip, caso não consiga exibe mensagem de erro e finaliza script
  if($zip->open('nome_arquivo_zip.zip', ZIPARCHIVE::CREATE) == TRUE)
  {
   // Insere os arquivos que devem conter no arquivo zip
   
	$sql = "SELECT * ig_arquivo WHERE ig_evento_idEvento = '$id' AND publicado ='1'";
	$query = mysqli_query($con, $sql);
	if($query){
	while($arquivo = mysqli_fetch_array($query)){
   $zip->addFile($diretorio.$arquivo['arquivo'],$arquivo['arquivo']);
	}
	}
	
 }
   echo 'Arquivo criado com sucesso.';
  }
  else
  {
   exit('O Arquivo não pode ser criado.');
  }

  // Fecha arquivo Zip aberto
  $zip->close();
?>