<?php
	session_start();
	$cpf_cliente = $_SESSION['cliente'][0];
	$data_locacao = $_GET['data_locacao'];
	$data_locacao = date('Y-m-d H:i:s',strtotime($data_locacao));
	$dia_entrega_prevista = $_GET['dia_entrega'];
	$mes_entrega_prevista = $_GET['mes_entrega'];
	$ano_entrega_prevista = $_GET['ano_entrega'];
	$entrega_prevista = $ano_entrega_prevista . '-' . $mes_entrega_prevista . '-' . $dia_entrega_prevista;
	$qtdFilmes = $_SESSION['filmesLocados']['size'];
	$valor = $_GET['valor'];
	
	if(!(isset($_SESSION['cliente']) && isset($_SESSION['filmesLocados']))){
		$_SESSION['resposta'] = "<font color='red'>Para finalizar a locação tem que selecionar o cliente e pelo menos um filme!!!</font>";
		header('Location:cadastrarLocacao.php');
		exit();
	}
	if(strtotime($data_locacao) > strtotime($entrega_prevista)){
		$_SESSION['resposta'] = "<font color='red'>A data da entrega não pode ser menor que a data da locação.</font>";
		header('Location:cadastrarLocacao.php');
		exit();
	}
	$conexao = mysql_connect('localhost:3306','root','');
				mysql_select_db('locadora',$conexao);
				if($conexao){
					$sql = "INSERT INTO locacoes (cpf_cliente,data_locacao,data_entrega_prevista,qtd_filmes,valor) 
						VALUES ('$cpf_cliente','$data_locacao','$entrega_prevista','$qtdFilmes','$valor')";
					$result = mysql_query($sql);
					if($result){
						$cod_locacao = mysql_insert_id();
						for($i = 0; $i < $qtdFilmes; $i++){
							$cod_filme = $_SESSION['filmesLocados'][$i]['cod'];
							$sql = "INSERT INTO filme_locado VALUES ('$cod_locacao', '$cod_filme')";
							$result = mysql_query($sql);
							if($result){
								$_SESSION['resposta'] = "<font color='lime'>Locação efetuada com sucesso!!!</font>";
							} else {
								$_SESSION['resposta'] = mysql_error() . '<br/>' . $sql;
							}
						}
						
					} else {
						$_SESSION['resposta'] = mysql_error() . '<br/>' . $sql;
					}
				} else {
					$_SESSION['resposta'] = "<font color='red'>SQL ERRO = ".mysql_error()."</font>";
				}
				mysql_close();
				
	unset($_SESSION['cliente']);
	unset($_SESSION['filmesLocados']);
	unset($_SESSION['pesqFilme']);

	header('Location:../view/locacoes.php');
?>