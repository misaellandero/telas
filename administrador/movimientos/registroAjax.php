<?php
header('Content-type: application/json');
	switch($_REQUEST['action']){
		case 'entradasKeyUp':
			require_once('../../funciones.php');

			require '../../conexionp.php';

			conectar($host,$user,$pw,$db);
$sql="SELECT * FROM rollos_telas WHERE codigo = '" . mysql_real_escape_string($_POST['codigoBarras']) . "'";
			$rec=mysql_query($sql);
			if ($row=mysql_fetch_array($rec)) {
				//$row=mysql_fetch_array($rec);
				echo json_encode(
					array(
						'codigo' => $row['codigo'],
						'id_art_telas' => $row['id_art_telas'],
						'metros' => $row['metros'],
						'success' => true
					)
				);
			}else{
				echo json_encode(
					array(
						'error' => mysql_error(),
						'success' => false
					)
				);
			}
			break;
		case 'entradas':
			require_once('../../funciones.php');
require '../../conexionp.php';
						conectar($host,$user,$pw,$db);
			$sql="SELECT id FROM art_telas WHERE codigo = '" . mysql_real_escape_string($_POST['codigoBarras']) . "'";
			$rec=mysql_query($sql);
			if ($row=mysql_fetch_array($rec)) {
				$id = $row['id'];
				$sql="SELECT MAX(SUBSTRING(codigo,12,1)) + 1 AS contador FROM rollos_telas WHERE id_art_telas = '" . $id . "'";
				$rec=mysql_query($sql);
				if ($row=mysql_fetch_array($rec)) {
					//$row=mysql_fetch_array($rec);
					echo json_encode(
						array(
							'contador' => empty($row['contador']) ? 0 : $row['contador'],
							'id_art_telas' => $id ,
							'success' => true
						)
					);
				}else{
					echo json_encode(
						array(
							'error' => mysql_error(),
							'success' => false
						)
					);
				}
			} else {
				echo json_encode(
					array(
						'error' => 'Codigo no encontrado',
						'success' => false
					)
				);
			}

			break;
		case 'verificaCodigo':
			require_once('../../funciones.php');
			require '../../conexionp.php';
			conectar($host,$user,$pw,$db);
			$sql='SELECT MAX(CAST(corte as SIGNED)) as corte FROM art_telas WHERE proveedor = "' . $_POST['proveedor'] . '" AND tipo = "' . $_POST['tipo'] . '" AND nombre = "' . $_POST['tela'] . '"';
			$rec=mysql_query($sql);
			if ($row=mysql_fetch_array($rec)) {
				$corte = intval($row['corte']) + 1;
				echo json_encode(
					array(
						'corte' => $corte,
						'select' => $sql,
						'success' => true
					)
				);
			}else{
				echo json_encode(
					array(
						'corte' => 1,
						'success' => true
					)
				);
			}
			break;
		case 'todoRollo':
			require_once('../../funciones.php');
			require '../../conexionp.php';
						conectar($host,$user,$pw,$db);

			$sql = "SELECT metros FROM rollos_telas WHERE codigo =  '" . $_POST['codigoBarras'] . "'";
			$rec=mysql_query($sql);
			if ($row=mysql_fetch_array($rec)) {
				//$row=mysql_fetch_array($rec);
				echo json_encode(
					array(
						'metros' => $row['metros'],
						'success' => true
					)
				);
			}else{
				echo json_encode(
					array(
						'error' => mysql_error(),
						'success' => false
					)
				);
			}
			break;
}
