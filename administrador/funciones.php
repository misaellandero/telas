<?php
function conectar($servidor, $user, $pass, $name)
{
	$con = @mysql_connect($servidor, $user, $pass);
<<<<<<< HEAD
	@mysql_select_db($name, $con);
=======
	@mysql_select_db($name, $con);	
>>>>>>> parent of fd9289d... Revert "commit inicial"
}

function retConectar($servidor, $user, $pass)
{
	$con = @mysql_connect($servidor, $user, $pass);

	return $con;

}

<<<<<<< HEAD
?>
=======
?>
>>>>>>> parent of fd9289d... Revert "commit inicial"
