<?php
// Establecer conexión a la base de datos
$connectionInfo = array("Database" => "Tarea1Bases");
$conn = sqlsrv_connect("FABO\SQLEXPRESS01", $connectionInfo);

if (!$conn) {
    die("Error en la conexión a la base de datos");
}

// Consulta para obtener los empleados
$sql = "EXEC dbo.sp_get_empleados"; 
$result = sqlsrv_query($conn, $sql);

// Verificar si hay resultados
if ($result === false) {
    // Capturar y mostrar el error si la consulta falla
    die(print_r(sqlsrv_errors(), true));
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Empleados</title>
</head>
<body>
    <h1>Lista de Empleados</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Salario</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Recorrer los resultados de la consulta y mostrarlos en la tabla
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['Id'] . "</td>";
                echo "<td>" . $row['Nombre'] . "</td>";
                echo "<td>" . "$" . number_format($row['Salario'], 2) . "</td>"; // Formatear salario a dos decimales
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <br>

    <button>Insertar Empleado</button>

</body>
</html>

<?php
// Liberar la consulta y cerrar la conexión
sqlsrv_free_stmt($result);
sqlsrv_close($conn);
?>
