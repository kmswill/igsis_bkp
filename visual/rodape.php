

	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
                <p><?php geraFrase(); ?></p>
					<p>2016 @ Informações Gerais CCSP + Siscontrat DEC / Secretaria Municipal de Cultura / Prefeitura de São Paulo</p>
				</div>
				<div class="col-md-12">
					<?php
if($_SESSION['perfil'] == 1){
echo "<strong>SESSION</strong><pre>", var_dump($_SESSION), "</pre>";
echo "<strong>POST</strong><pre>", var_dump($_POST), "</pre>";
echo "<strong>GET</strong><pre>", var_dump($_GET), "</pre>";
echo "<strong>SERVER</strong><pre>", var_dump($_SERVER), "</pre>";
echo "<strong>FILES</strong><pre>", var_dump($_FILES), "</pre>";

echo ini_get('session.gc_maxlifetime')/60; // em minutos
}

?>
				</div>
			</div>		
		</div>	
	</footer>
	 
	 <!-- js -->
    <!--<script src="js/jquery.js"></script>-->
    
    <?php 
	if(isset($_GET['perfil'])){
	$modulo = recuperaDados("ig_modulo",$_GET['perfil'],"pag");
	
	?>
    	<script>
	var enter = new Date();
	
	$(document).ready(function() {
		var load = (new Date()).getTime() - enter.getTime();
		$('#doc').text('- Você está no Módulo <?php echo $modulo['nome'] ?>');
	});
	
	<?php } ?>

	</script>
    
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.smooth-scroll.min.js"></script>
	<script src="js/jquery.dlmenu.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/custom.js"></script>
  	</body>
