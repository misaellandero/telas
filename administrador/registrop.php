<?php

require_once('../funciones.php');
conectar('localhost','root','CornComputerInc1*','sistema');

//Recibir
$descripsion = strip_tags($_POST['descripsion']);



$query = @mysql_query('SELECT * FROM proveedor WHERE descripcion ="'.mysql_real_escape_string($descripsion).'"');
if($existe = @mysql_fetch_object($query))
{
	echo "<script type=\"text/javascript\">alert('Este proveedor ya esta registrado, Use otra clave o use la funcion Editar datos'); window.location='../entrar.php';</script>";


}else{
	$meter = @mysql_query('INSERT INTO proveedor ( descripcion) values ( "'.mysql_real_escape_string($descripsion).'")');
	if($meter)
	{
	echo"<script type=\"text/javascript\">alert('El articulo ha sido registrado con exito'); window.location='../entrar.php';</script>";
	}else{
		echo"<script type=\"text/javascript\">alert('Hubo un error en el registro XDP'); window.location='../entrar.php';</script>";
	}
}

?>
