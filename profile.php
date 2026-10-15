<?php
/**
 * CodeQuest Kids — Profil Siswa & Manajemen Akun
 */

require_once __DIR__ . '/includes/functions.php';
requireLogin();

$pageTitle  = 'Profil Siswa';
$activePage = 'profile';

$user  = getCurrentUser();
$stats = getUserStats($user['id']);

$message = '';
if (isset($_GET['reset_done'])) {
    $message = 'Progress petualangan berhasil direset!';
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logoutUser();
    header('Location: ' . getBaseUrl() . '/index.php');
    exit;
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-container px-gutter py-4">
    <div style="max-width: 640px; margin: 0 auto;">
        <!-- Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.75rem; color: var(--on-surface);">Profil Penjelajah Cilik 👤</h1>
            <a href="<?= $baseUrl ?>/dashboard.php" class="btn btn-outline btn-sm">
                <span class="material-symbols-outlined">arrow_back</span>
                <span>Dashboard</span>
            </a>
        </div>

        <?php if (!empty($message)): ?>
        <div class="card mb-3" style="background: var(--tertiary-fixed); border: 1px solid var(--mint-shade); color: var(--tertiary); padding: 0.75rem 1rem; font-weight: 700;">
            ✅ <?= e($message) ?>
        </div>
        <?php endif; ?>

        <!-- Student Profile Card -->
        <div class="card mb-4" style="text-align: center; padding: 2rem 1.5rem;">
            <div style="width: 5.5rem; height: 5.5rem; border-radius: 50%; background: var(--primary-container); color: #fff; font-size: 2.25rem; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: 0 4px 0 var(--on-primary-fixed);">
                <?= mb_substr($user['name'], 0, 1) ?>
            </div>

            <h2 style="font-size: 1.5rem; margin-bottom: 0.25rem;"><?= e($user['name']) ?></h2>
            <div style="display: flex; justify-content: center; gap: 0.5rem; margin-bottom: 1.25rem;">
                <span class="badge-pill badge-blue"><?= e($stats['level_title']) ?> (Level <?= $stats['level'] ?>)</span>
                <span class="badge-pill badge-mint">SD Kelas 4</span>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; background: var(--surface-container-low); padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
                <div>
                    <span class="text-muted" style="font-size: 0.75rem; font-weight: 700; display: block;">Total XP</span>
                    <span style="font-size: 1.25rem; font-weight: 800; color: var(--secondary);"><?= number_format($stats['xp']) ?></span>
                </div>
                <div>
                    <span class="text-muted" style="font-size: 0.75rem; font-weight: 700; display: block;">Misi Lulus</span>
                    <span style="font-size: 1.25rem; font-weight: 800; color: var(--tertiary);"><?= $stats['completed'] ?> / 6</span>
                </div>
                <div>
                    <span class="text-muted" style="font-size: 0.75rem; font-weight: 700; display: block;">Lencana</span>
                    <span style="font-size: 1.25rem; font-weight: 800; color: var(--coral-shade);"><?= $stats['badges_earned'] ?></span>
                </div>
            </div>

            <!-- Testing / Development Tools -->
            <div style="display: flex; flex-direction: column; gap: 0.75rem; text-align: left; border-top: 1px solid var(--card-stroke); padding-top: 1.25rem;">
                <span style="font-size: 0.8rem; font-weight: 800; color: var(--on-surface-variant); text-transform: uppercase;">Aksi &amp; Uji Coba:</span>

                <button class="btn btn-outline" onclick="confirmResetProgress()" style="justify-content: flex-start; color: var(--coral-shade);">
                    <span class="material-symbols-outlined">restart_alt</span>
                    <span>Reset Progress ke Level 1 (Untuk Uji Coba Ulang)</span>
                </button>

                <a href="<?= $baseUrl ?>/onboarding.php" class="btn btn-outline" style="justify-content: flex-start;">
                    <span class="material-symbols-outlined text-primary">person_add</span>
                    <span>Ganti Siswa / Buat Akun Baru</span>
                </a>

                <a href="<?= $baseUrl ?>/profile.php?action=logout" class="btn btn-outline" style="justify-content: flex-start; color: var(--error);">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Keluar (Logout)</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmResetProgress() {
    if (confirm("Apakah kamu yakin ingin mereset progress belajar akun ini kembali ke Level 1?")) {
        fetch('<?= $baseUrl ?>/api/reset-progress.php', { method: 'POST' })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '<?= $baseUrl ?>/profile.php?reset_done=1';
                } else {
                    alert('Gagal mereset: ' + (data.error || 'Terjadi kesalahan'));
                }
            })
            .catch(err => alert('Network error: ' + err));
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
