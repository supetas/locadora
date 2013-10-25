<?php 
include '../style.php'; 
include '../js.php';
?>

<html>

<title>Cadastrar Filmes - Sistema de Locadora de Filmes</title>
<body>
	<h1 align="center">Cadastrar Filmes - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';?>	
	
	<?php
		if(isSet($_GET['nome'])){
			$nome = $_GET['nome'];
			$qtd = $_GET['qtd'];
			$cod_categoria1 = $_GET['cod_categoria1'];
			$cod_categoria2 = $_GET['cod_categoria2'];
			$cod_categoria3 = $_GET['cod_categoria3'];
			$sql = "INSERT INTO filmes (nome,qtd,categoria1,categoria2,categoria3) VALUES ('$nome','$qtd',$cod_categoria1,$cod_categoria2,$cod_categoria3)";
			
			if($nome != ''){
				$conexao = mysql_connect('localhost:3306','root','');
				mysql_select_db('locadora',$conexao);
				if($conexao){
					$result = mysql_query($sql);
					if($result){
						echo "<font color='lime'>$nome cadastro com sucesso!!!</font>";
					} else {
						echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
					}
				} else {
					echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
				}
				mysql_close();
			} else {
				echo "<font color='red'>Nome é obrigatório!!!</font>";
			}
			
		}
	?>
	</div>
	<hr/>
	<form action='/aksjdji/control/cadastrarFilme.php'>
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
				Quantidade
			</td>
			<td>
				<input type='text' name='qtd' onkeypress="return mascara(this, '####')" maxlength="4"/>
			</td>
		</tr>
		<?php
			$categorias = array();
			$teste;
			$conexao = mysql_connect('localhost','root','');
			mysql_select_db('locadora',$conexao);
			$result = mysql_query("SELECT cod,nome FROM categorias");
			while(list($cod,$nome) = mysql_fetch_array($result)){
				$categorias[] = $cod;
				$categorias[] = $nome;
			}
			if($conexao && $result){
			echo "
				<tr>
					<td>
						Categoria1
					</td>
					<td>
						<select name='cod_categoria1'>";
							for($i = 0, $j = 1;$j < sizeof($categorias);$i += 2, $j += 2){
								echo "<option value=$categorias[$i]>$categorias[$j]</option>";
							}
							
						echo "</select>
					</td>
				</tr>
			";
			echo "
				<tr>
					<td>
						Categoria 2
					</td>
					<td>
						<select name='cod_categoria2'>
							<option value=null>selecione</option>";
							for($i = 0, $j = 1;$j < sizeof($categorias);$i += 2, $j += 2){
								echo "<option value=$categorias[$i]>$categorias[$j]</option>";
							}
							
						echo "</select>
					</td>
				</tr>
			";
			echo "
				<tr>
					<td>
						Categoria 3
					</td>
					<td>
						<select name='cod_categoria3'>
							<option value=null>selecione</option>";
							for($i = 0, $j = 1;$j < sizeof($categorias);$i += 2, $j += 2){
								echo "<option value=$categorias[$i]>$categorias[$j]</option>";
							}
							
						echo "</select>
					</td>
				</tr>
			";
			} else {
				echo "<font color='red'>SQL ERROR = ".mysql_error()."</font>";
			}
		?>
		
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