<?php
include("moodread.php");
$nama = $_SESSION["nama"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Tracker - Daily Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Tambahkan Bootstrap Icons untuk ikon panah -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="mood-style.css"> <!-- Link ke file CSS eksternal -->

    <style>
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .day {
            width: 100%;
            padding: 20px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            position: relative;
        }

        .day[data-mood="1"] {
            background-color: #ff6b6b;
            /* Merah */
            color: white;
        }

        .day[data-mood="2"] {
            background-color: #ffa502;
            /* Oranye */
            color: white;
        }

        .day[data-mood="3"] {
            background-color: #f1c40f;
            /* Kuning */
            color: black;
        }

        .day[data-mood="4"] {
            background-color: #2ecc71;
            /* Hijau */
            color: white;
        }

        .day[data-mood="5"] {
            background-color: #3498db;
            /* Biru */
            color: white;
        }

        .btn.btn-outline-primary {
            margin-top: 4%;
        }

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
            <h2 class="mb-4">Pantau Moodmu setiap hari</h2>
            <div class="calendar">
                <?php
                $currentMonth = date('m');
                $currentYear = date('Y');
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $date = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
                    $mood = $moodData[$date] ?? null; // Ambil mood dari data
                    switch ($mood) {
                        case 1:
                            $emoji = '😞';
                            break;
                        case 2:
                            $emoji = '😐';
                            break;
                        case 3:
                            $emoji = '🙂';
                            break;
                        case 4:
                            $emoji = '😊';
                            break;
                        case 5:
                            $emoji = '😍';
                            break;
                        default:
                            $emoji = '📅'; // Default emoji jika tidak ada data
                            break;
                    }
                    echo "<div class='day' data-mood='{$mood}' data-date='{$date}'>
                            <strong>{$day}</strong>
                            <div>{$emoji}</div>
                        </div>";
                }
                // print_r($moodData); // Cetak data mood pada saat load halaman
                ?>
            </div>

            <button class="btn btn-outline-primary shadow-sm rounded-pill px-4 py-2" onclick="showMoodDetails()">
                Lihat Detail Mood <i class="bi bi-arrow-right"></i>
            </button>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <script>
        function showMoodDetails() {
            window.location.href = `mood-detail.php`;
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("moodread.php")
                .then(response => response.json())
                .then(moodData => {
                    document.querySelectorAll(".day").forEach(day => {
                        let date = day.getAttribute("data-date");
                        let mood = moodData[date] || null;
                        let emoji = "📅"; // Default emoji

                        switch (mood) {
                            case "1":
                                emoji = "😞";
                                break;
                            case "2":
                                emoji = "😐";
                                break;
                            case "3":
                                emoji = "🙂";
                                break;
                            case "4":
                                emoji = "😊";
                                break;
                            case "5":
                                emoji = "😍";
                                break;
                        }

                        day.setAttribute("data-mood", mood);
                        day.innerHTML = `<strong>${day.innerText}</strong><div>${emoji}</div>`;
                    });
                })
                .catch(error => console.error("Gagal mengambil data mood:", error));
        });
    </script>

</body>

</html>