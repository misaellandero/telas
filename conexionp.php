<?php
	class conexion{
		function recuperarDatos(){
			$host = "localhost";
			$user = "u722193362_root";
			$pw = "03032014";
			$db = "u722193362_date";

			$con = mysql_connect($host, $user, $pw) or die("No se pudo conectar a la base de datos ");
			mysql_select_db($db, $con) or die ("No se encontro la base de datos. ");
			

		}
	}
?>