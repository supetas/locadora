<?php include '../style.php'; ?>
<html>

<title>Editar Categoria - Sistema de Locadora de Filmes</title>
<body>
	<h1 align="center">Editar Categoria - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';?>	
	
	<?php
		$conexao = mysql_connect('localhost:3306','root','');
		mysql_select_db('locadora',$conexao);
		
		$cod = '';
		$nome = '';
		if(isSet($_GET['cod'])){
			$cod = $_GET['cod'];
			$nome = $_GET['nome'];
		}
		if(isSet($_GET['alterar'])){
			
			if($conexao){
				$result = mysql_query("UPDATE categorias SET nome='$nome' WHERE cod='$cod'");
				if($result){
					echo "<font color='lime'>Categoria $nome atualizada com sucesso!</font> <br/><br/>";
				} else {
					echo "<font color='red'>Categoria $nome não pode ser atualizada! ERROR = ".mysql_error()."</font><br/><br/>";
				}
			}
		}
		
		echo "
		<form action='".$_SERVER['PHP_SELF']."'>
		<table>
			<tr>
				<td>
					Código
				</td>
				<td>
					<input type='text' name='cod' value = '$cod' readonly='readonly'/>
				</td>
			</tr>
			<tr>
				<td>
					Nome
				</td>
				<td>
					<input type='text' name='nome' value = '$nome' autofocus/>
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<input type='hidden' name='alterar' value='true'/>
					<button>Salvar</button>
				</td>
			</tr>
		</table>
		</form>";
		mysql_close();
	?>
</body>
</html>