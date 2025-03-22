<?php

$connectionInfo = array("Database" => "Tarea1Bases");
$conn = sqlsrv_connect("FABO\SQLEXPRESS01", $connectionInfo);

if ($conn){
    echo("Servidor conectado");
} else {
    die("d");
}
?>