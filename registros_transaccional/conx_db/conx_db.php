<?php

// Conectarse a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sistema_numeros";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("<h2>Error al conectar a la base de datos: </h2>" . $conn->connect_error);
    }
?>