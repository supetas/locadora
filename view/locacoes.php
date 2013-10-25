<?php 
include '../style.php';
include '../js.php'; ?>


<html>

<title>Locações - Sistema de Locadora de Filmes</title>
<body>
	
	<h1 align="center">Locações - Sistema de Locadora de Filmes<h1>
	
	<?php 
		include '../menu.php';

		if(isset($_SESSION['resposta'])){
			echo $_SESSION['resposta'].'<br/>';
			unset($_SESSION['resposta']);
		}
		
		echo "<div style='background-color:green'>
		<form action = '".$_SERVER['PHP_SELF']."'>
		<h6>";
			if(isset($_GET['fechados']) && $_GET['fechados'] == true){
				echo "<input type='checkbox' name='fechados' value='true' checked/>Incluir Locação Encerradas</br></br>";
			} else {
				echo "<input type='checkbox' name='fechados' value='true'/>Incluir Locação Encerradas</br></br>";
			}
		echo "<b>CPF do cliente:</b>";
			
				$pesq = '';
				
				if(isSet($_GET['pesq'])){
					$pesq = $_GET['pesq'];
				}
			echo "<input type='text' name='pesq' value='$pesq' onkeypress=\"return mascara(this,'###.###.###-##')\" maxlength = '14' autofocus/>
				
			
			<button>Pesquisar</button>
			
		</h6>
	</form>
	</div>
	
	<a href='/aksjdji/control/novaLocacao.php'><button>Nova Locação</button></a>";
	
		if(isset($_SESSION['cliente'])){
			echo "<a href='/aksjdji/control/cadastrarLocacao.php'><button>Continuar Locação Anterior</button></a>";
		}
		echo "<hr/>";
	
	
		$conexao = mysql_connect('localhost:3306','root','');
		mysql_select_db('locadora',$conexao);
			
		$pesq = '';
		
		if(isSet($_GET['pesq'])){
			$pesq = $_GET['pesq'];
		}
		if($pesq == ''){
			$sql = "SELECT cod,cpf_cliente,data_locacao,data_entrega_prevista,data_entrega,qtd_filmes,valor FROM locacoes WHERE data_entrega is null ORDER BY data_entrega_prevista, data_locacao LIMIT 20";
		} else {
			if(isset($_GET['fechados']) && $_GET['fechados'] == true){
				$sql = "SELECT cod,cpf_cliente,data_locacao,data_entrega_prevista,data_entrega,qtd_filmes,valor FROM locacoes WHERE cpf_cliente = '$pesq' ORDER BY data_entrega_prevista, data_locacao";
			} else {
				$sql = "SELECT cod,cpf_cliente,data_locacao,data_entrega_prevista,data_entrega,qtd_filmes,valor FROM locacoes WHERE cpf_cliente = '$pesq' AND data_entrega is null ORDER BY data_entrega_prevista, data_locacao";
			}
			
		}
		$result = mysql_query($sql);
				
				if($result){
					$hoje = date('Y-m-d');
					
					$hoje = strtotime($hoje);
					
					$amanha = $hoje + 86400;
						echo "<table border=1>
					<tr>
						<td>
							<b>Código</b>
						</td>
						<td>
							<b>Cpf do Cliente</b>
						</td>
						<td>
							<b>Data Locação</b>
						</td>
						<td>
							<b>Data Prevista de Entrega</b>
						</td>
						<td>
							<b>Data Entrega</b>
						</td>
						<td>
							<b>Quantidade</b>
						</td>
						<td>
							<b>Valor</b>
						</td>
						<td>
							<b>Filmes</b>
						</td>
						<td>
							<b>Finalizar</b>
						</td>
					</tr>";
					while($row = mysql_fetch_array($result)){
						echo "
						<tr>
							<td>
								".$row['cod']."
							</td>
							<td>
								".$row['cpf_cliente']."
							</td>
							<td>
								".$row['data_locacao']."
							</td>
							<td>";
								$prevista = strtotime($row['data_entrega_prevista']);
								$dataPrevista = $row['data_entrega_prevista'];
								
								if($prevista < $hoje){
									echo "<font color='red'>$dataPrevista</font>";
								} elseif($prevista == $hoje) {
									echo "<font color='orange'>$dataPrevista</font>";
								} else {
									echo "<font color='lime'>$dataPrevista</font>";
								}
						echo "
							</td>
							<td>
								";
								$entrega = strtotime($row['data_entrega']);
								
								$dataEntrega = $row['data_entrega'];
								
								if($entrega > ($prevista + 86399)){
									echo "<font color='red'>$dataEntrega</font>";
								} else {
									echo "<font color='lime'>$dataEntrega</font>";
								}
						echo "
							</td>
							<td>
								".$row['qtd_filmes']."
							</td>
							<td>
								".$row['valor']."
							</td>
							<td>
								<form action='filmesLocados.php'>
									<input type='hidden' name='cod' value = '".$row['cod']."'/>
									<button>Filmes</button>
								</form>
							</td>
							<td>
								<form action='/aksjdji/model/finalizarLocacao.php'>
									<input type='hidden' name='cod' value = '".$row['cod']."'/>";
									if($row['data_entrega'] == ''){
										echo "<button onclick=\"return confirm('Tem certeza que deseja finalizar esta locação?')\">Finalizar</button>";
									} else {
										echo 'Finalizada!';
									}
								echo "</form>
							</td>
						</tr>";
					}
					echo '</table>';
				} else {
					$_SESSION['resposta'] = "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
					header('Location:locacoes.php');
				}
		
		mysql_close();
	?>
</body>
</html>