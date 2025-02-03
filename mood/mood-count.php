<?php
session_start();

include("../database/dbconn.php");

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../regis/login.php");
    exit;
}

// Pastikan koneksi database ada
if (!$conn) {
    die(json_encode(["error" => "Gagal terhubung ke database."]));
}

try {
    // Query untuk mengambil data mood berdasarkan users_notes
    $query = "
        SELECT MONTH(n.tanggal) AS bulan, n.mood, COUNT(*) AS total
        FROM notes n
        JOIN users_notes un ON n.id = un.note_id
        WHERE un.user_id = ?
        GROUP BY MONTH(n.tanggal), n.mood
        ORDER BY bulan, mood
    ";

    // Siapkan statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Statement tidak dapat diproses: " . $conn->error);
    }

    // Bind parameter
    $stmt->bind_param("i", $_SESSION['user_id']);

    // Eksekusi statement
    $stmt->execute();

    // Ambil hasilnya
    $result = $stmt->get_result();
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Inisialisasi array hasil untuk 12 bulan & 5 kategori mood
    $emojiCounts = [];
    for ($i = 1; $i <= 12; $i++) {
        $emojiCounts[$i] = [0, 0, 0, 0, 0]; // 5 kategori mood
    }

    // Mengisi array dengan data dari query
    foreach ($data as $row) {
        $bulan = (int) $row['bulan'];
        $moodIndex = (int) $row['mood'] - 1; // Mood mulai dari 1, index array dari 0
        $emojiCounts[$bulan][$moodIndex] = (int) $row['total'];
    }

    // Tutup statement & koneksi
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    error_log("Gagal mengambil data mood: " . $e->getMessage());
    echo json_encode(["error" => "Gagal mengambil data mood"]);
}
