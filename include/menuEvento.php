	<div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Open Menu</button>
						<ul class="dl-menu">
							<li><a href="?perfil=evento&p=basica">Informações Gerais</a>
								
							</li>
							<li><a href="#">Serviços</a>	
								<ul class="dl-submenu">
									<li><a href="?perfil=evento&p=internos">Serviços Internos</a></li>
									<li><a href="?perfil=evento&p=externos">Serviços Externos</a></li>
									</ul>
							</li>
					
                            <li><a href="?perfil=evento&p=area">Espeficidades</a></li>

                            <?php if($_SESSION['subEvento'] == 1){ ?>
                            <li><a href="#">Sub-eventos</a>	
								<ul class="dl-submenu">
									<li><a href="?perfil=evento&p=subEvento&action=listar">Listar sub-eventos</a></li>
									<li><a href="?perfil=evento&p=subEvento&action=inserir">Inserir sub-evento</a> 
									</ul>
							</li>
                              
    						<?php } ?>
                            <?php if($_SESSION['cinema'] == 1){ ?>
                                <li><a href="?perfil=cinema">Módulo Cinema</a> 
    						<?php } ?>
                            <li><a href="?perfil=evento&p=arquivos">Arquivos Comunicação/Produção</a></li>
                            <li><a href="#">Ocorrências</a>
                             		<ul class="dl-submenu">
                                    	<li><a href="?perfil=evento&p=ocorrencias&action=listar">Listar ocorrências</a>
                                        <li><a href="?perfil=evento&p=ocorrencias&action=inserir">Inserir nova ocorrência</a></li>
                                    </ul>
                            </li>
                            <li><a href="?perfil=contratados">Contratados</a></li>

                            <li><a href="?perfil=evento&p=enviar">Enviar</a> </li>
 							<li><a href="#">Outras Opções</a> 
    
                                    <ul class="dl-submenu">
                                        <li><a href="?perfil=evento">Voltar </a></li>
										<li><a href="?secao=perfil">Carregar Módulos</a></li>
                                       <li><a href="?perfil=inicio">Voltar a Página Inicial</a></li>
                                        <li><a href="../include/logoff.php">Sair do Sistema</a></li>
                                    </ul>
                                </li>
                       </ul>
					</div><!-- /dl-menuwrapper -->
	</div>	
    