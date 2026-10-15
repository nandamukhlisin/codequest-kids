<?php
/**
 * CodeQuest Kids — Landing Page
 * Mengacu pada PRD Section 9.1 (Innovating Education Through Technology)
 */

require_once __DIR__ . '/includes/functions.php';
initSession();

$pageTitle  = 'Platform Belajar Coding Interaktif Anak SD';
$activePage = 'home';
$user       = isLoggedIn() ? getCurrentUser() : null;

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-container px-gutter py-4">
    <!-- Hero Section -->
    <section class="card mb-5" style="background: linear-gradient(135deg, #ffffff 0%, #f0f4ff 100%); padding: 3rem 2rem; border-radius: var(--radius-xl); border: 2px solid var(--card-stroke); box-shadow: var(--shadow-tactile-lg); position: relative; overflow: hidden;">
        <!-- Ambient Background Decors -->
        <div style="position: absolute; -top: 50px; -right: 50px; width: 260px; height: 260px; border-radius: 50%; background: rgba(21, 80, 211, 0.08); filter: blur(40px); pointer-events: none;"></div>
        <div style="position: absolute; -bottom: 60px; left: 20%; width: 300px; height: 300px; border-radius: 50%; background: rgba(67, 185, 144, 0.08); filter: blur(50px); pointer-events: none;"></div>

        <div style="display: flex; flex-direction: column; gap: 2rem; position: relative; z-index: 2;" class="lg:flex-row lg:items-center lg:justify-between">
            <!-- Left: Hero Text -->
            <div style="flex: 1; max-width: 640px;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap;">
                    <span class="badge-pill badge-blue">
                        <span class="material-symbols-outlined" style="font-size: 16px;">emoji_objects</span>
                        Telkomsel M-ONE 2026
                    </span>
                    <span class="badge-pill badge-mint">Khusus Anak Sekolah Dasar</span>
                </div>

                <h1 style="font-size: 2.8rem; color: var(--on-surface); line-height: 1.15; letter-spacing: -0.02em; margin-bottom: 1rem;">
                    Belajar Coding,<br>
                    <span style="color: var(--primary-container);">Mainkan Petualanganmu! 🚀</span>
                </h1>

                <p style="font-size: 1.15rem; color: var(--on-surface-variant); line-height: 1.6; margin-bottom: 2rem;">
                    Kenali dunia <em>computational thinking</em> lewat balok logika visual, panduan Robot Kiko, dan puzzle seru tanpa syntax rumit. Belajar coding semenyenangkan bermain game!
                </p>

                <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center;">
                    <?php if ($user): ?>
                    <a href="<?= $baseUrl ?>/dashboard.php" class="btn btn-run btn-lg">
                        <span class="material-symbols-outlined">smart_toy</span>
                        <span>Masuk ke Dashboard <?= e($user['name']) ?> ▶</span>
                    </a>
                    <?php else: ?>
                    <a href="<?= $baseUrl ?>/onboarding.php" class="btn btn-run btn-lg">
                        <span class="material-symbols-outlined">rocket_launch</span>
                        <span>Mulai Petualangan Coder Cilik!</span>
                    </a>
                    <a href="<?= $baseUrl ?>/dashboard.php" class="btn btn-outline btn-lg">
                        <span>Masuk sebagai Raka (Demo) 👤</span>
                    </a>
                    <?php endif; ?>
                </div>

                <!-- Trust / Features Badges -->
                <div style="display: flex; flex-wrap: wrap; gap: 1.25rem; margin-top: 2rem; font-size: 0.85rem; font-weight: 700; color: var(--on-surface);">
                    <div style="display: flex; align-items: center; gap: 0.35rem;">
                        <span class="material-symbols-outlined text-mint" style="font-size: 18px;">check_circle</span>
                        <span>Tanpa Instalasi Syntax</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.35rem;">
                        <span class="material-symbols-outlined text-mint" style="font-size: 18px;">check_circle</span>
                        <span>Visual Grid Animasi Real-time</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.35rem;">
                        <span class="material-symbols-outlined text-mint" style="font-size: 18px;">check_circle</span>
                        <span>Sistem XP &amp; Badge Gamifikasi</span>
                    </div>
                </div>
            </div>

            <!-- Right: Mascot Graphic Preview Card -->
            <div style="min-width: 340px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <div class="card" style="padding: 2rem; background: var(--surface-white); border-radius: var(--radius-lg); text-align: center; box-shadow: var(--shadow-tactile-lg); border: 2px solid var(--card-stroke); width: 100%; max-width: 380px;">
                    <div style="width: 6rem; height: 6rem; border-radius: 50%; background: var(--primary-fixed); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: 0 4px 0 var(--primary-shade);">
                        <span class="material-symbols-outlined animate-bounce" style="font-size: 56px; color: var(--primary-container);">smart_toy</span>
                    </div>

                    <h3 style="font-size: 1.35rem; color: var(--primary); margin-bottom: 0.25rem;">Robot Kiko</h3>
                    <span class="badge-pill badge-yellow" style="margin-bottom: 1rem;">Sahabat Coding Cilik</span>

                    <p style="font-size: 0.88rem; color: var(--on-surface-variant); margin-bottom: 1.25rem; line-height: 1.45;">
                        "Hai! Aku Kiko. Beri aku instruksi balok kode yang tepat, dan kita akan petik semua bintang emas bersama!"
                    </p>

                    <div style="background: var(--surface-container-low); padding: 0.75rem; border-radius: var(--radius-sm); display: flex; justify-content: space-around; font-size: 0.8rem; font-weight: 800;">
                        <div>
                            <span class="text-secondary" style="font-size: 1.15rem; display: block;">6</span>
                            <span>Level Misi</span>
                        </div>
                        <div style="width: 1px; background: var(--card-stroke);"></div>
                        <div>
                            <span class="text-tertiary" style="font-size: 1.15rem; display: block;">5</span>
                            <span>Lencana Logika</span>
                        </div>
                        <div style="width: 1px; background: var(--card-stroke);"></div>
                        <div>
                            <span class="text-primary" style="font-size: 1.15rem; display: block;">100%</span>
                            <span>Ramah Anak</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: How It Works (Metode Belajar) -->
    <section class="mb-5" id="cara-belajar">
        <div style="text-align: center; max-width: 650px; margin: 0 auto 2rem;">
            <span class="badge-pill badge-mint" style="margin-bottom: 0.5rem;">ALUR BELAJAR MENYENANGKAN</span>
            <h2 style="font-size: 2rem; color: var(--on-surface);">Bagaimana Cara Belajar di CodeQuest Kids?</h2>
            <p style="color: var(--on-surface-variant); font-size: 0.95rem; margin-top: 0.5rem;">
                Mengubah konsep pemrograman abstrak menjadi 4 tahapan permainan interaktif yang mudah dipahami anak SD.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.25rem;">
            <div class="card card-hover" style="text-align: center; padding: 1.5rem;">
                <div style="width: 3.5rem; height: 3.5rem; border-radius: var(--radius-sm); background: var(--primary-fixed); color: var(--primary); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: var(--shadow-tactile-xs);">
                    <span class="material-symbols-outlined" style="font-size: 30px;">menu_book</span>
                </div>
                <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem;">1. Pahami Cerita</h3>
                <p style="font-size: 0.85rem; color: var(--on-surface-variant); line-height: 1.45;">
                    Baca konsep dasar lewat analogi kehidupan sehari-hari dan petunjuk ramah dari Robot Kiko.
                </p>
            </div>

            <div class="card card-hover" style="text-align: center; padding: 1.5rem;">
                <div style="width: 3.5rem; height: 3.5rem; border-radius: var(--radius-sm); background: var(--secondary-fixed); color: var(--secondary); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: var(--shadow-tactile-xs);">
                    <span class="material-symbols-outlined" style="font-size: 30px;">extension</span>
                </div>
                <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem;">2. Susun Balok Kode</h3>
                <p style="font-size: 0.85rem; color: var(--on-surface-variant); line-height: 1.45;">
                    Pilih dan susun perintah gerak (MAJU, BELOK KANAN, BELOK KIRI) ke dalam urutan langkah.
                </p>
            </div>

            <div class="card card-hover" style="text-align: center; padding: 1.5rem;">
                <div style="width: 3.5rem; height: 3.5rem; border-radius: var(--radius-sm); background: var(--tertiary-fixed); color: var(--tertiary); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: var(--shadow-tactile-xs);">
                    <span class="material-symbols-outlined" style="font-size: 30px;">play_circle</span>
                </div>
                <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem;">3. Jalankan Simulasi</h3>
                <p style="font-size: 0.85rem; color: var(--on-surface-variant); line-height: 1.45;">
                    Tekan tombol JALANKAN KODE dan saksikan robot bergerak di papan petualangan grid secara nyata!
                </p>
            </div>

            <div class="card card-hover" style="text-align: center; padding: 1.5rem;">
                <div style="width: 3.5rem; height: 3.5rem; border-radius: var(--radius-sm); background: var(--error-container); color: var(--error); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: var(--shadow-tactile-xs);">
                    <span class="material-symbols-outlined" style="font-size: 30px;">military_tech</span>
                </div>
                <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem;">4. Raih Hadiah &amp; XP</h3>
                <p style="font-size: 0.85rem; color: var(--on-surface-variant); line-height: 1.45;">
                    Dapatkan poin XP, kumpulkan bintang, dan koleksi lencana prestasi coder cilik!
                </p>
            </div>
        </div>
    </section>

    <!-- Section 3: Curriculum Overview (6 Levels) -->
    <section class="mb-5" id="kurikulum">
        <div style="text-align: center; max-width: 650px; margin: 0 auto 2rem;">
            <span class="badge-pill badge-blue" style="margin-bottom: 0.5rem;">KURIKULUM BERTAHAP</span>
            <h2 style="font-size: 2rem; color: var(--on-surface);">6 Pulau Petualangan Logika</h2>
            <p style="color: var(--on-surface-variant); font-size: 0.95rem; margin-top: 0.5rem;">
                Materi dirancang berjenjang dari pengenalan urutan paling dasar hingga proyek mandiri.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
            <div class="card" style="border-left: 4px solid var(--tertiary);">
                <span style="font-size: 0.72rem; font-weight: 800; color: var(--tertiary);">LEVEL 1 • MUDAH</span>
                <h3 style="font-size: 1.15rem; margin-top: 0.2rem;">🌱 Coding Explorer</h3>
                <p style="font-size: 0.82rem; color: var(--on-surface-variant); margin-top: 0.35rem;">Pengenalan dasar computational thinking dan instruksi langkah lurus robot.</p>
            </div>

            <div class="card" style="border-left: 4px solid var(--primary);">
                <span style="font-size: 0.72rem; font-weight: 800; color: var(--primary);">LEVEL 2 • MUDAH</span>
                <h3 style="font-size: 1.15rem; margin-top: 0.2rem;">🧩 Sequence Master</h3>
                <p style="font-size: 0.82rem; color: var(--on-surface-variant); margin-top: 0.35rem;">Menyusun urutan perintah berbelok 90° untuk menghindari rintangan karang.</p>
            </div>

            <div class="card" style="border-left: 4px solid var(--secondary);">
                <span style="font-size: 0.72rem; font-weight: 800; color: var(--secondary);">LEVEL 3 • MENENGAH</span>
                <h3 style="font-size: 1.15rem; margin-top: 0.2rem;">🔁 Loop Adventure</h3>
                <p style="font-size: 0.82rem; color: var(--on-surface-variant); margin-top: 0.35rem;">Menggunakan REPEAT untuk mengulang instruksi tanpa menulisnya berkali-kali.</p>
            </div>

            <div class="card" style="border-left: 4px solid var(--soft-purple);">
                <span style="font-size: 0.72rem; font-weight: 800; color: var(--purple-shade);">LEVEL 4 • MENENGAH</span>
                <h3 style="font-size: 1.15rem; margin-top: 0.2rem;">❓ Condition Island</h3>
                <p style="font-size: 0.82rem; color: var(--on-surface-variant); margin-top: 0.35rem;">Mengambil keputusan berdasarkan logika percabangan IF jalan terhalang.</p>
            </div>

            <div class="card" style="border-left: 4px solid var(--coral-shade);">
                <span style="font-size: 0.72rem; font-weight: 800; color: var(--coral-shade);">LEVEL 5 • TANTANGAN</span>
                <h3 style="font-size: 1.15rem; margin-top: 0.2rem;">📦 Variable Vault</h3>
                <p style="font-size: 0.82rem; color: var(--on-surface-variant); margin-top: 0.35rem;">Menyimpan nilai skor, koin, dan penghitung langkah dengan variabel.</p>
            </div>

            <div class="card" style="border-left: 4px solid var(--yellow-shade);">
                <span style="font-size: 0.72rem; font-weight: 800; color: var(--secondary);">LEVEL 6 • MAESTRO</span>
                <h3 style="font-size: 1.15rem; margin-top: 0.2rem;">🏆 Mini Project Coder</h3>
                <p style="font-size: 0.82rem; color: var(--on-surface-variant); margin-top: 0.35rem;">Menggabungkan semua konsep dalam sebuah proyek maze dan petualangan utuh!</p>
            </div>
        </div>
    </section>

    <!-- Section 4: Final Call to Action -->
    <section class="card text-center" style="background: linear-gradient(135deg, var(--primary-container) 0%, var(--primary) 100%); color: #ffffff; padding: 2.5rem 1.5rem; border-radius: var(--radius-xl); box-shadow: var(--shadow-modal);">
        <h2 style="font-size: 2.2rem; color: #ffffff; margin-bottom: 0.75rem;">Siap Menjadi Inovator Cilik Masa Depan?</h2>
        <p style="font-size: 1.05rem; opacity: 0.9; max-width: 600px; margin: 0 auto 1.5rem;">
            Ayo bergabung bersama Raka dan Robot Kiko sekarang juga. Buka pintu ke dunia coding yang penuh keajaiban!
        </p>
        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <a href="<?= $baseUrl ?>/onboarding.php" class="btn btn-secondary btn-lg">
                <span class="material-symbols-outlined">rocket_launch</span>
                <span>Daftar / Mulai Petualangan!</span>
            </a>
            <a href="<?= $baseUrl ?>/dashboard.php" class="btn btn-outline btn-lg" style="background: rgba(255,255,255,0.15); color: #fff; border-color: rgba(255,255,255,0.4);">
                <span>Coba Demo Siswa Raka 🎮</span>
            </a>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
