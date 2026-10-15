# CodeQuest Kids — Design Specification

## 1. Referensi Utama dan Prioritas

Gunakan `CodeQuest_Kids_PRD.md` sebagai referensi utama untuk memahami tujuan produk, kebutuhan fungsional, struktur halaman, alur pengguna, dan ruang lingkup proyek CodeQuest Kids.

Jika terdapat perbedaan antara asumsi desain dan kebutuhan dalam PRD, prioritaskan kebutuhan produk dalam PRD. Dokumen ini memberikan arahan visual dan UI/UX yang lebih spesifik.

Fokuskan hasil pada desain UI/UX yang konsisten, interaktif, responsif, dan realistis untuk diimplementasikan. Jangan mengubah tujuan utama produk menjadi website landing page saja.

## 2. Peran dan Konteks Produk

Bertindaklah sebagai Senior UI/UX Designer dan Game-Based Learning Product Designer.

Buat desain UI/UX lengkap untuk **CodeQuest Kids**, sebuah platform edukasi coding interaktif untuk anak Sekolah Dasar (SD) yang menjadi proyek M-ONE Telkomsel Coding Competition 2026.

### 2.1 Product Vision

CodeQuest Kids mengajarkan dasar-dasar pemrograman dan computational thinking kepada anak SD melalui pembelajaran berbasis game.

**Tagline:** "Belajar Coding, Taklukkan Tantangan!"

Anak harus merasa sedang memainkan game petualangan sambil belajar coding. Mereka tidak hanya membaca materi, tetapi juga menyusun perintah, menjalankan kode, memecahkan masalah, mendapatkan feedback, mengumpulkan XP, dan membuka level berikutnya.

**Penting:** Jangan membuat website yang hanya berupa landing page. Hasil desain harus berupa sistem aplikasi edukasi multi-halaman dengan alur belajar yang jelas dan fitur interaktif sebagai fokus utama.

### 2.2 Target Users

- Anak SD berusia sekitar 7–12 tahun.
- Pengguna pemula yang belum memahami pemrograman.
- Guru atau orang tua yang ingin melihat perkembangan belajar anak.

Desain harus ramah anak, mudah dipahami tanpa kemampuan teknis, menyenangkan, tidak terlalu padat, dan nyaman digunakan selama sesi belajar.

## 3. Visual Design Direction

Gunakan gaya visual berikut:

- Playful, modern, colorful, dan polished.
- Terinspirasi dari game edukasi digital dan petualangan fantasi ringan.
- Ilustrasi karakter robot atau maskot kecil yang membantu anak belajar.
- Elemen visual berupa pulau petualangan, peta level, bintang, koin, badge, dan progress bar.
- Rounded corners, kartu yang rapi, serta bayangan halus.
- Tipografi sans-serif yang bulat dan mudah dibaca.
- Hierarki visual dan navigasi yang jelas.

### 3.1 Color Palette

| Elemen | Warna |
|---|---|
| Primary Blue | `#4F7CFF` |
| Bright Yellow | `#FFD45A` |
| Mint Green | `#65DDB4` |
| Soft Purple | `#A78BFA` |
| Coral | `#FF8B75` |
| Background | `#F5F7FF` |
| Main Text | `#263252` |

Gunakan warna secara konsisten. Hindari tampilan terlalu ramai, terlalu kekanak-kanakan, atau menyerupai dashboard admin perusahaan.

## 4. Core User Flow

Rancang alur pengguna berikut:

`Landing Page → Mulai Belajar → Buat Profil Siswa → Dashboard → Learning Map → Lesson Detail → Coding Challenge → Menjalankan Perintah → Feedback Berhasil/Gagal → Mendapatkan XP dan Badge → Progress Belajar`

Pastikan setiap halaman terhubung secara visual dan memiliki navigasi yang konsisten.

## 5. Required Pages

Buat desain untuk seluruh halaman berikut, bukan hanya satu halaman.

### A. Landing Page

- Hero section dengan tagline dan ilustrasi karakter robot.
- Tombol utama "Mulai Belajar".
- Penjelasan singkat tentang pembelajaran berbasis game.
- Preview peta petualangan dan coding challenge.
- Keunggulan platform.
- Preview XP, level, dan badge.
- Footer sederhana.

### B. Student Onboarding / Profile Setup

- Memasukkan nama panggilan.
- Memilih avatar karakter.
- Memilih atau menampilkan tingkat pengalaman coding pemula.
- Tombol untuk memulai petualangan.
- Formulir sederhana yang tidak meminta data pribadi yang tidak diperlukan.

### C. Student Dashboard

- Sapaan personal menggunakan nama panggilan.
- Avatar dan level pemain.
- Total XP dan badge yang diperoleh.
- Tombol "Lanjutkan Belajar".
- Progress pembelajaran.
- Level terakhir yang dimainkan.
- Rekomendasi misi berikutnya.
- Ringkasan aktivitas belajar.

### D. Learning Map

- Peta perjalanan belajar berbentuk pulau atau jalur petualangan.
- Level ditampilkan sebagai node yang jelas.
- Status level: terkunci, tersedia, sedang dikerjakan, atau selesai.
- Nama level, ikon, dan status progres.
- Visual menarik tetapi tetap mudah dipahami.
- Navigasi kembali ke dashboard.

### E. Lesson Detail

- Judul dan tujuan pembelajaran.
- Penjelasan konsep menggunakan bahasa sederhana untuk anak SD.
- Contoh visual atau ilustrasi.
- Contoh penggunaan perintah.
- Tombol "Coba Tantangan".
- Indikator posisi materi dalam perjalanan belajar.

### F. Interactive Coding Challenge

**Ini adalah halaman dengan prioritas tertinggi.** Desain harus menggambarkan game coding puzzle yang benar-benar interaktif, bukan halaman materi dengan tombol dekoratif.

#### Layout Desktop

- Header berisi nama level, progress, XP, dan tombol keluar.
- Area permainan di sebelah kiri atau tengah berupa grid atau maze.
- Karakter robot yang harus mencapai tujuan.
- Obstacle dan target yang terlihat jelas.
- Panel penyusunan kode di sebelah kanan.
- Command blocks yang dapat dipilih atau disusun.
- Tombol RUN, RESET, dan HINT yang mudah ditemukan.
- Panel daftar perintah yang tersedia.
- Area feedback atau petunjuk di bagian bawah.

#### Command Blocks Awal

- `MOVE FORWARD`
- `TURN LEFT`
- `TURN RIGHT`
- `JUMP`

Untuk level lanjutan, sediakan konsep `LOOP` dan `CONDITION` jika sesuai.

#### Interaksi yang Harus Digambarkan

1. Anak memilih atau menambahkan command block.
2. Perintah tersusun berurutan di panel kode.
3. Anak menekan RUN.
4. Karakter bergerak mengikuti urutan perintah.
5. Sistem menampilkan feedback apakah tujuan tercapai.
6. Anak dapat mengulang, memperbaiki kode, atau menggunakan hint.

Jangan bergantung pada drag-and-drop saja. Command blocks juga harus dapat dipilih dengan klik atau tap agar mudah digunakan pada perangkat mobile dan realistis untuk diimplementasikan.

### G. Challenge Success State

- Animasi atau ilustrasi kemenangan.
- Pesan positif.
- XP yang diperoleh.
- Badge jika berhasil membuka badge baru.
- Ringkasan penyelesaian misi.
- Tombol "Lanjut ke Level Berikutnya".
- Tombol "Kembali ke Peta".

### H. Challenge Failed / Hint State

- Pesan kesalahan yang ramah dan tidak menghakimi.
- Penjelasan singkat tentang kemungkinan kesalahan.
- Hint yang membantu anak memahami logika perintah.
- Tombol "Coba Lagi".
- Tombol "Perbaiki Kode".

Jangan menggunakan pesan yang mempermalukan anak.

### I. Progress Page

- Progress keseluruhan.
- Jumlah level selesai.
- Total XP.
- Materi yang sudah dikuasai.
- Materi yang perlu dilanjutkan.
- Visualisasi perkembangan belajar yang mudah dibaca anak.

### J. Badge Collection

- Grid koleksi badge.
- Badge yang sudah diperoleh dan badge yang belum terbuka.
- Nama serta syarat memperoleh badge.

Contoh badge:

- First Mission
- Logic Solver
- Loop Master
- Consistent Coder
- Code Creator

### K. Profile Page

- Avatar dan nama panggilan.
- Level pemain dan total XP.
- Ringkasan progres.
- Pengaturan sederhana.
- Tombol untuk kembali ke dashboard.

### L. Mini Project Page

- Area untuk mencoba membuat solusi coding sederhana.
- Instruksi singkat.
- Area menyusun perintah.
- Tombol menjalankan dan menguji hasil.
- Feedback hasil.

Halaman ini merupakan fitur tambahan jika tidak mengorbankan kualitas coding challenge utama.

## 6. Learning Curriculum

Susun visual dan urutan level berdasarkan kurikulum berikut:

| Urutan | Nama Misi | Konsep |
|---|---|---|
| 1 | Coding Explorer | Mengenal logika dan urutan instruksi |
| 2 | Sequence Master | Memahami urutan perintah |
| 3 | Loop Adventure | Memahami pengulangan |
| 4 | Condition Quest | Memahami kondisi |
| 5 | Variable World | Mengenal variabel dengan contoh sederhana |
| 6 | Mini Project | Menerapkan konsep yang telah dipelajari |

Gunakan contoh dan ilustrasi yang relevan dengan anak SD. Hindari penjelasan teknis yang terlalu rumit.

## 7. Design System

Buat sistem desain yang konsisten untuk seluruh halaman, mencakup:

- Warna utama dan warna pendukung.
- Tipografi dan hierarki heading.
- Tombol primary, secondary, dan disabled.
- Kartu level dan kartu materi.
- Badge, XP counter, dan progress bar.
- Command blocks untuk game coding.
- Modal konfirmasi.
- Toast atau feedback message.
- Empty state dan locked state.
- Navigasi desktop dan mobile.

Gunakan ikon yang mudah dikenali serta komponen yang dapat digunakan ulang.

## 8. Responsive Design

Prioritaskan desain desktop karena website akan dikembangkan dan didemonstrasikan melalui laptop.

Tetap buat desain responsif untuk tablet dan smartphone dengan ketentuan:

- Navigasi mobile yang sederhana.
- Kartu yang menyesuaikan lebar layar.
- Tombol dengan ukuran nyaman untuk disentuh.
- Coding challenge yang tetap dapat digunakan di layar kecil.
- Pada mobile, area permainan dan panel command dapat disusun vertikal.

Jangan mengecilkan seluruh layout desktop secara paksa hingga sulit dibaca.

## 9. Implementation Constraints

Desain akan diimplementasikan menggunakan:

- HTML5
- CSS3
- JavaScript Vanilla
- PHP Native
- MySQL
- XAMPP

Karena itu:

1. Utamakan layout dan komponen UI yang realistis dibuat menggunakan HTML dan CSS.
2. Hindari interaksi yang hanya mungkin dilakukan dengan teknologi khusus yang kompleks.
3. Jangan menjadikan animasi berat, 3D, atau efek WebGL sebagai kebutuhan utama.
4. Prioritaskan gameplay berbasis grid, command blocks, feedback, dan progress.
5. Gunakan komponen berulang agar halaman mudah dikembangkan.
6. Jangan menampilkan fitur yang tidak memiliki tujuan jelas dalam proses pembelajaran.

## 10. Final Output Expectations

Hasilkan desain UI/UX yang lengkap dan konsisten untuk seluruh halaman yang disebutkan.

### Prioritas Pengerjaan Desain

1. Interactive Coding Challenge.
2. Dashboard dan Learning Map.
3. Lesson Detail.
4. Success dan Failed State.
5. Progress dan Badge Collection.
6. Student Profile.
7. Landing Page.
8. Mini Project.

Setiap halaman harus memiliki tujuan yang jelas dan saling terhubung. Gunakan konten contoh yang realistis, teks antarmuka berbahasa Indonesia, dan visual yang konsisten.

Fokus utama adalah menghasilkan website edukasi coding berbasis game yang benar-benar mengajarkan coding melalui interaksi, bukan sekadar website promosi tentang coding.

**Ketentuan akhir:**
- Jangan menghilangkan halaman coding challenge atau menggantinya dengan ilustrasi statis.
- Jangan menyederhanakan produk menjadi landing page saja.
- Pastikan desain realistis untuk diimplementasikan menggunakan teknologi yang telah ditentukan.
- Prioritaskan pengalaman belajar yang interaktif, konsisten, responsif, dan ramah anak.