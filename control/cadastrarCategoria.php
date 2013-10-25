<?php include '../style.php'; ?>
<html>

<title>Cadastrar Categoria - Sistema de Locadora de Filmes</title>
<body>
	<h1 align="center">Cadastrar Categoria - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';?>	
	
	<?php
		if(isSet($_GET['nome'])){
			$nome = $_GET['nome'];
			
			if($nome != ''){
				$conexao = mysql_connect('localhost:3306','root','');
				mysql_select_db('locadora',$conexao);
				if($conexao){
					$result = mysql_query("INSERT INTO categorias (nome) VALUES ('$nome')");
					if($result){
						echo "<font color='lime'>$nome cadastro com sucesso!!!</font>";
						
					} else {
						if("Duplicate entry" == substr(mysql_error(),0, strlen('Duplicate entry'))){
							echo "<font color='red'> A categoria ".$_GET['nome']." já existe</font>";
						} else {	
							echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
						}
						
					}
				} else {
					echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
				}
				mysql_close();
			} else {
				echo "<font color='red'>Campo nome é obrigatório!!!</font>";
			}
			
		}
	?>
	
	<form action='/aksjdji/control/cadastrarCategoria.php'>
	<table>
		<tr>
			<td>
				Nome
			</td>
			<td>
				<input type='text' name='nome' autofocus/>
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