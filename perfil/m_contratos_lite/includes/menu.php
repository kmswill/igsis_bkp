<?php
//geram o insert pro framework da igsis
$pasta = "?perfil=contratos_lite&p=";
$usuario = recuperaDados("ig_usuario",$_SESSION['idUsuario'],"idUsuario");
 ?>


<div class="menu-area">
  <div id="dl-menu" class="dl-menuwrapper">
	<button class="dl-trigger">Open Menu</button>
	<ul class="dl-menu">
        
		<li><a href="<?php echo $pasta ?>frm_busca">Contratos</a></li>
		<li><a href="<?php echo $pasta ?>frm_busca_periodo">Contratos por período</a></li>
  		<li style="color:white;">-------------------------</li>
        <li><a href="index.php?secao=perfil">Carregar módulos</a></li>
		<li><a href="<?php echo $pasta ?>ajuda">Ajuda</a></li>
		<li><a href="../index.php">Sair</a></li>
			</ul>
  </div>
</div>	
