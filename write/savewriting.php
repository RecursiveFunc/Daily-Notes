<?php
session_start();
include("../helper/path.php");
include("../database/dbconn.php");

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak! Silakan login terlebih dahulu.");
}

$user_id = $_SESSION['user_id']; // Ambil ID pengguna dari session

// Ambil data dari form
$title = htmlspecialchars($_POST['title']); // Escape untuk keamanan
$content = htmlspecialchars($_POST['content']); // Escape untuk keamanan
$mood = intval($_POST['mood']); // Pastikan data adalah integer
$date = DateTime::createFromFormat('d-m-Y', $_POST['date'])->format('Y-m-d'); // Format tanggal ke YYYY-MM-DD

// Upload gambar
$imageName = null;
if (!empty($_FILES['image']['name'])) {
    $targetDir = "uploads/"; // Folder tujuan penyimpanan
    $imageName = basename($_FILES['image']['name']);
    $targetFilePath = $targetDir . $imageName;

    // Validasi dan upload
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif']; // Jenis file yang diizinkan
    if (in_array($fileType, $allowedTypes)) {
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true); // Buat folder jika belum ada
        }
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            die("Gagal mengupload gambar");
        }
    } else {
        die("Jenis file tidak diizinkan. Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.");
    }
}

// Mulai transaksi
$conn->begin_transaction();

try {
    // Simpan data ke tabel notes
    $sql = "INSERT INTO notes (judul, isi, mood, gambar, tanggal) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $title, $content, $mood, $imageName, $date);

    if (!$stmt->execute()) {
        throw new Exception("Gagal menyimpan catatan: " . $stmt->error);
    }

    // Ambil ID catatan yang baru saja dibuat
    $note_id = $conn->insert_id;

    // Simpan data ke tabel users_note (hubungan antara user dan note)
    $sql = "INSERT INTO users_notes (user_id, note_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $note_id);

    if (!$stmt->execute()) {
        throw new Exception("Gagal menyimpan ke users_note: " . $stmt->error);
    }

    // Commit transaksi jika semua berhasil
    $conn->commit();

    // Redirect dengan pesan sukses
    header("Location: write.php?success=1");
    exit;
} catch (Exception $e) {
    // Rollback transaksi jika terjadi kesalahan
    $conn->rollback();
    die("Terjadi kesalahan: " . $e->getMessage());
}

// Tutup koneksi
$stmt->close();
$conn->close();
