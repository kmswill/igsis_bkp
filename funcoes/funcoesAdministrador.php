<?php 
$con = bancoMysqli();
	//Verifica erro na string
	//$mysqlii = new mysqlii("localhost", "root", "lic54eca","igsis_beta");
	//if (!$mysqlii->query($sql_inserir)) {
    //printf("Errormessage: %s\n", $mysqlii->error);
	//}

// funções da aba ADICIONAR USUÁRIO

function acessoInstituicao($tabela,$select,$instituicao){ //gera os options de um select
		$con = bancoMysqli();
		if($instituicao != ""){
		$sql = "SELECT * FROM $tabela WHERE idInstituicao = $instituicao OR idInstituicao = 999";
	}else{
		 $sql = "SELECT * FROM ig_instituicao "; // $sql = "SELECT * FROM ig_papelusuario WHERE idPapelUsuario";
	}
	
	$query = mysqli_query($con,$sql);
	while($option = mysqli_fetch_row($query)){
		if($option[0] == $select){
			echo "<option value='".$option[0]."' selected >".$option[1]."</option>";	
		}else{
			echo "<option value='".$option[0]."'>".$option[1]."</option>";	
		}
	}
}
function acessoPerfilUser($tabela,$select,$instituicao){ //gera os options de um select
		$con = bancoMysqli();
		if($instituicao != ""){
		$sql = "SELECT * FROM $tabela WHERE idInstituicao = $instituicao OR idInstituicao = 999";
	}else{
		 $sql = "SELECT * FROM ig_papelusuario WHERE idPapelUsuario >= '3'"; // $sql = "SELECT * FROM ig_papelusuario WHERE idPapelUsuario";
	}
	
	$query = mysqli_query($con,$sql);
	while($option = mysqli_fetch_row($query)){
		if($option[0] == $select){
			echo "<option value='".$option[0]."' selected >".$option[1]."</option>";	
		}else{
			echo "<option value='".$option[0]."'>".$option[1]."</option>";	
		}
	}
}
function acessoLocal($tabela,$select,$local){ //gera os options de um select
		$con = bancoMysqli();
		if($local != ""){
		$sql = "SELECT * FROM $tabela WHERE idLocal = $local OR idLocal = 999  ORDER BY sala ASC";
	}else{
		 $sql = "SELECT * FROM ig_local ORDER BY sala ASC "; // $sql = "SELECT * FROM ig_papelusuario WHERE idPapelUsuario";
	}
	
	$query = mysqli_query($con,$sql);
	while($option = mysqli_fetch_row($query)){
		if($option[0] == $select){
			echo "<option value='".$option[0]."' selected >".$option[1]."</option>";	
		}else{
			echo "<option value='".$option[0]."'>".$option[1]."</option>";	
		}
	}
}
function geraTituloChamado($tabela,$select,$instituicao){ //gera os options de um select  (( tirei o idInstituição)
	$con = bancoMysqli();
			$sql = "SELECT idTipoChamado,chamado FROM igsis_tipo_chamado ";
			$query = mysqli_query($con,$sql);
	while($option = mysqli_fetch_row($query)){
		if($option[0] == $select) {
			echo "<option value='".$option[0]."' selected >".$option[1]."</option>";	
		}else{
			echo "<option value='".$option[0]."'>".$option[1]."</option>";	
		}
	}
}

function geraUsuario($tabela,$select,$instituicao){ //gera os options de um select  (( tirei o idInstituição)
	$con = bancoMysqli();
			$sql = "SELECT idUsuario, nomeCompleto FROM ig_usuario ";
			$query = mysqli_query($con,$sql);
	while($option = mysqli_fetch_row($query)){
		if($option[0] == $select) {
			echo "<option value='".$option[0]."' selected >".$option[1]."</option>";	
		}else{
			echo "<option value='".$option[0]."'>".$option[1]."</option>";	
		}
	}
}


function instituicaoLocal($tabela,$select,$instituicao){ //gera os options de um select
			$con = bancoMysqli();
	if($instituicao != ""){
		$sql = "SELECT * FROM $tabela WHERE idInstituicao = $instituicao OR idInstituicao = 999";
	}else{
		$sql = "SELECT * FROM ig_instituicao WHERE idInstituicao";   // editar para só adicionar instituicao do LOCAL
	}
	
	$query = mysqli_query($con,$sql);
	while($option = mysqli_fetch_row($query)){
		if($option[0] == $select){
			echo "<option value='".$option[0]."' selected >".$option[1]."</option>";	
		}else{
			echo "<option value='".$option[0]."'>".$option[1]."</option>";	
		}
	}
}
//FUNÇÃO USUÁRIO
function recuperaUser ($idUsuario) {
		$con = bancoMysqli();
			$sql = "SELECT * FROM ig_usuario WHERE Id_PessoaFisica = $id";
			$query = mysqli_query($con,$sql);
			$x = mysqli_fetch_array($query);
			$y['nome'] = $x['Nome']; 
			$y['tipo'] = "Pessoa física";
			$y['numero'] = $x['CPF'];
			$y['cep'] = $x['CEP'];
			$y['ccm'] = $x['CCM'];
			$y['telefones'] = $x['Telefone1']." / ".$x['Telefone2']." / ".$x['Telefone3'];
			return $y;
}

function listuserAdministrador($id){ 
	if($id == ''){
		$instituicao = '';	
	}else{
		$instituicao = "AND idInstituicao = '$id' ";  
		
	}
	
	$con = bancoMysqli();
	//$sql = "SELECT idUsuario, nomeCompleto, nomeUsuario,email FROM ig_usuario WHERE idInstituicao = '$idUsuario' AND idUsuario NOT IN (1,7,8,9,14,16,17) AND publicado = '1'";
	$sql = "SELECT idUsuario, nomeCompleto, nomeUsuario,email,idInstituicao, local FROM ig_usuario WHERE idUsuario NOT IN (1,7,8,9,14,16,17) AND publicado = '1' AND nomeCompleto <> '' $instituicao ORDER BY nomeCompleto ASC";

	$query = mysqli_query($con,$sql);
	$num_user = mysqli_num_rows($query);
	echo "<p>$num_user usuários encontrados.</p>";
	echo"<table class='table table-condensed'>
					<thead>					
					<tr class='list_menu'> 
							<td>Nome Completo</td>
							<td>Nome Usuário</td>
  							<td>Email</td>
							<td>Instituição</td>
							<td>Local</td>
							<td width='5%'></td>
							<td width='%'></td>
						 </tr>	
					</thead>
					<tbody>";
	while($campo = mysqli_fetch_array($query)){
			//$RecuperaIdUsuario = recuperaDados("ig_usuario",$campo['idUsuario'], "ig_usuario_idUsuario");
			$instituicao = recuperaDados("ig_instituicao",$campo['idInstituicao'],"idInstituicao");
			$local = recuperaDados ("ig_local",$campo['local'],"idLocal");
			echo "<tr>";
			echo "<td class='list_description'>".$campo['nomeCompleto']."</td>";
			echo "<td class='list_description'>".$campo['nomeUsuario']."</td>";
			echo "<td class='list_description'>".$campo['email']."</td>";
			echo "<td class='list_description'>".$instituicao['sigla']."</td>";
			echo "<td class='list_description'>".$local['sala']."</td>";
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=administrador&p=editarUser'>
			<input type='hidden' name='editarUser' value='".$campo['idUsuario']."' />
			<input type ='submit' class='btn btn-theme btn-block' value='Editar usuário'></td></form>"	;
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=administrador&p=users'>
			<input type='hidden' name='apagar' value='".$campo['idUsuario']."' />
			<input type ='submit' class='btn btn-theme  btn-block' value='apagar usuário'></td></form>"	;
			echo "</tr>";		
	}
			echo "</tbody>
				</table>"; 
} 


function geraProjetoEspecial($tabela,$select,$publicado,$instituicao){ //gera os options de um select  (( tirei o idInstituição)
	$con = bancoMysqli();
	if($publicado = "1"){
		$sql = "SELECT * FROM $tabela WHERE publicado = $publicado OR publicado = 1";
	}else{
		$sql = "SELECT * FROM ig_projeto_especial";
	}
		$query = mysqli_query($con,$sql);
	while($option = mysqli_fetch_row($query)){
		if($option[0] == $select) {
			echo "<option value='".$option[0]."' selected >".$option[1]."</option>";	
		}else{
			echo "<option value='".$option[0]."'>".$option[1]."</option>";	
		}
	}
}

function geraStatusChamado($tabela,$select,$instituicao){ //gera os options de um select  (( tirei o idInstituição)
	$con = bancoMysqli();
			$sql = "SELECT * FROM igsis_status ";
			$query = mysqli_query($con,$sql);
	while($option = mysqli_fetch_row($query)){
		if($option[0] == $select) {
			echo "<option value='".$option[0]."' selected >".$option[4]."</option>";	
		}else{
			echo "<option value='".$option[0]."'>".$option[4]."</option>";	
		}
	}
}
// FUNÇÕES DA ABA ESPAÇO
function espacoExistente ($idUsuario) {
	$con = bancoMysqli();
		$sql = "SELECT local.sala, local.idLocal , local.idInstituicao, inst.instituicao
	FROM ig_local local
		INNER JOIN ig_instituicao inst 
			ON local.idInstituicao = inst.idInstituicao 
			WHERE local.publicado = 1 ";   // editar para só adicionar instituicao do LOCAL
//$sql = "SELECT * FROM ig_espaco WHERE idEspaco AND publicado = 1";
	  $query = mysqli_query($con,$sql); 
	  	echo " 
		<table class='table table-condensed'>	
		<div class='col-md-offset-2 col-md-8'>
					<thead>						
					<tr class='list_menu'> 
							<td>Nome do Espaço</td>
							<td>Instituição</td>
  							<td></td>
							<td width='1%'></td>
							<td width='1%'></td>
					 </tr>	
					</thead>
					</div>
					<tbody>";
					
				echo "<tr>";
					
		while($campo = mysqli_fetch_array($query)){
			echo "<td class='list_description'>".$campo['sala']."</td>";
			echo "<td class='list_description'>".$campo['instituicao']."</td>";
			echo "
				<td class='list_description'>
			<form method='POST' action='?perfil=administrador&p=espacos'>
			<input type='hidden' name='apagar' value='".$campo['idLocal']."' />
			<input type ='submit' class='btn btn-theme  btn-block' value='apagar'></td></form>"	;
			echo "</tr>";		
	  }
	  echo "	</tbody>
				</table>";
}

function projetoEspecialExistente ($idUsuario) {
	$con = bancoMysqli();
	$sql = "SELECT * FROM ig_projeto_especial WHERE idProjetoEspecial AND publicado = 1";
	  $query = mysqli_query($con,$sql); 
	  	echo " 
		<table class='table table-condensed'>	
		<div class='col-md-offset-2 col-md-8'>
					<thead>					
					<tr class='list_menu'> 
							<td>Nome do projeto especial</td>
  							
							<td width='10%'></td>
							<td width='10%'></td>
					 </tr>	
					 
					</thead>
					</div>
					<tbody>";
					
				echo "<tr>";
					
		while($campo = mysqli_fetch_array($query)){
			echo "<td class='list_description'>".$campo['projetoEspecial']."</td>";
					echo "
				<td class='list_description'>
			<form method='POST' action='?perfil=administrador&p=listaprojetoespecial'>
			<input type='hidden' name='apagar' value='".$campo['idProjetoEspecial']."' />
			<input type ='submit' class='btn btn-theme  btn-block' value='apagar'></td></form>"	;
			echo "</tr>";		
	  }
	  echo "	</tbody>
				</table>";
}

function listaEventosAdministrador($idUsuario){ 
	$con = bancoMysqli();
	$sql = "SELECT eve.nomeEvento, eve.idEvento, inst.instituicao
	FROM ig_evento eve
	INNER JOIN ig_instituicao inst
	ON eve.idInstituicao = inst.idInstituicao
	WHERE eve.publicado = 0";
	$query = mysqli_query($con,$sql);
	echo "<table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td>Nome do evento</td>
							<td>Instituição</td>
  							<td></td>
							<td width='10%'></td>
						</tr>
					</thead>
					<tbody>";
	while($campo = mysqli_fetch_array($query)){
			echo "<tr>";
			echo "<td class='list_description'>".$campo['nomeEvento']."</td>";
			echo "<td class='list_description'>".$campo['instituicao']."</td>";
			echo "<td class='list_description'></td>";
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=evento&p=basica'>
			<input type='hidden' name='carregar' value='".$campo['idEvento']."' />
			<input type ='submit' class='btn btn-theme btn-block' value='recuperar'></td></form>"	;
			
			/* Botão APAGAR
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=administrador&p=eventos'>
			<input type='hidden' name='apagar' value='".$campo['idEvento']."' />
			<input type ='submit' class='btn btn-theme  btn-block' value='apagar'></td></form>"	;
			echo "</tr>";
			*/
	}
	echo "					</tbody>
				</table>";
 } // FUNÇÃO DE ALTERACOES
 
 	function estadoChamado($id){
		if($id == 1){
			return "Aberto";
		}else{
			return "Fechado";
			
		}
		
	}
 
 
 function recuperaAlteracao($idChamado,$campo){ //retorna uma array com os dados da tabela Chamado com Ig_Usuario
	$con = bancoMysqli();
$sql = "SELECT * FROM $tabela WHERE ".$campo." = '$idEvento' LIMIT 0,1";
	$query = mysqli_query($con,$sql);
	$campo = mysqli_fetch_array($query);
	return $campo;		
}

function listaAlteracoes($idUsuario){ 
	$con = bancoMysqli();
	$sql = "SELECT * FROM igsis_chamado	
	WHERE estado = 1 ORDER BY idChamado DESC";
/*		$sql = "SELECT  cham.idChamado, cham.justificativa,cham.data,
        usu.nomeUsuario, usu.idUsuario, usu.nomeCompleto,
          tip_cham.chamado,
        stat.status 
FROM igsis_chamado cham
INNER JOIN ig_usuario usu
	on cham.idUsuario = usu.idUsuario
INNER JOIN igsis_status stat
	ON stat.idStatus = cham.estado
left JOIN  igsis_tipo_chamado tip_cham
	ON tip_cham.idTipoChamado = cham.titulo
	WHERE  usu.idInstituicao = $idUsuario"; */
	$query = mysqli_query($con,$sql);
	echo "<table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td>Cod. Chamado</td>
							<td>Nome Completo</td>
							<td>Titulo</td>
							<td>Data do chamado</td>
							<td>Status</td>
  							
							<td width='3%'></td>
							<td width='10%'></td>
						</tr>
					</thead>
					<tbody>";
				
	while($campo = mysqli_fetch_array($query)){
			$usuario = recuperaDados("ig_usuario",$campo['idUsuario'],"idUsuario");
			$tipo = recuperaDados("igsis_tipo_chamado",$campo['tipo'],"idTipoChamado");
			echo "<tr>";
			echo "<td class='list_description'>".$campo['idChamado']."</td>";
			echo "<td class='list_description'>".$usuario['nomeCompleto']."</td>";
			echo "<td class='list_description'>".$tipo['chamado']." - ".$campo['titulo']."</td>";
			echo "<td class='list_description'>".$campo['data']."</td>";
			echo "<td class='list_description'>".estadoChamado($campo['estado'])."</td>";
		
			echo "<td class='list_description'></td>";
		
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=administrador&p=formularioalteracoes'>
			<input type='hidden' name='carregaChamado' value='".$campo['idChamado']."' />
			<input type ='submit' class='btn btn-theme btn-block' value='visualizar chamado'></td></form>"	;
				echo "</tr>";		
	}
	echo "					</tbody>
				</table>";
				}
			
function listaAlteracoesFinalizado($idUsuario){ 
	$con = bancoMysqli();
	$sql = "SELECT * FROM igsis_chamado
	WHERE estado = 2 ORDER BY idChamado DESC";
/*		$sql = "SELECT  cham.idChamado, cham.justificativa,cham.data,
        usu.nomeUsuario, usu.idUsuario, usu.nomeCompleto,
          tip_cham.chamado,
        stat.status 
FROM igsis_chamado cham
INNER JOIN ig_usuario usu
	on cham.idUsuario = usu.idUsuario
INNER JOIN igsis_status stat
	ON stat.idStatus = cham.estado
left JOIN  igsis_tipo_chamado tip_cham
	ON tip_cham.idTipoChamado = cham.titulo
	WHERE  usu.idInstituicao = $idUsuario"; */
	$query = mysqli_query($con,$sql);
	echo "<table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
							<td>Cod. Chamado</td>
							<td>Nome Completo</td>
							<td>Titulo</td>
							<td>Data do chamado</td>
							<td>Status</td>
  							
							<td width='3%'></td>
							<td width='10%'></td>
						</tr>
					</thead>
					<tbody>";
				
	while($campo = mysqli_fetch_array($query)){
			$usuario = recuperaDados("ig_usuario",$campo['idUsuario'],"idUsuario");
			$tipo = recuperaDados("igsis_tipo_chamado",$campo['tipo'],"idTipoChamado");
			echo "<tr>";
			echo "<td class='list_description'>".$campo['idChamado']."</td>";
			echo "<td class='list_description'>".$usuario['nomeCompleto']."</td>";
			echo "<td class='list_description'>".$tipo['chamado']." - ".$campo['titulo']."</td>";
			echo "<td class='list_description'>".$campo['data']."</td>";
			echo "<td class='list_description'>".estadoChamado($campo['estado'])."</td>";
		
			echo "<td class='list_description'></td>";
		
			echo "
			<td class='list_description'>
			<form method='POST' action='?perfil=administrador&p=formularioalteracoes'>
			<input type='hidden' name='carregaChamado' value='".$campo['idChamado']."' />
			<input type ='submit' class='btn btn-theme btn-block' value='visualizar chamado'></td></form>"	;
				echo "</tr>";		
	}
	echo "					</tbody>
				</table>";
				}

 function listaLogAdministrador($idUsuario){ 
	$con = bancoMysqli();
	$sql = "SELECT * FROM ig_log WHERE idLog";
	$query = mysqli_query($con,$sql);
	echo "<table class='table table-condensed'>
					<thead>
						<tr class='list_menu'>
						
							<td>Endereço de IP</td>
							<td>data</td>
  							<td>Descrição</td>
							<td width='10%'></td>
							<td width='10%'></td>
						</tr>
					</thead>
					<tbody>";
	while($campo = mysqli_fetch_array($query)){
			echo "<tr>";
			//echo "<td class='list_description'>".recuperaIdDado("ig_usuario",$campo['ig_usuario_idUsuario'])."</td>";
			echo "<td class='list_description'>".$campo['enderecoIP']."</td>";
			echo "<td class='list_description'>".$campo['dataLog']."</td>";
			echo "<td class='list_description'>".$campo['descricao']."</td>";
			echo "<td class='list_description'></td>";
			echo " 
			<td class='list_description'>
			<form method='POST' action='?perfil='>
			<input type='hidden' name='carregar' value='".$campo['idLog']."' />
			<input type ='submit' class='btn btn-theme btn-block' value='carregar'></td></form>" ;
			}
	echo "	</tbody>
				</table>";
}

// Envia email para área de contratos : os usuários devem ter habilitados o receberEmail
function enviarEmailContratos($conteudo_email, $instituicao, $subject, $email, $idEvento ){ 


	require_once('../include/phpmailer/class.phpmailer.php');
	//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

	$mail->IsSMTP(); // telling the class to use SMTP

	try {
	  //$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
	  $mail->CharSet = 'UTF-8';
	  $mail->SMTPAuth   = true;                  // enable SMTP authentication
	  $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	  $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	  $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
	  $mail->Username   = "sistema.igsis";  // GMAIL username
	  $mail->Password   = "dec1935!";            // GMAIL password
	  $mail->AddReplyTo('sistema.igsis@gmail.com', 'IGSIS');
	
	  //criar laço com todos os interessados
	  	$con = bancoMysqli();

		// Usuários Operadores de Contratos
		$sql_user = "SELECT nomeCompleto, email FROM ig_usuario WHERE contratos IS NOT NULL AND receberNotificacao = '1'"; //seleciona somente a área de contratos
		$query_user = mysqli_query($con,$sql_user);
		while($campo_user = mysqli_fetch_array($query_user)){
			
			$mail->AddBCC($campo_user['email'],$campo_user['nomeCompleto']);
		}
		
		// Responsáveis pelo evento
		$user = recuperaDados("ig_evento",$idEvento,"idEvento");
		$usuario = recuperaDados("ig_usuario",$user['idUsuario'],"idUsuario");
		$fiscal = recuperaDados("ig_usuario",$user['idResponsavel'],"idUsuario");
		$suplente = recuperaDados("ig_usuario",$user['suplente'],"idUsuario");

		if($usuario['receberNotificacao'] == 1){
			$mail->AddBCC($usuario['email'],$usuario['nomeCompleto']);
		}
		if($fiscal['receberNotificacao'] == 1){
			$mail->AddBCC($fiscal['email'],$fiscal['nomeCompleto']);
		}
		if($suplente['receberNotificacao'] == 1){
			$mail->AddBCC($suplente['email'],$suplente['nomeCompleto']);
		}
	
			
		
	  
	  //$mail->AddAddress(emailUserLogin($logado), nomeUserLogin($logado));
	
	
	  $mail->SetFrom('sistema.igsis@gmail.com', 'IGSIS');
	  $mail->AddReplyTo('sistema.igsis@gmail.com', 'IGSIS');
	
	  //assunto da IGCCSP 	
	  $mail->Subject = utf8_decode($subject);
	
	  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
		//	Criar uma variável com as informações
	  $mail->MsgHTML(utf8_decode ($conteudo_email));
	  $mail->Send();
	  return "Um email foi enviado para seu endereço eletrônico cadastrado.</p>\n";
	} catch (phpmailerException $e) {
	  return $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
	  return $e->getMessage(); //Boring error messages from anything else!
	}


}

?>