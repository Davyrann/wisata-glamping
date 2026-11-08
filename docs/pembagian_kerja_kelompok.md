# DOKUMEN PEMBAGIAN KERJA & JOBDESK ANGGOTA KELOMPOK
## Proyek UAS Pemrograman Web: Aplikasi Wisata Glamping (Kelas B)

---

### Informasi Kelompok
- **Topik / Fokus**: Kelas B — Penyedia Wisata Glamping (Glamour Camping)
- **Teknologi**: Laravel 12 (PHP 8.3+), Tailwind CSS v4, SQLite/MySQL
- **Jumlah Anggota**: 4 Orang

---

## 1. Ringkasan Peran & Tanggung Jawab Utama

| No | Peran / Posisi | Fokus Utama | Deliverable Kunci |
| :---: | :--- | :--- | :--- |
| **1** | **Project Lead & Core Backend Engine** | Skema Database, Logika Reservasi, Validasi Stok & Asuransi | Engine reservasi kamar, kalkulasi asuransi refund, validasi stok tanggal, Pest test core. |
| **2** | **Backend & Operations Specialist** | Panel Staff & Admin, Verifikasi Check-in/out, Audit Log | Dashboard staff, approval pembatalan, check-in/out QR dummy, audit log, manajemen user. |
| **3** | **Frontend Engineer & UI/UX Specialist** | Antarmuka Pengguna, Mobile-First Layout, Kartu Digital | UI Blade + Tailwind v4, katalog glamping, form checkout, sandbox QRIS, kartu digital. |
| **4** | **QA, Content & DevOps Lead** | CRUD Artikel, Seeder Akun Demo, Automated Testing & Deployment | CRUD artikel, seeder demo (Admin/Staff/User), automated testing, deployment live, laporan akhir. |

---

## 2. Rincian Jobdesk Setiap Anggota

### Anggota 1: Project Lead & Core Backend Engine
* **Tanggung Jawab Spesifik**:
  1. Merancang dan mengimplementasikan migrasi tabel utama: `rooms` dan `bookings`.
  2. Membangun logika validasi ketersediaan stok kamar glamping per rentang tanggal (`check_in_date` s/d `check_out_date`) dengan proteksi `DB::transaction()`.
  3. Mengimplementasikan formula biaya sewa per malam dan aturan kalkulasi asuransi pembatalan:
     - Dengan Asuransi (> 3 hari sebelum check-in = refund 100%).
     - Dengan Asuransi (≤ 3 hari sebelum check-in = refund 50%).
     - Tanpa Asuransi (refund 0%).
  4. Menyiapkan Middleware autentikasi dan otorisasi hak akses (Role-Based Access Control) untuk proteksi rute User, Staff, dan Admin.
  5. Menulis skenario Automated Feature Test (Pest) untuk alur reservasi dan kalkulasi refund.
* **Branch Git Utama**: `feat/booking-engine-core`

---

### Anggota 2: Backend & Operations Specialist
* **Tanggung Jawab Spesifik**:
  1. Membangun Dashboard Operasional Staff: metrik reservasi hari ini, permohonan pembatalan pending, pendapatan dummy, dan tabel transaksi terkini.
  2. Mengembangkan alur peninjauan pembatalan (`cancellation_requests`): aksi Approve (status menjadi `cancelled`, stok rilis, nominal refund tercatat) dan Reject (booking tetap aktif).
  3. Membangun panel verifikasi serah terima kamar (Check-in → status `checked_in`, Check-out → status `completed` & stok rilis).
  4. Mengimplementasikan sistem pencatatan otomatis riwayat aktivitas (`activity_logs`) untuk setiap tindakan operasional Staff dan Admin.
  5. Mengembangkan fitur Manajemen Akun Pengguna (CRUD akun Admin, Staff, User di panel Admin).
* **Branch Git Utama**: `feat/staff-admin-operations`

---

### Anggota 3: Frontend Engineer & UI/UX Specialist
* **Tanggung Jawab Spesifik**:
  1. Menerapkan desain antarmuka bersih (*Anti-Slop Clean UI*) dan responsif (*Mobile-First*) menggunakan Blade dan Tailwind CSS v4.
  2. Membangun halaman publik: Beranda glamping, katalog paket kamar, tata cara reservasi, dan halaman kontak.
  3. Mengembangkan form pemesanan kamar dan halaman simulasi pembayaran QRIS dummy (tombol instan "Simulasikan Bayar Berhasil" dan "Batalkan Pesanan").
  4. Membangun Halaman Publik "Cek Reservasi" (pencarian via Kode Booking + Email/Telepon) serta tampilan Kartu Digital sewa dengan QR code dummy.
  5. Membangun Dashboard Profil User (riwayat booking, form pengajuan batal, dan visualisasi grafik sewa).
* **Branch Git Utama**: `feat/frontend-mobile-ui`

---

### Anggota 4: QA, Content Specialist & DevOps Lead
* **Tanggung Jawab Spesifik**:
  1. Mengembangkan modul CRUD Artikel edukasi wisata (minimal 3 artikel wajib: tips glamping, checklist liburan alam, etika wisata alam).
  2. Menyiapkan Database Seeder lengkap dengan 3 akun demo wajib:
     - Admin: `admin@demo.test` / `Admin#2026`
     - Staff: `staff@demo.test` / `Staff#2026`
     - User: `user@demo.test` / `User#2026`
     beserta data dummy kamar glamping dan artikel awal.
  3. Melakukan quality assurance (QA), menjalankan linter kode (`vendor/bin/pint`), dan melengkapi automated testing suite (Pest).
  4. Mengelola deployment aplikasi ke hosting/cloud agar URL Web Live dapat diakses dosen.
  5. Menyusun dan merapikan dokumen laporan akhir (format PDF / Markdown) memuat diagram flow, struktur database, dan bukti kontribusi.
* **Branch Git Utama**: `feat/content-qa-deployment`

---

## 3. Matriks Tanggung Jawab (RACI Matrix)

* **R (Responsible)**: Pelaksana tugas langsung
* **A (Accountable)**: Penanggung jawab hasil akhir
* **C (Consulted)**: Pihak yang diajak berdiskusi/koordinasi
* **I (Informed)**: Pihak yang menerima pembaruan informasi

| Modul / Komponen Sistem | Anggota 1 | Anggota 2 | Anggota 3 | Anggota 4 |
| :--- | :---: | :---: | :---: | :---: |
| Perancangan Skema Database & ERD | **A / R** | C | C | I |
| Validasi Stok & Engine Reservasi | **A / R** | C | C | I |
| Logika Asuransi & Refund Pembatalan | **A / R** | C | I | I |
| Dashboard Operasional Staff & Admin | C | **A / R** | C | I |
| Alur Verifikasi Check-in / Check-out | C | **A / R** | C | I |
| Audit Trail / Activity Logging | I | **A / R** | I | I |
| Manajemen Akun Pengguna (RBAC) | C | **A / R** | I | I |
| UI/UX Katalog & Mobile Responsiveness | C | I | **A / R** | C |
| Halaman Cek Booking & Kartu Digital QR | I | C | **A / R** | I |
| Sandbox Pembayaran QRIS Dummy | C | I | **A / R** | I |
| Modul CRUD Artikel Wisata | I | I | C | **A / R** |
| Seeder Akun Demo & Data Awal | C | C | I | **A / R** |
| Pengujian Otomatis (Pest Testing) | C | C | I | **A / R** |
| Deployment Live & Laporan Akhir | C | I | I | **A / R** |

---

## 4. Standar Alur Kerja Tim (Git & Kolaborasi)

Untuk memastikan penilaian **Kerapian Kode & Pengelolaan DB (15%)** dan **Commit History Jelas** terpenuhi:
1. **Aturan Branching**:
   - Dilarang melakukan *direct push* ke branch `main`.
   - Setiap anggota bekerja pada branch masing-masing (`feat/...`).
   - Penggabungan kode ke `main` dilakukan melalui Pull Request / Merge setelah dipastikan tidak ada konflik.
2. **Standar Pesan Commit (Conventional Commits)**:
   - `feat(...)`: Menambah fitur baru
   - `fix(...)`: Memperbaiki bug atau logika
   - `docs(...)`: Memperbarui dokumentasi
   - `test(...)`: Menambah atau memperbarui automated test
3. **Pemeriksaan Sebelum Push**:
   - Jalankan `vendor/bin/pint --dirty --format agent` untuk menjaga format kode seragam.
   - Jalankan `php artisan test --compact` untuk memastikan seluruh fitur berjalan tanpa error.
