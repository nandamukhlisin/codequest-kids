<?php
/**
 * CodeQuest Kids — Dashboard Siswa
 * Mengacu pada PRD Section 11 & Design/dashboard_siswa_petualangan_coding_raka
 */

require_once __DIR__ . '/includes/functions.php';
requireLogin();

$pageTitle  = 'Dashboard Siswa';
$activePage = 'dashboard';

$user     = getCurrentUser();
$stats    = getUserStats($user['id']);
$progress = getUserProgress($user['id']);
$badges   = getUserBadges($user['id']);

// Tentukan misi berikutnya yang aktif/belum selesai
$currentLevel = null;
foreach ($progress as $p) {
    if ($p['status'] === 'unlocked' || $p['status'] === 'in_progress') {
        $currentLevel = $p;
        break;
    }
}
if (!$currentLevel) {
    // Jika semua selesai atau belum ada, ambil level 1
    $currentLevel = $progress[0] ?? null;
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-container px-gutter py-4">
    <!-- 1. Hero Banner Siswa & Aksi Utama -->
    <section class="card mb-4" style="background: linear-gradient(135deg, #f2f3ff 0%, #eaedff 100%); border-radius: var(--radius-lg); padding: 1.75rem; border: 1px solid var(--card-stroke); box-shadow: var(--shadow-tactile-md);">
        <div style="display: flex; flex-direction: column; gap: 1.5rem;" class="lg:flex-row lg:items-center lg:justify-between">
            <!-- Left: Greetings & Mascot Speech -->
            <div style="flex: 1; display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem;">
                    <span class="badge-pill badge-blue" style="font-size: 0.8rem; box-shadow: var(--shadow-tactile-xs);">
                        <span class="material-symbols-outlined" style="font-size: 16px;">military_tech</span>
                        <?= e($stats['level_title']) ?> (Level <?= $stats['level'] ?>)
                    </span>
                    <span class="badge-pill badge-yellow" style="font-size: 0.8rem; box-shadow: var(--shadow-tactile-xs);">
                        <span class="material-symbols-outlined" style="font-size: 16px; color: var(--yellow-shade);">local_fire_department</span>
                        3 Hari Beruntun 🔥
                    </span>
                </div>

                <div>
                    <h1 style="font-size: 2.2rem; color: var(--on-surface); letter-spacing: -0.02em;">
                        Halo, <?= e($user['name']) ?>! 👋
                    </h1>
                    <p style="font-size: 1.15rem; color: var(--primary-shade); font-weight: 700; margin-top: 0.2rem;">
                        Siap Lanjut Bertualang Menaklukkan Logika Hari Ini?
                    </p>
                </div>

                <!-- Mascot Speech Balloon -->
                <div class="mascot-speech-card" style="max-width: 600px;">
                    <div class="mascot-speech-icon">
                        <span class="material-symbols-outlined">smart_toy</span>
                    </div>
                    <div>
                        <span style="font-size: 0.85rem; color: var(--primary-shade); font-weight: 800;">Robot Kiko Berkata:</span>
                        <p style="font-size: 0.95rem; color: var(--on-surface-variant); font-weight: 600; margin-top: 0.25rem;">
                            "Ayo lanjutkan perjalanan kita! Setiap blok perintah yang kamu susun membantuku melewati rintangan dan memetik bintang emas!"
                        </p>
                    </div>
                </div>

                <!-- Quick Stats Row -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 0.65rem; max-width: 600px;">
                    <div class="card" style="padding: 0.65rem 0.85rem; display: flex; align-items: center; gap: 0.65rem; box-shadow: var(--shadow-tactile-xs);">
                        <span class="material-symbols-outlined text-yellow" style="font-size: 26px;">bolt</span>
                        <div>
                            <span class="text-locked" style="font-size: 0.7rem; display: block; font-weight: 700;">Total XP</span>
                            <span style="font-size: 1.15rem; font-weight: 800; color: var(--on-surface);"><?= number_format($stats['xp']) ?></span>
                        </div>
                    </div>
                    <div class="card" style="padding: 0.65rem 0.85rem; display: flex; align-items: center; gap: 0.65rem; box-shadow: var(--shadow-tactile-xs);">
                        <span class="material-symbols-outlined text-yellow" style="font-size: 26px;">star</span>
                        <div>
                            <span class="text-locked" style="font-size: 0.7rem; display: block; font-weight: 700;">Bintang</span>
                            <span style="font-size: 1.15rem; font-weight: 800; color: var(--on-surface);">12 ⭐</span>
                        </div>
                    </div>
                    <div class="card" style="padding: 0.65rem 0.85rem; display: flex; align-items: center; gap: 0.65rem; box-shadow: var(--shadow-tactile-xs);">
                        <span class="material-symbols-outlined text-primary" style="font-size: 26px;">extension</span>
                        <div>
                            <span class="text-locked" style="font-size: 0.7rem; display: block; font-weight: 700;">Misi Lulus</span>
                            <span style="font-size: 1.15rem; font-weight: 800; color: var(--on-surface);"><?= $stats['completed'] ?> Misi</span>
                        </div>
                    </div>
                    <div class="card" style="padding: 0.65rem 0.85rem; display: flex; align-items: center; gap: 0.65rem; box-shadow: var(--shadow-tactile-xs);">
                        <span class="material-symbols-outlined" style="font-size: 26px; color: var(--soft-purple);">workspace_premium</span>
                        <div>
                            <span class="text-locked" style="font-size: 0.7rem; display: block; font-weight: 700;">Lencana</span>
                            <span style="font-size: 1.15rem; font-weight: 800; color: var(--on-surface);"><?= $stats['badges_earned'] ?> / 5</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Mascot Illustration & Primary CTA -->
            <div style="min-width: 320px; display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                <div style="width: 100%; height: 180px; background: var(--surface-container); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; box-shadow: var(--shadow-tactile-md); border: 2px solid var(--card-stroke);">
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 0.5rem;">
                        <span class="material-symbols-outlined animate-bounce" style="font-size: 64px; color: var(--primary-container);">smart_toy</span>
                        <span style="font-weight: 800; font-size: 0.95rem; color: var(--primary);">Robot Kiko Siap Bergerak!</span>
                    </div>
                    <div style="position: absolute; bottom: 8px; right: 8px; background: rgba(255,255,255,0.9); padding: 4px 10px; border-radius: var(--radius-full); display: flex; align-items: center; gap: 4px; box-shadow: var(--shadow-tactile-xs); font-size: 0.75rem; font-weight: 800;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: var(--mint-shade); display: inline-block;" class="animate-pulse"></span>
                        Status: Aktif
                    </div>
                </div>

                <!-- Primary Tactile 3D Action Button -->
                <?php if ($currentLevel): ?>
                <a href="<?= $baseUrl ?>/tantangan.php?level=<?= $currentLevel['level_id'] ?>" class="btn btn-run btn-lg" style="width: 100%;" id="cta-lanjut-misi">
                    <span class="material-symbols-outlined" style="font-size: 26px;">play_arrow</span>
                    <span>LANJUTKAN: Misi <?= $currentLevel['order_number'] ?> (<?= e($currentLevel['level_title']) ?>)</span>
                </a>
                <span style="font-size: 0.78rem; color: var(--on-surface-variant); font-weight: 700; display: flex; align-items: center; gap: 4px;">
                    <span class="material-symbols-outlined text-mint" style="font-size: 16px;">check_circle</span>
                    Selesaikan misi untuk unlock level berikutnya!
                </span>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- 2. Ringkasan Progress Belajar -->
    <section class="card mb-4">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
            <div>
                <span style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: var(--primary); letter-spacing: 0.05em;">Kurikulum Computational Thinking</span>
                <h2 style="font-size: 1.45rem; color: var(--on-surface);">Progres Jalur Belajar Kamu</h2>
            </div>
            <div style="display: flex; align-items: center; gap: 0.65rem;">
                <span class="badge-pill badge-blue" style="font-size: 0.85rem;">
                    <?= $stats['progress_pct'] ?>% Selesai
                </span>
                <span style="font-size: 0.85rem; color: var(--on-surface-variant);">
                    (<?= $stats['completed'] ?> dari <?= $stats['total_levels'] ?> Misi Tuntas)
                </span>
            </div>
        </div>

        <!-- Thick Progress Bar -->
        <div style="width: 100%; height: 1.5rem; background: var(--surface-container-high); border-radius: var(--radius-full); padding: 3px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.06); position: relative; overflow: hidden; margin-bottom: 1.25rem;">
            <div style="height: 100%; border-radius: var(--radius-full); background: linear-gradient(90deg, var(--primary-shade), var(--mint-shade)); width: <?= max(5, $stats['progress_pct']) ?>%; transition: width 0.8s ease; display: flex; align-items: center; justify-content: flex-end; padding-right: 6px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #ffffff;" class="animate-ping"></span>
            </div>
        </div>

        <!-- 6 Levels Grid Preview -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1rem;">
            <?php foreach ($progress as $lvl): ?>
            <?php
                $isCompleted = ($lvl['status'] === 'completed');
                $isUnlocked  = ($lvl['status'] === 'unlocked' || $lvl['status'] === 'in_progress');
                $isLocked    = ($lvl['status'] === 'locked');
            ?>
            <div class="card card-hover" style="display: flex; flex-direction: column; justify-content: space-between; gap: 0.75rem; <?= $isLocked ? 'opacity: 0.7; background: #fafafa;' : '' ?>">
                <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 0.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.65rem;">
                        <span style="font-size: 1.75rem;"><?= getLevelIcon($lvl['order_number']) ?></span>
                        <div>
                            <span style="font-size: 0.7rem; font-weight: 800; color: <?= $isCompleted ? 'var(--mint-shade)' : ($isUnlocked ? 'var(--primary)' : 'var(--locked-text)') ?>;">
                                MISI 0<?= $lvl['order_number'] ?> • <?= strtoupper($lvl['status']) ?>
                            </span>
                            <h3 style="font-size: 1.05rem; color: var(--on-surface);"><?= e($lvl['level_title']) ?></h3>
                        </div>
                    </div>
                    <span class="badge-pill <?= $isCompleted ? 'badge-mint' : ($isUnlocked ? 'badge-yellow' : 'badge-locked') ?>" style="font-size: 0.7rem;">
                        +<?= $lvl['xp_reward'] ?> XP
                    </span>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 0.5rem; border-top: 1px solid var(--card-stroke);">
                    <a href="<?= $baseUrl ?>/materi.php?level=<?= $lvl['level_id'] ?>" style="font-size: 0.78rem; font-weight: 700; color: var(--primary-shade); display: flex; align-items: center; gap: 2px;">
                        <span class="material-symbols-outlined" style="font-size: 16px;">menu_book</span> Baca Materi
                    </a>
                    <?php if ($isUnlocked || $isCompleted): ?>
                    <a href="<?= $baseUrl ?>/tantangan.php?level=<?= $lvl['level_id'] ?>" class="btn <?= $isCompleted ? 'btn-outline' : 'btn-primary' ?> btn-sm">
                        <?= $isCompleted ? 'Main Ulang 🔄' : 'Mulai Main ▶' ?>
                    </a>
                    <?php else: ?>
                    <span style="font-size: 0.78rem; color: var(--locked-text); display: flex; align-items: center; gap: 2px; font-weight: 700;">
                        <span class="material-symbols-outlined" style="font-size: 16px;">lock</span> Terkunci
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 3. Bottom Links & Badges Teaser -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
        <div class="card" style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3rem; height: 3rem; border-radius: var(--radius-sm); background: var(--secondary-container); display: flex; align-items: center; justify-content: center; color: var(--secondary); flex-shrink: 0; box-shadow: var(--shadow-yellow-btn);">
                <span class="material-symbols-outlined" style="font-size: 28px;">map</span>
            </div>
            <div style="flex: 1;">
                <h4 style="font-size: 1rem;">Jelajahi Peta Belajar</h4>
                <p style="font-size: 0.8rem; color: var(--on-surface-variant);">Lihat rute 6 pulau petualangan coding dari awal hingga akhir!</p>
            </div>
            <a href="<?= $baseUrl ?>/peta-belajar.php" class="btn btn-outline btn-sm">Lihat Peta 🗺️</a>
        </div>

        <div class="card" style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3rem; height: 3rem; border-radius: var(--radius-sm); background: rgba(167, 139, 250, 0.25); display: flex; align-items: center; justify-content: center; color: var(--purple-shade); flex-shrink: 0; box-shadow: var(--shadow-tactile-sm);">
                <span class="material-symbols-outlined" style="font-size: 28px;">emoji_events</span>
            </div>
            <div style="flex: 1;">
                <h4 style="font-size: 1rem;">Koleksi Lencana</h4>
                <p style="font-size: 0.8rem; color: var(--on-surface-variant);"><?= $stats['badges_earned'] ?> lencana telah diraih dari total 5 lencana!</p>
            </div>
            <a href="<?= $baseUrl ?>/badges.php" class="btn btn-outline btn-sm">Lihat Badge 🏆</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
