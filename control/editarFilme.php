<?php include '../style.php'; ?>
<html>

<title>Editar Filme - Sistema de Locadora de Filmes</title>
<body>
	<h1 align="center">Editar Filme - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';?>	
	
	<?php
		$conexao = mysql_connect('localhost:3306','root','');
		mysql_select_db('locadora',$conexao);
		
		$cod = '';
		$nome = '';
		$qtd = '';
		$cod_categoria1 = '';
		$cod_categoria2 = '';
		$cod_categoria3 = '';
		
		if(isSet($_GET['cod'])){
			$cod = $_GET['cod'];
			$nome = $_GET['nome'];
			$qtd = $_GET['qtd'];
			$cod_categoria1 = $_GET['cod_categoria1'];
			$cod_categoria2 = $_GET['cod_categoria2'];
			$cod_categoria3 = $_GET['cod_categoria3'];
			
		}
		if(isSet($_GET['alterar'])){
			
			$sql = "UPDATE filmes SET nome='$nome',qtd=$qtd,categoria1=$cod_categoria1,categoria2=$cod_categoria2,categoria3=$cod_categoria3 WHERE cod=$cod";
			if($conexao){
				$result = mysql_query($sql);
				if($result){
					echo "<font color='lime'>Filme $nome atualizado com sucesso!</font> <br/><br/>";
				} else {
					echo "<font color='red'>Filme $nome não pode ser atualizado! ERROR = ".mysql_error()."</font><br/><br/>";
					echo $sql;
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
					Quantidade
				</td>
				<td>
					<input type='text' name='qtd' value = '$qtd'/>
				</td>
			</tr>";
			
			$categorias = array();
			
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
								if($cod_categoria1 == $categorias[$i]){
									echo "<option value=$categorias[$i] selected>$categorias[$j]</option>";
								} else {
									echo "<option value=$categorias[$i]>$categorias[$j]</option>";
								}
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
								if($cod_categoria2 == $categorias[$i]){
									echo "<option value=$categorias[$i] selected>$categorias[$j]</option>";
								} else {
									echo "<option value=$categorias[$i]>$categorias[$j]</option>";
								}
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
								if($cod_categoria3 == $categorias[$i]){
									echo "<option value=$categorias[$i] selected>$categorias[$j]</option>";
								} else {
									echo "<option value=$categorias[$i]>$categorias[$j]</option>";
								}
							}
							
						echo "</select>
					</td>
				</tr>
			";
			} else {
				echo "<font color='red'>SQL ERROR = ".mysql_error()."</font>";
			}
		

			
			echo "<tr>
				<td>
				</td>
				<td>
					<input type='hidden' name='categoria1' value='$cod_categoria1'/>
					<input type='hidden' name='categoria2' value='$cod_categoria2'/>
					<input type='hidden' name='categoria3' value='$cod_categoria3'/>
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