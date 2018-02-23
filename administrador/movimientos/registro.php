<?php

//var_dump($_POST);die();

require_once('../../funciones.php');
conectar('localhost', 'u722193362_root','03032014','u722193362_date');

session_start();
$usuario = $_SESSION['MM_Username'];

$id_art_tela = $_POST['id-art-tela'];
$codigo = $_POST['codigo'];
// $Producto = $_POST['Producto'];
// $tipo = $_POST['tipo'];
// $Descripcion = $_POST['Descripcion'];
// $talla = $_POST['talla'];
$Cantidad= $_POST['cantidad'];
$tipo = $_POST["tipo-movimiento"];

for($i = 0; $i<count($codigo); $i++) {
	
	if ($Cantidad[$i] === 'All') {
		$sql = "SELECT metros FROM rollos_telas WHERE codigo =  " . $codigo[$i];
		$retval = mysql_query($sql);
		if (!$retval) {
			echo mysql_error();
			return;
		}

		$fila = mysql_fetch_array($retval);
		$metros = $fila['metros'];

		$Cantidad[$i] = $metros;
	}


	$sql = "Insert Into hist_mov_ent_sal_telas (codigo_id,tipo_mov,cantidad,usuario) 
		values('" . $codigo[$i] . "','".$tipo."', " .$Cantidad[$i] . ",'".$usuario."');";
	$retval = mysql_query( $sql);
	if (!$retval){
		echo mysql_error();
		return;
	}

	$sql = "Update art_telas SET metros = (metros ". ($tipo === "entrada" ? "+" : "-")." ". $Cantidad[$i] . ") WHERE id = '" . $id_art_tela[$i] . "'" ;
	$retval = mysql_query( $sql);
	if (!$retval){
		echo mysql_error();
		return;
	}

	if ($tipo === "entrada") {
		$sql = "INSERT INTO rollos_telas (codigo,id_art_telas,metros) VALUES (
			'" . $codigo[$i] . "', '" . $id_art_tela[$i]. "', '".$Cantidad[$i]."')";		
	} else {
		$sql = "Update rollos_telas SET metros = (metros ". ($tipo === "entrada" ? "+" : "-")." ". $Cantidad[$i] . ") WHERE codigo = '" . $codigo[$i] . "'" ;	
	}
	
	$retval = mysql_query( $sql);
	if (!$retval){
		echo mysql_error();
		return;
	}

	$sql = "SELECT metros FROM rollos_telas WHERE codigo = '" . $codigo[$i] . "'";
	$retval = mysql_query($sql);
	if (!$retval){
		echo mysql_error();
		return;
	}

	$reg = mysql_fetch_array($retval);
	$metros = $reg['metros'];

	if ($metros <= 0) {
		$sql = "DELETE FROM rollos_telas WHERE codigo = '" . $codigo[$i] . "'";
		$retval = mysql_query($sql);
		if (!$retval){
			echo mysql_error();
			return;
		}
	}
}


echo"<script type=\"text/javascript\">alert('El proceso se realizo con exito'); window.location='../../entrar.php';</script>"; 


?>
