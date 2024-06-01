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
$name = $postData['name'] ?? '';
$age = $postData['age'] ?? '';
$occupation = $postData['occupation'] ?? '';
$email = $postData['email'] ?? '';

// Verificar si algún campo está vacío
if (empty($name) || empty($age) || empty($occupation) || empty($email)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit; // Salir del script
}

// Insertar datos del usuario en la tabla users
$sql_insert_user = "INSERT INTO users (name, age, occupation, email) VALUES ('$name', $age, '$occupation', '$email')";

if ($conn->query($sql_insert_user) === TRUE) {
    // Obtener el ID del usuario recién insertado
    $id_usuario = $conn->insert_id;

    // Continuar con el proceso de registro en la tabla auth
    $password = $postData['password'] ?? '';
    if (empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Password is required']);
        exit; // Salir del script
    }

    // Insertar una nueva fila en la tabla auth
    $sql_auth = "INSERT INTO auth (email, password, user_id) VALUES ('$email', '$password', $id_usuario)";

    if ($conn->query($sql_auth) === TRUE) {
        // Registro exitoso en ambas tablas
        echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
    } else {
        // Manejar errores de inserción en la tabla auth
        echo json_encode(['status' => 'error', 'message' => 'Failed to register in auth table']);
    }
} else {
    // Manejar errores de inserción en la tabla users
    echo json_encode(['status' => 'error', 'message' => 'Failed to register in users table']);
}

$conn->close();
?>
