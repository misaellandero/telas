<?php
function conectar($servidor, $user, $pass, $name)
{
	$con = @mysql_connect($servidor, $user, $pass);
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
	@mysql_select_db($name, $con);
=======
	@mysql_select_db($name, $con);	
>>>>>>> parent of fd9289d... Revert "commit inicial"
=======
	@mysql_select_db($name, $con);	
>>>>>>> parent of fd9289d... Revert "commit inicial"
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
<<<<<<< HEAD
<<<<<<< HEAD
?>
=======
?>
>>>>>>> parent of fd9289d... Revert "commit inicial"
=======
?>
>>>>>>> parent of fd9289d... Revert "commit inicial"
=======
?>
>>>>>>> parent of fd9289d... Revert "commit inicial"
