<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agenda";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener la acción del cliente
$input = json_decode(file_get_contents('php://input'), true);
$action = isset($input['action']) ? $input['action'] : null;

// Valid actions
$valid_actions = ['update_note', 'delete_note'];

// Check if the action is valid
if (!in_array($action, $valid_actions)) {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid action'));
    exit; // Exit the script if the action is not valid
}

// Execute the corresponding action
switch ($action) {
    case 'update_note':
        updateNote();
        break;
    case 'delete_note':
        deleteNote();
        break;
    default:
        echo json_encode(array('status' => 'error', 'message' => 'Invalid action'));
}

// Function to update an existing note
function updateNote() {
    global $conn, $input;
    
    // Get data from the client
    $id = isset($input['id']) ? $input['id'] : null;
    $titulo = isset($input['titulo']) ? $input['titulo'] : null;
    $contenido = isset($input['contenido']) ? $input['contenido'] : null;

    if ($id && $titulo && $contenido) {
        // Prepare SQL statement
        $sql = "UPDATE notas SET titulo = ?, contenido = ?, updatedAt = NOW() WHERE id_nota = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $titulo, $contenido, $id);

        // Execute the statement and check if it was successful
        if ($stmt->execute()) {
            echo json_encode(array('status' => 'success', 'message' => 'Note updated successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Error updating note'));
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Missing data to update note'));
    }
}

// Function to delete a note
function deleteNote() {
    global $conn, $input;
    
    // Get data from the client
    $id = isset($input['id']) ? $input['id'] : null;

    if ($id) {
        // Prepare SQL statement
        $sql = "DELETE FROM notas WHERE id_nota = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        // Execute the statement and check if it was successful
        if ($stmt->execute()) {
            echo json_encode(array('status' => 'success', 'message' => 'Note deleted successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Error deleting note'));
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Missing data to delete note'));
    }
}

$conn->close();
?>
