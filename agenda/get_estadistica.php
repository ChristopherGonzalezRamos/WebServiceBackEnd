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

// Calcular estadísticas
$today = date("Y-m-d");

// Cantidad total de notas
$sqlTotalNotes = "SELECT COUNT(*) as total_notes FROM notas";
$resultTotalNotes = $conn->query($sqlTotalNotes);
$totalNotes = $resultTotalNotes->fetch_assoc()['total_notes'];

// Cantidad de notas creadas en la última semana
$sqlNotesLastWeek = "SELECT COUNT(*) as notes_last_week FROM notas WHERE createdAt >= DATE_SUB('$today', INTERVAL 7 DAY)";
$resultNotesLastWeek = $conn->query($sqlNotesLastWeek);
$notesLastWeek = $resultNotesLastWeek->fetch_assoc()['notes_last_week'];

// Cantidad de notas creadas hoy
$sqlNotesToday = "SELECT COUNT(*) as notes_today FROM notas WHERE DATE(createdAt) = '$today'";
$resultNotesToday = $conn->query($sqlNotesToday);
$notesToday = $resultNotesToday->fetch_assoc()['notes_today'];

// Devolver los resultados como JSON
echo json_encode([
    'status' => 'success',
    'total_notes' => $totalNotes,
    'notes_last_week' => $notesLastWeek,
    'notes_today' => $notesToday
]);

$conn->close();
?>
