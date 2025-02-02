<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../regis/login.php"); // Redirect ke halaman login jika belum login
    exit;
}

require("../helper/path.php");
$nama = $_SESSION["nama"];
?>
<!DOCTYPE html>
<html lang="en" x-data>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Notes - Daily Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="write-style.css">
    <style>
        /* Konten Utama */
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            color: white;
            min-height: 100vh;
            width: 250px;
            padding: 20px;
        }

        .content {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 20px;
        }

        .form-control,
        .form-range {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-range:focus {
            border-color: #8f94fb;
            box-shadow: 0 0 8px rgba(143, 148, 251, 0.5);
        }

        /* Emoji */
        .emoji {
            font-size: 2rem;
            margin: 10px 47.5%;
            transition: transform 0.3s ease;
        }

        /* Button Submit */
        .btn-submit {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(78, 84, 200, 0.4);
        }

        .btn-submit:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .img-thumbnail {
            border-radius: 10px;
            border: 2px solid #8f94fb;
            transition: transform 0.3s ease;
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
        }

        .text-danger {
            font-size: 0.9rem;
            color: #ff4757;
        }
    </style>
</head>

<body>
    <main class="container-fluid d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <?php
            include("svg.php");
            include("sidebar.php");
            ?>
        </div>

        <!-- Konten Utama -->
        <div class="content p-4 w-100">
            <h2 class="mb-4">Tambahkan Catatan Harianmu</h2>
            <form action="savewriting.php" method="POST" enctype="multipart/form-data" x-data="{ 
                mood: 3, 
                imagePreview: null, 
                title: '', 
                content: '', 
                isValid: false 
            }" x-effect="isValid = title.trim() !== '' && content.trim().length >= 10">

                <!-- Judul -->
                <div class="mb-4">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan judul catatan" required x-model="title">
                    <small class="text-danger" x-show="title.trim() == ''">Judul tidak boleh kosong</small>
                </div>

                <!-- Gambar -->
                <div class="mb-4">
                    <label for="image" class="form-label">Gambar</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*"
                        @change="imagePreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                    <div class="mt-3" x-show="imagePreview">
                        <p>Pratinjau Gambar:</p>
                        <img :src="imagePreview" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                </div>

                <!-- Mood Tracker -->
                <div class="mb-4">
                    <label for="mood" class="form-label">Mood</label>
                    <input type="range" id="mood" name="mood" class="form-range" min="1" max="5" step="1" x-model="mood">
                    <p class="mt-2">Mood: <strong x-text="mood"></strong></p>
                    <div class="emoji" x-show="mood == 1">😞</div>
                    <div class="emoji" x-show="mood == 2">😐</div>
                    <div class="emoji" x-show="mood == 3">🙂</div>
                    <div class="emoji" x-show="mood == 4">😊</div>
                    <div class="emoji" x-show="mood == 5">😍</div>
                </div>

                <!-- Isi Catatan -->
                <div class="mb-4">
                    <label for="content" class="form-label">Isi catatan</label>
                    <textarea id="content" name="content" rows="5" class="form-control" placeholder="Tulis catatanmu disini..." required x-model="content"></textarea>
                    <small class="text-danger" x-show="content.trim().length < 10">Isi catatan harus minimal 10 karakter</small>
                </div>

                <!-- Tanggal -->
                <div class="mb-4">
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="text" id="date" name="date" class="form-control" placeholder="dd-mm-yyyy" required>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-submit" :disabled="!isValid">
                    Simpan Note
                </button>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#date", {
            dateFormat: "d-m-Y",
            allowInput: true
        });
    </script>
    <?php if (isset($_GET['success'])): ?>
        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "Note berhasil ditambahkan.",
                icon: "success",
                confirmButtonText: "OK"
            });
        </script>
    <?php elseif (isset($_GET['error'])): ?>
        <script>
            Swal.fire({
                title: "Gagal!",
                text: "Terjadi kesalahan saat menyimpan data.",
                icon: "error",
                confirmButtonText: "Coba Lagi"
            });
        </script>
    <?php endif; ?>
</body>

</html>