<?php 

//require "../funcoes/funcoesSiscontrat.php";

$linha_tabela_lista = siscontratLista(1,"",1000,1,"DESC",6); //esse gera uma array com os pedidos

//$tipoPessoa,$num_registro,$pagina,$ordem,$estado

$link="index.php?perfil=juridico&p=frm_cadastra_juridico_pf&id_ped=";

$id_ped = $_GET['id_ped'];

?>

<?php include 'includes/menu.php';?>
		
	  	  
<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
	                <h4>Escolha um modelo</h4>
                </div>
            </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
			<?php
			$con = bancoMysqli();
				$sql = "select * from sis_modelos_juridico";
				$query = mysqli_query($con,$sql);
				while ($modelo = mysqli_fetch_array ($query))
				{
					
			?>
			
	            <a href="?perfil=juridico&p=frm_cadastra_juridico_pf&id_ped=<?php echo $id_ped ?>&idModelo=<?php echo $modelo['idModelo'] ?>" class="btn btn-theme btn-lg btn-block"><?php echo $modelo['nomeModelo'] ?></a> 
				<?php }
			?>				
            </div>
			
			<div class="form-group">
			<div class="col-md-offset-2 col-md-8"><p>&nbsp;</p>
			</div>
			</div>
			
			<div class="form-group">
            <div class="col-md-offset-2 col-md-8"><a href="?perfil=juridico&p=frm_edita_juridico_pf&id_ped=<?php echo $id_ped ?>" class="btn btn-theme btn-lg btn-block">Editar</a>
			</div>
			<div>
          </div>
        </div>
    </div>
</section>   

<!--fim_list-->