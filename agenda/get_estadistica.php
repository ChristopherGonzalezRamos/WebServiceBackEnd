<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agenda";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array();

// Consulta para contar las notas de hoy
$sql_today = "SELECT COUNT(*) as count FROM notas WHERE DATE(createdAt) = CURDATE()";
$result_today = $conn->query($sql_today);
if ($result_today->num_rows > 0) {
    $row = $result_today->fetch_assoc();
    $response['notes_today'] = $row['count'];
} else {
    $response['notes_today'] = 0;
}

// Consulta para contar las notas de la última semana
$sql_last_week = "SELECT COUNT(*) as count FROM notas WHERE DATE(createdAt) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND CURDATE()";
$result_last_week = $conn->query($sql_last_week);
if ($result_last_week->num_rows > 0) {
    $row = $result_last_week->fetch_assoc();
    $response['notes_last_week'] = $row['count'];
} else {
    $response['notes_last_week'] = 0;
}

$response['status'] = 'success';
echo json_encode($response);

$conn->close();
?>
