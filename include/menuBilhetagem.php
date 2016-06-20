	<div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Busca</button>
						<ul class="dl-menu">
   
	        
	         <?php if($_SESSION['idInstituicao'] == 5){ ?>
	           <li><a href="?perfil=bilhetagem&p=all" > Todos os eventos</a></li>      
				<?php } ?>
	               
							<li><a href="#">+ opções</a>   
                             <ul class="dl-submenu">
                                        <li selected><a href="?perfil=evento&p=basica">Início</a></li>
                                        <li><a href="?secao=perfil">Carregar módulo</a></li>
                                        <li><a href="../include/logoff.php">Sair</a></li>
                                    </ul>
                            </li>   
						</ul>
					</div><!-- /dl-menuwrapper -->
	</div>	