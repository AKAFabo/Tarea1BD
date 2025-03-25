<?php
// Establecer conexión a la base de datos
$connectionInfo = array("Database" => "Tarea1Bases");
$conn = sqlsrv_connect("", $connectionInfo);

if (!$conn) {
    die("Error en la conexión a la base de datos");
}

// Consulta para obtener los empleados
$sql = "EXEC dbo.sp_get_empleados"; 
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Empleados</title>
    <script>
        function abrirModal() {
            document.getElementById("modal").style.display = "block";
        }

        function cerrarModal() {
            document.getElementById("modal").style.display = "none";
        }

        function insertarEmpleado() {
            var nombre = document.getElementById("nombre").value;
            var salario = document.getElementById("salario").value;

            if (nombre.trim() === "" || salario.trim() === "") {
                alert("Por favor, complete todos los campos.");
                return;
            }

            var formData = new FormData();
            formData.append("nombre", nombre);
            formData.append("salario", salario);

            fetch("insertar_empleado.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                cerrarModal();
                location.reload(); // Recargar la página para mostrar el nuevo empleado
            })
            .catch(error => console.error("Error:", error));
        }
    </script>
    <style>
        /* Estilos para el modal */
        #modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        #modal-content {
            background-color: white;
            padding: 20px;
            width: 300px;
            margin: 15% auto;
            border-radius: 10px;
            text-align: center;
        }
    </style>
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
            <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row['Id'] ?></td>
                    <td><?= $row['Nombre'] ?></td>
                    <td>$<?= number_format($row['Salario'], 2) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <br>

    <button onclick="abrirModal()">Insertar Empleado</button>

    <!-- Modal -->
    <div id="modal">
        <div id="modal-content">
            <h2>Nuevo Empleado</h2>
            <label>Nombre:</label>
            <input type="text" id="nombre"><br><br>
            <label>Salario:</label>
            <input type="number" id="salario" step="0.01"><br><br>
            <button onclick="insertarEmpleado()">Guardar</button>
            <button onclick="cerrarModal()">Cancelar</button>
        </div>
    </div>

</body>
</html>

<?php
sqlsrv_free_stmt($result);
sqlsrv_close($conn);
?>
