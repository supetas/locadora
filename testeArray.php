<?php
//array com a lista de produtos
$produtos = array(0 =>"relogio digital",
1 =>"mouse",
2 =>"arame para cerca",
3 =>"bateria de celular",
4 =>"doce de abobora",
5 =>"tv de plasma",
6 =>"pacote de pregos",
7 =>"peneu de caminhao",
8 =>"polvora",
9 =>"prato de porcelana");

//criando a string com a versátil função php implode
$string_array = implode("|", $produtos);
?>

<script>
//variáveis
var i, array_produtos, string_array;
//recebe a string com elementos separados, vindos do PHP
string_array = "<?php echo $string_array; ?>";
//transforma esta string em um array próprio do Javascript
array_produtos = string_array.split("|");

//varre o array só pra mostrar que tá tudo ok
for (i in array_produtos)
alert(array_produtos[i]);

</script>