<?php
// Data untuk grafik
include("mood-count.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Details - Daily Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Tambahkan Bootstrap Icons untuk ikon panah -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="mood-style.css"> Link ke file CSS eksternal -->

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
    </style>
</head>

<body>
    <main class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Statistik Mood Bulanan</h1>
            <button class="btn btn-outline-primary shadow-sm rounded-pill px-4 py-2" onclick="window.history.back()">
                <i class="bi bi-arrow-left"></i> Kembali
            </button>
        </div>
        <canvas id="moodChart" width="400" height="200"></canvas>
    </main>

    <script>
        // Data untuk grafik
        const emojiCounts = <?php echo json_encode($emojiCounts); ?>;

        // Menyiapkan data untuk Chart.js
        const labels = Object.keys(emojiCounts); // Nama bulan
        const datasets = [{
                label: '😞 Sangat Buruk',
                data: Object.values(emojiCounts).map(data => data[0]),
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
            },
            {
                label: '😐 Netral',
                data: Object.values(emojiCounts).map(data => data[1]),
                backgroundColor: 'rgba(255, 159, 64, 0.6)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1,
            },
            {
                label: '🙂 Baik',
                data: Object.values(emojiCounts).map(data => data[2]),
                backgroundColor: 'rgba(255, 205, 86, 0.6)',
                borderColor: 'rgba(255, 205, 86, 1)',
                borderWidth: 1,
            },
            {
                label: '😊 Sangat Baik',
                data: Object.values(emojiCounts).map(data => data[3]),
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            },
            {
                label: '😍 Luar Biasa',
                data: Object.values(emojiCounts).map(data => data[4]),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
            },
        ];

        // Konfigurasi Chart.js
        const ctx = document.getElementById('moodChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets,
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw}`;
                            },
                        },
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5,
                        },
                    },
                },
            },
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>

</html>