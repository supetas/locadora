<?php 
include '../style.php'; 
include '../js.php';
?>
<html>

<title>Cadastrar Cliente - Sistema de Locadora de Filmes</title>
<body>
	<h1 align="center">Cadastrar Cliente - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';?>	
	
	<?php
			if(isSet($_GET['cpf'])){
				$cpf = $_GET['cpf'];
				$nome = $_GET['nome'];
				$data_nascimento = $_GET['ano'] . '-' . $_GET['mes'] . '-' . $_GET['dia'];
				$endereco = $_GET['endereco'];
				$fone = $_GET['ddd'] . "" .$_GET['telefone'];
				
				if($cpf != ''){
					$conexao = mysql_connect('localhost:3306','root','');
					mysql_select_db('locadora',$conexao);
					if($conexao){
						$result = mysql_query("INSERT INTO clientes (cpf,nome,data_nascimento,endereco,telefone)
							VALUES ('$cpf','$nome','$data_nascimento','$endereco','$fone')");
						if($result){
							echo "<font color='lime'>$nome cadastro com sucesso!!!</font>";
						} else {
							$error = mysql_error();
							$error = substr($error,0,strlen('Duplicate entry'));
							$duplicadaPK = "Duplicate entry";	
						
							if($error == $duplicadaPK){
								echo "<font color='red'>O CPF $cpf já existe!</font>";
							} else {
								echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
							}
						}
					} else {
						echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
					}
					mysql_close();
				} else {
					echo "<font color='red'>CPF é obrigatório!!!</font>";
				}
				
			} 
	?>
	
	<form action='/aksjdji/control/cadastrarCliente.php'>
	<table>
		<tr>
			<td>
				CPF
			</td>
			<td>
				<input type='text' name='cpf' onkeypress="return mascara(this, '###.###.###-##')" maxlength="14" autofocus/>
			</td>
		</tr>
		<tr>
			<td>
				Nome
			</td>
			<td>
				<input type='text' name='nome'/>
			</td>
		</tr>
		<tr>
			<td>
				Data de Nascimento
			</td>
			<td>
				<?php
					echo "<select name='dia'>";
						for($i = 1;$i<=31;$i++){
							echo "<option value='$i'>$i</option>";
						}
					echo '</select>';
					echo "<select name='mes'>";
						for($i = 1;$i<=12;$i++){
							echo "<option value='$i'>$i</option>";
						}
					echo '</select>';	
					echo "<select name='ano'>";
						for($i = 1900;$i<=2012;$i++){
							echo "<option value='$i'>$i</option>";
						}
					echo "
					<option value='2013' selected>2013</option>;
					</select>";
				?>
			</td>
		</tr>
		<tr>
			<td>
				Endereço
			</td>
			<td>
				<input type='text' name='endereco'/>
			</td>
		</tr>
		<tr>
			<td>
				Telefone
			</td>
			<td>
				<input type='text' name='ddd' size="2" maxlength="2" onkeypress="return mascara(this,'##')"/>
				<input type='text' name='telefone' size="11" maxlength="8" onkeypress="return mascara(this,'########')"/>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<button>Cadastrar</button>
				<button type='reset'>Limpar</button>
			</td>
		</tr>
	</table>
	</form>
	
</body>
</html>