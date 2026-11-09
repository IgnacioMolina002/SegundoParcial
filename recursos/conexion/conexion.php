<?php
/* $host = "sql300.infinityfree.com";
$user = "ifo_43073240";
$pass = "";
$baseDatos = "ifo_43073240_nuevatabla"; */

$host = "localhost";
$user = "root";
$pass = "";
$baseDatos = "tuAuto.com";
$puerto = "3306";

$conexion = mysqli_connect($host,$user,$pass,$baseDatos,$puerto);

if(!$conexion){
    die("Error al conectar..." . mysqli_connect_error());
}

?>