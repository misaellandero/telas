<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexion_usuarios = "localhost";
$database_conexion_usuarios = "sistema";
$username_conexion_usuarios = "root";
$password_conexion_usuarios = "CornComputerInc1*";
$conexion_usuarios = @mysql_pconnect($hostname_conexion_usuarios, $username_conexion_usuarios, $password_conexion_usuarios) or trigger_error(mysql_error(),E_USER_ERROR);
?>
