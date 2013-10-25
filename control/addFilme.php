<?php
if(isset($_GET['filmeAdd'])){
	setcookie("user",$_GET['filmeAdd']);
}
$up[0]['nome'] = 'Clairton';
$up[0]['sobre'] = 'Carneiro';
$up[0]['end'] = 'Luz';
setcookie('ff', $up);
	//	header("Location:cadastrarLocacao.php");
?>
