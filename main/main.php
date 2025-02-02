<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../regis/login.php"); // Redirect ke halaman login jika belum login
    exit;
}

include("../helper/path.php");
include("../database/dbconn.php"); // File koneksi database

$nama = $_SESSION["nama"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Daily Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="main-style.css"> <!-- Link ke file CSS eksternal -->

    <style>
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

        .btn.btn-primary {
            padding-right: 5%;
            margin-right: 10px;
        }

        .btn.btn-success {
            padding-right: 5%;
            margin-right: 10px;
        }

        .btn.btn-info {
            padding-right: 5%;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <main class="container-fluid d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <?php
            include("svg.php");
            include("sidebar.php"); ?>
        </div>

        <!-- Konten Utama -->
        <div class="content p-4 w-100">
            <h2 class="mb-4">Selamat Datang, <?php echo htmlspecialchars($nama); ?>!</h2>
            <p>Bagaimana moodmu hari ini? Yuk tambahkan catatan harian atau pantau statistikmu.</p>

            <div class="row">
                <div class="col-md-6">
                    <div class="summary mb-4">
                        <div class="card p-3 mb-3">
                            <h4>Total Catatan Bulan Ini</h4>
                            <p class="fs-3" id="total-notes">Loading...</p>
                        </div>

                        <div class="card p-3">
                            <h4>Rata-rata Mood Bulan Ini</h4>
                            <p class="fs-3" id="average-mood">Loading...</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="shortcut d-flex justify-content-between mb-4">
                        <a href="../write/write.php" class="btn btn-primary btn-lg">➕ Tambahkan Note Baru</a>
                        <a href="../mood/mood.php" class="btn btn-success btn-lg">📅 Pantau Mood Harian</a>
                        <a href="../mood/mood-detail.php" class="btn btn-info btn-lg">📊 Lihat Statistik</a>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h4>Catatan Terbaru</h4>
                    <ul id="recent-notes" class="list-group">
                        <li class="list-group-item">Loading...</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <script>
        function fetchDashboardData() {
            fetch('fetch-main.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-notes').textContent = data.total_notes + " Catatan";
                    document.getElementById('average-mood').textContent = data.avg_mood + " / 5";

                    let notesList = document.getElementById('recent-notes');
                    notesList.innerHTML = '';

                    if (data.recent_notes.length > 0) {
                        data.recent_notes.forEach(note => {
                            let listItem = document.createElement('li');
                            listItem.classList.add('list-group-item');
                            listItem.innerHTML = `<strong>${note.judul}</strong> 
                                <span class="text-muted">(${note.tanggal})</span> 
                                <span class="badge bg-info">Mood: ${note.mood}</span>`;
                            notesList.appendChild(listItem);
                        });
                    } else {
                        notesList.innerHTML = '<li class="list-group-item">Belum ada catatan.</li>';
                    }
                })
                .catch(error => console.error("Error fetching data:", error));
        }

        fetchDashboardData();
        setInterval(fetchDashboardData, 10000);
    </script>

</body>

</html>