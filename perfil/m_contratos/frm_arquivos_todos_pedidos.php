<?php

//   @ini_set('display_errors', '1');
//	error_reporting(E_ALL); 
require "../../funcoes/funcoesGerais.php";
require_once "../../funcoes/funcoesConecta.php";
$path = "../../uploadsdocs/";
$con = bancoMysqli();
//$con = bancoMysqli();

$data = date('YmdHis');
//$nome_arquivo = $data."_igsis.zip";
$nome_arquivo = $data.".zip";

$zip = new ZipArchive();
 
if( $zip->open( $nome_arquivo , ZipArchive::CREATE )  === true){
     
   $idPedido = $_GET['idPedido'];



// arquivos do pedido
$sql = "SELECT * FROM igsis_arquivos_pedidos WHERE idPedido = '$idPedido' AND publicado = '1'";
$query = mysqli_query($con,$sql);

if(isset($_GET['all'])){
// arquivos da pessoa
$pedido = recuperaDados("igsis_pedido_contratacao",$idPedido,"idPedidoContratacao");
$idPessoa = $pedido['idPessoa'];
$tipo = $pedido['tipoPessoa'];
$sql_pessoa = "SELECT * FROM igsis_arquivos_pessoa WHERE idPessoa = '$idPessoa' AND idTipoPessoa = '$tipo' AND publicado = '1'";
$query_pessoa = mysqli_query($con,$sql_pessoa);

//se existir um executante
	if($pedido['IdExecutante'] != "" OR $pedido['IdExecutante'] != NULL){
		$idExec = $pedido['IdExecutante'];
		$sql_exec = "SELECT * FROM igsis_arquivos_pessoa WHERE idPessoa = '$idExec' AND idTipoPessoa = '1' AND publicado = '1'";
		$query_exec = mysqli_query($con,$sql_exec);
	
	}

	if($pedido['idRepresentante01'] != 0 OR $pedido['idRepresentante01'] != NULL){
		$idRep01 =  $pedido['idRepresentante01'];
		$sql_rep01 = "SELECT * FROM igsis_arquivos_pessoa WHERE idPessoa = '$idRep01' AND idTipoPessoa = '3' AND publicado = '1'";
		$query_rep01 = mysqli_query($con,$sql_rep01);
	
	}

	if($pedido['idRepresentante02'] != 0 OR $pedido['idRepresentante02'] != NULL){ 
		$idRep02 = $pedido['idRepresentante02'];
		$sql_rep02 = "SELECT * FROM igsis_arquivos_pessoa WHERE idPessoa = '$idRep02' AND idTipoPessoa = '3' AND publicado = '1'";
		$query_rep02 = mysqli_query($con,$sql_rep02);
	
	}


}
    // Criando um diretorio chamado "teste" dentro do pacote
    //$z->addEmptyDir('teste');

    // Criando um TXT dentro do diretorio "teste" a partir do valor de uma string
    //$z->addFromString('teste/texto.txt', 'Conteúdo do arquivo de Texto');

    // Criando outro TXT dentro do diretorio "teste"
    //$z->addFromString('teste/outro.txt', 'Outro arquivo');

    // Copiando um arquivo do HD para o diretorio "teste" do pacote
	while($arquivo = mysqli_fetch_array($query)){
		$file = $path.$arquivo['arquivo'];
		$file2 = $arquivo['arquivo'];
    	$zip->addFile($file, "pedido/".$file2);
		//$z->renameName($file2, substr($file2,15));
	}
if(isset($_GET['all'])){	
	while($arquivo = mysqli_fetch_array($query_pessoa)){
		$file = $path.$arquivo['arquivo'];
		$file2 = $arquivo['arquivo'];
    	$zip->addFile($file, "pessoa/".$file2);
		//$z->renameName($file2, substr($file2,15));
	}
}

if($pedido['IdExecutante'] != "" OR $pedido['IdExecutante'] != NULL){
	while($arquivo = mysqli_fetch_array($query_exec)){
		$file = $path.$arquivo['arquivo'];
		$file2 = $arquivo['arquivo'];
    	$zip->addFile($file, "executante/".$file2);
		//$z->renameName($file2, substr($file2,15));
	}
}


	if($pedido['idRepresentante01'] != 0 OR $pedido['idRepresentante01'] != NULL){
	while($arquivo = mysqli_fetch_array($query_rep01)){
		$file = $path.$arquivo['arquivo'];
		$file2 = $arquivo['arquivo'];
    	$zip->addFile($file, "rep01/".$file2);
		//$z->renameName($file2, substr($file2,15));
	}
	}
	if($pedido['idRepresentante02'] != 0 OR $pedido['idRepresentante02'] != NULL){
	while($arquivo = mysqli_fetch_array($query_rep02)){
		$file = $path.$arquivo['arquivo'];
		$file2 = $arquivo['arquivo'];
    	$zip->addFile($file, "rep02/".$file2);
		//$z->renameName($file2, substr($file2,15));
	}
	
}

    // Apagando o segundo TXT
    //$z->deleteName('teste/outro.txt');

    // Salvando o arquivo
	//*/
    //$z->close();

     
        
    $zip->close();
}

//ob_start();

/*
 // Criando o objeto
$z = new ZipArchive();

// Criando o pacote chamado "teste.zip"
$criou = $z->open($nome_arquivo, ZipArchive::CREATE);
if ($criou === true) {
/*
$idPedido = $_GET['idPedido'];



// arquivos do pedido
$sql = "SELECT * FROM igsis_arquivos_pedidos WHERE idPedido = '$idPedido' AND publicado = '1'";
$query = mysqli_query($con,$sql);

if(isset($_GET['all'])){
// arquivos da pessoa
$pedido = recuperaDados("igsis_pedido_contratacao",$idPedido,"idPedidoContratacao");
$idPessoa = $pedido['idPessoa'];
$tipo = $pedido['tipoPessoa'];
$sql_pessoa = "SELECT * FROM igsis_arquivos_pessoa WHERE idPessoa = '$idPessoa' AND idTipoPessoa = '$tipo' AND publicado = '1'";
$query_pessoa = mysqli_query($con,$sql_pessoa);

//se existir um executante
	if($pedido['IdExecutante'] != "" OR $pedido['IdExecutante'] != NULL){
		$idExec = $pedido['IdExecutante'];
		$sql_exec = "SELECT * FROM igsis_arquivos_pessoa WHERE idPessoa = '$idExec' AND idTipoPessoa = '1' AND publicado = '1'";
		$query_exec = mysqli_query($con,$sql_exec);
	
	}

	if($pedido['idRepresentante01'] != 0 OR $pedido['idRepresentante01'] != NULL){
		$idRep01 =  $pedido['idRepresentante01'];
		$sql_rep01 = "SELECT * FROM igsis_arquivos_pessoa WHERE idPessoa = '$idRep01' AND idTipoPessoa = '3' AND publicado = '1'";
		$query_rep01 = mysqli_query($con,$sql_rep01);
	
	}

	if($pedido['idRepresentante02'] != 0 OR $pedido['idRepresentante02'] != NULL){ 
		$idRep02 = $pedido['idRepresentante02'];
		$sql_rep02 = "SELECT * FROM igsis_arquivos_pessoa WHERE idPessoa = '$idRep02' AND idTipoPessoa = '3' AND publicado = '1'";
		$query_rep02 = mysqli_query($con,$sql_rep02);
	
	}


}
    // Criando um diretorio chamado "teste" dentro do pacote
    //$z->addEmptyDir('teste');

    // Criando um TXT dentro do diretorio "teste" a partir do valor de uma string
    //$z->addFromString('teste/texto.txt', 'Conteúdo do arquivo de Texto');

    // Criando outro TXT dentro do diretorio "teste"
    //$z->addFromString('teste/outro.txt', 'Outro arquivo');

    // Copiando um arquivo do HD para o diretorio "teste" do pacote
	while($arquivo = mysqli_fetch_array($query)){
		$file = $path.$arquivo['arquivo'];
		$file2 = $arquivo['arquivo'];
    	$z->addFile($file, $file2);
		//$z->renameName($file2, substr($file2,15));
	}
if(isset($_GET['all'])){	
	while($arquivo = mysqli_fetch_array($query_pessoa)){
		$file = $path.$arquivo['arquivo'];
		$file2 = $arquivo['arquivo'];
    	$z->addFile($file, $file2);
		//$z->renameName($file2, substr($file2,15));
	}
}

if($pedido['IdExecutante'] != "" OR $pedido['IdExecutante'] != NULL){
	while($arquivo = mysqli_fetch_array($query_exec)){
		$file = $path.$arquivo['arquivo'];
		$file2 = $arquivo['arquivo'];
    	$z->addFile($file, $file2);
		//$z->renameName($file2, substr($file2,15));
	}
}


	if($pedido['idRepresentante01'] != 0 OR $pedido['idRepresentante01'] != NULL){
	while($arquivo = mysqli_fetch_array($query_rep01)){
		$file = $path.$arquivo['arquivo'];
		$file2 = $arquivo['arquivo'];
    	$z->addFile($file, $file2);
		//$z->renameName($file2, substr($file2,15));
	}
	}
	if($pedido['idRepresentante02'] != 0 OR $pedido['idRepresentante02'] != NULL){
	while($arquivo = mysqli_fetch_array($query_rep02)){
		$file = $path.$arquivo['arquivo'];
		$file2 = $arquivo['arquivo'];
    	$z->addFile($file, $file2);
		//$z->renameName($file2, substr($file2,15));
	}
	
}

    // Apagando o segundo TXT
    //$z->deleteName('teste/outro.txt');

    // Salvando o arquivo
	*/
    //$z->close();
	
	
	//SETANDO OS HEADERS NECESSARIOS
// Enviando para o cliente fazer download
// Configuramos os headers que serão enviados para o browser

header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename="'.$nome_arquivo.'"');
header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($nome_arquivo));
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Expires: 0');

// Envia o arquivo para o cliente
//echo $nome_arquivo;
ob_end_clean(); //essas duas linhas antes do readfile
flush();

readfile($nome_arquivo);
	
	//ABRINDO O ARQUIVO 

?>