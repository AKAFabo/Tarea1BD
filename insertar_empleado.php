<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $salario = $_POST["salario"];

    $connectionInfo = array("Database" => "Tarea1Bases");
    $conn = sqlsrv_connect("", $connectionInfo);

    if (!$conn) {
        die("Error en la conexión a la base de datos");
    }

    $mensaje = "";  // Inicializar el mensaje

    $sql = "EXEC sp_insert_empleado ?, ?, ?";

    // Usar sqlsrv_prepare para preparar la consulta
    $stmt = sqlsrv_prepare($conn, $sql, array(&$nombre, &$salario, &$mensaje));

    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true)); // Mostrar errores si ocurre uno
    }

    $result = sqlsrv_execute($stmt);

    if ($result === false) {
        die(print_r(sqlsrv_errors(), true)); // Mostrar errores si ocurre uno
    }

    // Enviar el mensaje como respuesta al cliente
    echo $mensaje; // Retornar el mensaje al cliente //NO ESTA FUNCIONANDO

    // Liberar recursos
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>
