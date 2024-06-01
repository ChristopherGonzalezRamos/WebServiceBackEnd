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

// Obtener los datos del POST request
$postData = json_decode(file_get_contents('php://input'), true);
$query = isset($postData['query']) ? $postData['query'] : '';

// Verificar si la consulta está vacía
if (empty($query)) {
    echo json_encode(['status' => 'error', 'message' => 'Search query is empty']);
    exit;
}

// Escapar la consulta para prevenir SQL injection
$query = $conn->real_escape_string($query);

// Buscar notas que coincidan con el título
$sql = "SELECT * FROM notas WHERE titulo LIKE '%$query%'";
$result = $conn->query($sql);

if ($result === false) {
    echo json_encode(['status' => 'error', 'message' => 'SQL error']);
    exit;
}

$notes = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
}

echo json_encode(['status' => 'success', 'notes' => $notes]);

$conn->close();
?>
