<?php
require_once('funciones.php');
conectar('localhost', 'u722193362_date','03032014','u722193362_root');
?>

<form id="registro-producto" action="registro.php" method="POST" enctype="multipart/form-data" >


  <label>Clave Principal</label><p>
        <input id="Id" name="Id"  type="int(11)" maxlength="13" required disabled/>
        <input id="id-hidden" name="id-hidden"  type="hidden" maxlength="13"/>

        <input id="id-sugerido" name="id-sugerido"  type="hidden" maxlength="13"/>
<p>

  <label> Proveedor</label><p>
        <select id="proveedor" name="proveedor" type="text" required/>
<?php
$sql="SELECT * FROM proveedor ";
$rec=mysql_query($sql);
while($row=mysql_fetch_array($rec))
{
	echo "<option val='".$row["id"]."'>";
	echo $row['descripcion'];
	echo "</option>";
}
?>
</select>
 <p>

  <label> Tipo</label><p>
        <select  id="tipo" name="tipo" type="text" required/>
<?php
$sql="SELECT * FROM tipo ";
$rec=mysql_query($sql);
while($row=mysql_fetch_array($rec))
{
	echo "<option val='".$row["Id"]."'>";
	echo $row['Descripcion'];
	echo "</option>";
}
?>
</select>
 <p>
<label>Tela</label><p>
        <select id="tela"  name="tela" type="text" required/>
<?php
$sql="SELECT * FROM tela ";
$rec=mysql_query($sql);
while($row=mysql_fetch_array($rec))
{
	echo "<option val='".$row["Id"]."'>";
	echo $row['Descripcion'];
	echo "</option>";
}
?>
</select>
<p>
	<label>Composicion de Tela</label><p>
	<input id="compo-telap1" name="compo-telap1"> %
	<select id="compo-tela-s1" name="compo-tela-s1">
		<option></option>
		<option>Algodon</option>
		<option>Spandex</option>
		<option>Poliester</option>
    <option>Viscosa</option>
      <option>Elastano</option>
	</select>
	<input id="compo-telap2" name="compo-telap2" > %
	<select id="compo-tela-s2" name="compo-tela-s2">
		<option></option>
		<option>Algodon</option>
		<option>Spandex</option>
		<option>Poliester</option>
	</select>
	<input id="compo-telap3" name="compo-telap3" > %
	<select id="compo-tela-s3" name="compo-tela-s3">
		<option></option>
		<option>Algodon</option>
		<option>Spandex</option>
		<option>Poliester</option>
	</select>
	<input id="compo-telap4" name="compo-telap4" > %
	<select id="compo-tela-s4" name="compo-tela-s4">
		<option></option>
		<option>Algodon</option>
		<option>Spandex</option>
		<option>Poliester</option>
	</select>
</p>
 <p>
<label>Tela</label><p>
	<select id="campo1" name="campo1" />
<option>Rigida</option>
<option>Strech</option>
	</select>

<br />
<br />

<label>Metros de ancho</label><p>
        <input id="metros-ancho" name="metros-ancho"  type="number" step="0.01" value="0" style="height:25px" >
</p>
<label>Color visible</label><p>
	<input id="color-visible" name="color-visible"></p>

<input type='button' id='agregar-rollo-registro' class='btn btn-primary' value='Agregar Rollo'>

<div id="contenedor-rollos"></div>

<br />

<?php include('upload.php'); ?>
