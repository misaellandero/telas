<?php

require '../conexionp.php';
function conectar ($servidor, $user, $pass, $name)

{
	$con =@mysql_connect($servidor, $user, $pass);
	@mysql_select_db($name, $con );
}
$conexion=mysql_connect($host,$user,$pw);

if(!$conexion)
{
	die("No se pudo realizar la conexión a la Db" . mysql_error());

	mysql_select_db($db,&conexion);
}
?>
