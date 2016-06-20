<?php
require_once("../funcoes/funcoesVerifica.php");
require_once("../funcoes/funcoesSiscontrat.php");
if(isset($_GET['idEvento'])){
	$evento = verificaCampos($_GET['idEvento']);
	$ocorrencia = verificaOcorrencias($_GET['idEvento']);	


}
if(isset($_SESION['idEvento'])){
unset($_SESION['idEvento']);		
}


if(isset($_GET['p'])){
	$p = $_GET['p'];
}else{
	$p= "inicio";	
}

?>
<script type="application/javascript">
$(function(){
	$('#instituicao').change(function(){
		if( $(this).val() ) {
			$('#local').hide();
			$('.carregando').show();
			$.getJSON('local.ajax.php?instituicao=',{instituicao: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value=""></option>';	
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].idEspaco + '">' + j[i].espaco + '</option>';
				}	
				$('#local').html(options).show();
				$('.carregando').hide();
			});
		} else {
			$('#local').html('<option value="">-- Escolha uma instituição --</option>');
		}
	});
});
</script>
<?php include "../include/menuChamado.php"; ?>
<?php 

switch($p){
case "inicio":
?>

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
	                <h4>Escolha uma opção</h4>
                </div>
            </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="?perfil=chamado&p=inserir" class="btn btn-theme btn-lg btn-block">Abrir um chamado</a>
	            <a href="?perfil=chamado&p=acompanhar" class="btn btn-theme btn-lg btn-block">Acompanhar um chamado</a>
  	            <a href="?perfil=chamado&p=arqeventos" class="btn btn-theme btn-lg btn-block">Enviar arquivos para evento</a>
            </div>
          </div>
        </div>
    </div>
</section>    

<?php 
break;
case "inserir":
?>
<section id="inserir" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                    <h3>Abrir um chamado.</h3>
                     <h4><?php if(isset($mensagem)){echo $mensagem;} ?></h4>
                </div>
            </div>
    </div>
    
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
        <form method="POST" action="?perfil=chamado&p=acompanhar" class="form-horizontal" role="form">
       		 <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            		<label>Título do chamado</label>
            		<input type="text" name="titulo" class="form-control" id="inputSubject" />
            	</div> 
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                	<label>Tipo de chamado</label>
                	<select class="form-control" name="tipo" id="inputSubject" >
                    <option value="1"></option>
					<?php echo geraOpcao("igsis_tipo_chamado","","") ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
            	<label>Evento</label>
            	<select class="form-control" name="evento" id="inputSubject" >
					<option value="0"></option>
				<?php
				$idUsuario = $_SESSION['idUsuario'];
				$con = bancoMysqli();
				$sql_lista_eventos = "SELECT * FROM ig_evento WHERE (idUsuario = '$idUsuario' OR idResponsavel = '$idUsuario' OR suplente = '$idUsuario') AND publicado = '1' AND dataEnvio IS NOT NULL ORDER BY idEvento";
				$query_lista_eventos = mysqli_query($con,$sql_lista_eventos);
				while($event = mysqli_fetch_array($query_lista_eventos)){ ?>
				<option value="<?php echo $event['idEvento'] ?>"><?php echo $event['nomeEvento'] ?></option>
				<?php					
				}				
				 ?>
                </select>
        	    </div>
      	    </div>

            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            		<label>Descrição</label>
            		<textarea name="descricao" class="form-control" rows="10" placeholder="Detalhe o teor da chamada ou alteração."></textarea>
            	</div>
             </div>
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            		<label>Justificativa para alteração</label>
            		<textarea name="justificativa" class="form-control" rows="10" placeholder="Caso seja uma alteração de dados, justifique."></textarea>
									
            	</div>
            </div>

            <div class="form-group">
	            <div class="col-md-offset-2 col-md-8">
                	<input type="hidden" name="inserir" value="1" />
    		        <input type="submit" class="btn btn-theme btn-lg btn-block" value="Enviar" onclick="this.disabled = true; this.value = 'Enviando…'; this.form.submit();">
            	</div>
            </div>
            </form>
        </div>
    </div>
</section>  


<?php 
break;
case "acompanhar":
?>


<?php

if(isset( $_POST['arqeventos'] ) ) {
	$idEvento = $_POST['evento'];
	$evento = recuperaDados("ig_evento",$idEvento,"idEvento");
	$nome_evento = $evento['nomeEvento'];
    $pathToSave = '../uploads/';
    // A variavel $_FILES é uma variável do PHP, e é ela a responsável
    // por tratar arquivos que sejam enviados em um formulário
    // Nesse caso agora, a nossa variável $_FILES é um array com 3 dimensoes
    // e teremos de trata-lo, para realizar o upload dos arquivos
    // Quando é definido o nome de um campo no form html, terminado por []
    // ele é tratado como se fosse um array, e por isso podemos ter varios
    // campos com o mesmo nome
    $i = 0;
    $msg = array( );
    $arquivos = array( array( ) );
    foreach(  $_FILES as $key=>$info ) {
        foreach( $info as $key=>$dados ) {
            for( $i = 0; $i < sizeof( $dados ); $i++ ) {
                // Aqui, transformamos o array $_FILES de:
                // $_FILES["arquivo"]["name"][0]
                // $_FILES["arquivo"]["name"][1]
                // $_FILES["arquivo"]["name"][2]
                // $_FILES["arquivo"]["name"][3]
                // para
                // $arquivo[0]["name"]
                // $arquivo[1]["name"]
                // $arquivo[2]["name"]
                // $arquivo[3]["name"]
                // Dessa forma, fica mais facil trabalharmos o array depois, para salvar
                // o arquivo
                $arquivos[$i][$key] = $info[$key][$i];
            }
        }
    }
    $i = 1;
    // Fazemos o upload normalmente, igual no exemplo anterior
    foreach( $arquivos as $file ) {
        // Verificar se o campo do arquivo foi preenchido
        if( $file['name'] != '' ) {
			$con = bancoMysqli();
			$dataUnique = date('YmdHis');
			$data = date('Y-m-d H:i:s');
            $arquivoTmp = $file['tmp_name'];
            $arquivo = $pathToSave.$dataUnique."_alt_".semAcento($file['name']);
			$arquivo_base = $dataUnique."_alt_".semAcento($file['name']);
			if(file_exists($arquivo)){
				echo "O arquivo ".$arquivo_base." já existe! Renomeie e tente novamente<br />";
			}else{

			$sql = "INSERT INTO ig_arquivo (idArquivo , arquivo , ig_evento_idEvento, publicado) VALUES( NULL , '$arquivo_base' , '$idEvento', '1' );";
			mysqli_query($con,$sql);
			$descricao = "Foram anexados arquivos.<br />
			<a href=?perfil=busca&p=detalhe&evento=$idEvento target=_blank>Clique aqui para ter acesso.</a><br />
			
			
			";
			$idUsuario = $_SESSION['idUsuario'];
			$titulo = "Foram enviados arquivos.";
			$sql_alt="INSERT INTO `igsis_chamado` (`idChamado`, `titulo`, `descricao`, `data`, `idUsuario`, `estado`, `tipo`, `idEvento`, `justificativa`) VALUES (NULL, '$titulo', '$descricao', '$data', '$idUsuario', 'aberto', '10', '$idEvento', '')";
			if(mysqli_query($con,$sql_alt)){
			gravarLog($sql_alt);
			$mensagem = "Chamada aberta com sucesso!";
			}else{
			$mensagem = "Erro ao abrir chamada. Tente novamente.";

			}
			
			gravarLog($sql);
            if( !move_uploaded_file( $arquivoTmp, $arquivo ) ) {
                $msg[$i] = 'Erro no upload do arquivo '.$i;
            } else {
                $msg[$i] = 'Upload do arquivo %s foi um sucesso!';
            }
			}
       } 
        $i++;
    }
    // Imprimimos as mensagens geradas pelo sistema
	
	
	
 foreach( $msg as $e ) {
	 	echo " <div id = 'mensagem_upload'>";
        printf('%s<br>', $e);
		echo " </div>";
    }

			$titulo = "Foram enviados arquivos.";
			$sql_alt="INSERT INTO `igsis_chamado` (`idChamado`, `titulo`, `descricao`, `data`, `idUsuario`, `estado`, `tipo`, `idEvento`, `justificativa`) VALUES (NULL, '$titulo', '$descricao', '$data', '$idUsuario', 'aberto', '10', '$idEvento', '')";
			if(mysqli_query($con,$sql_alt)){
			gravarLog($sql_alt);
			$mensagem = "Chamada aberta com sucesso!";
			}else{
			$mensagem = "Erro ao abrir chamada. Tente novamente.";

			}	
	
}
?>

<?php

 
if(isset($_POST['inserir'])){
	$con = bancoMysqli();
$titulo = $_POST['titulo'];
$tipo = $_POST['tipo'];
$evento = $_POST['evento'];
$descricao = $_POST['descricao'];
$justificativa = $_POST['justificativa'];
$idUsuario = $_SESSION['idUsuario'];
$data = date('Y-m-d H:i:s');
$conteudo_email = "";
	$sql_inserir_chamado = "INSERT INTO `igsis_chamado` (`idChamado`, `titulo`, `descricao`, `data`, `idUsuario`, `estado`, `tipo`, `idEvento`, `justificativa`) VALUES (NULL, '$titulo', '$descricao', '$data', '$idUsuario', '1', '$tipo', '$evento', '$justificativa')";
	$query_inserir_chamado = mysqli_query($con,$sql_inserir_chamado);
	if($query_inserir_chamado){
		$tipo01 = recuperaDados("igsis_tipo_chamado",$tipo,"idTipoChamado");
		$usuario = recuperaDados("ig_usuario",$idUsuario,"idUsuario");
		$num_pedidos = 0;
		if($tipo01['tipo'] == '2'){ // Tipo técnico
			$conteudo_email = "
			Olá, <br /><br />
			O usuário ".$usuario['nomeCompleto']." abriu um chamado em ".exibirDataHoraBr($data)." que pode ser de seu interesse.<br /><br />
			<b>Título:</b> ".$tipo01['chamado']."<br /><br />
			<b>Descrição:</b> ".nl2br($descricao)."<br /><br />
			<b>Justificativa:</b> ".nl2br($justificativa)."<br /><br /><br />";
			$subject = "Foi aberto uma chamada técnica: ".$tipo01['chamado'].".";
			$idEvento = 0;
			$num_pedidos = -1;			
		}

		if($tipo01['tipo'] == '1'){ // Tipo Alteração
			$evento_chamado = recuperaDados("ig_evento",$evento,"idEvento");
			$conteudo_email = "
			Olá, <br /><br />
			O usuário ".$usuario['nomeCompleto']." abriu um chamado em ".exibirDataHoraBr($data)." que pode ser de seu interesse.<br /><br />
			<b>Título:</b> ".$tipo01['chamado']." - ".$evento_chamado['nomeEvento']."<br /><br />
			<b>Descrição:</b> ".nl2br($descricao)."<br /><br />
			<b>Justificativa:</b> ".nl2br($justificativa)."<br /><br /><br />";
			$sql_pedidos = "SELECT * FROM igsis_pedido_contratacao WHERE publicado = '1' AND idEvento = '$evento'";
			$query_pedidos = mysqli_query($con,$sql_pedidos);
			$num_pedidos = mysqli_num_rows($query_pedidos);
			if($num_pedidos > 0){
				$ped = "";
				while($idPedido =  mysqli_fetch_array($query_pedidos)){
					$ped .= $idPedido['idPedidoContratacao'].", ";	
				}	
				$conteudo_email .= "Os seguintes Números de pedidos de contratação estão relacionados com este evento: <b>".substr(trim($ped),0,-1)."</b>.<br /><br />";		
			}			

			$conteudo_email .= "
			
			Saiba mais acessando: <a href='http://www.centrocultural.cc/igsis/'> centrocultural.cc/igsis </a>
			<br />
			<br />
			<p>Atenciosamente,<br />
			Equipe IGSIS</p>
			";
			
			$subject = "Foi aberto uma chamada para o evento ".$evento_chamado['nomeEvento'].".";
			$idEvento = $evento;

			
		}

		$mensagem = "Chamado aberto com sucesso.";
		
		
		enviarEmail($conteudo_email, $_SESSION['idInstituicao'], $subject, $evento, $num_pedidos );
	}else{
		$mensagem = "Erro ao inserir chamado. Tente novamente.";

	}
}
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Chamado</h2>
					<h4></h4>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                   

                 </div>
				  </div>
			  </div>  
			
			<div class="table-responsive list_info">
                  <table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td width='10%'>ID</td>
							<td>Chamado</td>
							<td>Data do envio</td>
							<td>Status</td>
						</tr>
					</thead>
					<tbody>
					<?php
					$idUsuario = $_SESSION['idUsuario'];
					$con = bancoMysqli();
					$sql_busca = "SELECT * FROM igsis_chamado WHERE idUsuario = '$idUsuario' ORDER BY idChamado DESC";
					$query_busca = mysqli_query($con,$sql_busca);
						while($chamado = mysqli_fetch_array($query_busca)){ 
						$tipo = recuperaDados("igsis_tipo_chamado",$chamado['tipo'],"idTipoChamado");
						
						
						?>
						
					<tr>
					<td><?php echo $chamado['idChamado']; ?></td>
					<td><a href="?perfil=chamado&p=detalhe&id=<?php echo $chamado['idChamado'] ?>" ><?php echo $tipo['chamado']." - ".$chamado['titulo']; ?>
                    <?php
					if($chamado['idEvento'] != NULL){
							$evento = recuperaDados("ig_evento",$chamado['idEvento'],"idEvento");
							echo "<br />".$evento['nomeEvento'];
						}
	                ?>
                    </a></td>
					<td><?php echo exibirDataHoraBr($chamado['data']) ?></td>
					<td><?php echo $chamado['estado'] ?></td>
					</tr>					
					<?php
						}
					?>
					
					
					</tbody>
					</table>
				   
			</div>
		</div>
	</section>

<?php
break;
case "evento":
$idEvento = $_GET['id'];
$evento = recuperaDados("ig_evento",$idEvento,"idEvento");

?>

	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2><?php echo $evento['nomeEvento']; ?></h2>
					<h4></h4>
                    <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>
                 </div>
				  </div>
			  </div>  
			
			<div class="table-responsive list_info">
                  <table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td width='10%'>ID</td>
							<td>Chamado</td>
							<td>Data do envio</td>
							<td>Status</td>
						</tr>
					</thead>
					<tbody>
					<?php
					$idUsuario = $_SESSION['idUsuario'];
					$con = bancoMysqli();
					$sql_busca = "SELECT * FROM igsis_chamado WHERE idEvento = '$idEvento' ORDER BY idChamado DESC";
					$query_busca = mysqli_query($con,$sql_busca);
						while($chamado = mysqli_fetch_array($query_busca)){ 
						$tipo = recuperaDados("igsis_tipo_chamado",$chamado['tipo'],"idTipoChamado");
						
						
						?>
						
					<tr>
					<td><?php echo $chamado['idChamado']; ?></td>
					<td><a href="?perfil=chamado&p=detalhe&id=<?php echo $chamado['idChamado'] ?>" ><?php echo $tipo['chamado']." - ".$chamado['titulo']; ?>
                    <?php
					if($chamado['idEvento'] != NULL){
							$evento = recuperaDados("ig_evento",$chamado['idEvento'],"idEvento");
							echo "<br />".$evento['nomeEvento'];
						}
	                ?>
                    </a></td>
					<td><?php echo exibirDataHoraBr($chamado['data']) ?></td>
					<td><?php echo $chamado['estado'] ?></td>
					</tr>					
					<?php
						}
					?>
					
					
					</tbody>
					</table>
				   
			</div>
		</div>
	</section>

<?php 
break;
case "detalhe":
if(isset($_POST['envia'])){
	$con = bancoMysqli();
	$idChamado = $_GET['id'];
	$data = date('Y-m-d H:i:s');
	$idUsuario = $_SESSION['idUsuario'];
	$comentario = $_POST['comentario'];
	$sql_insere_comentario = "INSERT INTO `igsis_chamado_comentarios` (`idComentario`, `idChamado`, `data`, `idUsuario`, `comentario`) VALUES (NULL, '$idChamado', '$data', '$idUsuario', '$comentario')";
	$query_insere_comentario = mysqli_query($con,$sql_insere_comentario);
	if($query_insere_comentario){
		$usuario = recuperaDados("ig_usuario",$idUsuario,"idUsuario");
		$chamado = recuperaDados("igsis_chamado",$idChamado,"idChamado");	
		$tipo01 = recuperaDados("igsis_tipo_chamado",$chamado['tipo'],"idTipoChamado");
		$url =  urlAtual();	
		
		if($tipo01['tipo'] == '1'){ // Tipo técnico

		$conteudo_email = "Olá,<br /><br />
		O usuário ".$usuario['nomeCompleto']." fez um comentário sobre o chamado ".$chamado['titulo'].". <br /><br />
		
		<a href='$url'>Acompanhe clicando aqui.</a> (É preciso estar logado no sistema)
			<br />
			<br />
			<p>Atenciosamente,<br />
			Equipe IGSIS</p>
		";
		$subject = "O usuário ".$usuario['nomeCompleto']." fez um comentário sobre o chamado ".$chamado['titulo'];
		$evento = 0;
		$num_pedidos = -1;
		}
		
		if($tipo01['tipo'] == '2'){ // Tipo técnico
			$evento = $chamado['idEvento'];
			$sql_pedidos = "SELECT * FROM igsis_pedido_contratacao WHERE publicado = '1' AND idEvento = '$evento'";
			$query_pedidos = mysqli_query($con,$sql_pedidos);
			$num_pedidos = mysqli_num_rows($query_pedidos);
	
			$conteudo_email = "Olá,<br /><br />
			O usuário ".$usuario['nomeCompleto']." fez um comentário sobre o chamado ".$tipo01['chamado']." - ".$chamado['titulo'].". <br /><br />
		
		<a href='$url'>Acompanhe clicando aqui.</a> (É preciso estar logado no sistema)
			<br />
			<br />
			<p>Atenciosamente,<br />
			Equipe IGSIS</p>
		";
		$subject = "O usuário ".$usuario['nomeCompleto']." fez um comentário sobre o chamado ".$chamado['titulo']." - ".$tipo01['chamado'];





	}
		if(enviarEmail($conteudo_email, $_SESSION['idInstituicao'], $subject, $evento, $num_pedidos )){
			$mensagem = "Email enviado com sucesso. <br />";
		}
		$mensagem .= "Comentário inserido com sucesso.";	
	}else{
		$mensagem = "Erro";	
	}	
}

$chamado = recuperaDados("igsis_chamado",$_GET['id'],"idChamado");
$tipo = recuperaDados("igsis_tipo_chamado",$chamado['tipo'],"idTipoChamado");
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Chamado</h2>
	                  <h5><?php if(isset($mensagem)){echo $mensagem;} ?></h5>

                 </div>
				  </div>
			  </div>  
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
       
       		 <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
                <div class="left">
				<p>Chamado: <strong><?php echo $tipo['chamado']." - ".$chamado['titulo'];
				if($chamado['idEvento'] != NULL){
							$evento = recuperaDados("ig_evento",$chamado['idEvento'],"idEvento");
							echo "<br />".$evento['nomeEvento'];
						}
				?></strong></p>
                <p>Descrição:<br />
                <strong><?php echo nl2br($chamado['descricao']) ?></strong>
                </p> 
                <br />
                <p>Justificativa:<br />
                <strong><?php echo nl2br($chamado['justificativa']) ?></strong>
                </p> 
                <br />
                <p>Aberto em: <strong><?php echo exibirDataHoraBr($chamado['data']) ?></strong></p>
                <p>Status: <strong><?php echo $chamado['estado'] ?></strong> </p><br />
			</div>
                <div class="left">
                <label>Deixe um comentário</label>
				<form method="POST" action="?perfil=chamado&p=detalhe&id=<?php echo $_GET['id'] ?>" class="form-horizontal" role="form">
                <textarea name="comentario" class="form-control" rows="10" placeholder=""></textarea>
                <input type="hidden" name="envia" value='1' />
				 <input type="image" alt="Enviar" value="submit" class="btn btn-theme btn-block">
				</form>
                </div>
                <br /><br />
                <div class="left">
				
                <label>Comentários anteriores</label><br /><br />
                <?php recuperaComentarios($_GET['id']); ?>
                
				</div>

            	</div> 
            </div>			
					</div>
	</section>
<?php 
break;
case "arqeventos":
if(isset($_POST['evento'])){
	$con = bancoMysqli();
	$idArquivo = $_POST['apagar'];
	$sql_apagar_arquivo = "UPDATE ig_arquivo SET publicado = '0' WHERE idArquivo = '$idArquivo'";
	if(mysqli_query($con,$sql_apagar_arquivo)){
		$arq = recuperaDados("ig_arquivo",$idArquivo,"idArquivo");
		$mensagem =	"Arquivo ".$arq['arquivo']."apagado com sucesso!";
		gravarLog($sql_apagar_arquivo);
	}else{
		$mensagem = "Erro ao apagar o arquivo. Tente novamente!";
	}
}
$campo = recuperaEvento($_SESSION['idEvento']); //carrega os dados do evento em questão
?>
    
    	 <section id="enviar" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
                                        <h1><?php echo $campo["nomeEvento"] ?>  </h1>

					 <h3>Envio de Arquivos</h3>
<p>Nesta página, você envia os arquivos como o rider, mapas de cenas e luz, logos de parceiros, programação de filmes de mostras de cinema, etc. O tamanho máximo do arquivo deve ser 50MB.</p>
<p>Não envie cópias de documentos de pessoas físicas e jurídicas nesta página. Os arquivos que subirem por esta página estarão disponíveis a todos do sistema. <!--Para o envio, vá até a área de "<a href="?perfil=contratados&p=lista">Pedidos de contratação</a>" e anexe direto em cada contratado.--></p>
<p> Em caso de envio de fotografia, considerar as seguintes especificações técnicas:<br />
- formato: horizontal <br />
- tamanho: mínimo de 300dpi”</p>

<br />
<form method='POST' action="?perfil=chamado&p=acompanhar" enctype='multipart/form-data'>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
            	<label>Evento</label>
            	<select class="form-control" name="evento" id="inputSubject" >
					<option value="0"></option>
				<?php
				$idUsuario = $_SESSION['idUsuario'];
				$con = bancoMysqli();
				$sql_lista_eventos = "SELECT * FROM ig_evento WHERE (idUsuario = '$idUsuario' OR idResponsavel = '$idUsuario' OR suplente = '$idUsuario') AND publicado = '1' AND dataEnvio IS NOT NULL ORDER BY idEvento";
				$query_lista_eventos = mysqli_query($con,$sql_lista_eventos);
				while($event = mysqli_fetch_array($query_lista_eventos)){ ?>
				<option value="<?php echo $event['idEvento'] ?>"><?php echo $event['nomeEvento'] ?></option>
				<?php					
				}				
				 ?>
                </select>
<br />
<br />

        	    </div>
      	    </div>
<div class = "center">


<p><input type='file' name='arquivo[]'></p>
<p><input type='file' name='arquivo[]'></p>
 <p><input type='file' name='arquivo[]'></p>
 <p><input type='file' name='arquivo[]'></p>
 <p><input type='file' name='arquivo[]'></p>
 <p><input type='file' name='arquivo[]'></p>
 <p><input type='file' name='arquivo[]'></p>
  <p><input type='file' name='arquivo[]'></p>
  <p><input type='file' name='arquivo[]'></p>
    <br>
    <input type="hidden" value='<?php echo $event['idEvento'] ?>' name='arqeventos' />
    
    <input type="submit" class="btn btn-theme btn-lg btn-block" value='Enviar' name='enviar'>
</form>
</div>


					</div>
				  </div>
                  
			  </div>
			  
		</div>
	</section>



<?php 
break;
case "arqpessoas":
?>    

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
	                <h4>Escolha uma opção</h4>
                </div>
            </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="?perfil=chamado&p=arqpf" class="btn btn-theme btn-lg btn-block">Enviar arquivos de pessoas físicas (PF)</a>
	            <a href="?perfil=chamado&p=arqpj" class="btn btn-theme btn-lg btn-block">Enviar arquivos de pessoas jurídicas (PJ)</a>
            </div>
          </div>
        </div>
    </div>
</section>   

    
    
<?php break; ?>
<?php } ?>