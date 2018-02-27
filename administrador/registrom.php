<?php

require_once('../funciones.php');
require '../conexionp.php';

conectar($host,$user,$pw,$db);

//Recibir
$Id = strip_tags($_POST['Id']);
$descripsion = strip_tags($_POST['descripsion']);



$query = @mysql_query('SELECT * FROM modelo  WHERE Id ="'.mysql_real_escape_string($Id).'"');
if($existe = @mysql_fetch_object($query))
{
	echo "<script type=\"text/javascript\">alert('Este Modelo ya esta registrado, Use otra clave o use la funcion Editar datos'); window.location='../entrar.php';</script>";


}else{
	$meter = @mysql_query('INSERT INTO modelo (Id, descripsion) values ("'.$Id.'", "'.mysql_real_escape_string($descripsion).'")');
	if($meter)
	{
	echo"<script type=\"text/javascript\">alert('El articulo ha sido registrado con exito'); window.location='../entrar.php';</script>";
	}else{
		echo"<script type=\"text/javascript\">alert('Hubo un error en el registro XDP'); window.location='../entrar.php';</script>";
	}
}

?>
