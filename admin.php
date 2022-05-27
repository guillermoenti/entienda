<?php
session_start();

if (!isset($_SESSION["id_user"])){
	echo "Es obligatorio identificarse";
	exit();
}

if (intval($_SESSION["id_user"]) != 1){
	echo "No tienes permiso para estar aquí!";
	exit();
}

require("template.php");

require("config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db);

$content = "";
$groups = "";
$engines = "";

$dynamic_query = <<<EOD
SELECT * FROM groups;
EOD;



$res = $conn->query($dynamic_query);

while($prod = $res->fetch_assoc()){
$groups .= <<<EOD
	<option value="{$prod["id_group"]}">{$prod["group"]}</option>
EOD;
}

$dynamic_query = <<<EOD
SELECT * FROM engines;
EOD;

$res = $conn->query($dynamic_query);

while($prod = $res->fetch_assoc()){

$engines .= <<<EOD
	<option value="{$prod["id_engine"]}">{$prod["engine"]}</option>
EOD;
}

$id_product = 0;
if(isset($_GET["id_product"])){
	$id_product = intval($_GET["id_product"]);
}

if($id_product == 0){
$content = <<<EOD

<form method="post" action="product_insert_req.php" id="product-form">
<p><label for="product">Product</label><input type="text" name="product" id="product" /></p>
<p><label for="description">Descripcion</label><input type="text" name="description" id="description" /></p>
<p><label for="price">Precio</label><input type="text" name="price" id="price" /></p>
<p><label for="reference">Referencia</label><input type="text" name="reference" id="reference" /></p>
<p><label for="website">Web</label><input type="text" name="website" id="website" /></p>
<p>Grupo</p>
<select for="id_group" name="id_group">{$groups}</select>
<p>Motor</p>
<select for="id_engine_version" name="id_engine_version">{$engines}</select>

<p><input type="submit" /></p>

</form>

<form method="post" action="group_insert_req.php" id="group-form">
<p><label for="group_name">Group name</label><input type="text" name="group_name" id="group_name" /></p>
<p><label for="course">Course</label><input type="text" name="course" id="course" /></p>
<p><label for="jam_year">Jam Year</label><input type="text" name="jam_year" id="jam_year" /></p>
<p><label for="mark">Mark</label><input type="text" name="mark" id="mark" /></p>

<p><input type="submit" /></p>

</form>



EOD;
}else{

require("config.php");
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db);

$query = <<<EOD
	SELECT * FROM products WHERE id_product={$id_product};
EOD;

$res = $conn->query($query);

if(!$res){
	echo "Mala query";
	exit();
}

if($res->num_rows != 1){
	echo "Error, producto erroneo";
	exit();
}

$prod = $res->fetch_assoc();


$content = <<<EOD

<form method="post" action="product_update_req.php" id="product-form">
<input type="hidden" name="id_product" value="{$prod["id_product"]}" />
<p><label for="product">Product</label><input type="text" name="product" id="product" value="{$prod["product"]}" /></p>
<p><label for="description">Descripcion</label><input type="text" name="description" id="description"  value="{$prod["description"]}" //></p>
<p><label for="price">Precio</label><input type="text" name="price" id="price"  value="{$prod["price"]}" //></p>
<p><label for="reference">Referencia</label><input type="text" name="reference" id="reference"  value="{$prod["reference"]}" //></p>
<p><label for="website">Web</label><input type="text" name="website" id="website"  value="{$prod["website"]}" //></p>
<p>Grupo</p>
<select for="id_group" name="id_group" id="id_group">{$groups}</select>
<p>Motor</p>
<select for="id_engine_version" name="id_engine_version" id="id_engine_version">{$engines}</select>

<p><input type="submit" /></p>

</form>

<script>
document.getElementById("id_group").selectedIndex = {$prod["id_group"]}-1;
document.getElementById("id_engine").selectedIndex = {$prod["id_engine_version"]};
</script>

EOD;
}



showHeader("ENTIenda ADMIN");
showContent($content);
showFooter();


?>
