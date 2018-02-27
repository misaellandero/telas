
<?php
require_once('funciones.php');
conectar('localhost', 'u722193362_root','03032014','u722193362_date');

// Datos recibidos desde el Formulario

//variable($ejemplo) y nombre o id de el input de donde recibe los datos ('ejemplo') 
$Id = strip_tags($_POST['id-hidden']);
$proveedor = strip_tags($_POST['proveedor']);
$tipo = strip_tags($_POST['tipo']);
$tela = strip_tags($_POST['tela']);
$metrosAncho = strip_tags($_POST['metros-ancho']);
$color = strip_tags($_POST['color-visible']);


$compTelap1 = strip_tags($_POST['compo-telap1']);
$compTelas1 = strip_tags($_POST['compo-tela-s1']);
$compTelap2 = strip_tags($_POST['compo-telap2']);
$compTelas2 = strip_tags($_POST['compo-tela-s2']);
$compTelap3 = strip_tags($_POST['compo-telap3']);
$compTelas3 = strip_tags($_POST['compo-tela-s3']);
$compTelap4 = strip_tags($_POST['compo-telap4']);
$compTelas4 = strip_tags($_POST['compo-tela-s4']);

$compTelaTotal = $compTelap1 . "% " . $compTelas1;

if (!empty($compTelap2)) {
	$compTelaTotal .= " - " . $compTelap2 . "% " . $compTelas2;
}

if (!empty($compTelap3)) {
	$compTelaTotal .= " - " . $compTelap3 . "% " . $compTelas3;
}

if (!empty($compTelap4)) {
	$compTelaTotal .= " - " . $compTelap4 . "% " . $compTelas4;
}

$campo1 = strip_tags($_POST['campo1']);
$img = strip_tags($_POST['nombre']);

if (isset($_POST['id-rollo-hidden'])) {
	$idsRollos = $_POST['id-rollo-hidden'];
	$metrosRollos = $_POST['metros-rollo'];
}

if (!empty($_FILES['archivo']['tmp_name'])) {
//Extrae el nombre asignado	
$nom = $_POST['nombre'];
//Esto es un misterio ni idea como funciona pero funciona LOL Xp !!!
//Supongo el archivo extradio y su nombre son remplzados por el nombre asignado 
$ext = substr($_POST['name_image'], strrpos($_POST['name_image'], '.'));
//se crea un nuevo archivo con el nombre creado y la extención del original
$valor = $nom.$ext;
// el archivo es guardado en la  carpeta 
move_uploaded_file($_FILES['archivo']['tmp_name'], "files/".$valor);
// Mensaje de confirmación, no mostrado por entrar en conflico con el codigo del form  
//echo "<script>alert('El archivo ha sido cargado correctamente')</script>";
}

$msj = "";
$codigosNoExistentes = array();
$metrosCodigosNoExistentes = array();
for ($i = 0; $i < count($idsRollos); $i++) {
	$sql = mysql_query('SELECT * FROM rollos_telas WHERE codigo = '. $idsRollos[$i]);
	if (!$existe = @mysql_fetch_object($sql)) {
		$codigosNoExistentes[] = $idsRollos[$i];
		$metrosCodigosNoExistentes[] = $metrosRollos[$i];
	} else {
		$msj .= ' , ' . $idsRollos[$i];
	}
}
	
//Si no existe lo inserta dentro de la base de datos (insert into base de datos) en los campos (campo1, campo2, campo 3) los valores (variable1, variable2, variable 3 etc..)
$query = @mysql_query('SELECT * FROM art_telas WHERE codigo = ' . $Id);

if (!$existe = mysql_fetch_object($query)) {
	
	$meter = mysql_query('INSERT INTO art_telas (codigo,proveedor,tipo,nombre,metros, composicion_tela, campo1, metros_ancho, color_visible, img) 
		values ("'.$Id.'", "' . $proveedor . '" ,"'.$tipo.'", "'.$tela.'", "'.array_sum($metrosCodigosNoExistentes).'", "'.$compTelaTotal.'", "' . $campo1 .'", "' . $metrosAncho . '", "' . $color . '", "files/'.$valor.'")');
	$id_art = mysql_insert_id();
	if($meter)
	{		

		for ($i = 0; $i < count($codigosNoExistentes); $i++) {
			$meter = mysql_query('INSERT INTO rollos_telas (codigo, id_art_telas, metros)
				values ("'.$codigosNoExistentes[$i].'","' . $id_art . '","'.$metrosCodigosNoExistentes[$i].'")');			
			if (!$meter) {
				$msj .= '\nHa ocurrido un error al ingresar el rollo ' . $codigosNoExistentes[$i];
			}
		}

		if (empty($msj)) {
			echo"El articulo ha sido registrado con exito"; 
		}else{
			echo"Los siguientes codigos ya existen: " . $msj . " \n por lo tanto no pudieron ser registrados";
		}

	}else{
		// si el articulo no fue  registro con exito manda el siguiente Mensaje
		echo"Hubo un error en el registro " . mysql_error(); 
	}
} else {
	echo"La tela con ese codigo ya existe, favor de verificarlo"; 
}

?>