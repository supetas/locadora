<title>Filmes Locados - Sistema de Locadora de Filmes</title> 
<h1 align="center">Filmes Locados - Sistema de Locadora de Filmes<h1>
<?php
include '../style.php';


include '../menu.php'; 
	$cod_locacao = $_GET['cod'];
	echo "<table>";
	$conexao = mysql_connect('localhost:3306','root','');
				mysql_select_db('locadora',$conexao);
				if($conexao){
					$sql = "SELECT fl.cod_filme,f.nome FROM filme_locado as fl
						INNER JOIN filmes as f
						ON fl.cod_filme = f.cod
						WHERE fl.cod_locacao = $cod_locacao";
					
					$result = mysql_query($sql);
					echo "<table border=1>
							<tr>
								<td colspan='2' align='center'>
									<b>Filmes da Locação $cod_locacao</b>
								</td>
							</tr>
							<tr>
								<td>
									<b>Código</b>
								</td>
								<td>
									<b>	Nome</b>
								</td>
							</tr>";
					if($result){
						
						while($row = mysql_fetch_array($result)){
						
							echo "
							<tr>
								<td>
									".$row['cod_filme']."
								</td>
								<td>
									".$row['nome']."
								</td>
							</tr>";
						
						}
						
					} else {
						$_SESSION['resposta'] = mysql_error() . '<br/>' . $sql;
						header('Location:locacoes.php');
						exit();
					}
					echo "</table>";
				} else {
					$_SESSION['resposta'] = "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
					header('Location:locacoes.php');
					exit();
				}
				mysql_close();
	echo "</table>";
	
?>