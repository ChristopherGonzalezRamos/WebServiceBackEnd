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
$email = $postData['email'] ?? '';
$password = $postData['password'] ?? '';

// Verificar si el correo electrónico o la contraseña están vacíos
if (empty($email) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Email and password are required']);
    exit; // Salir del script
}

// Verificar si el usuario existe en la base de datos
$sql = "SELECT * FROM auth WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($password == $row['password']) {
        // Obtener los datos del usuario
        $user_id = $row['user_id'];
        $sql_user = "SELECT * FROM users WHERE id_usuario=$user_id";
        $result_user = $conn->query($sql_user);
        $row_user = $result_user->fetch_assoc();

        // Usuario autenticado correctamente
        echo json_encode(['status' => 'success', 'message' => 'Login successful', 'user' => $row_user]);
    } else {
        // Contraseña incorrecta
        echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
    }
} else {
    // Usuario no encontrado
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
}

$conn->close();
?>
