<?php

session_start();

$conexao = mysql_connect('localhost:3306','root','');
mysql_select_db('locadora',$conexao);
// check if connection failed
if(!$conexao){
	$_SESSION['resposta'] = "<font color='red'>SQL ERROR = ".mysql_error()."</font>";
} else {
	$codFilme = $_GET['codFilme'];
	
	$sql = "
		SELECT f.cod,f.nome
		FROM filmes as f
		WHERE f.cod = '$codFilme'";
	
	$result = mysql_query($sql);
	
	if(list($cod,$nome) = mysql_fetch_array($result)){
		// verifica se já tem algum filme adicionado;
		if(!isSet($_SESSION['filmesLocados']['size'])){
			$_SESSION['filmesLocados']['size'] = 0;
		}
		
		// atribui a $i o valor atual do tamanho do vetor filmesLocados para usa-lo como posição para adicionar outro vetor
		$i = $_SESSION['filmesLocados']['size'];
		
		// adiciona o filme a variavel de sessao
		$_SESSION['filmesLocados'][$i]['cod'] = $cod; 
		$_SESSION['filmesLocados'][$i]['nome'] = $nome;
		
		// incrementa o size para informar que tem mais um filme selecionado
		$_SESSION['filmesLocados']['size'] = ($_SESSION['filmesLocados']['size'] + 1);
		
		echo $_SESSION['filmesLocados'][$i]['cod'] . '<br/>';
		echo $_SESSION['filmesLocados'][$i]['nome'] . '<br/>';
		echo $_SESSION['filmesLocados']['size'] . '<br/>';
	} else {
			$_SESSION['resposta'] = '<font color=red>O filme não foi selecionado.</font>';
	}
}
mysql_close();
header('Location:../control/cadastrarLocacao.php');
		
?>