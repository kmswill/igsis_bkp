<?php
$con = bancoMysqli();
if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p = 'inicio';	
}
?>

<?php switch($p){
case 'inicio': 

?>
	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h4>CADASTRO DE CONTRATAÇÃO ARTÍSTICA</h4>

<h4></h4>
<p class="left">Olá!</p>
<div class="left">

				<p>Este formulário viabilizará a contratação artística e a divulgação para o evento que você realizará no Centro Cultural São Paulo. Por favor, preencha atentamente todos os campos, que estão divididos em:</p><br />
			  <p>	+ EVENTO: são as informações básicas do seu evento como ficha técnica, duração, sinopse, etc. Pedimos que esteja atento às especificações de conteúdo, como limite de caracteres, e que procure ser o mais claro e objetivo possível, considerando que as informações circularão para um público bastante amplo, não necessariamente especializado em sua área.</p><br />
				<p>+ CONTRATO: são as informações contratuais, como documentos, contatos e dados bancários * </p><br />
				  
				<p>+ ANEXO: nesse espaço você pode nos enviar arquivos como o rider, mapas de cenas e luz, logos de parceiros e imagens para a divulgação de seu evento, com tamanho máximo de 15MB.</p><br />
				 <p>  Após preencher, você deve clicar em Enviar > Enviar. Você receberá um número de protocolo, que deve ser enviado por email ao Curador do CCSP com quem você está em contato. Depois, basta aguardar a confirmação de recebimento do Curador.</p><br />
				 <p>Bom trabalho e seja bem-vindo ao CCSP!</p><br />
               
<p>* Para agilizar sua contratação, você pode adiantar e enviar como anexo deste formulário a seguinte documentação:</p><br />

<p><strong>Pessoa física</strong></p><br />

<p><em>CPF: </em><br />
  <a href="http://www.receita.fazenda.gov.br/Aplicacoes/ATCTA/CPF/ConsultaPublica.asp" target="_blank">http://www.receita.fazenda.gov.br/Aplicacoes/ATCTA/CPF/ConsultaPublica.asp</a></p><br />

<p><em>CCM</em> (verifica-se se a pessoa é inscrita no CCM): <br />
  <a href="http://www7.prefeitura.sp.gov.br/fdc/fdc_imp01.asp" target="_blank">http://www7.prefeitura.sp.gov.br/fdc/fdc_imp01.asp</a></p><br />

<p><em>Tributos Mobiliários</em> (caso seja inscrita no CCM):<br />
  <a href="http://www.prefeitura.sp.gov.br/cidade/secretarias/financas/servicos/certidoes/index.php?p=2394" target="_blank">http://www.prefeitura.sp.gov.br/cidade/secretarias/financas/servicos/certidoes/index.php?p=2394</a></p><br />

<p><em>CADIM</em>: <br />
  <a href="http://www3.prefeitura.sp.gov.br/cadin/Pesq_Deb.aspx" target="_blank">http://www3.prefeitura.sp.gov.br/cadin/Pesq_Deb.aspx</a></p><br />
 

<p><strong>Pessoa jurídica</strong></p><br />

<p><em>CND</em>:<br />
  <a href="http://www010.dataprev.gov.br/cws/contexto/cnd/cnd.html" target="_blank">http://www010.dataprev.gov.br/cws/contexto/cnd/cnd.html</a></p><br />

<p><em>CRF do FGTS</em>: <br />
  <a href="https://www.sifge.caixa.gov.br/Cidadao/Crf/FgeCfSCriteriosPesquisa.asp" target="_blank">https://www.sifge.caixa.gov.br/Cidadao/Crf/FgeCfSCriteriosPesquisa.asp</a></p><br />

<p><em>Tributos Mobiliários</em>:<br />
  <a href="http://www.prefeitura.sp.gov.br/cidade/secretarias/financas/servicos/certidoes/index.php?p=2394" target="_blank">http://www.prefeitura.sp.gov.br/cidade/secretarias/financas/servicos/certidoes/index.php?p=2394</a></p><br />

<p><em>CADIM</em>: <br />
  <a href="http://www3.prefeitura.sp.gov.br/cadin/Pesq_Deb.aspx" target="_blank">http://www3.prefeitura.sp.gov.br/cadin/Pesq_Deb.aspx</a></p><br />




</div>
<br />
<br />


					</div>
				  </div>
			  </div>
			         <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="?p=evento" class="btn btn-theme btn-lg btn-block">Iniciar o formulário</a>
            </div>
          </div> 
		</div>
	</section>
  <?php 
  break;
  case "evento":
  
  ?>
  	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>EVENTO</h3>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=contratados&p=lista" method="post">
				  
			  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome do evento</strong><br/>
					  <input type="text" class="form-control" id="RazaoSocial" name="RazaoSocial" placeholder="RazaoSocial" >
					</div>
				  </div>

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Artista, banda, grupo, companhia, etc</strong><br/>
					  <input type="text" class="form-control" id="RazaoSocial" name="RazaoSocial" placeholder="RazaoSocial" >
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Ficha técnica completa:</strong><br/>
					 <textarea name="Observacao" class="form-control" rows="10" placeholder="Dramaturgos, músicos, elenco, técnicos, etc"></textarea>
					</div>
				  </div>
			  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Classificação etária:</strong><br/>
					  <select class="form-control" id="IdRepresentanteLegal1" name="IdRepresentanteLegal1" >
					<option>Teste 1</option>
					<option>Teste 1</option>
					<option>Teste 1</option>

					  </select>
					</div>
				
					<div class=" col-md-6"><strong>Duração do evento em minutos:</strong><br/>
					<input type="text" class="form-control" id="CNPJ" name="CNPJ" placeholder="CNPJ" >
					</div>
				  </div>  
                  				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Sinopse (limite máximo de 600 caracteres/ uso na divulgação):</strong><br/>
					 <textarea name="Observacao" class="form-control" rows="10" placeholder="Dramaturgos, músicos, elenco, técnicos, etc"></textarea>
					</div>
				  </div>
                  
                                  				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Release (limite máximo de 4000 caracteres):</strong><br/>
					 <textarea name="Observacao" class="form-control" rows="10" placeholder="Dramaturgos, músicos, elenco, técnicos, etc"></textarea>
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Produtor do evento</strong><br/>
					  <input type="text" class="form-control" id="RazaoSocial" name="RazaoSocial" placeholder="RazaoSocial" >
					</div>
				  </div>
                                                    				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone:</strong><br/>
					  <input type="text" class="form-control" id="CNPJ" name="CNPJ" placeholder="CNPJ" >
					</div>
					<div class="col-md-6"><strong>E-mail:</strong><br/>
					  <input type="text" class="form-control" id="CCM" name="CCM" placeholder="CCM" >
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Equipe (Nome completo, RG):</strong><br/>
					 <textarea name="Observacao" class="form-control" rows="10" placeholder="Dramaturgos, músicos, elenco, técnicos, etc"></textarea>
					</div>
				  </div>
				  
				  
				<!-- Botão Gravar -->	
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                     <input type="hidden" name="cadastrarJuridica" value="1" />
					 <input type="image" alt="GRAVAR" value="submit" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
				</form>
	        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="?p=contrato" class="btn btn-theme btn-lg btn-block">Inserir dados de contratação =></a>
            </div>
          </div> 
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  



  <?php 
  break;
  case "contrato":
  
  ?>
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<div class="sub-title">CADASTRO DE PESSOA JURÍDICA</div>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=contratados&p=lista" method="post">
				  
			  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Razão Social:</strong><br/>
					  <input type="text" class="form-control" id="RazaoSocial" name="RazaoSocial" placeholder="RazaoSocial" >
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>CNPJ:</strong><br/>
					  <input type="text" class="form-control" id="CNPJ" name="CNPJ" placeholder="CNPJ" >
					</div>
					<div class="col-md-6"><strong>CCM:</strong><br/>
					  <input type="text" class="form-control" id="CCM" name="CCM" placeholder="CCM" >
					</div>
				  </div>
				  
				  <div class="form-group">
                  					<div class="col-md-offset-2 col-md-6"><strong>CEP *:</strong><br/>
					  <input type="text" class="form-control" id="CEP" name="CEP" placeholder="Bairro">
					</div>				  
					<div class=" col-md-6"><strong>Estado *:</strong><br/>
					  <input type="text" class="form-control" id="Estado" name="Estado" placeholder="Estado">
					</div>

				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Endereço *:</strong><br/>
					  <input type="text" class="form-control" id="Endereco" name="Endereco" placeholder="Endereço">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
					  <input type="text" class="form-control" id="Numero" name="Numero" placeholder="Numero">
					</div>				  
					<div class=" col-md-6"><strong>Complemento:</strong><br/>
					  <input type="text" class="form-control" id="Complemento" name="Complemento" placeholder="Complemento">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Bairro *:</strong><br/>
					  <input type="text" class="form-control" id="Bairro" name="Bairro" placeholder="Bairro">
					</div>				  
					<div class=" col-md-6"><strong>Cidade *:</strong><br/>
					  <input type="text" class="form-control" id="Cidade" name="Cidade" placeholder="Cidade">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone:</strong><br/>
					  <input type="text" class="form-control" id="Telefone1" name="Telefone1" placeholder="Telefone">
					</div>				  
					<div class=" col-md-6"><strong>Telefone:</strong><br/>
					  <input type="text" class="form-control" id="Telefone2" name="Telefone2" placeholder="Telefone" >
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone:</strong><br/>
					  <input type="text" class="form-control" id="Telefone3" name="Telefone3" placeholder="Telefone">
					</div>				  
					<div class=" col-md-6"><strong>E-mail:</strong><br/>
					  <input type="text" class="form-control" id="Email" name="Email" placeholder="E-mail">
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Representante Legal #1:</strong><br/>
					  <select class="form-control" id="IdRepresentanteLegal1" name="IdRepresentanteLegal1" >
					<?php geraOpcaoLegal($_SESSION['idEvento']); ?>
					  </select>
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Representante Legal #2:</strong><br/>
					  <select class="form-control" id="IdRepresentanteLegal2" name="IdRepresentanteLegal2">
					<?php geraOpcaoLegal($_SESSION['idEvento']); ?>
					  </select>
					</div>
				  </div>
		  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observações:</strong><br/>
					 <textarea name="Observacao" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>
				  
				  
				<!-- Botão Gravar -->	
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                     <input type="hidden" name="cadastrarJuridica" value="1" />
					 <input type="image" alt="GRAVAR" value="submit" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
				</form>
	        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="?p=evento" class="btn btn-theme btn-lg btn-block"><= Voltar a edição do evento</a>
            </div>
          </div> 	       
	        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	           <br />
            </div>
          </div> 	
           <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="?p=contrato" class="btn btn-theme btn-lg btn-block">Anexar aquivos =></a>
            </div>
          </div> 	
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  


  
  <?php 
  break;
	}
  ?>
  