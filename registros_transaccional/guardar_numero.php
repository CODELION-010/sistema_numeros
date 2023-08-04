<?php
include "index.html";
include "conx_db/conx_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el número enviado desde el formulario
    $numero = $_POST["numero"];

    // Verificar si se ha alcanzado el límite de retiros y depósitos para el número
    $query = "SELECT retiros, depositos FROM registros WHERE numero = '$numero'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $retiros = $row['retiros'];
        $depositos = $row['depositos'];

        if ($retiros < 2 && isset($_POST['retiro'])) {
            // Registrar un retiro para el número
            $query = "UPDATE registros SET retiros = retiros + 1, hora = NOW() WHERE numero = '$numero'";
            $conn->query($query);
            echo "<h2>Se ha registrado un retiro para el número $numero</h2>";
        } elseif ($depositos < 2 && isset($_POST['deposito'])) {
            // Registrar un depósito para el número
            $query = "UPDATE registros SET depositos = depositos + 1, hora = NOW() WHERE numero = '$numero'";
            $conn->query($query);
            echo "<h2>Se ha registrado un depósito para el número $numero</h2>";
        } else {
            echo "<h2>Se ha alcanzado el límite de retiros y depósitos para el número $numero</h2>";
        }

        // Verificar si se ha seleccionado Daviplata
        if (isset($_POST['daviplata'])) {
            // Registrar o actualizar Daviplata en la tabla correspondiente
            $query = "INSERT INTO daviplata (cantidad, valor) VALUES (1, 1000) ON DUPLICATE KEY UPDATE cantidad = cantidad + 1";
            $conn->query($query);
            echo "<h2>Se ha registrado Daviplata para el número $numero</h2>";
        }

        // Verificar si se ha seleccionado Nequi
        if (isset($_POST['nequi'])) {
            // Registrar o actualizar Nequi en la tabla correspondiente
            $query = "INSERT INTO nequi (cantidad, valor) VALUES (1, 1500) ON DUPLICATE KEY UPDATE cantidad = cantidad + 1";
            $conn->query($query);
            echo "<h2>Se ha registrado Nequi para el número $numero</h2>";
        }
    } else {
        // No existen registros para el número, se crea uno nuevo
        if (isset($_POST['retiro'])) {
            $query = "INSERT INTO registros (numero, fecha, hora, retiros) VALUES ('$numero', CURDATE(), NOW(), 1)";
            $conn->query($query);
            echo "<h2>Se ha registrado un retiro para el número $numero</h2>";
        } elseif (isset($_POST['deposito'])) {
            $query = "INSERT INTO registros (numero, fecha, hora, depositos) VALUES ('$numero', CURDATE(), NOW(), 1)";
            $conn->query($query);
            echo "<h2>Se ha registrado un depósito para el número $numero</h2>";
        } else {
            echo "<h2>No se ha seleccionado un tipo de operación para el número $numero</h2>";
        }
    }

    $conn->close();
}
?>
