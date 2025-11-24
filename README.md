# tugas-kriptografi
Tugas mata kuliah "Kriptografi dan Steganografi"

Fungsi dari setiap file dalam program *CRUD* (Create, Read, Update, Delete) kontak yg terenkripsi sebagai berikut:

1. config.php
File ini berfungsi sebagai konfigurasi utama aplikasi.
  - Fungsi Utama: Menyimpan pengaturan koneksi ke database MySQL.
  - Informasi yang Disimpan: Nama host (host), nama database (dbname), username (user), password (pass), dan charset.
  - Keamanan: Menyimpan kunci kriptografi simetris (crypto_key) yang digunakan untuk mengenkripsi dan mendekripsi data sensitif (nama, email, catatan).

2. functions.php
File ini adalah pustaka yang berisi semua fungsi bantu (helper) yang digunakan di seluruh aplikasi.
  - Fungsi Utama: Menyediakan fungsi untuk enkripsi, dekripsi, dan koneksi ke database.
  - Detail Fungsi: xor_stream(string $data, string $key): Melakukan operasi XOR antara data dan kunci kriptografi.
    - encrypt(string $plaintext, string $key): Mengenkripsi plaintext menggunakan XOR dan mengonversinya menjadi base64 untuk penyimpanan.
    - decrypt(string $cipherbase64, string $key): Mendekripsi data base64 terenkripsi kembali ke plaintext.
    - get_pdo(array $dbconfig): Membuat dan mengembalikan objek PDO (PHP Data Objects) untuk koneksi database.

3. index.php
File ini berfungsi sebagai halaman utama (Read) yang menampilkan daftar kontak.
  - Fungsi Utama: Mengambil semua data kontak dari tabel contacts, mendekripsi field sensitif (name, email, notes) menggunakan kunci kriptografi, dan menampilkannya dalam format tabel.
  - Tampilan: Menyediakan tautan ke halaman create.php (tambah kontak) dan tautan aksi untuk update.php (edit) serta delete.php (hapus) untuk setiap baris kontak.
![Tampilan Form Edit Kontak](screenshot/image%20(3).png)

4. create.php
File ini berfungsi sebagai halaman Create (Tambah) untuk menambahkan kontak baru.
  - Fungsi Utama: Menampilkan formulir HTML untuk input data kontak dan memproses pengiriman formulir (POST request).
  - Proses Data: Saat formulir dikirim, ia mengambil data, mengenkripsi name, email, dan notes, lalu menyimpannya ke database.
  - Navigasi: Setelah berhasil disimpan, pengguna diarahkan kembali (header('Location: index.php')) ke halaman index.php.
![Tampilan Form Edit Kontak](screenshot/image%20(4).png)

5. update.php
File ini berfungsi sebagai halaman Update (Edit) untuk memodifikasi kontak yang sudah ada.
  - Fungsi Utama (GET): Mengambil data kontak berdasarkan id dari URL, mendekripsi datanya, dan mengisi formulir HTML.
  - Fungsi Utama (POST): Memproses perubahan data dari formulir, mengenkripsi field yang diperbarui, dan menyimpan pembaruan ke database berdasarkan id.
  - Navigasi: Setelah berhasil diperbarui, pengguna diarahkan kembali ke index.php.
![Tampilan Form Edit Kontak](screenshot/image%20(5).png)

6. delete.php
File ini berfungsi sebagai script Delete (Hapus) untuk menghapus kontak.
  - Fungsi Utama: Menerima id kontak melalui parameter URL (GET), menghapus baris yang sesuai dari tabel contacts di database.
  - Navigasi: Setelah penghapusan, pengguna diarahkan kembali ke index.php.
![Tampilan Form Edit Kontak](screenshot/image%20(6).png)
