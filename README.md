# Aplikasi Penghitungan & Transparansi Gaji DPR RI

Aplikasi ini dikembangkan untuk menyediakan sistem manajemen dan transparansi mengenai komponen penghasilan, tunjangan, dan perhitungan Take Home Pay (THP) anggota DPR RI. Sistem ini memisahkan akses data berdasarkan peran pengguna (Admin dan Public).

---

## 💻 Fitur Utama Aplikasi

Aplikasi ini memenuhi semua kebutuhan sistem (CRUD, validasi, *search*, dan aturan bisnis) yang diminta dalam spesifikasi proyek
### Akses Admin (Full Management)
1.  **Pengelolaan Data Master (CRUD)**: Mengelola data Anggota DPR  dan Komponen Gaji/Tunjangan
2.  **Pengelolaan Data Penggajian (CRUD)**: Membuat data penggajian dengan memilih komponen gaji per anggota
    * **Tantangan Validasi**: Menerapkan aturan bahwa komponen gaji yang dipilih harus sesuai dengan **Jabatan** anggota dan mencegah duplikasi komponen
    * **Perhitungan THP**: Menghitung Take Home Pay bulanan secara akurat, termasuk mempertimbangkan **Tunjangan Istri/Suami** (jika status menikah) dan **Tunjangan Anak** (maksimal 2 anak)
3.  **Pencarian Lanjut**: Mendukung pencarian multi-kolom pada semua tabel data master dan transaksi
4.  **Interaksi DOM**: Menggunakan JavaScript untuk *feedback* interaktif dan konfirmasi penghapusan

### Akses Public (Read Only)
1.  **Akses Data Anggota**: Melihat daftar dan detail data Anggota DPR (Read Only)
2.  **Akses Data Penggajian**: Melihat ringkasan dan detail perhitungan THP per anggota (Read Only)

---

## ⚙️ Teknologi yang Digunakan

| Kategori | Teknologi | Keterangan |
| :--- | :--- | :--- |
| **Backend Framework** | Laravel (PHP)| Digunakan untuk routing, ORM (Eloquent), Authentication, Middleware, dan Controller Logic. |
| **Database** | MySQL / RDBMS  | Digunakan sebagai basis data untuk menyimpan data Anggota, Komponen Gaji, dan Penggajian. |
| **Frontend/Styling** | HTML & Custom CSS  | Tampilan dibuat dengan HTML dasar dan CSS kustom untuk konsistensi visual. |
| **Interaksi** | JavaScript (DOM Manipulation) | Digunakan untuk meningkatkan *user experience* seperti konfirmasi penghapusan. |

---

## 🔑 Cara Login

Aplikasi ini menggunakan sistem *Authentication* berbasis *Role* untuk memisahkan hak akses antara Administrator dan Pengguna Publik

| Role | Email | Password | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Admin** | `thoriq@simanjuntak.com` | `admin123` | Full CRUD, Pengaturan Gaji, THP Calculation. |
| **Public** | `richard@subakat.com` | `public123` | Read Only pada data Anggota dan Penggajian. |

Akses aplikasi dimulai dari halaman `/login` setelah menjalankan server development.

## 📝 Panduan Penggunaan Fitur (Admin)

Berikut adalah tata cara penggunaan fitur-fitur utama di sisi Administrator:

### A. Manajemen Data Anggota DPR
1.  **Akses:** Dari Dashboard Admin, klik kartu **"Manajemen Anggota DPR"**.
2.  **Tambah Data:** Klik tombol **"Tambah Anggota"**. Isi semua kolom (Nama, Jabatan, Status Pernikahan, Jumlah Anak). Data ini sangat penting untuk perhitungan THP.
3.  **Pencarian:** Gunakan kolom *Search* untuk mencari Anggota berdasarkan Nama Depan, Nama Belakang, Jabatan, atau ID.
4.  **Ubah/Hapus:** Gunakan tombol **Ubah** atau **Hapus** pada baris tabel yang bersangkutan. Penghapusan akan memicu konfirmasi DOM.

### B. Manajemen Komponen Gaji & Tunjangan
1.  **Akses:** Dari Dashboard Admin, klik kartu **"Komponen Gaji & Tunjangan"**.
2.  **Tambah Data:** Klik **"Tambah Komponen"**. Isi Nama Komponen, pilih Kategori (Gaji Pokok/Tunjangan), Jabatan (Siapa yang berhak), Nominal, dan Satuan.
3.  **Pencarian:** Mendukung pencarian multi-kolom berdasarkan Nama, Kategori, Jabatan, Nominal, dan ID.

### C. Manajemen Data Penggajian (THP Calculation)
1.  **Akses:** Dari Dashboard Admin, klik kartu **"Data Penggajian & THP"**.
2.  **Tambah Data Penggajian:**
    * Klik **"Tambah Data Penggajian"**.
    * Pilih Anggota DPR yang ingin diatur komponen gajinya.
    * Pilih Komponen Gaji yang ingin diberikan (Multi-select).
    * **Sistem akan memvalidasi** secara otomatis apakah komponen gaji tersebut sah untuk jabatan Anggota yang dipilih, dan mencegah duplikasi.
3.  **Lihat Detail & THP:**
    * Pada tabel ringkasan Penggajian, klik tautan **"Lihat Detail THP"**.
    * Halaman detail akan menampilkan semua komponen yang diperoleh dan **Total Take Home Pay Bulanan** yang sudah dihitung berdasarkan status keluarga Anggota.
4.  **Ubah/Hapus:**
    * Tombol **Ubah** akan membawa Anda ke halaman *edit* di mana Anda dapat mengatur ulang daftar komponen gaji Anggota tersebut.
    * Tombol **Hapus** akan menghapus semua catatan penggajian Anggota terkait.