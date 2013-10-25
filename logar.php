<?php
	session_start();
	$login = $_POST['login'];
	$pass = $_POST['pass'];
	
	$sql = "SELECT login,nome FROM funcionario WHERE login = '$login' AND pass = '$pass'";
	
	$conexao = mysql_connect('localhost:3306','root','');
	mysql_select_db('locadora',$conexao);
	// check if connection failed
	if(!$conexao){
		$_SESSION['resposta'] = "<font color='red'>SQL ERROR = ".mysql_error()."</font>";
	} else {
		$result = mysql_query($sql);
		echo $sql;
		if($row = mysql_fetch_array($result)) 
		{
			$_SESSION['logado']['login'] = $row[0];
			$_SESSION['logado']['nome'] = $row[1];
			
		} else {
			$_SESSION['resposta'] = "<font color='red'>Login ou Senha incorreto!</font>";
		}
	}
	mysql_close();
	
	header('Location:.');

?>