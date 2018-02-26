<?php require_once('Connections/conexion_usuarios.php'); ?>
<?php
mysql_select_db($database_conexion_usuarios, $conexion_usuarios);
$query_consulta_usuarios = "SELECT * FROM usuarios";
$consulta_usuarios = mysql_query($query_consulta_usuarios, $conexion_usuarios) or die(mysql_error());
$row_consulta_usuarios = mysql_fetch_assoc($consulta_usuarios);
$totalRows_consulta_usuarios = mysql_num_rows($consulta_usuarios);
?><?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  $password=$_POST['contrasena'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "entrar.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexion_usuarios, $conexion_usuarios);

  $LoginRS__query=sprintf("SELECT user, password FROM usuarios WHERE user='%s' AND password='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password));

  $LoginRS = mysql_query($LoginRS__query, $conexion_usuarios) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";

    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>


<!-- saved from url=(0040)http://getbootstrap.com/examples/signin/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="Signin Template for Bootstrap_files/favicon.png">

    <title>Ingreso al sistema</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/signin/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="./Signin Template for Bootstrap_files/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
<div align="center">  </div>
   <form class="form-signin" id="form_ingreso" name="form_ingreso" method="POST" action="<?php echo $loginFormAction; ?>">
        <h1 class="form-signin-heading">Panel de Control </h1> <p>


        <label for="inputEmail" class="sr-only">Usuario</label>
        <input name="usuario" type="text" id="usuario" class="form-control" value="Nombre del Usuario" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'USERNAME';}" ><a href="#" class=" icon user"/>
        <label for="inputPassword" class="sr-only">Password</label>
        <input  class="form-control" name="contrasena"  id="contrasena" type="password" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}"><a href="#" class=" icon lock">
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Recordarme
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
      </form>

    </div> <!-- /container -->

<div align="center">
 
</div>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./Signin Template for Bootstrap_files/ie10-viewport-bug-workaround.js"></script>

<?php
mysql_free_result($consulta_usuarios);
?>

</body></html>
