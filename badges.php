<?php
/**
 * CodeQuest Kids — Koleksi Lencana (Badges)
 * Mengacu pada PRD Section 19 (Badge System)
 */

require_once __DIR__ . '/includes/functions.php';
requireLogin();

$pageTitle  = 'Koleksi Lencana Coder';
$activePage = 'badges';

$user       = getCurrentUser();
$stats      = getUserStats($user['id']);
$allBadges  = getAllBadges();
$userBadges = getUserBadges($user['id']);

$earnedBadgeIds = array_column($userBadges, 'id');
$earnedDates    = array_column($userBadges, 'earned_at', 'id');

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-container px-gutter py-4">
    <!-- Header -->
    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.5rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                <span class="badge-pill badge-yellow">Ruang Penghargaan</span>
                <span class="badge-pill badge-blue"><?= count($userBadges) ?> / <?= count($allBadges) ?> Terkumpul</span>
            </div>
            <h1 style="font-size: 2rem; color: var(--on-surface);">Piala &amp; Koleksi Lencana 🏆</h1>
        </div>
        <a href="<?= $baseUrl ?>/dashboard.php" class="btn btn-outline btn-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>

    <!-- Hero Card -->
    <div class="card mb-4" style="background: linear-gradient(135deg, rgba(253, 210, 89, 0.2) 0%, rgba(220, 225, 255, 0.4) 100%); padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem;">
        <div style="width: 4.5rem; height: 4.5rem; border-radius: 50%; background: var(--secondary-container); display: flex; align-items: center; justify-content: center; color: var(--secondary); flex-shrink: 0; box-shadow: var(--shadow-yellow-btn);" class="animate-bounce">
            <span class="material-symbols-outlined" style="font-size: 40px;">workspace_premium</span>
        </div>
        <div>
            <h2 style="font-size: 1.35rem; color: var(--on-surface); margin-bottom: 0.25rem;">Buktikan Kehebatan Logikamu!</h2>
            <p style="font-size: 0.88rem; color: var(--on-surface-variant); line-height: 1.45;">
                Selesaikan misi coding, taklukkan rintangan, dan dapatkan lencana penghargaan istimewa dari Telkomsel M-ONE 2026!
            </p>
        </div>
    </div>

    <!-- 5 Badges Showcase Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem;">
        <?php foreach ($allBadges as $b): ?>
        <?php
            $isEarned = in_array((int) $b['id'], $earnedBadgeIds, true);
            $earnedAt = $earnedDates[$b['id']] ?? null;

            $badgeIcons = [
                1 => ['icon' => 'hotel_class', 'bg' => 'var(--secondary-fixed)', 'color' => 'var(--secondary)'],
                2 => ['icon' => 'extension', 'bg' => 'var(--tertiary-fixed)', 'color' => 'var(--tertiary)'],
                3 => ['icon' => 'autorenew', 'bg' => 'var(--primary-fixed)', 'color' => 'var(--primary)'],
                4 => ['icon' => 'local_fire_department', 'bg' => 'rgba(255, 139, 117, 0.3)', 'color' => 'var(--coral-shade)'],
                5 => ['icon' => 'emoji_events', 'bg' => 'var(--secondary-container)', 'color' => 'var(--secondary)'],
            ];
            $iconSpec = $badgeIcons[$b['id']] ?? ['icon' => 'military_tech', 'bg' => 'var(--surface-container-high)', 'color' => 'var(--primary)'];
        ?>
        <div class="card card-hover" style="display: flex; flex-direction: column; justify-content: space-between; text-align: center; padding: 1.75rem 1.25rem; border-radius: var(--radius-lg); <?= !$isEarned ? 'background: #fbfbfd; opacity: 0.75;' : 'border-color: var(--yellow-shade);' ?>">
            <div>
                <!-- Badge Emblem -->
                <div style="width: 5rem; height: 5rem; border-radius: 50%; background: <?= $isEarned ? $iconSpec['bg'] : 'var(--locked-gray)' ?>; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: <?= $isEarned ? $iconSpec['color'] : 'var(--locked-text)' ?>; box-shadow: <?= $isEarned ? 'var(--shadow-tactile-md)' : 'none' ?>;">
                    <span class="material-symbols-outlined" style="font-size: 44px; font-variation-settings: 'FILL' <?= $isEarned ? 1 : 0 ?>;">
                        <?= $isEarned ? $iconSpec['icon'] : 'lock' ?>
                    </span>
                </div>

                <span class="badge-pill <?= $isEarned ? 'badge-mint' : 'badge-locked' ?>" style="font-size: 0.7rem; margin-bottom: 0.5rem;">
                    <?= $isEarned ? 'DIRAIH ✅' : 'TERKUNCI 🔒' ?>
                </span>

                <h3 style="font-size: 1.2rem; color: var(--on-surface); margin-bottom: 0.35rem;">
                    <?= e($b['name']) ?>
                </h3>

                <p style="font-size: 0.85rem; color: var(--on-surface-variant); line-height: 1.45; margin-bottom: 0.75rem;">
                    <?= e($b['description']) ?>
                </p>
            </div>

            <div style="border-top: 1px solid var(--card-stroke); padding-top: 0.75rem;">
                <span style="font-size: 0.72rem; color: var(--locked-text); display: block; font-weight: 700;">
                    <?php if ($isEarned && $earnedAt): ?>
                        Diraih pada: <?= date('d M Y, H:i', strtotime($earnedAt)) ?>
                    <?php else: ?>
                        Syarat: <?= e($b['requirement']) ?>
                    <?php endif; ?>
                </span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
