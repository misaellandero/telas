
<!--//  Sistema de Inventarios Para la empresa Tynno Jeans 
// Tec. en Informática Francisco Misael Landero Ychante 
// Versión 3. ultima actualización 21/11/2014   --> 

<?php require_once('Connections/conexion_usuarios.php'); ?>
<?php
header("Access-Control-Allow-Origin: *");
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
} 
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "ingreso.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?><?php
$colname_consulta_usuario = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_consulta_usuario = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexion_usuarios, $conexion_usuarios);
$query_consulta_usuario = sprintf("SELECT `user` FROM usuarios WHERE `user` = '%s'", $colname_consulta_usuario);
$consulta_usuario = mysql_query($query_consulta_usuario, $conexion_usuarios) or die(mysql_error());
$row_consulta_usuario = mysql_fetch_assoc($consulta_usuario);
$totalRows_consulta_usuario = mysql_num_rows($consulta_usuario);
?>
<!doctype html>
<html lang="es">
<head>

<link rel="shortcut icon" href="http://tynnosjeans.com/images/logoico.ico"
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>Sistema De Inventario</title>
    <link rel="stylesheet" type="text/css" href="styles/normalize.css">
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" type="text/css" href="styles/jquery-ui-1.10.3.custom.css">
	<link rel="stylesheet" type="text/css" href="styles/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="styles/bootstrap-responsive.css">
	<link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="styles/jquery-impromptu.css">

	<script src="scripts/jquery.dataTables.js"></script>
	<script src="scripts/jquery-ui-1.10.3.custom.js"></script>
	<script src="scripts/jquery.js"></script>
	<script src="scripts/functions.js"></script>
	<script src="scripts/prefixfree.min.js"></script>
	<script src="scripts/datatables.js"></script>
	<script src="scripts/jjquery-ui.js"></script>
	<script src="scripts/jquery-barcode.js"></script>
  <script src="scripts/jquery-impromptu.js"></script>
</head>
<body>
	<div id="mainWrapper">
<header>
	      <h1>Sistema de Inventario</h1>
          
      </header><header><strong>Bienvenido </strong>
Usuario:<?php echo $row_consulta_usuario['user']; ?>
&nbsp;<a href="<?php echo $logoutAction ?>">Desconectar</a>
<?php
mysql_free_result($consulta_usuario);
?></header>
</script>
<div style="float:right;">
<script type="text/javascript">
//<![CDATA[
var  today = new Date();
var m = today.getMonth() + 1;
var mes = (m < 10) ? '0' + m : m;
  document.write('Fecha: '+today.getDate(),'/' +mes,'/'+today.getYear());
//]]> 
</script>
<script type="text/javascript">
function startTime(){
today=new Date();
h=today.getHours();
m=today.getMinutes();
s=today.getSeconds();
m=checkTime(m);
s=checkTime(s);
document.getElementById('reloj').innerHTML=h+":"+m+":"+s;
t=setTimeout('startTime()',500);}
function checkTime(i)
{if (i<10) {i="0" + i;}return i;}
window.onload=function(){startTime();}
</script>
<div id="reloj" style="font-size:20px;"></div>
</div>
  <ul class="nav nav-tabs">
              <li><a href="#">Registrar</a></li>
              <li class="active"><a href="#">Buscar</a></li>
              <li><a href="#">Datos</a></li>
              <li><a href="#">Entradas</a></li>
              <li><a href="#">Salidas</a></li>
           </ul>
       </nav>
<header id="titleContent">Registrar Articulo</header>
<section>
			<article id="aRegister">
				<div class="row-fluid">
					<div class="span6">
					<?php include('form.php'); ?>
          <script type="text/javascript">

            var formRegistro = $("#registro-producto");

            var crearId = function(){            
              formRegistro.find("#Id").val(formRegistro.find("#id-sugerido").val());
              formRegistro.find("#Id").trigger("keyup");
              formRegistro.find("#id-hidden").val(formRegistro.find("#Id").val());
            }


            var crearCorte = function(claveSugerida){
              $.ajax({
                  url: 'administrador/movimientos/registroAjax.php',
                  type: 'post',
                  data: { 'producto': formRegistro.find("#producto option:selected").html(), 'modelo' : formRegistro.find("#tipo option:selected").html(), 'talla' : formRegistro.find("#talla option:selected").html(), 'tela' : formRegistro.find("#tela option:selected").html() , 'action' : 'verificaCodigo'},
                  dataType: 'json',
                  success: function (data) {
                      if (data.success) {

                          var cod = parseInt(data.corte);

                          if (cod <= 9){cod = "0" + cod;}

                          $("#Corte").val(cod);
                          claveSugerida += cod;

                          formRegistro.find("#id-sugerido").val(claveSugerida);
                          crearId();

                      }
                  },
                  error: function (jqXHR, textStatus, errorThrown){
                      alert(JSON.stringify(jqXHR));
                      //alert(textStatus);
                  }
              });
            }

            var fnClaveSugerida = function (){
                var claveSugerida = "";
                formRegistro.find("select").not("#unidad-registro").each(function(i){
                  var cod = $(this).find("option:selected").attr('val');
                  if ($.type(cod) !== "undefined"){
                    if (cod.length <= 1){cod = "0" + cod;}

                    // if (cod.length <= 1 && $(this).attr("id") === "tipo"){cod = "00" + cod;}
                    // if (cod.length == 2 && $(this).attr("id") === "tipo"){cod = "0" + cod;}

                    // if (cod.length <= 1 && $(this).attr("id") === "Descripcion"){cod = "00" + cod;}
                    // if (cod.length == 2 && $(this).attr("id") === "Descripcion"){cod = "0" + cod;}

                    claveSugerida += cod;
                  }
                });

                crearCorte(claveSugerida);

            }

            fnClaveSugerida();

            formRegistro.find("select").not("#unidad-registro").change(function(){
              fnClaveSugerida();
            });

          </script>
					</div>
					<div class="span6">
						
							<div class="alert"></div>
                            <div class="row-fluid">
               
              
               
               
					   <img id="img_destino" src="#" alt="Tu imagen">
					</div>
              
                            <div class="contentBarcode">
							<div class="barCode">
								<header><h4>Codigo</h4></header>
								<div>
<?php include('Codigob.php'); ?></div>
						</div>
					</div>
				</div>  
			</article>
			<article id="aSearch" >
				<table id="tSearch" cellspacing="1">
	<caption>Lista de Articulos</caption>
	<thead>
				<tr>
					<th>ID</th>
					<th>Producto</th>		
                    	<th>Tipo</th>
                        <th>Descripcion</th>	
                        <th>Folio</th>				
							          <th>Piezas</th>
                        <th>Docenas</th>
                           <th> Talla </th>	
                           <th> Tela </th>	
                           <th> imagen </th>
                           <th>NC</th>
       </tr>
			</thead>
	<tbody>
	</tbody>
	</table>
    <div>
    
		<input type="button"  value="Ver" class="btn btn-success" id="ver-codigo">
    <input type="button"   value="Ver Codigo" class="btn btn-success" id="ver-codigo-solo"></div><br>
	   <div class="row-fluid" id="contenido-imprimir-codigo">
					<div class="span6">
          <h3>Informacion articulo<span></span></h3>
					<!-- <h3>Editar Articulo ART-<span></span></h3> -->
					    <!-- Ultima actualizacion:<i></i> -->
					
              <div id="datos-codigo"> </div><?php include('uploadi.php'); ?>
					</div>
					<div class="span6" > 
          <img id="img_destino_articulo_imprimir" src="#" alt="Tu imagen">
						<div class="contentBarcode">              
							<div class="barCode">
								<header style='width:115;'><h4>Codigo</h4></header>
                  <div style='width:115;height:70;'>
                    <?php include('CodigoB2.php'); ?>
                   
                    <div id="valor-codigo" style="clear:both;margin-top:0px; width: 100%; background-color: #FFFFFF; color: #000000; text-align: center; font-size: 10px; margin-top: 5px;"></div>
                  </div>
                
							</div>
							<!-- <a href="#" class="btn btn-primary">Guardar</a> -->
							<!-- <div class="alert"></div> -->
						</div>
					</div>
				</div>
	</article>
    <article id="aDates">

    <h3>A&ntilde;adir Datos</h3>
    <div>
 <div class="span6">
  <h3>Datos Registrados</h3><caption><h4>Lista de Lineas de Productos</h4></caption>
<table id="tp" class="table" cellspacing="0" width="100%" border="1px">
  <thead><tr><th>ID</th><th>Descripcion</th></tr></thead>
  <tbody>
     <?php
      include("Connections/conexionp.php");

      $query = "SELECT * FROM producto";
      $resultado = mysql_query($query);

      while ($fila = mysql_fetch_array($resultado)) {
        echo " <tr>";
        echo "<td> $fila[Id]  </td> <td> $fila[Descripcion] </td>";
        echo " </tr>";
      }
              $Con = new conexion();
              $Con->recuperarDatos();
           ?></tbody></table> 
           <h5>Registrar Nueva Linea de Producto</h5><?php include('administrador/formp.php'); ?>

  </div>
          
          

        <div>   <div class="span6"> 
 <h3>Datos Registrados</h3><caption><h4>Lista de Tipos de Producto</h4></caption>
<table  class="table" cellspacing="0" width="100%" border="1px">
  
  <thead><tr><th>ID</th><th>Descripcion</th></tr></thead>
  <tbody>
     <?php
          
      include("Connections/conexiont.php"); 
              $Con->recuperarDatos();
           ?></tbody></table><div class="span6"><h5> Registrar Nuevo Tipo de Producto</h5><?php include('administrador/formt.php'); ?>
  </div></div>  
          <div class="span6">  <h3>Datos Registrados</h3><caption><h4>Lista de Modelo</h4></caption>
<table  id="tp" class="table" cellspacing="0" width="100%" border="1px">
  
  <thead><tr><th>ID</th><th>Descripcion</th></tr></thead>
  <tbody>
     <?php
          
     include("Connections/conexionm.php");
              $Con->recuperarDatos();
           ?></tbody></table>
         <div class="span6"> <h5> Registrar Nuevo Modelo</h5><?php include('administrador/formm.php'); ?></div>   
  </div> 
          <div class="span6">  <h3>Datos Registrados</h3><caption><h4>Lista de Talla</h4></caption>
<table  id="tp" class="table" cellspacing="0" width="100%"  border="1px">
  
  <thead><tr><th>ID</th><th>Descripcion</th></tr></thead>
  <tbody>
     <?php
          
     include("Connections/conexiontt.php");
             
              $Con->recuperarDatos();
           ?></tbody></table><div class="span6"> <h5>Registrar Nueva Talla</h5><?php include('administrador/formta.php'); ?></div>   
          <div class="span6"> <h3>Datos Registrados</h3><caption><h4>Lista de Tela</h4></caption>
<table id="tp" class="table" cellspacing="0" width="100%"  border="1px">
  
  <thead><tr><th>ID</th><th>Descripcion</th></tr></thead>
  <tbody>
     <?php
          
      include("Connections/conexiontl.php");
              $Con->recuperarDatos();
           ?></tbody></table><div class="span6"> <h5>Registrar Nueva Tela</h5><?php include('administrador/formte.php'); ?></div>

    </div>

    </article>

    <article id="aEntry">
      <?php include('administrador/movimientos/forme.php'); ?>
    </article>
    <article id="aSalida">
      <?php include('administrador/movimientos/forms.php'); ?>
    </article>
    
</section><script type='text/javascript'>
(function () {	var done = false;	var script = document.createElement('script'); script.async = true;	script.type = 'text/javascript';	script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) {	if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({ c: 'c723c174-ef33-48e6-869b-c91e0be9243f', f: true }); done = true;	}	};	})();
</script>
</body>
</html>
<body>
<p>
