<h3>Editar Datos</h3>
<form id="registroi" action="registroi.php" method="POST" enctype="multipart/form-data">

 <label>Imagen</label><p>
 		
 		<input type="hidden" name="data_img" class="data_img" value="" />
		<input type="hidden" name="name_img" class="name_img" value="" />

 		<input type="hidden" name='id-art' id="id-art-update-image" value="">
 		<input type="hidden" name='nombre-image-anterior' id="nombre-image-anterior-update" value="">
		<input type="text" id="nombrer-update-image" name="nombrer" required style="height:25px"> 
        <p>
        <label>Cargar Nueva Imagen</label>
		<input type="file"  id="archivo-update" name="archivo" style="height:35px" >

		<p> <label>Rotacion de imagen (grados 45, 90, 180)</label><p> 
				<input type="button" class="btn btn-default rotar-imagen" data-rotar="45" value="Rotar 45" />
				<input type="button" class="btn btn-default rotar-imagen" data-rotar="90" value="Rotar 90" />
				<input type="button" class="btn btn-default rotar-imagen" data-rotar="180" value="Rotar 180" />
				<input type="button" class="btn btn-default rotar-imagen" data-rotar="270" value="Rotar 270" />
		<p>
<label>Ancho del Rollo </label>
<p>
<input type="number" id="ancho-update-ancho" name="ancho" required step="0.01" style="height:25px" > 
<p>
<label>Color Visible </label>
<p>
<input type="text" id="color-update-color" name="color" required style="height:25px"> 
<p>
	<input type="submit" id="cargar" name="cargar" value="Registrar" class="btn btn-success" >
            
	</form>
      
