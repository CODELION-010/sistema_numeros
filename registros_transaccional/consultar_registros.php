<?php

include "index.html";
include "conx_db/conx_db.php";

// Consultar todos los registros
$query = "SELECT id, numero, fecha, TIME_FORMAT(hora, '%h:%i %p') AS hora_12h, retiros, depositos FROM registros";
$result = $conn->query($query);

// Comprobar si hay registros
if ($result && $result->num_rows > 0) {
    // Mostrar los registros en una tabla
    echo "<table>";
    echo "<tr><th>ID</th><th>Número</th><th>Fecha</th><th>Hora</th><th>Retiros</th><th>Depósitos</th></tr>";

    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $numero = $row['numero']; // <-- Línea 7
        $fecha = $row['fecha']; // Fecha almacenada en la tabla
        $hora = $row['hora_12h']; // Hora en formato de 12 horas almacenada en la tabla
        $retiros = $row['retiros'];
        $depositos = $row['depositos'];

        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$numero</td>";
        echo "<td>$fecha</td>";
        echo "<td>$hora</td>";
        echo "<td>$retiros</td>";
        echo "<td>$depositos</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<h2>No se encontraron registros.</h2>";
}

$conn->close();
?>
