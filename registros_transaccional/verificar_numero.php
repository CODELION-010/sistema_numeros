<?php
include "index.html";
include "conx_db/conx_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el número a verificar enviado desde el formulario
    $numeroVerificar = $_POST["numero_verificar"];

    // Obtener los movimientos del número consultado
    $movimientosQuery = "SELECT fecha, TIME_FORMAT(hora, '%h:%i %p') AS hora_12h, SUM(retiros) AS total_retiros, SUM(depositos) AS total_depositos FROM registros WHERE numero = '$numeroVerificar' GROUP BY fecha";

    $movimientosResult = $conn->query($movimientosQuery);

    if ($movimientosResult && $movimientosResult->num_rows > 0) {
        echo "<h2>Movimientos del número $numeroVerificar:</h2>";

        // Mostrar los movimientos en una tabla
        echo "<table>";
        echo "<tr><th>Fecha</th><th>Hora</th><th>Retiros</th><th>Depósitos</th></tr>";

        while ($row = $movimientosResult->fetch_assoc()) {
            $fecha = $row['fecha'];
            $hora = $row['hora_12h']; // Hora en formato de 12 horas con am/pm
            $retiros = $row['total_retiros'];
            $depositos = $row['total_depositos'];

            echo "<tr>";
            echo "<td>$fecha</td>";
            echo "<td>$hora</td>";
            echo "<td>$retiros</td>";
            echo "<td>$depositos</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<h2>No se encontraron movimientos para el número $numeroVerificar</h2>";
    }

    $conn->close();
}
?>
