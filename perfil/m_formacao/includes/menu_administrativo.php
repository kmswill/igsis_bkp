<?php
//geram o insert pro framework da igsis
$pasta = "?perfil=formacao&p=administrativo&pag=";
 ?>
  <!-- Menu -->
<div class="menu-area">
	<div id="dl-menu" class="dl-menuwrapper">
		<button class="dl-trigger">Open Menu</button>
			<ul class="dl-menu">
				<li><a href="#">Cargo</a>
                	<ul class="dl-submenu">
                    	<li><a href="<?php echo $pasta ?>add_cargo">Cadastrar</a></li>
						<li><a href="<?php echo $pasta ?>list_cargo">Listar</a></li>
                    </ul>
                </li>
                <li><a href="#">Coordenadoria</a>
                	<ul class="dl-submenu">
                    	<li><a href="<?php echo $pasta ?>add_coordenadoria">Cadastrar</a></li>
						<li><a href="<?php echo $pasta ?>list_coordenadoria">Listar</a></li>
                    </ul>
                </li>
                <li><a href="#">Detalhes do Equipamento</a>
                	<ul class="dl-submenu">
                    	<li><a href="<?php echo $pasta ?>add_equipamento">Cadastrar</a></li>
						<li><a href="<?php echo $pasta ?>list_equipamento">Listar</a></li>
                    </ul>
                </li>
                <li><a href="#">Edital</a>
                	<ul class="dl-submenu">
                    	<li><a href="<?php echo $pasta ?>add_edital">Cadastrar</a></li>
						<li><a href="<?php echo $pasta ?>list_edital">Listar</a></li>
                    </ul>
                </li>
                <li><a href="#">Linguagem</a>
                	<ul class="dl-submenu">
                    	<li><a href="<?php echo $pasta ?>add_linguagem">Cadastrar</a></li>
						<li><a href="<?php echo $pasta ?>list_linguagem">Listar</a></li>
                    </ul>
                </li>
                <li><a href="#">Projeto</a>
                	<ul class="dl-submenu">
                    	<li><a href="<?php echo $pasta ?>add_projeto">Cadastrar</a></li>
						<li><a href="<?php echo $pasta ?>list_projeto">Listar</a></li>
                    </ul>
                </li>
                <li><a href="#">Subprefeitura</a>
                	<ul class="dl-submenu">
                    	<li><a href="<?php echo $pasta ?>add_subprefeitura">Cadastrar</a></li>
						<li><a href="<?php echo $pasta ?>list_subprefeitura">Listar</a></li>
                    </ul>
                </li>
                <li><a href="#">Vigência</a>
                	<ul class="dl-submenu">
                    	<li><a href="?perfil=formacao&p=frm_cadastra_vigencia&novo">Cadastrar</a></li>
						<li><a href="?perfil=formacao&p=frm_cadastra_vigencia&pag=lista">Listar</a></li>
                    </ul>
                </li>
                <li><a href="?perfil=formacao">Voltar ao módulo Formação</a></li>
			</ul>
	</div>
</div>	
<!-- Menu -->
