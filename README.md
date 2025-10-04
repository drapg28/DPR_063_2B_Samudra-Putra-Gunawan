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
| **Admin** | `admin@dpr.com` | `password` | Full CRUD, Pengaturan Gaji, THP Calculation. |
| **Public** | `public@dpr.com` | `password` | Read Only pada data Anggota dan Penggajian. |

Akses aplikasi dimulai dari halaman `/login` setelah menjalankan server development.