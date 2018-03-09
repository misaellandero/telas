<?php

$host= "localhost";
$user = "u315449203_sis";
$pw = "CornComputerInc1*";
$db = "u315449203_sis";

	class conexion{
		function recuperarDatos(){

			$con = mysql_connect($host, $user, $pw) or die("No se pudo conectar a la base de datos ");
			mysql_select_db($db, $con) or die ("No se encontro la base de datos. ");

		}
	}


		return new PDO('mysql:host='.$host.';dbname='.$db,$user,$pw);


?>
