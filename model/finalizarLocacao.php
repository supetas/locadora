<?php
	include '../menu.php';
	session_start();
	$data_entrega = date('Y-m-d H:i:s');
	$cod_locacao = $_GET['cod'];
	$conexao = mysql_connect('localhost:3306','root','');
				mysql_select_db('locadora',$conexao);
				if($conexao){
					$sql = "UPDATE locacoes SET data_entrega = '$data_entrega' WHERE cod = $cod_locacao";
					
					$result = mysql_query($sql);
					if($result){
						$_SESSION['resposta'] = "<font color='lime'>Locação $cod_locacao entrege as $data_entrega com sucesso!</font>";
					} else {
						$_SESSION['resposta'] = mysql_error() . '<br/>' . $sql;
						mysql_close();
						header('Location:../view/locacoes.php');
						exit();
					}
				} else {
					$_SESSION['resposta'] = "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
					mysql_close();
					header('Location:../view/locacoes.php');
					exit();
				}
				$_SESSION['resposta'] = $sql;
				mysql_close();
	
	header('Location:../view/locacoes.php');
?>