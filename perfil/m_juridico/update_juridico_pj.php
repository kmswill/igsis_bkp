<?php
include 'includes/menu.php';
$conexao = bancoMysqli();
$server = "http://".$_SERVER['SERVER_NAME']."/igsis/";
$http = $server."/pdf/";
$link1=$http."rlt_despacho_padrao_pj.php";
$link2=$http."rlt_manifestacaojuridica_pj.php";

$id_ped=$_GET['id_ped'];

$AmparoLegal=$_POST['AmparoLegal'];
$ComplementoDotacao=$_POST['ComplementoDotacao'];
$Finalizacao=$_POST['Finalizacao'];
 
$data = date('Y-m-d H:i:s');
$update = "UPDATE igsis_pedido_contratacao
                                               SET
                                               AmparoLegal = '$AmparoLegal',
                                               ComplementoDotacao = '$ComplementoDotacao',
                                               Finalizacao = '$Finalizacao',
											   estado = 7,
											   DataJuridico = '$data'
                                               WHERE IdPedidoContratacao = '$id_ped' ";
 
$stmt = mysqli_prepare($conexao,$update);
 
if(mysqli_stmt_execute($stmt))
{
               echo"<p>&nbsp;</p><h4><center>Dados Inseridos com sucesso!</h4><br>";
                $last_id = mysqli_insert_id($conexao);
                echo "<br><br><h6>Qual modelo de documento deseja gerar?</h6><br>
                               <div class='row'>
                <div class='col-md-offset-1 col-md-10'>
               
                <form class='form-horizontal' role='form'>
                                              
                <div class='form-group'>
					<div class='col-md-offset-2 col-md-6'>
                        <a href='$link1?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Despacho</a></div>
					<div class='col-md-6'>
                        <a href='$link2?id=$id_ped' class='btn btn-theme btn-lg btn-block' target='_blank'>Manifestação Jurídica</a></div>
				</div>
               
                <br/>
                 
                 <br /></center>";
 
}
?>