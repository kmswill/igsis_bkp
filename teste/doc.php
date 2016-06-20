<?php
ob_start();
header('Content-type: application/msword');
header('Content-Disposition: inline, filename=PHPBrasil.rtf');

$filename='PHPBrasil.rtf';
$fp=fopen($filename,'r');

$output=fread($fp,filesize($filename));

fclose($fp);
$nome='Diogo Gomes';
$codigo='php0001';
$data=date("d/m/Y");

$output=str_replace('=nome=',$nome,$output);
$output=str_replace('=codigo=',$codigo,$output);
$output=str_replace('=mm/dd/yyyy=',$data,$output);

echo $output;

?>