<?php

session_start();

require("config.php");
require("template.php");


$conn = mysqli_connect($db_server, $db_user, $db_pass, $db);

if(isset($_GET["id_product"])){

	$id_product = intval($_GET["id_product"]);
	$query = <<<EOD
	SELECT * FROM products WHERE id_product={$id_product};
EOD;
	}
else{
	$query = <<<EOD
	SELECT * FROM products;
EOD;
}

$res = $conn->query($query);



$content = "";

if ($res->num_rows > 1){
	while($prod = $res->fetch_assoc()){
		$content .= <<<EOD
	<section>
	<h2>{$prod["product"]}</h2>
	<p><a href="shop.php?id_product={$prod["id_product"]}">Ver</a></p>
	</section>
EOD;
	}

}
else if ($res->num_rows == 1){

$product = $res->fetch_assoc();

	$admin_link = "";
	$buy_link = "";
	if(isset($_SESSION["id_user"])){
		if($_SESSION["id_user"] == 1){
			$admin_link = <<<EOD
<p>[ <a href="admin.php?id_product={$product["id_product"]}">EDITAR</a> ] </p>
EOD;
		}
		else{
			$query = <<<EOD
SELECT * FROM users_products
WHERE id_user={$_SESSION["id_user"]} AND id_product={$product["id_product"]};
EOD;
	
			$res = $conn->query($query);
			if($res){
				if($res->num_rows == 0){
					$buy_link = <<<EOD
<form method="post" action="buy_req.php">
<input type="hidden" name="id_product" value="{$product["id_product"]}" />
<p><input type="submit" value="COMPRAR!!!" /></p>
</form>
EOD;
				}
				else{
					$buy_link = "<p>COMPRADO!!!</p>";
				}
			}
		}
	}

$query = <<<EOD
SELECT * FROM groups WHERE id_group={$product["id_group"]};
EOD;

$res = $conn->query($query);
$group_id = $res->fetch_assoc();

$query = <<<EOD
SELECT * FROM engines WHERE id_engine={$product["id_engine_version"]};
EOD;

$res = $conn->query($query);
$engine_id = $res->fetch_assoc();


$content = <<<EOD
<p><strong>{$product["product"]}</strong></p>
{$admin_link}
{$buy_link}
<p> {$product["description"]}</p>
<p><strong>Precio:</strong> {$product["price"]}</p>
<p><strong>Referencia:</strong> {$product["reference"]}</p>
<p><strong>Descuento:</strong> {$product["discount"]}</p>
<p><strong>Unidades vendidas:</strong> {$product["units_sold"]}</p>
<p><strong>Página web:</strong> {$product["website"]}</p>
<p><strong>Tamaño:</strong> {$product["size"]} <strong> MB</strong></p>
<p><strong>Duración:</strong> {$product["duration"]}</p>
<p><strong>Fecha de salida:</strong> {$product["release_date"]}</p>
<p><strong>Grupo:</strong> {$group_id["group"]}</p>
<p><strong>Versión:</strong> {$engine_id["engine"]}</p>

EOD;
}
else{
 $content = "No hay productos con esa referencia";
}

showHeader("ENTIenda: Tienda");
showContent($content);
showFooter();

?>
