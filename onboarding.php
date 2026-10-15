<?php
/**
 * CodeQuest Kids — Student Onboarding
 * Mengacu pada PRD Section 10 (User Onboarding)
 */

require_once __DIR__ . '/includes/functions.php';
initSession();

$pageTitle = 'Mulai Petualangan Coder Cilik';
$activePage = 'home';
$hideNav = true; // Clean onboarding without standard header

$error = '';
$success = '';

// Handle quick login Raka
if (isset($_GET['login_raka'])) {
    $raka = getUser(1);
    if ($raka) {
        loginUser(1);
        header('Location: ' . getBaseUrl() . '/dashboard.php');
        exit;
    }
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $avatar = trim($_POST['avatar'] ?? 'avatar_raka.png');

    if (empty($name)) {
        $error = 'Silakan tulis nama panggilanmu dulu ya!';
    } elseif (mb_strlen($name) > 30) {
        $error = 'Nama maksimal 30 karakter.';
    } else {
        try {
            $newUserId = createUser($name, $avatar);
            loginUser($newUserId);
            header('Location: ' . getBaseUrl() . '/dashboard.php');
            exit;
        } catch (Exception $e) {
            $error = 'Gagal membuat profil: ' . $e->getMessage();
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-container px-gutter py-5" style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div class="card" style="max-width: 520px; width: 100%; padding: 2.25rem 1.75rem; border-radius: var(--radius-xl); box-shadow: var(--shadow-modal); border: 2px solid var(--card-stroke);">
        <!-- Top Logo & Mascot -->
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <div style="width: 4.5rem; height: 4.5rem; border-radius: 50%; background: var(--primary-fixed); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem; box-shadow: 0 4px 0 var(--primary-shade);">
                <span class="material-symbols-outlined animate-bounce" style="font-size: 44px; color: var(--primary-container);">smart_toy</span>
            </div>
            <h1 style="font-size: 1.75rem; color: var(--on-surface); margin-bottom: 0.25rem;">Selamat Datang! 👋</h1>
            <p style="font-size: 0.9rem; color: var(--on-surface-variant); font-weight: 600;">
                Siapakah nama penjelajah cilik yang hebat hari ini?
            </p>
        </div>

        <?php if (!empty($error)): ?>
        <div class="card mb-3" style="background: var(--error-container); border: 1px solid var(--error); color: var(--error); padding: 0.65rem 1rem; font-size: 0.82rem; font-weight: 700;">
            ⚠️ <?= e($error) ?>
        </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST" action="" style="display: flex; flex-direction: column; gap: 1.25rem;">
            <!-- Name Input -->
            <div>
                <label for="student-name" style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--on-surface); margin-bottom: 0.4rem;">
                    1. Tulis Nama Panggilanmu:
                </label>
                <input type="text" id="student-name" name="name" placeholder="Misal: Raka, Maya, Budi..." required
                    style="width: 100%; padding: 0.85rem 1.25rem; border-radius: var(--radius-full); border: 2px solid var(--card-stroke); font-family: inherit; font-size: 1rem; font-weight: 700; color: var(--on-surface); background: var(--surface-container-low); outline: none; transition: border-color 0.2s ease;"
                    onfocus="this.style.borderColor='var(--primary-container)';" onblur="this.style.borderColor='var(--card-stroke)';">
            </div>

            <!-- Avatar Selection -->
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 800; color: var(--on-surface); margin-bottom: 0.5rem;">
                    2. Pilih Karakter Avatarmu:
                </label>
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.75rem;">
                    <?php
                    $avatarOptions = [
                        ['id' => 'avatar_raka.png', 'name' => 'Raka 🧢', 'icon' => 'boy', 'bg' => 'var(--primary-fixed)'],
                        ['id' => 'avatar_maya.png', 'name' => 'Maya 🎀', 'icon' => 'girl', 'bg' => 'rgba(255, 139, 117, 0.25)'],
                        ['id' => 'avatar_kiko.png', 'name' => 'Kiko 🤖', 'icon' => 'smart_toy', 'bg' => 'var(--tertiary-fixed)'],
                        ['id' => 'avatar_star.png', 'name' => 'Bintang ⭐', 'icon' => 'star', 'bg' => 'var(--secondary-fixed)'],
                    ];
                    foreach ($avatarOptions as $idx => $opt):
                    ?>
                    <label style="cursor: pointer; text-align: center;">
                        <input type="radio" name="avatar" value="<?= $opt['id'] ?>" <?= $idx === 0 ? 'checked' : '' ?> style="display: none;" onchange="updateAvatarSelection(this)">
                        <div class="avatar-card <?= $idx === 0 ? 'active-avatar' : '' ?>" style="padding: 0.75rem 0.5rem; border-radius: var(--radius-md); background: <?= $opt['bg'] ?>; border: 2px solid var(--card-stroke); transition: all 0.15s ease; display: flex; flex-direction: column; align-items: center; gap: 0.25rem;">
                            <span class="material-symbols-outlined" style="font-size: 32px; color: var(--on-surface);"><?= $opt['icon'] ?></span>
                            <span style="font-size: 0.75rem; font-weight: 800;"><?= $opt['name'] ?></span>
                        </div>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Submit CTA -->
            <button type="submit" class="btn btn-run btn-lg" style="width: 100%; margin-top: 0.5rem;">
                <span class="material-symbols-outlined" style="font-size: 24px;">play_arrow</span>
                <span>Masuk &amp; Mulai Petualangan!</span>
            </button>
        </form>

        <!-- Quick Demo Option for Judges / Reviewers -->
        <div style="border-top: 1px solid var(--card-stroke); margin-top: 1.5rem; padding-top: 1.25rem; text-align: center;">
            <span style="font-size: 0.78rem; color: var(--on-surface-variant); font-weight: 700; display: block; margin-bottom: 0.5rem;">
                Ingin langsung mencoba dengan akun siswa yang sudah memiliki progress?
            </span>
            <a href="<?= $baseUrl ?>/onboarding.php?login_raka=1" class="btn btn-outline btn-sm" style="width: 100%;">
                <span class="material-symbols-outlined text-primary" style="font-size: 18px;">account_circle</span>
                <span>Lanjutkan sebagai Raka (Level 2, 750 XP) 🚀</span>
            </a>
        </div>
    </div>
</div>

<script>
function updateAvatarSelection(radio) {
    document.querySelectorAll('.avatar-card').forEach(el => {
        el.style.border = '2px solid var(--card-stroke)';
        el.style.boxShadow = 'none';
    });
    const parentCard = radio.parentElement.querySelector('.avatar-card');
    if (parentCard) {
        parentCard.style.border = '2px solid var(--primary-container)';
        parentCard.style.boxShadow = '0 3px 0 var(--on-primary-fixed)';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
