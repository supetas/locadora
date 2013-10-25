<?php include '../style.php'; ?>
<html>

<title>Categorias - Sistema de Locadora de Filmes</title>
<body>
	
	<h1 align="center">Categorias - Sistema de Locadora de Filmes<h1>
	
	<?php include '../menu.php';?>	
	
	<div style="background-color:green">
	<form action = "/aksjdji/view/categorias.php">
		<h6>
			<b>Pesquisar:</b>
			<?php
				$pesq = '';
				
				if(isSet($_GET['pesq'])){
					$pesq = $_GET['pesq'];
				}
				echo "<input type='text' name='pesq' value='$pesq' autofocus/>";
				
			?>
			
			<button>Pesquisar</button>
			
		</h6>
	</form>
	</div>
	
	<a href="/aksjdji/control/cadastrarCategoria.php"><button>Nova Categoria</button></a>
	
	<hr/>
	<?php
		$conexao = mysql_connect('localhost:3306','root','');
		mysql_select_db('locadora',$conexao);
			
		if($conexao){
			if(isSet($_GET['cod'])){
				$cod = $_GET['cod'];
				$nome = $_GET['nome'];
				
				$resultExcluir = mysql_query("DELETE FROM categorias WHERE cod = '$cod'");
				if($resultExcluir){
					echo "<font color='lime'>Categoria $nome deletada com sucesso!</font> <br/><br/>";
				} else {
					$erro = mysql_error();
					$errofk_categoria_esta_sendo_usada = "Cannot delete or update a parent row: a foreign key constraint fails (`locadora`.`filmes`, CONSTRAINT `fk_filmes_categoria1_categorias_cod` FOREIGN KEY (`categoria1`) REFERENCES `categorias` (`cod`))";
					if($erro == $errofk_categoria_esta_sendo_usada){
						echo "<font color='red'>Categoria $nome não pode ser deletada existe um ou mais filmes utilizando esta categoria</font> <br/><br/>";
					} else {
						echo "FALHA NA EXCLUSÃO! " . mysql_error();
					}
				}
			}
			$pesq = '';
			if(isSet($_GET['pesq'])){
					$pesq = $_GET['pesq'];
			}
				$result = mysql_query("SELECT cod,nome FROM categorias WHERE nome like '$pesq%' ORDER BY nome");
				
				if($result){
					echo "<table border=1>
					<tr>
						<td>
							<b>Código</b>
						</td>
						<td>
							<b>Nome</b>
						</td>
						<td>
							<b>Delete</b>
						</td>
						<td>
							<b>Editar</b>
						</td>
					</tr>";
					while($row = mysql_fetch_array($result)){
						echo "
						<tr>
							<td>
								".$row['cod']."
							</td>
							<td>
								".$row['nome']."
							</td>
							<td>
								<form action='".$_SERVER['PHP_SELF']."'>
									<input type='hidden' name='cod' value = '".$row['cod']."'/>
									<input type='hidden' name='nome' value = '".$row['nome']."'/>
									<input type='hidden' name='pesq' value = '".$pesq."'/>
									<button>Delete</button>
								</form>
							</td>
							<td>
								<form action='/aksjdji/control/editarCategoria.php'>
									<input type='hidden' name='cod' value = '".$row['cod']."'/>
									<input type='hidden' name='nome' value = '".$row['nome']."'/>
									<button>Editar</button>
								</form>
							</td>
						</tr>";
					}
					echo '</table>';
				} else {
					echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
				}
				
		}else {
			echo "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
		}
		mysql_close();
	?>
</body>
</html>