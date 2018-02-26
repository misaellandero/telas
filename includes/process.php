<?php
	if (isset($_POST['tag'])) {
		switch ($_POST['tag']) {
			case 'getData':
				try {
					$conn = require_once 'connect.php';

					$sql = "SELECT *, (SELECT id FROM proveedor WHERE descripcion = proveedor LIMIT 1) 
					as num_proveedor, 
					(SELECT COUNT(*) FROM rollos_telas WHERE id_art_telas =  tela.id) as rollos 
					FROM art_telas as tela";
					$result = $conn->prepare($sql) or die ($sql);

					if (!$result->execute()) return false;

					if ($result->rowCount() > 0) {
						$json = array();
						while ($row = $result->fetch()) {
							$json[] = array(
								'id' => $row['id'],
								'codigo' => $row['codigo'],
								'proveedor' => $row['proveedor'],
								'num_proveedor' => $row['num_proveedor'],
								'tipo' => $row['tipo'],
								'nombre' => $row['nombre'],
								'metros' => $row['metros'],
								'composicion' => $row['composicion_tela'],
								'campo1' => $row['campo1'],
								'ancho' => $row['metros_ancho'],
								'color' => $row['color_visible'],
								'img' => $row['img'],
								'date' => $row['date'],
								'rollos' => $row['rollos']
							);
						}

						$json['success'] = true;
						echo json_encode($json);
					}
				} catch (PDOException $e) {
					echo 'Error: '. $e->getMessage();
				}
			break;
			case 'busqueda':
				try {
					$conn = require_once 'connect.php';

					if ($_POST['fecha'] === 'Todos') {
						$sql = "SELECT * FROM rollos_telas WHERE id_art_telas = " . $_POST['id-tela'];
					} else {
						$sql = "SELECT * FROM rollos_telas WHERE id_art_telas = " . $_POST['id-tela'] . 
						" AND DATE_FORMAT(fecha_creacion,'%Y-%m-%d') = '" . $_POST['fecha'] . "'";
					}

					$result = $conn->prepare($sql) or die ($sql);

					if (!$result->execute()) return false;

					$json = array();
					if ($result->rowCount() > 0) {						
						while ($row = $result->fetch()) {
							$fecha = new DateTime($row['fecha_creacion']);
							$json[] = array(
								'id' => $row['id'],
								'codigo' => $row['codigo'],
								'metros' => $row['metros'],
								'fecha_creacion' => $fecha->format('Y-m-d'),
							);
						}
						
						echo json_encode($json);
					}
				} catch (PDOException $e) {
					echo 'Error: '. $e->getMessage();
				}
			break;
		}		
	}

?>