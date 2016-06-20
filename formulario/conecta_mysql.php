<?php
// Conecta-se com o MySQL 
mysql_connect("dbmy0010.whservidor.com", "tvcatchup_42", "lic54eca"); 
// Converte caracteres utf8 para evitar erros no banco
mysql_query("SET NAMES 'utf8';");
// Seleciona banco de dados 
mysql_select_db("tvcatchup_42"); 

?>
