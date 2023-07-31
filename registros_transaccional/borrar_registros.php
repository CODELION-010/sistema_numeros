<?php

include "index.html";
include "conx_db/conx_db.php";

// Borrar registros de la tabla "registros" con fecha igual a la fecha actual
$sql = "DELETE FROM registros WHERE fecha = CURDATE()";

if ($conn->query($sql) === TRUE) {
    echo "<h2>Registros borrados correctamente</h2>";
} else {
    echo "<h2>Error al borrar los registros: </h2>" . $conn->error;
}

$conn->close();
?>
