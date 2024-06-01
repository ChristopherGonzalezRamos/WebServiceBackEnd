<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Verificar si el método de solicitud es GET o POST
if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

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

// Obtener los datos del POST request o de la URL en caso de una solicitud GET
$email = isset($_POST['email']) ? $_POST['email'] : (isset($_GET['email']) ? $_GET['email'] : '');

// Verificar si el correo electrónico está vacío
if (empty($email)) {
    echo json_encode(['status' => 'error', 'message' => 'Email is empty']);
    exit; // Salir del script
}

// Consultar datos del usuario en la tabla users
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result === false) {
    // Manejar errores de consulta SQL
    echo json_encode(['status' => 'error', 'message' => 'SQL error']);
    exit; // Salir del script
}

if ($result->num_rows > 0) {
    // El usuario fue encontrado, obtener sus datos
    $row = $result->fetch_assoc();
    $user = [
        'id_usuario' => $row['id_usuario'],
        'name' => $row['name'],
        'age' => $row['age'],
        'occupation' => $row['occupation'],
        'email' => $row['email']
    ];
    echo json_encode(['status' => 'success', 'user' => $user]);
} else {
    // El usuario no fue encontrado, devolver un mensaje de error
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
}

$conn->close();
?>
