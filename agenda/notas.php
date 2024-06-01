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

// Obtener la acción del cliente
$action = isset($_POST['action']) ? $_POST['action'] : null;

// Verificar si la acción es válida
if ($action === 'create_note') {
    createNote();
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid action'));
}

// Función para crear una nueva nota
function createNote() {
    global $conn;
    
    // Obtener datos del cliente
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : null;
    $contenido = isset($_POST['contenido']) ? $_POST['contenido'] : null;

    if ($titulo && $contenido) {
        // Preparar la sentencia SQL
        $sql = "INSERT INTO notas (titulo, contenido) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $titulo, $contenido);

        // Ejecutar la sentencia y verificar si fue exitosa
        if ($stmt->execute()) {
            echo json_encode(array('status' => 'success', 'message' => 'Note created successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Error creating note'));
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Missing data to create note'));
    }
}

// Cerrar la conexión
$conn->close();
?>
