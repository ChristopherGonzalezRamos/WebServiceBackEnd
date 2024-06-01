<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agenda";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener la fecha actual y la fecha dentro de 3 días
$currentDate = date("Y-m-d");
$threeDaysLater = date("Y-m-d", strtotime("+3 days"));

// Consulta SQL para obtener las notas dentro del rango de fechas
$sql = "SELECT * FROM notas WHERE createdAt >= '$currentDate' AND createdAt <= '$threeDaysLater'";
$result = $conn->query($sql);

if ($result === false) {
    // Manejar errores de consulta SQL
    echo json_encode(['status' => 'error', 'message' => 'SQL error']);
    exit; // Salir del script
}

if ($result->num_rows > 0) {
    // Recopilar las notas en un array
    $notes = [];
    while($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
    
    // Devolver las notas en formato JSON
    echo json_encode(['status' => 'success', 'notes' => $notes]);
} else {
    // No se encontraron notas dentro del rango de fechas
    echo json_encode(['status' => 'success', 'notes' => []]);
}

$conn->close();
?>
