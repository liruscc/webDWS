<?php
$ref = array();
$cat = false;
$subcat = false;
//Guardamos la referencia que viene en la url en la variable referencia
if(isset($_GET["cat"])){
	$cat = $_GET["cat"];
}
if(isset($_GET["subcat"])){
	$subcat = $_GET["subcat"];	
}
$referencia = $_GET["ref"];
$precio = $_GET["pre"];

//Comprobamos si a cookie existe
if(isset ($_COOKIE["carrito"][$referencia])){
	//Si ya existe valor para la referencia aumentamos el valor en +1
	setcookie("carrito[$referencia]",$_COOKIE["carrito"][$referencia]+1,time()+3600);
}
else{
	//Si no existe el valor para la referencia creamos la cookie con valor 1
	setcookie("carrito[$referencia]",1,time()+3600);
}

//Redirigimos a la tienda
header("Location: index.php?cat=".$cat."&subcat=".$subcat);
?>