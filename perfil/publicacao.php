<?php
//include para publicação

if(isset($_GET['p'])){
	$p = $_GET['p'];	
}else{
	$p = "index";
	}
include "../funcoes/funcoesSiscontrat.php";
include "../funcoes/funcoesFormacao.php";	
include "m_publicacao/".$p.".php";


 ?>

