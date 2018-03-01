<?php require_once('Connections/conexion_usuarios.php'); ?>
<?php
header("Access-Control-Allow-Origin: *");
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

$verificado = false;
$modulos = $_SESSION['MM_Modulos'];

foreach ($modulos as $modulo)
  {
    if ($modulo === 'fabrics')
      {
        $verificado = true;
      }
  }
    if ($verificado === false) {

      header ('Location:index.php');
}





function validar_pestana($modulo, $verificar_pestana)

{

  $pestanas= $_SESSION['MM_pestanas'];


   foreach ($pestanas as $pestana)
   {
      if (key($pestana) == $modulo && current($pestana) == $verificar_pestana)

      {
        return true;
      }
   }
   return false;
}

?>
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

  $logoutGoTo = " index.php";
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

$MM_restrictGoTo = "index.php";
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
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<!--//  Sistema de Inventarios Para la empresa Tynno Jeans
// Tec. en Informática Francisco Misael Landero Ychante
// Versión 3. ultima actualización 21/11/2014   -->



<head>

  <link rel="icon" href="../Signin Template for Bootstrap_files/favicon.png">
     <meta charset="utf-8">
    <title>Inventario Telas</title>
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
  <script src="/PC/js/canvasResize/canvasResize.js"></script>
  <script src="/PC/js/canvasResize/zepto.min.js"></script>
  <script src="/PC/js/canvasResize/binaryajax.js"></script>
  <script src="/PC/js/canvasResize/exif.js"></script>



 <link href="../css/fontello.css" rel="stylesheet">
   <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/signin/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="./Signin Template for Bootstrap_files/ie-emulation-modes-warning.js"></script>


<link rel="stylesheet" type="text/css" href="../css/imprimir.css" media="print" />

<!--iOS -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="img/favicon.png">
<link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-ipad-retina.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-iphone-retina.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-ipad.png">
<link rel="apple-touch-icon" sizes="57x57" href="img/apple-touch-icon-iphone.png">


  <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->




 <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/main.css">
  <script src="../js/vendor/modernizr-2.6.2.min.js"></script>
  <style type="text/css">
  .back-link a {
    color: #4ca340;
    text-decoration: none;
    border-bottom: 1px #4ca340 solid;
  }
  .back-link a:hover,
  .back-link a:focus {
    color: #408536;
    text-decoration: none;
    border-bottom: 1px #408536 solid;
  }
  h1 {
    height: 100%;
    /* The html and body elements cannot have any padding or margin. */
    margin: 0;
    font-size: 14px;
    font-family: 'Open Sans', sans-serif;
    font-size: 32px;
    margin-bottom: 3px;
  }
  .entry-header {
    text-align: left;
    margin: 0 auto 50px auto;
    width: 80%;
        max-width: 978px;
    position: relative;
    z-index: 10001;
  }
  #demo-content {
    padding-top: 0px;
  }
  </style>
</head>
<body class="demo">
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

  <!-- Demo content -->
  <div id="demo-content">

    <div id="loader-wrapper">
      <div id="loader"></div>

      <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>

    </div>

    <div id="content">



<header>
	      <h1><span class="icon-buffer"></span>&nbsp; &nbsp; Inventario Telas</h1>

     <!-- linea del usuario -->
<div id="Userdiv">
       <h5>Bienvenido <span class="icon-emo-thumbsup"></span> &nbsp; Usuario:
           <?php
              $sql="SELECT `img` FROM `usuarios` WHERE `id_empleado`=  {$_SESSION['MM_UserId']}";
              $rec_i=mysql_query($sql);
                   while ($row=mysql_fetch_array($rec_i)) {
                                                             echo "<span><img src='../files/".$row["img"]."'  width='4%' class='img-circle'></span>";
                                                          }
            ?>

            <strong>
                <?php echo $row_consulta_usuario['user']; ?>
                <span class="icon-ok"></span>&nbsp;

           </strong>
           <a href="<?php echo $logoutAction ?>">&nbsp;Salir&nbsp;
             <span class="icon-cancel-circled"></span>
           </a>


    <!-- Script de la fecha actual -->


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
</div></h5>
</header>
</script>
 <ul id="menu" class="nav nav-tabs">
                  <li ><a href="#" <?php echo  (validar_pestana('fabrics', 'registrar')) ? '' : 'style="display:none"'; ?>><span class="icon-plus-squared-alt"></span> Registrar</a></li>
               <li class="active"><a href="#" <?php echo  (validar_pestana('fabrics', 'buscar')) ? '' : 'style="display:none"'; ?>><span class="icon-search"></span> Buscar</a></li>
              <li><a href="#" <?php echo  (validar_pestana('fabrics', 'datos')) ? '' : 'style="display:none"'; ?>><span class=" icon-pencil-squared"></span> Datos</a></li>
              <li><a href="#" <?php echo  (validar_pestana('fabrics', 'entradas')) ? '' : 'style="display:none"'; ?>><span class="icon-download"></span> Entradas</a></li>
              <li><a href="#" <?php echo  (validar_pestana('fabrics', 'salidas')) ? '' : 'style="display:none"'; ?>><span class="icon-upload"></span> Salidas</a></li>
                <li><a href="#" <?php echo  (validar_pestana('fabrics', 'rollos')) ? '' : 'style="display:none"'; ?>><span class="icon-buffer"></span> Rollos</a></li>
              <li><a href="#" <?php echo  (validar_pestana('fabrics', 'movimientos')) ? '' : 'style="display:none"'; ?>><span class="icon-spin3"> </span> Movimientos</a></li>
           </ul>
       </nav>
<header id="titleContent">Buscar Tela</header>
<section>
			<article id="aRegister">
				<div class="row-fluid">
					<div class="span6">
					<?php include('form.php'); ?>
          <script type="text/javascript">

            var formRegistro = $("#registro-producto");

            var sumatoriaRegistroFabrics = function() {
              var totalRollos = 0, totalMetros = 0;
              $(".rollos-registro").each(function(key, value) {
                totalMetros += parseFloat($(this).find(".metros-rollos-registro").val());
                totalRollos++;
              });

              $("#totales-registro-fabrics").html('Totales: ' + totalRollos + ' Rollos || ' + totalMetros + ' Metros');
            }

            var crearId = function(){
              formRegistro.find("#Id").val(formRegistro.find("#id-sugerido").val());
              formRegistro.find("#Id").trigger("keyup");
              formRegistro.find("#id-hidden").val(formRegistro.find("#Id").val());
            }

            var fnClaveSugerida = function (){
                var claveSugerida = "";
                formRegistro.find("select").not("#unidad-registro").each(function(i){
                  var cod = $(this).find("option:selected").attr('val');
                  if ($.type(cod) !== "undefined"){
                    switch ($(this).attr("id")){
                      case "tela":
                        if (cod.length === 1) {cod = '00' + cod;} else
                        if (cod.length === 2) {cod = '0' + cod;}
                        // console.log("tela" + cod);
                      break;
                      case "tipo":
                        // console.log("tipo" + cod);
                      break;
                      case "proveedor":
                        if (cod.length <= 1){cod = "0" + cod;}
                        // console.log("proveedor" + cod);
                      break;
                    }

                    claveSugerida += cod;
                  }
                });

                formRegistro.find("#id-sugerido").val(claveSugerida);
                crearId();

            }

            fnClaveSugerida();

            formRegistro.find("select").not("#unidad-registro").change(function(){
              fnClaveSugerida();
            });

            formRegistro.submit(function(event) {
              if (formRegistro.find("#contenedor-rollos").find('.rollos-registro').length > 0) {
                if (($.isNumeric($("#compo-telap1").val()) || $("#compo-telap1").val() === "") && ($.isNumeric($("#compo-telap2").val()) || $("#compo-telap2").val() === "") && ($.isNumeric($("#compo-telap3").val()) || $("#compo-telap3").val() === "") && ($.isNumeric($("#compo-telap4").val())) || $("#compo-telap4").val() === "") {

                  var tela1 = $("#compo-telap1").val() !== "" ? parseInt($("#compo-telap1").val()) : 0 ;
                  var tela2 = $("#compo-telap2").val() !== "" ? parseInt($("#compo-telap2").val()) : 0 ;
                  var tela3 = $("#compo-telap3").val() !== "" ? parseInt($("#compo-telap3").val()) : 0 ;
                  var tela4 = $("#compo-telap4").val() !== "" ? parseInt($("#compo-telap4").val()) : 0 ;
                  var telaTotal = tela1 + tela2 + tela3 + tela4;

                  if (telaTotal !== 100) {
                    alert("El total de la composicion debe de dar 100 %");
                    event.preventDefault();
                  } else {
                    window.print();
                  }
                } else {
                  alert("Los porcentajes de la tela deben de ser numericos, favor de verificar");
                  event.preventDefault();
                }
              } else {
                alert("Debes capturar por lo menos un rollo en la tela");
                event.preventDefault();
              }

            })

            $('#agregar-rollo-registro').click(function(event){

              var statesDemos = {
                  state0: {
                      title: 'Capture Metros',
                      html:'<label><input id="metros-ingresar-registro" >Metros</label>',
                      buttons: { Agregar: 1, Listo: 2 },
                      focus: 0,
                      submit:function(e,v,m,f){

                          if (v === 2) {
                              $.prompt.close();
                          } else {

                              $obj = $(m[0]);
                              metros = $obj.find('#metros-ingresar-registro').val();

                              if (metros > 0) {
                                var primerosDigitos = formRegistro.find("#Id").val();

                                var consecutivo = $('.consecutivo-registro').size() + 1;
                                if (consecutivo.toString().length === 1) {consecutivo = '00' + consecutivo;} else
                                if (consecutivo.toString().length === 2) {consecutivo = '0' + consecutivo;}
                                var rolloHtml = '<div id="" class="rollos-registro"><hr style="border:1px solid black"><br><p><label>Codigo</label><input class="id-rollo-registro" name="id-rollo[]" value="' + primerosDigitos + '" disabled></p>'
                                                + '<input type="hidden" class="id-rollo-hidden" name="id-rollo-hidden[]" >'
                                                + '<input type="hidden" class="consecutivo-registro" name="consecutivo[]" value="' + consecutivo + '">'
                                                + '<p><label>Metros</label><input maxlength="3" class="metros-rollos-registro" name="metros-rollo[]" value="' + metros + '" readonly></p>'
                                                + '<p><label class="label-codigo-barras" style="display:none">Codigo Barras</label><div class="codigo-barras"></div></p>'
                                                + '<a href="#" value="cerrar" class="btn btn-danger eliminar-registro-rollo">Eliminar</a></div>';

                                formRegistro.find("#contenedor-rollos").append(rolloHtml);
                                formRegistro.find("#contenedor-rollos").find('.metros-rollos-registro').trigger('keyup');

                                sumatoriaRegistroFabrics();

                              } else {
                                alert("Valor de metros invalido");
                              }

                              $obj.find('#metros-ingresar-registro').val('');
                              $obj.find('#metros-ingresar-registro').focus();
                              e.preventDefault();

                          }

                      }
                  }

              }

              $.prompt(statesDemos, {
                  loaded: function(){
                      $("#metros-ingresar-registro").focus();
                  }
              });

            });

            formRegistro.on('click', '.eliminar-registro-rollo', function(){
              $(this).closest('.rollos-registro').remove();
              sumatoriaRegistroFabrics();
            })

            formRegistro.on('keyup', '.metros-rollos-registro', function(){
              var primerosDigitos = formRegistro.find("#Id").val();
              var registro = $(this).closest('.rollos-registro');
              var idRegistro = registro.find('.id-rollo-registro');

                var consecutivo = registro.find('.consecutivo-registro').val();
                idRegistro.val(idRegistro.val() + consecutivo);
                idRegistro.trigger('keyup');

              registro.find('.id-rollo-hidden').val(idRegistro.val());
            })

            formRegistro.on('keyup', '.id-rollo-registro', function(){
              var ob = $(this).closest('.rollos-registro');
              if ($(this).val().length >= 12){

                var $this = $(this),
                text = $this.val(),
                filtered = "",
                c = '';
                for(var i=0; i<text.length; i++){
                  c = text.charAt(i);
                  if ( (c >= '0') && (c <= '9') ){
                    filtered += c;
                  }
                }
                $this.val(filtered);
                ob.find('.codigo-barras').barcode(filtered, "ean13");
                ob.find(".id-rollo-registro").val(ob.find('.codigo-barras').find("div").last().html());
                ob.find(".id-rollo-hidden").val(ob.find("#id-rollo-registro").val());
                ob.find('.label-codigo-barras').show();

              } else {
                ob.find('.codigo-barras').html('');
              }
            });

          </script>
					</div>
					<div class="span6">

							<div class="alert"></div>
                            <div class="row-fluid">

					   <img id="img_destino" src="#" alt="Tu imagen">
             <h3 id="totales-registro-fabrics">Totales: 0 Rollos || 0 Metros</h3>
					</div>

            <!-- <div class="contentBarcode">
							<div class="barCode">
								<header><h4>Codigo</h4></header>
								<div>
                <?php include('Codigob.php'); ?></div>
						  </div>
					</div> -->
				</div>
			</article>
			<article id="aSearch" >
				<table id="tSearch" cellspacing="1">
	<caption>Lista de Telas</caption>
	<thead>
				<tr>
					<th>Codigo</th>
					<th>Proveedor</th>
        	<th>Tipo</th>
          <th>Tela</th>
          <th>Metros</th>
          <th>Composicion</th>
          <th>Tipo</th>
          <th>Ancho</th>
          <th>Color</th>
          <th>Imagen</th>
          <th>Fecha Creacion</th>
       </tr>
			</thead>
	<tbody>
	</tbody>
	</table>

  <h3 id="totales-busqueda-fabrics"></h3>
    <div>

		<input type="button"  value="Imprimir Inventario" class="btn btn-success" onclick='window.print();' >
    <input type="button"  value="Ver" class="btn btn-success" id="ver-codigo"><br>
    <br>
    <label>Filtrar por fecha: </label><select id="fechas-imprimir"></select>
	   <div class="row-fluid" id="contenido-imprimir-codigo">
        <div class="span6" id='content-rollos-telas-busqueda'>
          <div id='titulo-telas-busqueda'>
          <!-- <h3>Informacion articulo<span></span></h3> -->
          <!-- <h3>Editar Articulo ART-<span></span></h3> -->
              <!-- Ultima actualizacion:<i></i> -->

              <!-- <div id="datos-codigo"> </div><?php include('uploadi.php'); ?> -->
          </div>
					<div id='rollos-telas-busqueda'>
          <!-- <h3>Informacion articulo<span></span></h3> -->
					<!-- <h3>Editar Articulo ART-<span></span></h3> -->
					    <!-- Ultima actualizacion:<i></i> -->

              <!--  -->
					</div>
        </div>
					<div class="span6" >
          <img id="img_destino_articulo_imprimir" src="#" alt="Tu imagen">
          <div id="datos-codigo"> </div><?php include('uploadi.php'); ?>

						<div class="contentBarcode">
							<!-- <div class="barCode">
								<header style='width:115;'><h4>Codigo</h4></header>
                  <div style='width:115;height:70;'>
                    <div id="valor-codigo" style="clear:both;margin-top:0px; width: 100%; background-color: #FFFFFF; color: #000000; text-align: center; font-size: 10px; margin-top: 5px;"></div>
                  </div>

							</div>
							<a href="#" class="btn btn-primary">Guardar</a>
							<div class="alert"></div>
						</div> -->
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

                $query = "SELECT * FROM proveedor";
                $resultado = mysql_query($query);

                while ($fila = mysql_fetch_array($resultado)) {
                  echo " <tr>";
                  echo "<td> $fila[id]  </td> <td> $fila[descripcion] </td>";
                  echo " </tr>";
                }

             ?></tbody></table>
             <h5>Registrar Nuevo proveedor</h5><?php include('administrador/formp.php'); ?>

          </div>



        <div>   <div class="span6">
 <h3>Datos Registrados</h3><caption><h4>Lista de Tipos de Producto</h4></caption>
<table  class="table" cellspacing="0" width="100%" border="1px">

  <thead><tr><th>ID</th><th>Descripcion</th></tr></thead>
  <tbody>
     <?php

      include("Connections/conexiont.php");

           ?></tbody></table><div class="span6"><h5> Registrar Nuevo Tipo de Producto</h5><?php include('administrador/formt.php'); ?>
  </div></div>


          <div class="span6"> <h3>Datos Registrados</h3><caption><h4>Lista de Tela</h4></caption>
<table id="tp" class="table" cellspacing="0" width="100%"  border="1px">

  <thead><tr><th>ID</th><th>Descripcion</th></tr></thead>
  <tbody>
     <?php

      include("Connections/conexiontl.php");

           ?></tbody></table><div class="span6"> <h5>Registrar Nueva Tela</h5><?php include('administrador/formte.php'); ?></div>

    </div>

    </article>

    <article id="aEntry">
      <?php include('administrador/movimientos/forme.php'); ?>
    </article>
    <article id="aSalida">
      <?php include('administrador/movimientos/forms.php'); ?>
    </article>

     <article id="aroll" style="display:none">

  <div >
          <h3>Rollos</h3><caption><h4>Lista de rollos registrados </h4></caption>
        <table id="tp" class="table" cellspacing="0" width="100%" border="1px">
          <thead><tr><th>Id</th><th>Codigo</th><th>id tela</th><th>Metros</th><th>Fecha de creación</th></tr></thead>
          <tbody>
             <?php

                $query = "SELECT * FROM rollos_telas";
                $resultado = mysql_query($query);

                while ($fila = mysql_fetch_array($resultado)) {
                  echo " <tr>";
                  echo "<td> $fila[id]  </td> <td> $fila[codigo] </td><td> $fila[id_art_telas] </td><td> $fila[metros] </td><td> $fila[fecha_creacion] </td>";
                  echo " </tr>";
                }

             ?></tbody></table>

          </div>

     </article>
      <article id="amov" style="display:none">

  <div >
          <h3>Rollos</h3><caption><h4>Lista de salidas y entradas al sistema </h4></caption>
        <table id="tp" class="table" cellspacing="0" width="100%" border="1px">
          <thead><tr><th>Id</th><th>Codigo rollo</th><th>tipo movimiento</th><th>metros</th><th>usuario</th><th>fecha</th></tr></thead>
          <tbody>
             <?php

                $query = "SELECT * FROM hist_mov_ent_sal_telas";
                $resultado = mysql_query($query);

                while ($fila = mysql_fetch_array($resultado)) {
                  echo " <tr>";
                  echo "<td> $fila[id]  </td> <td> $fila[codigo_id] </td><td> $fila[tipo_mov] </td><td> $fila[cantidad] </td><td> $fila[usuario] </td><td> $fila[fecha] </td>";
                  echo " </tr>";
                }

             ?></tbody></table>

          </div>

     </article>
</section><script type='text/javascript'>
(function () {	var done = false;	var script = document.createElement('script'); script.async = true;	script.type = 'text/javascript';	script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) {	if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({ c: 'c723c174-ef33-48e6-869b-c91e0be9243f', f: true }); done = true;	}	};	})();
</script>
<div align="center"> <p><h2><img src="../images/logo.png" alt="" width="5%"> <h4 id="titleContento">LanderCorp.mx</h4> &reg 2015<p> </div>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./Signin Template for Bootstrap_files/ie10-viewport-bug-workaround.js"></script>


 </div>
  <!-- /Demo content -->


  <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
  <script src="../js/main.js"></script>

</body>
</html>
