<?php

require_once('../funciones.php');
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
conectar('localhost','root','CornComputerInc1*','sistema');
=======
conectar('localhost', 'u722193362_root','03032014','u722193362_date');
>>>>>>> parent of fd9289d... Revert "commit inicial"
=======
conectar('localhost', 'u722193362_root','03032014','u722193362_date');
>>>>>>> parent of fd9289d... Revert "commit inicial"
=======
conectar('localhost', 'u722193362_root','03032014','u722193362_date');
>>>>>>> parent of fd9289d... Revert "commit inicial"

//Recibir
$Id = strip_tags($_POST['Id']);
$descripsion = strip_tags($_POST['descripsion']);



$query = @mysql_query('SELECT * FROM tela  WHERE Id ="'.mysql_real_escape_string($Id).'"');
if($existe = @mysql_fetch_object($query))
{
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
	echo "<script type=\"text/javascript\">alert('Esta tela ya esta registrado, Use otra clave o use la funcion Editar datos'); window.location='../entrar.php';</script>";


=======
	echo "<script type=\"text/javascript\">alert('Esta tela ya esta registrado, Use otra clave o use la funcion Editar datos'); window.location='../entrar.php';</script>"; 
	
	
>>>>>>> parent of fd9289d... Revert "commit inicial"
=======
	echo "<script type=\"text/javascript\">alert('Esta tela ya esta registrado, Use otra clave o use la funcion Editar datos'); window.location='../entrar.php';</script>"; 
	
	
>>>>>>> parent of fd9289d... Revert "commit inicial"
=======
	echo "<script type=\"text/javascript\">alert('Esta tela ya esta registrado, Use otra clave o use la funcion Editar datos'); window.location='../entrar.php';</script>"; 
	
	
>>>>>>> parent of fd9289d... Revert "commit inicial"
}else{
	$meter = @mysql_query('INSERT INTO tela (Id, Descripcion) values ("'.$Id.'", "'.mysql_real_escape_string($descripsion).'")');
	if($meter)
	{
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
	echo"<script type=\"text/javascript\">alert('El articulo ha sido registrado con exito'); window.location='../entrar.php';</script>";
	}else{
		echo"<script type=\"text/javascript\">alert('Hubo un error en el registro XDP'); window.location='../entrar.php';</script>";
=======
	echo"<script type=\"text/javascript\">alert('El articulo ha sido registrado con exito'); window.location='../entrar.php';</script>"; 
	}else{
		echo"<script type=\"text/javascript\">alert('Hubo un error en el registro XDP'); window.location='../entrar.php';</script>"; 
>>>>>>> parent of fd9289d... Revert "commit inicial"
=======
	echo"<script type=\"text/javascript\">alert('El articulo ha sido registrado con exito'); window.location='../entrar.php';</script>"; 
	}else{
		echo"<script type=\"text/javascript\">alert('Hubo un error en el registro XDP'); window.location='../entrar.php';</script>"; 
>>>>>>> parent of fd9289d... Revert "commit inicial"
=======
	echo"<script type=\"text/javascript\">alert('El articulo ha sido registrado con exito'); window.location='../entrar.php';</script>"; 
	}else{
		echo"<script type=\"text/javascript\">alert('Hubo un error en el registro XDP'); window.location='../entrar.php';</script>"; 
>>>>>>> parent of fd9289d... Revert "commit inicial"
	}
}

?>
