<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agenda";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL para obtener todas las notas ordenadas por fecha de actualización descendente
$query = "SELECT * FROM notas ORDER BY updatedAt DESC";
$result = $conn->query($query);

$notes = [];

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Recorrer cada fila y agregarla al array de notas
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
    // Devolver las notas como JSON
    echo json_encode(['status' => 'success', 'notes' => $notes]);
} else {
    // No se encontraron notas
    echo json_encode(['status' => 'success', 'notes' => []]);
}

// Cerrar la conexión
$conn->close();
?>
