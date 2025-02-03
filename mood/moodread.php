<?php
session_start();

include("../helper/path.php");
include("../database/dbconn.php"); // File untuk koneksi database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../regis/login.php"); // Redirect ke halaman login jika belum login
    exit;
}

// Pastikan koneksi database ada
if (!$conn) {
    die(json_encode(["error" => "Gagal terhubung ke database."]));
}

try {
    // Query untuk mendapatkan data mood dari tabel notes
    $user_id = $_SESSION['user_id'];
    $query = "SELECT n.tanggal, n.mood 
              FROM notes n
              JOIN users_notes un ON n.id = un.note_id
              WHERE un.user_id = ?";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        throw new Exception("Query tidak dapat diproses: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $moodData = [];

    // Periksa hasil query
    while ($row = $result->fetch_assoc()) {
        $moodData[$row['tanggal']] = $row['mood'];
    }
} catch (Exception $e) {
    error_log("Gagal mengambil data mood: " . $e->getMessage());
    echo json_encode(["error" => "Gagal mengambil data mood"]);
}

// Tutup koneksi
$stmt->close();
$conn->close();
