
<!-- MENU -->	
<?php include 'includes/menu.php';?>
<?php
$con = bancoMysqli();

$mensagem = "";

if(isset($_POST["enviar"])){

$sql_arquivos = "SELECT * FROM igsis_upload_docs";
$query_arquivos = mysqli_query($con,$sql_arquivos);
while($arq = mysqli_fetch_array($query_arquivos)){ 
	$y = $arq['idTipoDoc'];
	$x = $arq['sigla'];
	$nome_arquivo = $_FILES['arquivo']['name'][$x];
	if($nome_arquivo != ""){
	$nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
    //$ext = strtolower(substr($nome_arquivo[$i],-4)); //Pegando extensão do arquivo
      $new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
	  $hoje = date("Y-m-d H:i:s");
      $dir = '../uploadsdocs/'; //Diretório para uploads
	  $idPedido = $_GET['id_ped'];
	  
      if(move_uploaded_file($nome_temporario, $dir.$new_name)){
		 
		 $sql_insere_arquivo =  "INSERT INTO igsis_arquivos_pedidos (`idArquivosPedidos`, `idPedido`,`arquivo`,`data`,`publicado`,`tipo`)
		 VALUES (NULL, '$idPedido', '$new_name', '$hoje', '1','$y')";
		/* $sql_insere_arquivo = "INSERT INTO `igsis_arquivos_pedidos` (`idArquivosPessoa`, `idTipoPessoa`, `idPessoa`, `arquivo`, `dataEnvio`, `publicado`, `tipo`) 
		VALUES (NULL, '$tipoPessoa', '$idPessoa', '$new_name', '$hoje', '1', '$y'); "; */
		$query = mysqli_query($con,$sql_insere_arquivo);
		if($query){
		$mensagem = "Arquivo recebido com sucesso";
		}else{
		$mensagem = "Erro ao gravar no banco";
		}
		
		}else{
		 $mensagem = "Erro no upload"; 
		  
	  }
	}
	
}

}

if(isset($_POST['apagar'])){
	$idArquivo = $_POST['apagar'];
	$sql_apagar_arquivo = "UPDATE igsis_arquivos_pedidos SET publicado = 0 WHERE idArquivosPedidos = '$idArquivo'";
	if(mysqli_query($con,$sql_apagar_arquivo)){
		$arq = recuperaDados("igsis_arquivos_pedidos",$idArquivo,"idArquivosPedidos");
		$mensagem =	"Arquivo ".$arq['arquivo']."apagado com sucesso!";
		gravarLog($sql_apagar_arquivo);
	}else{
		$mensagem = "Erro ao apagar o arquivo. Tente novamente!";
	}
}


$pedido = siscontrat($_GET['id_ped']);

?>
    
    	 <section id="enviar" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
                                        <h2><?php echo $pedido['Objeto']; ?> </h2>
                                       
					 <h3>Envio de Arquivos</h3>
                     <p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
<p>Nesta página, você envia documentos digitalizados. O tamanho máximo do arquivo deve ser 60MB.</p>


<br />
<div class = "center">
<form method="POST" action="?perfil=contratos&p=frm_arquivos_pedidos&id_ped=<?php echo $_GET['id_ped']; ?>" enctype="multipart/form-data">
<table>
<tr>
<td width="50%"><td>
</tr>
<?php 
$sql_arquivos = "SELECT * FROM igsis_upload_docs";
$query_arquivos = mysqli_query($con,$sql_arquivos);
while($arq = mysqli_fetch_array($query_arquivos)){ ?>

<tr>
<td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
</tr>
	
<?php } ?>

  </table>
    <br>
    <input type="hidden" name="enviar" value="1"  />
    <input type="submit" class="btn btn-theme btn-lg btn-block" value='Enviar'>
</form>
</div>

					</div>
					<div class="col-md-offset-2 col-md-8">
             <?php 
			 $pessoa = recuperaDados("igsis_pedido_contratacao",$_SESSION['idPedido'],"idPedidoContratacao");
			 if($pessoa['tipoPessoa'] == 1){
				$pes = "pf";	 
			}else{
				$pes = "pj";	
			}
			 ?>       
			 <a href="?perfil=contratos&p=frm_edita_proposta<?php echo $pes ?>&id_ped=<?php echo $_SESSION['idPedido'];  ?>" class="btn btn-theme btn-block" >Voltar ao Pedido</a>	

					</div>	
			</div>

				  </div>
                  
			  </div>
			  
		</div>
	</section>

	<section id="list_items" class="home-section bg-white">
		<div class="container">
      			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
 <h2>Arquivos anexados</h2>
<h5>Se na lista abaixo, o seu arquivo começar com "http://", por favor, clique, grave em seu computador, faça o upload novamente e apague a ocorrência citada.</h5>
					</div>
			<div class="table-responsive list_info">
                         <?php listaArquivosPedido($_GET['id_ped']); ?>
			</div>
				  </div>
			  </div>  
             <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="../perfil/m_contratos/frm_arquivos_todos.php?idPedido=<?php echo $_SESSION['idPedido'] ?>" class="btn btn-theme btn-lg btn-block" target="_blank">Baixar todos os arquivos de uma vez</a>


            </div>
          </div>

		</div>
	</section>
