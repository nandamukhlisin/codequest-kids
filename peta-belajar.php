<?php
/**
 * CodeQuest Kids — Peta Belajar (6 Level Petualangan)
 * Mengacu pada PRD Section 12 & Design/peta_belajar_petualangan_coding_6_level
 */

require_once __DIR__ . '/includes/functions.php';
requireLogin();

$pageTitle  = 'Peta Belajar 6 Level';
$activePage = 'peta';

$user     = getCurrentUser();
$stats    = getUserStats($user['id']);
$progress = getUserProgress($user['id']);

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-container px-gutter py-4">
    <!-- Sub-navigation & Header Bar -->
    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.5rem;">
        <a href="<?= $baseUrl ?>/dashboard.php" class="btn btn-outline btn-sm">
            <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
            <span>Kembali ke Dashboard 🏠</span>
        </a>

        <!-- Status Legend -->
        <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem; background: var(--surface-container-low); padding: 0.4rem 1rem; border-radius: var(--radius-full); border: 1px solid var(--card-stroke); font-size: 0.8rem; font-weight: 700;">
            <span class="text-muted">Status:</span>
            <div style="display: flex; align-items: center; gap: 4px;">
                <span style="width: 10px; height: 10px; border-radius: 50%; background: var(--mint-shade);"></span>
                <span style="color: var(--tertiary);">Selesai</span>
            </div>
            <span style="color: var(--card-stroke);">|</span>
            <div style="display: flex; align-items: center; gap: 4px;">
                <span style="width: 10px; height: 10px; border-radius: 50%; background: var(--primary-container);" class="animate-pulse"></span>
                <span style="color: var(--primary);">Tersedia</span>
            </div>
            <span style="color: var(--card-stroke);">|</span>
            <div style="display: flex; align-items: center; gap: 4px;">
                <span style="width: 10px; height: 10px; border-radius: 50%; background: var(--locked-gray);"></span>
                <span style="color: var(--locked-text);">Terkunci</span>
            </div>
        </div>
    </div>

    <!-- Main Title & Overall Progress Hero Block -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f2f3ff 100%); padding: 1.75rem; border-radius: var(--radius-lg);">
        <div style="display: flex; flex-direction: column; gap: 1.5rem;" class="lg:flex-row lg:items-center lg:justify-between">
            <div style="max-width: 650px;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <span class="badge-pill badge-blue">Pulau Algoritma Telkomsel</span>
                    <span class="badge-pill badge-yellow">M-ONE 2026</span>
                </div>
                <h1 style="font-size: 2rem; color: var(--on-surface); margin-bottom: 0.35rem;">
                    Peta Petualangan Belajar Coding 🗺️
                </h1>
                <p style="font-size: 1rem; color: var(--on-surface-variant); font-weight: 600;">
                    Jelajahi pulau computational thinking, selesaikan misi satu per satu untuk membuka kekuatan coder cilik masa depan!
                </p>
            </div>

            <!-- Global Progression Card -->
            <div class="card" style="min-width: 280px; padding: 1rem 1.25rem; background: var(--surface-container-low); box-shadow: var(--shadow-tactile-xs);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; font-size: 0.85rem; font-weight: 800;">
                    <span>Progres Pulau</span>
                    <span style="color: var(--primary-shade);"><?= $stats['completed'] ?> dari <?= $stats['total_levels'] ?> Misi (<?= $stats['progress_pct'] ?>%)</span>
                </div>
                <div style="width: 100%; height: 1rem; background: var(--surface-container-high); border-radius: var(--radius-full); padding: 2px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.06); margin-bottom: 0.65rem; overflow: hidden;">
                    <div style="height: 100%; border-radius: var(--radius-full); background: linear-gradient(90deg, var(--primary-shade), var(--mint-shade)); width: <?= max(5, $stats['progress_pct']) ?>%; transition: width 0.8s ease;"></div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span class="stat-pill stat-xp">
                        <span class="material-symbols-outlined">bolt</span> <?= number_format($stats['xp']) ?> XP
                    </span>
                    <span class="stat-pill stat-xp">
                        <span class="material-symbols-outlined" style="color: var(--yellow-shade);">star</span> 12 Bintang
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Robot Kiko Mascot Banner -->
    <div class="card mb-4" style="background: linear-gradient(90deg, rgba(220, 225, 255, 0.6) 0%, rgba(234, 237, 255, 0.7) 100%); padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 1.25rem;">
        <div style="width: 4rem; height: 4rem; border-radius: 50%; background: var(--primary-container); display: flex; align-items: center; justify-content: center; color: #fff; flex-shrink: 0; box-shadow: 0 3px 0 var(--on-primary-fixed);">
            <span class="material-symbols-outlined animate-bounce" style="font-size: 38px;">smart_toy</span>
        </div>
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.2rem;">
                <span style="font-size: 1.05rem; font-weight: 800; color: var(--primary);">Robot Kiko Menemani:</span>
                <span class="badge-pill badge-mint" style="font-size: 0.72rem;">Pemandu Misi</span>
            </div>
            <p style="font-size: 0.92rem; color: var(--on-surface); font-weight: 600;">
                "Setiap level membawamu lebih dekat menjadi Master Coder! Misi 1 dan Misi 2 sudah dapat kamu mainkan secara penuh. Selesaikan tantangannya untuk membuka pulau berikutnya!"
            </p>
        </div>
    </div>

    <!-- 6-Level Adventure Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.25rem;">
        <?php foreach ($progress as $lvl): ?>
        <?php
            $isCompleted = ($lvl['status'] === 'completed');
            $isUnlocked  = ($lvl['status'] === 'unlocked' || $lvl['status'] === 'in_progress');
            $isLocked    = ($lvl['status'] === 'locked');

            $difficultyColors = [
                'easy'   => 'badge-mint',
                'medium' => 'badge-yellow',
                'hard'   => 'badge-coral',
            ];
            $diffBadge = $difficultyColors[$lvl['difficulty']] ?? 'badge-blue';
        ?>
        <div class="card card-hover" style="display: flex; flex-direction: column; justify-content: space-between; gap: 1rem; border-radius: var(--radius-md); <?= $isLocked ? 'background: #f8f9fc; opacity: 0.75;' : '' ?>">
            <!-- Card Header -->
            <div>
                <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 0.75rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 3.25rem; height: 3.25rem; border-radius: var(--radius-sm); background: <?= $isCompleted ? 'var(--tertiary-fixed)' : ($isUnlocked ? 'var(--primary-fixed)' : 'var(--surface-container-high)') ?>; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; box-shadow: var(--shadow-tactile-xs);">
                            <?= getLevelIcon($lvl['order_number']) ?>
                        </div>
                        <div>
                            <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: <?= $isCompleted ? 'var(--mint-shade)' : ($isUnlocked ? 'var(--primary)' : 'var(--locked-text)') ?>;">
                                MISI <?= sprintf('%02d', $lvl['order_number']) ?> • <?= $isCompleted ? 'SELESAI ✅' : ($isUnlocked ? 'TERSEDIA 🚀' : 'TERKUNCI 🔒') ?>
                            </span>
                            <h3 style="font-size: 1.25rem; color: var(--on-surface);"><?= e($lvl['level_title']) ?></h3>
                        </div>
                    </div>
                    <span class="badge-pill <?= $diffBadge ?>" style="font-size: 0.7rem;">
                        <?= strtoupper($lvl['difficulty']) ?>
                    </span>
                </div>

                <!-- Description & XP Reward -->
                <p style="font-size: 0.85rem; color: var(--on-surface-variant); line-height: 1.45; margin-bottom: 0.75rem;">
                    <?php if ($lvl['order_number'] == 1): ?>
                        Pelajari computational thinking dasar, instruksi arah, dan langkah maju pertama Robot Kiko di jalur hijau.
                    <?php elseif ($lvl['order_number'] == 2): ?>
                        Susun urutan perintah dan putaran 90° untuk memandu robot menghindari batu karang dan rawa air!
                    <?php elseif ($lvl['order_number'] == 3): ?>
                        Gunakan perintah REPEAT (Loop) untuk mengulang gerakan tanpa perlu menyusun blok satu per satu berkali-kali.
                    <?php elseif ($lvl['order_number'] == 4): ?>
                        Ambil keputusan cerdas dengan kondisi IF PATH BLOCKED untuk mendeteksi rintangan secara otomatis.
                    <?php elseif ($lvl['order_number'] == 5): ?>
                        Gunakan variabel sederhana untuk menghitung koin, permata, dan skor langkah robot.
                    <?php else: ?>
                        Gabungkan seluruh konsep sequence, loop, dan condition dalam proyek mini interaktif kreasi sendiri!
                    <?php endif; ?>
                </p>

                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span class="badge-pill badge-yellow" style="font-size: 0.75rem;">
                        <span class="material-symbols-outlined" style="font-size: 14px;">bolt</span> +<?= $lvl['xp_reward'] ?> XP Reward
                    </span>
                    <?php if ($isCompleted): ?>
                    <span class="badge-pill badge-mint" style="font-size: 0.75rem;">
                        <span class="material-symbols-outlined" style="font-size: 14px;">verified</span> 100% Selesai
                    </span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Actions Bar -->
            <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 0.75rem; border-top: 1px solid var(--card-stroke);">
                <a href="<?= $baseUrl ?>/materi.php?level=<?= $lvl['level_id'] ?>" style="font-size: 0.82rem; font-weight: 700; color: var(--primary); display: flex; align-items: center; gap: 3px;">
                    <span class="material-symbols-outlined" style="font-size: 18px;">menu_book</span> Pelajari Materi
                </a>

                <?php if ($isUnlocked || $isCompleted): ?>
                <a href="<?= $baseUrl ?>/tantangan.php?level=<?= $lvl['level_id'] ?>" class="btn <?= $isCompleted ? 'btn-outline' : 'btn-primary' ?> btn-sm">
                    <span class="material-symbols-outlined" style="font-size: 18px;"><?= $isCompleted ? 'replay' : 'play_arrow' ?></span>
                    <span><?= $isCompleted ? 'Mainkan Ulang' : 'Mulai Misi' ?></span>
                </a>
                <?php else: ?>
                <button class="btn btn-sm" disabled style="background: var(--locked-gray); color: var(--locked-text); cursor: not-allowed; box-shadow: none;">
                    <span class="material-symbols-outlined" style="font-size: 16px;">lock</span>
                    <span>Level Terkunci</span>
                </button>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
