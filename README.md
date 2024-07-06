# Aplikasi Absensi Siswa dan Guru

Aplikasi Absensi Siswa dan Guru adalah sebuah sistem berbasis web yang memungkinkan pengelolaan absensi dengan mudah. Aplikasi ini juga mendukung pengiriman notifikasi ke orang tua siswa mengenai kehadiran anak mereka.

## Fitur

1. **Tambah Siswa**:
   - Tambah siswa secara manual melalui form input.
   - Tambah siswa melalui unggah file Excel.

2. **Download Laporan Absen Bulanan**:
   - Laporan absensi bulanan dalam format Excel yang dapat diunduh.

3. **Notifikasi Orang Tua**:
   - Mengirimkan notifikasi ke orang tua melalui WhatsApp atau Telegram mengenai kehadiran siswa.

4. **Manajemen Guru**:
   - Tambah, edit, dan hapus data guru.

5. **Manajemen Siswa**:
   - Tambah, edit, dan hapus data siswa.

6. **Rekap Kehadiran**:
   - Melihat rekap kehadiran harian, mingguan, dan bulanan.

## Instalasi

1. Clone repositori ini ke direktori web server Anda:
    ```bash
    git clone https://github.com/galeriguru/Absensi---mengirim-pesan-otomatis.git
    ```

2. Pindah ke direktori proyek:
    ```bash
    cd Absensi---mengirim-pesan-otomatis
    ```

3. Buat database MySQL dan impor file `database.sql` yang ada di folder `sql`:
    ```sql
    CREATE DATABASE absensi_db;
    USE absensi_db;
    SOURCE sql/database.sql;
    ```

4. Konfigurasi koneksi database di `config.php`:
    ```php
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "absensi_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>
    ```

5. Pastikan Anda memiliki folder `PHPExcel` di direktori `htdocs/absensi/` untuk mendukung fitur upload dan download file Excel.

6. Jalankan aplikasi di web server lokal Anda dan akses melalui browser:
    ```
    http://localhost/absensi
    ```

## Penggunaan

### Menambah Siswa Secara Manual

1. Masuk sebagai admin.
2. Pilih menu "Manajemen Siswa".
3. Klik "Tambah Siswa".
4. Isi form dengan data siswa yang lengkap.
5. Klik "Simpan".

### Menambah Siswa Melalui Unggah File Excel

1. Masuk sebagai admin.
2. Pilih menu "Manajemen Siswa".
3. Klik "Unggah File Excel".
4. Pilih file Excel yang berisi data siswa.
5. Klik "Unggah".

### Mengunduh Laporan Absen Bulanan

1. Masuk sebagai admin atau guru.
2. Pilih menu "Laporan".
3. Pilih bulan dan tahun yang diinginkan.
4. Klik "Unduh Laporan".

### Mengirim Notifikasi ke Orang Tua

1. Pastikan API WhatsApp atau Telegram sudah dikonfigurasi di `config.php`.
2. Setiap kali siswa melakukan absensi, notifikasi otomatis akan dikirimkan ke orang tua.

## Kontribusi

Jika Anda ingin berkontribusi pada proyek ini, silakan fork repositori ini dan buat pull request dengan perubahan yang Anda buat. Jangan lupa untuk mendokumentasikan perubahan Anda dengan baik.

## Kontak

- **Email**: gurugaleri@gmail.com
- **YouTube**: [@galeriguru240](https://www.youtube.com/@galeriguru240)

## Lisensi

Aplikasi ini dilisensikan di bawah [MIT License](LICENSE).
