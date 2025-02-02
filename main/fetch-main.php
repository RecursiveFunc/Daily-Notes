<?php
session_start();
include("../database/dbconn.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Query jumlah catatan bulan ini dan rata-rata mood
$query = "
    SELECT COUNT(*) AS total_notes, AVG(mood) AS avg_mood 
    FROM notes 
    JOIN users_notes un ON notes.id = un.note_id
    WHERE un.user_id = ? AND MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())
";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

$totalNotes = $row['total_notes'] ?? 0;
$averageMood = isset($row['avg_mood']) ? round($row['avg_mood'], 1) : 'N/A';

// Query catatan terbaru
$query = "SELECT tanggal, mood, judul FROM notes 
          JOIN users_notes un ON notes.id = un.note_id
          WHERE un.user_id = ? 
          ORDER BY tanggal DESC LIMIT 5";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$recentNotes = [];
while ($row = $result->fetch_assoc()) {
    $row['tanggal'] = date('d M Y', strtotime($row['tanggal']));
    $recentNotes[] = $row;
}
$stmt->close();
$conn->close();

// Kirim response JSON
header("Content-Type: application/json");
echo json_encode([
    "total_notes" => $totalNotes,
    "avg_mood" => $averageMood,
    "recent_notes" => $recentNotes
]);
