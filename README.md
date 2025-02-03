# Daily-Notes

Daily Notes adalah aplikasi web sederhana untuk mencatat dan melacak mood harian pengguna. Aplikasi ini memungkinkan pengguna untuk menambahkan catatan harian, menyertakan mood, serta melihat statistik mood dari waktu ke waktu.

## 🚀 Fitur Utama
- ✍️ **Menambahkan Catatan**: Pengguna dapat membuat catatan harian dengan mood yang dirasakan.
- 📊 **Statistik Mood**: Visualisasi mood bulanan dalam bentuk grafik.
- 🖼 **Upload Gambar**: Pengguna dapat menyertakan gambar dalam catatan mereka.
- 🔒 **Autentikasi Pengguna**: Sistem login/logout untuk menjaga privasi catatan.
- 🔄 **AJAX Refresh**: Data akan otomatis terupdate tanpa perlu me-refresh halaman.

## 🛠 Instalasi dan Konfigurasi
### 1️⃣ Persyaratan Sistem
- PHP 7.4 atau lebih baru
- MySQL/MariaDB
- Apache/Nginx

### 2️⃣ Konfigurasi Database
1. Buat database baru dengan nama `daily_notes`.
2. Jalankan skrip SQL di `database/dbconn.php` atau import file `.sql` yang disediakan.
3. Sesuaikan konfigurasi database di file `dbconn.php`.

```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "daily_notes";
```

### 3️⃣ Menjalankan Aplikasi
1. Pastikan server lokal (XAMPP/LAMP) berjalan.
2. Simpan proyek ini di folder `htdocs` (untuk XAMPP) atau root server web Anda.
3. Akses di browser: `http://localhost/Daily-Notes`

## 🖼 Screenshots
Tampilan aplikasi:

### 📌 Dashboard
![Dashboard](/images/daily-notes-main-dashboard.png)

### 📌 Tambah Catatan
![Tambah Catatan](/images/daily-notes-tambah-catatan.png)

### 📌 Statistik Mood
![Mood Calender](/images/daily-notes-statistik-1.png)

![Mood Graphic](/images/daily-notes-statistik-2.png)

> **Catatan:** Simpan gambar dalam folder `screenshots/` agar tampil dalam dokumentasi.

## 🤝 Kontribusi
Jika ingin berkontribusi, silakan fork proyek ini dan buat pull request! 🚀

## 📜 Lisensi
Proyek ini dirilis di bawah lisensi **MIT**. Bebas digunakan dan dikembangkan lebih lanjut.

---
✨ **Dibuat dengan ❤️ oleh [RecursiveFunc]** ✨

