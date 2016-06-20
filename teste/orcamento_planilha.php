<?php
require_once("../funcoes/funcoesVerifica.php");
require_once("../funcoes/funcoesSiscontrat.php");
require_once("../funcoes/funcoesFinanca.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

$con = bancoMysqli();

header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");

header ("Content-Description: PHP Generated Data" );


$idInstituicao = $_GET['id'];

echo "<table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td>Verba</td>
							<td>Pessoa Física</td>
							<td>Pessoa Jurídica</td>
							<td>Prêmio</td>
							<td>Total</td>
  							<td></td>
						</tr>
					</thead>
					<tbody>";

$idInstituicao = $_GET['id'];
$sql = "SELECT * FROM sis_verba WHERE idInstituicao = '$idInstituicao' AND pai IS NOT NULL" ;
$query = mysqli_query($con,$sql);
while($verba = mysqli_fetch_array($query)){
?>

<tr>

<td><?php echo $verba['Verba']; ?></td>
<td><?php echo dinheiroParaBr($verba['pf']); ?></td>
<td><?php echo dinheiroParaBr($verba['pj']); ?></td>
<td><?php echo dinheiroParaBr($verba['premio']); ?></td>

<td><?php echo dinheiroParaBr($verba['premio'] + $verba['pj'] + $verba['pf']) ; ?></td>
<td>

</tr>
	
    <?php } ?>
<tr>
<td>Total:</td>    
<td><?php echo dinheiroParaBr(somaVerba(5,"pf")) ?></td>    
<td><?php echo dinheiroParaBr(somaVerba(5,"pj"))?></td>    
<td><?php echo dinheiroParaBr(somaVerba(5,"premio"))?></td>    
<td><strong><?php echo dinheiroParaBr(somaVerba(5,"pf") + somaVerba(5,"pj") + somaVerba(5,"premio")); ?></strong></td>
</tr>					
					</tbody>
				</table>



</table>
?>