<?php
/**
 * CodeQuest Kids — Halaman Materi Belajar (Misi 1 & Misi 2)
 * Mengacu pada PRD Section 13 & Design/detail_materi_belajar_misi_1_misi_2_reusable_lesson_detail
 */

require_once __DIR__ . '/includes/functions.php';
requireLogin();

$user     = getCurrentUser();
$stats    = getUserStats($user['id']);
$levels   = getAllLevels();

// Parameter level aktif
$activeLevelId = (int) ($_GET['level'] ?? 1);
if ($activeLevelId !== 2) {
    $activeLevelId = 1;
}

$pageTitle  = ($activeLevelId === 1) ? 'Materi Misi 1: Coding Explorer' : 'Materi Misi 2: Sequence Master';
$activePage = 'peta';

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-container px-gutter py-4">
    <!-- Breadcrumb & Audio Narrator -->
    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
            <a href="<?= $baseUrl ?>/peta-belajar.php" class="btn btn-outline btn-sm">
                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
                <span>Kembali ke Peta Belajar</span>
            </a>
            <span style="color: var(--locked-gray); font-weight: 700;">/</span>
            <span style="font-size: 0.85rem; font-weight: 700; color: var(--primary);">
                <?= ($activeLevelId === 1) ? 'Level 1: Coding Explorer' : 'Level 2: Sequence Master' ?>
            </span>
        </div>

        <button class="btn btn-outline btn-sm" id="ttsButton" onclick="readLessonNarration()">
            <span class="material-symbols-outlined" style="font-size: 18px; color: var(--purple-shade);">volume_up</span>
            <span id="ttsLabel">Dengarkan Penjelasan Suara 🔊</span>
            <span style="width: 8px; height: 8px; border-radius: 50%; background: var(--mint-shade); display: inline-block;" class="animate-pulse"></span>
        </button>
    </div>

    <!-- Lesson Switcher Tabs -->
    <div style="display: flex; gap: 0.5rem; background: var(--surface-container-low); padding: 0.35rem; border-radius: var(--radius-full); margin-bottom: 1.5rem; border: 1px solid var(--card-stroke); max-width: 650px;">
        <a href="<?= $baseUrl ?>/materi.php?level=1" class="btn <?= ($activeLevelId === 1) ? 'btn-primary' : 'btn-outline' ?> btn-sm" style="flex: 1; border: none; box-shadow: <?= ($activeLevelId === 1) ? 'var(--shadow-primary-btn)' : 'none' ?>;">
            <span>🌱</span>
            <span>Misi 1: Coding Explorer</span>
        </a>
        <a href="<?= $baseUrl ?>/materi.php?level=2" class="btn <?= ($activeLevelId === 2) ? 'btn-primary' : 'btn-outline' ?> btn-sm" style="flex: 1; border: none; box-shadow: <?= ($activeLevelId === 2) ? 'var(--shadow-primary-btn)' : 'none' ?>;">
            <span>🧩</span>
            <span>Misi 2: Sequence Master</span>
        </a>
    </div>

    <?php if ($activeLevelId === 1): ?>
    <!-- ═══════════════ MISI 1: CODING EXPLORER ═══════════════ -->
    <div id="lesson-content-1">
        <!-- Hero Section -->
        <section class="card mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f2f3ff 100%); padding: 1.75rem; border-radius: var(--radius-lg);">
            <div style="display: flex; flex-direction: column; gap: 1.5rem;" class="lg:flex-row lg:items-center lg:justify-between">
                <div style="flex: 1;">
                    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                        <span class="badge-pill badge-blue">LEVEL 1 • TAHAP PEMULA</span>
                        <span class="badge-pill badge-mint">⏱️ Estimasi: 5 Menit Belajar</span>
                    </div>

                    <h1 style="font-size: 2rem; color: var(--on-surface); margin-bottom: 0.5rem;">
                        Misi 1: Coding Explorer — <span style="color: var(--primary);">Langkah Pertama Robot Kiko</span>
                    </h1>

                    <!-- Learning Objective Callout -->
                    <div class="card" style="background: var(--canvas-bg); padding: 0.85rem 1rem; border-radius: var(--radius-md); display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 1rem; box-shadow: var(--shadow-tactile-xs);">
                        <span class="material-symbols-outlined text-coral" style="font-size: 24px;">flag_circle</span>
                        <p style="font-size: 0.92rem; color: var(--on-surface); font-weight: 600;">
                            <strong style="color: var(--on-surface);">Tujuan Belajar:</strong> Memahami bahwa <em>coding</em> adalah kumpulan instruksi teratur yang diberikan kepada robot agar bergerak langkah demi langkah mencapai tujuan.
                        </p>
                    </div>

                    <!-- Reward Summary -->
                    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 0.8rem; font-weight: 800; color: var(--on-surface-variant);">Hadiah Kelulusan:</span>
                        <span class="badge-pill badge-yellow"><span class="material-symbols-outlined" style="font-size: 15px;">bolt</span> +50 XP</span>
                        <span class="badge-pill badge-blue"><span class="material-symbols-outlined" style="font-size: 15px;">diamond</span> +15 Permata</span>
                        <span class="badge-pill badge-mint"><span class="material-symbols-outlined" style="font-size: 15px;">military_tech</span> Lencana First Mission</span>
                    </div>
                </div>

                <!-- Mascot Speech Box -->
                <div class="card" style="min-width: 300px; max-width: 380px; background: var(--surface-container-low); padding: 1.25rem; display: flex; align-items: center; gap: 1rem; box-shadow: var(--shadow-tactile-sm);">
                    <div style="width: 4rem; height: 4rem; border-radius: var(--radius-sm); background: var(--surface-white); display: flex; align-items: center; justify-content: center; color: var(--primary-container); flex-shrink: 0; box-shadow: var(--shadow-tactile-xs);">
                        <span class="material-symbols-outlined animate-bounce" style="font-size: 38px;">smart_toy</span>
                    </div>
                    <div>
                        <span style="font-size: 0.88rem; font-weight: 800; color: var(--primary); display: block;">Halo Teman Penjelajah! 👋</span>
                        <p style="font-size: 0.82rem; color: var(--on-surface-variant); font-weight: 600; margin-top: 0.2rem;">
                            Aku <strong>Robot Kiko</strong>. Aku hanya bisa melangkah jika kamu memberi balok kode yang jelas. Ayo kita mulai petualangan pertamamu!
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Core Concept & Analogy -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.25rem; margin-bottom: 1.5rem;">
            <!-- Card 1: Analogy -->
            <div class="card">
                <div style="display: inline-flex; align-items: center; gap: 0.35rem; margin-bottom: 0.75rem;" class="badge-pill badge-yellow">
                    <span class="material-symbols-outlined" style="font-size: 16px;">psychology_alt</span>
                    <span>Konsep Dasar</span>
                </div>
                <h2 style="font-size: 1.35rem; color: var(--on-surface); margin-bottom: 0.65rem;">
                    Apa itu Coding &amp; Instruksi Robot?
                </h2>
                <p style="font-size: 0.92rem; color: var(--on-surface-variant); line-height: 1.55; margin-bottom: 1rem;">
                    Bayangkan kamu sedang memandu seorang teman yang matanya ditutup kain. Agar temanmu bisa sampai ke meja tanpa menabrak kursi, kamu harus memberikan instruksi yang sangat jelas:
                </p>
                <div style="display: flex; flex-direction: column; gap: 0.5rem; background: var(--surface-container-low); padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--card-stroke);">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="width: 1.35rem; height: 1.35rem; border-radius: 50%; background: var(--tertiary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 800;">1</span>
                        <span style="font-weight: 700; font-size: 0.85rem;">"Maju satu langkah ke depan!"</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="width: 1.35rem; height: 1.35rem; border-radius: 50%; background: var(--tertiary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 800;">2</span>
                        <span style="font-weight: 700; font-size: 0.85rem;">"Maju satu langkah lagi!"</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="width: 1.35rem; height: 1.35rem; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 800;">3</span>
                        <span style="font-weight: 700; font-size: 0.85rem;">"Hore, kamu sampai di meja!"</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Command Block Explained -->
            <div class="card">
                <div style="display: inline-flex; align-items: center; gap: 0.35rem; margin-bottom: 0.75rem;" class="badge-pill badge-mint">
                    <span class="material-symbols-outlined" style="font-size: 16px;">widgets</span>
                    <span>Blok Perintah Misi 1</span>
                </div>
                <h2 style="font-size: 1.35rem; color: var(--on-surface); margin-bottom: 0.65rem;">
                    Mengenal Perintah "MAJU"
                </h2>
                <p style="font-size: 0.92rem; color: var(--on-surface-variant); line-height: 1.55; margin-bottom: 1rem;">
                    Pada Misi 1, Robot Kiko berada di petak (X:1, Y:2) menghadap ke arah <strong>Timur (Kanan ➡️)</strong>. Target Bintang Emas berada di petak (X:4, Y:2).
                </p>

                <div class="card" style="background: var(--tertiary-fixed); border: 2px solid var(--mint-shade); padding: 0.75rem 1rem; display: flex; align-items: center; gap: 1rem; box-shadow: var(--shadow-tactile-sm);">
                    <div style="width: 2.5rem; height: 2.5rem; border-radius: var(--radius-sm); background: var(--tertiary); color: #fff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 22px;">arrow_upward</span>
                    </div>
                    <div>
                        <span style="font-size: 0.95rem; font-weight: 800; color: var(--tertiary); text-transform: uppercase;">⬆️ MAJU (1 Petak)</span>
                        <span style="font-size: 0.75rem; color: var(--tertiary); display: block; font-weight: 600;">Menggerakkan robot 1 kotak ke depan sesuai arah hadap saat ini.</span>
                    </div>
                </div>

                <div style="margin-top: 1rem; padding: 0.65rem 0.85rem; background: var(--surface-container-low); border-radius: var(--radius-sm); font-size: 0.82rem; font-weight: 700; color: var(--primary);">
                    💡 Rahasia Misi 1: Karena jarak kotak dari 1 ke 4 adalah 3 langkah lurus, susun <strong>3 balok MAJU</strong> berturut-turut!
                </div>
            </div>
        </div>

        <!-- Quick Interactive Quiz -->
        <div class="card mb-4" style="background: linear-gradient(135deg, rgba(253, 210, 89, 0.25) 0%, rgba(255, 255, 255, 1) 100%);">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                <span class="badge-pill badge-yellow">❓ Kuis Pemahaman Singkat</span>
                <span style="font-size: 0.8rem; font-weight: 700; color: var(--secondary);">Uji Pemahamanmu Sebelum Masuk Tantangan</span>
            </div>
            <h3 style="font-size: 1.15rem; margin-bottom: 0.75rem;">
                Jika Robot Kiko ingin melangkah maju sejauh 3 petak, berapa kali balok [MAJU] harus disusun?
            </h3>
            <div style="display: flex; flex-wrap: wrap; gap: 0.65rem;" id="quiz-options-1">
                <button class="btn btn-outline btn-sm" onclick="checkQuizAnswer(this, false, 'Kurang tepat! 1 balok hanya menggerakkan 1 petak.')">A. 1 kali</button>
                <button class="btn btn-outline btn-sm" onclick="checkQuizAnswer(this, true, 'Hebat sekali! Benar, 3 petak membutuhkan tepat 3 balok MAJU!')">B. 3 kali ✅</button>
                <button class="btn btn-outline btn-sm" onclick="checkQuizAnswer(this, false, 'Terlalu banyak! Nanti Kiko bisa kebablasan keluar arena.')">C. 5 kali</button>
            </div>
            <div id="quiz-feedback-1" style="margin-top: 0.75rem; font-size: 0.85rem; font-weight: 800; display: none;"></div>
        </div>

        <!-- Big CTA to Play Mission 1 -->
        <div style="text-align: center; margin-top: 2rem;">
            <a href="<?= $baseUrl ?>/tantangan.php?level=1" class="btn btn-run btn-lg" id="btn-start-mission-1">
                <span class="material-symbols-outlined" style="font-size: 26px;">play_arrow</span>
                <span>Mulai Tantangan Coding Misi 1 Sekarang! 🚀</span>
            </a>
        </div>
    </div>

    <?php else: ?>
    <!-- ═══════════════ MISI 2: SEQUENCE MASTER ═══════════════ -->
    <div id="lesson-content-2">
        <!-- Hero Section -->
        <section class="card mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #eaedff 100%); padding: 1.75rem; border-radius: var(--radius-lg);">
            <div style="display: flex; flex-direction: column; gap: 1.5rem;" class="lg:flex-row lg:items-center lg:justify-between">
                <div style="flex: 1;">
                    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                        <span class="badge-pill badge-yellow">LEVEL 2 • TANTANGAN BERKELOK</span>
                        <span class="badge-pill badge-mint">⏱️ Estimasi: 7 Menit Belajar</span>
                    </div>

                    <h1 style="font-size: 2rem; color: var(--on-surface); margin-bottom: 0.5rem;">
                        Misi 2: Sequence Master — <span style="color: var(--primary);">Urutan Logika &amp; Belokan 90°</span>
                    </h1>

                    <!-- Learning Objective Callout -->
                    <div class="card" style="background: var(--canvas-bg); padding: 0.85rem 1rem; border-radius: var(--radius-md); display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 1rem; box-shadow: var(--shadow-tactile-xs);">
                        <span class="material-symbols-outlined text-coral" style="font-size: 24px;">flag_circle</span>
                        <p style="font-size: 0.92rem; color: var(--on-surface); font-weight: 600;">
                            <strong style="color: var(--on-surface);">Tujuan Belajar:</strong> Memahami bahwa komputer mengeksekusi instruksi secara <em>sekuensial</em> (berurutan dari atas ke bawah). Jika salah satu urutan keliru, robot bisa menabrak rintangan!
                        </p>
                    </div>

                    <!-- Reward Summary -->
                    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 0.8rem; font-weight: 800; color: var(--on-surface-variant);">Hadiah Kelulusan:</span>
                        <span class="badge-pill badge-yellow"><span class="material-symbols-outlined" style="font-size: 15px;">bolt</span> +80 XP</span>
                        <span class="badge-pill badge-blue"><span class="material-symbols-outlined" style="font-size: 15px;">diamond</span> +25 Permata</span>
                        <span class="badge-pill badge-mint"><span class="material-symbols-outlined" style="font-size: 15px;">military_tech</span> Lencana Sequence Master</span>
                    </div>
                </div>

                <!-- Mascot Speech Box -->
                <div class="card" style="min-width: 300px; max-width: 380px; background: var(--surface-container-low); padding: 1.25rem; display: flex; align-items: center; gap: 1rem; box-shadow: var(--shadow-tactile-sm);">
                    <div style="width: 4rem; height: 4rem; border-radius: var(--radius-sm); background: var(--surface-white); display: flex; align-items: center; justify-content: center; color: var(--primary-container); flex-shrink: 0; box-shadow: var(--shadow-tactile-xs);">
                        <span class="material-symbols-outlined animate-bounce" style="font-size: 38px;">smart_toy</span>
                    </div>
                    <div>
                        <span style="font-size: 0.88rem; font-weight: 800; color: var(--primary); display: block;">Awas Rintangan! ⚠️</span>
                        <p style="font-size: 0.82rem; color: var(--on-surface-variant); font-weight: 600; margin-top: 0.2rem;">
                            Di Misi 2, jalur lurus dihadang oleh <strong>Batu Karang Besar</strong>! Kita harus memutar arah robot dan mengambil rute berliku di baris atas!
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Command Blocks in Mission 2 -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.25rem; margin-bottom: 1.5rem;">
            <!-- Block 1: Forward -->
            <div class="card" style="border-top: 4px solid var(--tertiary);">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                    <div style="width: 2.25rem; height: 2.25rem; border-radius: var(--radius-sm); background: var(--tertiary); color: #fff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_upward</span>
                    </div>
                    <h3 style="font-size: 1.1rem;">1. Perintah MAJU</h3>
                </div>
                <p style="font-size: 0.85rem; color: var(--on-surface-variant); line-height: 1.45;">
                    Melangkahkan robot 1 kotak ke depan sesuai arah hadap kompas saat itu (Timur, Selatan, Barat, atau Utara).
                </p>
            </div>

            <!-- Block 2: Turn Left -->
            <div class="card" style="border-top: 4px solid var(--coral-shade);">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                    <div style="width: 2.25rem; height: 2.25rem; border-radius: var(--radius-sm); background: var(--coral-shade); color: #fff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 18px;">rotate_left</span>
                    </div>
                    <h3 style="font-size: 1.1rem;">2. Perintah BELOK KIRI</h3>
                </div>
                <p style="font-size: 0.85rem; color: var(--on-surface-variant); line-height: 1.45;">
                    Memutar arah robot <strong>90° berlawanan arah jarum jam</strong> tanpa berpindah petak. Misalnya dari menghadap Timur berputar menjadi menghadap Utara!
                </p>
            </div>

            <!-- Block 3: Turn Right -->
            <div class="card" style="border-top: 4px solid var(--yellow-shade);">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                    <div style="width: 2.25rem; height: 2.25rem; border-radius: var(--radius-sm); background: var(--secondary); color: #fff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 18px;">rotate_right</span>
                    </div>
                    <h3 style="font-size: 1.1rem;">3. Perintah BELOK KANAN</h3>
                </div>
                <p style="font-size: 0.85rem; color: var(--on-surface-variant); line-height: 1.45;">
                    Memutar arah robot <strong>90° searah jarum jam</strong> tanpa berpindah petak. Misalnya dari menghadap Utara berputar kembali menghadap Timur!
                </p>
            </div>
        </div>

        <!-- Sequence Logic Diagram -->
        <div class="card mb-4">
            <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem;">
                Strategi Sukses Misi 2 (Menghindari Batu Karang) 🗺️
            </h3>
            <p style="font-size: 0.88rem; color: var(--on-surface-variant); margin-bottom: 1rem;">
                Robot mulai di (1, 3). Jika langsung MAJU, robot akan menabrak batu karang di (2, 3). Ikuti langkah cerdas ini:
            </p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.75rem;">
                <div style="background: var(--surface-container-low); padding: 0.75rem; border-radius: var(--radius-sm); border-left: 3px solid var(--primary);">
                    <strong style="color: var(--primary); display: block; font-size: 0.8rem;">Langkah 1:</strong>
                    <span style="font-size: 0.82rem;">BELOK KIRI (Hadap ke Utara)</span>
                </div>
                <div style="background: var(--surface-container-low); padding: 0.75rem; border-radius: var(--radius-sm); border-left: 3px solid var(--tertiary);">
                    <strong style="color: var(--tertiary); display: block; font-size: 0.8rem;">Langkah 2:</strong>
                    <span style="font-size: 0.82rem;">MAJU 2 kali (Naik ke baris Y: 1)</span>
                </div>
                <div style="background: var(--surface-container-low); padding: 0.75rem; border-radius: var(--radius-sm); border-left: 3px solid var(--secondary);">
                    <strong style="color: var(--secondary); display: block; font-size: 0.8rem;">Langkah 3:</strong>
                    <span style="font-size: 0.82rem;">BELOK KANAN (Hadap ke Timur)</span>
                </div>
                <div style="background: var(--surface-container-low); padding: 0.75rem; border-radius: var(--radius-sm); border-left: 3px solid var(--tertiary);">
                    <strong style="color: var(--tertiary); display: block; font-size: 0.8rem;">Langkah 4:</strong>
                    <span style="font-size: 0.82rem;">MAJU 3 kali (Petik Bintang di 4, 1) ⭐</span>
                </div>
            </div>
        </div>

        <!-- Big CTA to Play Mission 2 -->
        <div style="text-align: center; margin-top: 2rem;">
            <a href="<?= $baseUrl ?>/tantangan.php?level=2" class="btn btn-run btn-lg" id="btn-start-mission-2">
                <span class="material-symbols-outlined" style="font-size: 26px;">play_arrow</span>
                <span>Mulai Tantangan Coding Misi 2 Sekarang! 🚀</span>
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
function checkQuizAnswer(btn, isCorrect, feedbackMsg) {
    const feedbackEl = document.getElementById('quiz-feedback-1');
    if (!feedbackEl) return;
    feedbackEl.style.display = 'block';
    if (isCorrect) {
        feedbackEl.style.color = 'var(--mint-shade)';
        feedbackEl.textContent = '🎉 ' + feedbackMsg;
        if (typeof playSuccessSound === 'function') playSuccessSound();
    } else {
        feedbackEl.style.color = 'var(--coral-shade)';
        feedbackEl.textContent = '❌ ' + feedbackMsg;
        if (typeof playErrorSound === 'function') playErrorSound();
    }
}

function readLessonNarration() {
    const activeLevel = <?= $activeLevelId ?>;
    let text = "";
    if (activeLevel === 1) {
        text = "Misi satu: Coding Explorer. Coding adalah kumpulan instruksi sederhana yang kamu berikan ke robot agar melangkah petak demi petak menuju bintang emas. Pada misi ini, kamu cukup menekan tombol hijau MAJU sebanyak 3 kali!";
    } else {
        text = "Misi dua: Sequence Master. Program komputer membaca perintah secara berurutan. Awas ada batu karang di depanmu! Putar arah robot dengan belok kiri, lalu maju ke atas, belok kanan, dan melangkah lurus menuju target bintang!";
    }
    speakText(text);
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
