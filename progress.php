<?php
/**
 * CodeQuest Kids — Progress Belajar Siswa
 * Mengacu pada PRD Section 20 (Progress System)
 */

require_once __DIR__ . '/includes/functions.php';
requireLogin();

$pageTitle  = 'Progress Belajar Siswa';
$activePage = 'progress';

$user     = getCurrentUser();
$stats    = getUserStats($user['id']);
$progress = getUserProgress($user['id']);
$badges   = getUserBadges($user['id']);

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-container px-gutter py-4">
    <!-- Header -->
    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.5rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                <span class="badge-pill badge-blue">Statistik Coder Cilik</span>
                <span class="badge-pill badge-mint">Real-time Data</span>
            </div>
            <h1 style="font-size: 2rem; color: var(--on-surface);">Progress Petualangan <?= e($user['name']) ?> 📈</h1>
        </div>
        <a href="<?= $baseUrl ?>/peta-belajar.php" class="btn btn-primary btn-sm">
            <span class="material-symbols-outlined">map</span>
            <span>Buka Peta Belajar</span>
        </a>
    </div>

    <!-- Quick Stats Metric Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        <div class="card" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3.25rem; height: 3.25rem; border-radius: var(--radius-sm); background: var(--secondary-fixed); display: flex; align-items: center; justify-content: center; color: var(--secondary); box-shadow: var(--shadow-yellow-btn);">
                <span class="material-symbols-outlined" style="font-size: 28px;">bolt</span>
            </div>
            <div>
                <span class="text-muted" style="font-size: 0.75rem; font-weight: 700; display: block;">Total XP Terkumpul</span>
                <span style="font-size: 1.5rem; font-weight: 800; color: var(--on-surface);"><?= number_format($stats['xp']) ?> XP</span>
            </div>
        </div>

        <div class="card" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3.25rem; height: 3.25rem; border-radius: var(--radius-sm); background: var(--primary-fixed); display: flex; align-items: center; justify-content: center; color: var(--primary); box-shadow: var(--shadow-primary-btn);">
                <span class="material-symbols-outlined" style="font-size: 28px;">military_tech</span>
            </div>
            <div>
                <span class="text-muted" style="font-size: 0.75rem; font-weight: 700; display: block;">Pangkat Coder</span>
                <span style="font-size: 1.25rem; font-weight: 800; color: var(--on-surface);"><?= e($stats['level_title']) ?></span>
            </div>
        </div>

        <div class="card" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3.25rem; height: 3.25rem; border-radius: var(--radius-sm); background: var(--tertiary-fixed); display: flex; align-items: center; justify-content: center; color: var(--tertiary); box-shadow: var(--shadow-run-btn);">
                <span class="material-symbols-outlined" style="font-size: 28px;">verified</span>
            </div>
            <div>
                <span class="text-muted" style="font-size: 0.75rem; font-weight: 700; display: block;">Misi Selesai</span>
                <span style="font-size: 1.5rem; font-weight: 800; color: var(--on-surface);"><?= $stats['completed'] ?> / <?= $stats['total_levels'] ?> Misi</span>
            </div>
        </div>

        <div class="card" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 3.25rem; height: 3.25rem; border-radius: var(--radius-sm); background: rgba(167, 139, 250, 0.25); display: flex; align-items: center; justify-content: center; color: var(--purple-shade); box-shadow: var(--shadow-tactile-sm);">
                <span class="material-symbols-outlined" style="font-size: 28px;">emoji_events</span>
            </div>
            <div>
                <span class="text-muted" style="font-size: 0.75rem; font-weight: 700; display: block;">Lencana Diraih</span>
                <span style="font-size: 1.5rem; font-weight: 800; color: var(--on-surface);"><?= $stats['badges_earned'] ?> / 5 Lencana</span>
            </div>
        </div>
    </div>

    <!-- Overall Completion Bar -->
    <div class="card mb-4" style="padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
            <div>
                <h3 style="font-size: 1.15rem;">Kelulusan Jalur Petualangan</h3>
                <span style="font-size: 0.8rem; color: var(--on-surface-variant);">Menuju Sertifikat Kelulusan Coding Cilik Telkomsel M-ONE</span>
            </div>
            <span class="badge-pill badge-mint" style="font-size: 0.9rem;"><?= $stats['progress_pct'] ?>% Selesai</span>
        </div>
        <div style="width: 100%; height: 1.5rem; background: var(--surface-container-high); border-radius: var(--radius-full); padding: 3px; overflow: hidden; box-shadow: inset 0 2px 4px rgba(0,0,0,0.06);">
            <div style="height: 100%; border-radius: var(--radius-full); background: linear-gradient(90deg, var(--primary-shade), var(--mint-shade)); width: <?= max(5, $stats['progress_pct']) ?>%; transition: width 0.8s ease;"></div>
        </div>
    </div>

    <!-- Detailed Level-by-Level Status Table -->
    <div class="card" style="padding: 1.5rem;">
        <h3 style="font-size: 1.25rem; margin-bottom: 1rem;">Detail Status Setiap Misi</h3>

        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <?php foreach ($progress as $p): ?>
            <?php
                $isDone = ($p['status'] === 'completed');
                $isOpen = ($p['status'] === 'unlocked' || $p['status'] === 'in_progress');
            ?>
            <div class="card" style="padding: 1rem; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; background: <?= $isDone ? 'rgba(143, 246, 207, 0.15)' : ($isOpen ? 'rgba(220, 225, 255, 0.25)' : '#fafafa') ?>; border-color: <?= $isDone ? 'var(--mint-shade)' : ($isOpen ? 'var(--primary-fixed)' : 'var(--card-stroke)') ?>;">
                <div style="display: flex; align-items: center; gap: 0.85rem;">
                    <div style="font-size: 2rem;"><?= getLevelIcon($p['order_number']) ?></div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: var(--on-surface-variant);">
                                Misi 0<?= $p['order_number'] ?>
                            </span>
                            <span class="badge-pill <?= $isDone ? 'badge-mint' : ($isOpen ? 'badge-blue' : 'badge-locked') ?>" style="font-size: 0.68rem;">
                                <?= strtoupper($p['status']) ?>
                            </span>
                        </div>
                        <h4 style="font-size: 1.05rem; color: var(--on-surface);"><?= e($p['level_title']) ?></h4>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                    <span class="badge-pill badge-yellow">
                        <span class="material-symbols-outlined" style="font-size: 15px;">bolt</span> +<?= $p['xp_reward'] ?> XP
                    </span>
                    <?php if ($isDone): ?>
                    <span style="font-size: 0.78rem; color: var(--tertiary); font-weight: 800; display: flex; align-items: center; gap: 3px;">
                        <span class="material-symbols-outlined" style="font-size: 16px;">check_circle</span> Selesai
                    </span>
                    <a href="<?= $baseUrl ?>/tantangan.php?level=<?= $p['level_id'] ?>" class="btn btn-outline btn-sm">Main Ulang 🔄</a>
                    <?php elseif ($isOpen): ?>
                    <a href="<?= $baseUrl ?>/tantangan.php?level=<?= $p['level_id'] ?>" class="btn btn-primary btn-sm">Mulai Misi ▶</a>
                    <?php else: ?>
                    <span style="font-size: 0.78rem; color: var(--locked-text); font-weight: 700;">Terkunci 🔒</span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
