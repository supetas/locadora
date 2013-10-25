<?php
session_start();
if(!isset($_SESSION['logado'])){
	header('Location:/aksjdji/login.php');
	exit();
}
echo "<h2>Funcionário: ".$_SESSION['logado']['nome']."</h2>";
?>