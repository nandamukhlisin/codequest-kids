<?php
/**
 * CodeQuest Kids — Interactive Gameplay Engine Page
 * Mendukung Misi 1 (Coding Explorer) & Misi 2 (Sequence Master)
 * Berdasarkan desain di Design/tantangan_coding_interaktif_misi_*
 */

require_once __DIR__ . '/includes/functions.php';
requireLogin();

$user     = getCurrentUser();
$stats    = getUserStats($user['id']);
$levels   = getAllLevels();

$levelId = (int) ($_GET['level'] ?? 1);
if ($levelId < 1 || $levelId > 6) {
    $levelId = 1;
}

$pageTitle  = "Tantangan Misi {$levelId}";
$activePage = 'peta';

// Ambil progress user untuk level ini
$levelProgress = getLevelProgress($user['id'], $levelId);
$isUnlocked    = ($levelProgress && ($levelProgress['status'] === 'unlocked' || $levelProgress['status'] === 'completed' || $levelProgress['status'] === 'in_progress'));

// Konfigurasi Level 1 & 2
$isLevel1 = ($levelId === 1);
$isLevel2 = ($levelId === 2);

if ($isLevel1) {
    $missionTitle = "Misi 1: Coding Explorer — Langkah Pertama Robot Kiko";
    $conceptBadge = "Konsep: Berpikir Komputasional (Sequencing)";
    $objective    = "🎯 Tujuan: Pandu Robot Kiko melangkah lurus sejauh 3 petak ke arah Timur menuju Bintang Emas!";
    $targetBlock  = "3 Perintah MAJU";
    $xpReward     = 50;
    $startX = 1; $startY = 2; $startAngle = 0; // East
    $targetX = 4; $targetY = 2;
    $obstacles = [];
    $maxBlocks = 3;
    $defaultCommands = ['MAJU', 'MAJU', 'MAJU'];
} elseif ($isLevel2) {
    $missionTitle = "Misi 2: Sequence Master — Menghindari Rintangan Karang";
    $conceptBadge = "Konsep: Urutan Instruksi & Rotasi 90°";
    $objective    = "🎯 Tujuan: Pandu Kiko mengitari batu karang dan rawa air untuk mencapai Bintang Emas di (4, 1)!";
    $targetBlock  = "7 Perintah (Max 8)";
    $xpReward     = 80;
    $startX = 1; $startY = 3; $startAngle = 0; // East
    $targetX = 4; $targetY = 1;
    $obstacles = [
        ['x' => 2, 'y' => 3, 'name' => 'Batu Karang Besar'],
        ['x' => 2, 'y' => 2, 'name' => 'Batu Karang Runcing'],
        ['x' => 3, 'y' => 4, 'name' => 'Rawa Air']
    ];
    $maxBlocks = 8;
    $defaultCommands = ['BELOK_KIRI', 'MAJU', 'MAJU', 'BELOK_KANAN', 'MAJU', 'MAJU', 'MAJU'];
} else {
    // Level 3-6 (Locked preview)
    $missionTitle = "Misi {$levelId}: Petualangan Lanjutan";
}

// Define $baseUrl here so it's available before header.php include (header.php also sets it, harmlessly)
$baseUrl = getBaseUrl();

$extraScripts = [
    $baseUrl . '/assets/js/game-engine.js'
];

require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-container px-gutter py-3">
    <?php if (!$isUnlocked && !$isLevel1 && !$isLevel2): ?>
    <!-- LOCKED SCREEN FOR LEVEL 3-6 -->
    <div class="card text-center py-5" style="max-width: 600px; margin: 3rem auto; padding: 2.5rem;">
        <div style="font-size: 4rem; margin-bottom: 1rem;">🔒</div>
        <h2 style="font-size: 1.75rem; color: var(--on-surface); margin-bottom: 0.5rem;">Misi Ini Masih Terkunci!</h2>
        <p style="color: var(--on-surface-variant); margin-bottom: 1.5rem; line-height: 1.5;">
            Kamu harus menyelesaikan <strong>Misi 1 (Coding Explorer)</strong> dan <strong>Misi 2 (Sequence Master)</strong> terlebih dahulu untuk membuka pulau petualangan berikutnya.
        </p>
        <div style="display: flex; justify-content: center; gap: 1rem;">
            <a href="<?= $baseUrl ?>/peta-belajar.php" class="btn btn-primary">
                <span class="material-symbols-outlined">map</span> Kembali ke Peta Belajar
            </a>
            <a href="<?= $baseUrl ?>/tantangan.php?level=1" class="btn btn-outline">
                Mainkan Misi 1 🌱
            </a>
        </div>
    </div>
    <?php else: ?>

    <!-- SECTION 1: Top Navigation, Breadcrumbs & Controls -->
    <div style="display: flex; flex-direction: column; gap: 0.65rem; margin-bottom: 0.75rem;">
        <div class="card" style="padding: 0.5rem 0.85rem; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.65rem; box-shadow: var(--shadow-tactile-xs);">
            <!-- Breadcrumbs -->
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.78rem; font-weight: 700; flex-wrap: wrap;">
                <a href="<?= $baseUrl ?>/peta-belajar.php" class="btn btn-outline btn-sm" style="padding: 0.25rem 0.65rem; font-size: 0.75rem;">
                    <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                    <span>Peta Belajar</span>
                </a>
                <span style="color: var(--locked-gray);">/</span>
                <span class="text-muted">Level <?= $levelId ?></span>
                <span style="color: var(--locked-gray);">/</span>
                <span class="badge-pill badge-blue" style="font-size: 0.72rem;"><?= $isLevel1 ? 'Langkah Pertama' : 'Sequence Master' ?></span>
            </div>

            <!-- Quick Controls -->
            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                <button class="btn btn-outline btn-sm" id="sfx-toggle" onclick="toggleSFX()" style="padding: 0.25rem 0.65rem; font-size: 0.75rem;">
                    <span class="material-symbols-outlined text-primary" style="font-size: 15px;" id="sfx-icon">volume_up</span>
                    <span id="sfx-text">SFX ON</span>
                </button>
                <button class="btn btn-secondary btn-sm" onclick="openModal('hint-modal')" style="padding: 0.25rem 0.75rem; font-size: 0.75rem;">
                    <span class="material-symbols-outlined" style="font-size: 15px;">lightbulb</span>
                    <span>💡 Butuh Petunjuk? (Hint)</span>
                </button>
                <button class="btn btn-outline btn-sm" onclick="gameEngine.resetPositionOnly()" style="padding: 0.25rem 0.65rem; font-size: 0.75rem;">
                    <span class="material-symbols-outlined text-coral" style="font-size: 15px;">refresh</span>
                    <span>🔄 Reset Grid</span>
                </button>
            </div>
        </div>

        <!-- Mission Title & Target Metric Banner -->
        <div class="card" style="padding: 0.85rem 1.25rem; display: flex; flex-direction: column; gap: 0.75rem;" class="lg:flex-row lg:items-center lg:justify-between">
            <div style="display: flex; align-items: center; gap: 0.85rem;">
                <div style="width: 2.75rem; height: 2.75rem; border-radius: var(--radius-sm); background: var(--primary-container); color: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 3px 0 var(--on-primary-fixed); flex-shrink: 0;">
                    <span class="material-symbols-outlined" style="font-size: 26px;">smart_toy</span>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                        <h1 style="font-size: 1.25rem; color: var(--on-surface); font-weight: 800;"><?= e($missionTitle) ?></h1>
                        <span class="badge-pill badge-blue" style="font-size: 0.7rem;"><?= e($conceptBadge) ?></span>
                    </div>
                    <div style="font-size: 0.82rem; color: var(--tertiary); font-weight: 700; margin-top: 0.15rem;">
                        <?= e($objective) ?>
                    </div>
                </div>
            </div>

            <!-- Target Chips -->
            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                <div class="stat-pill" style="font-size: 0.75rem;">
                    <span class="material-symbols-outlined text-primary" style="font-size: 16px;">flag</span>
                    <span>Target: <strong><?= e($targetBlock) ?></strong></span>
                </div>
                <div class="stat-pill" style="font-size: 0.75rem; background: var(--secondary-fixed); border-color: var(--yellow-shade);">
                    <span class="material-symbols-outlined" style="font-size: 16px; color: var(--secondary);">hotel_class</span>
                    <span style="color: var(--on-secondary-container);">Hadiah: <strong>+<?= $xpReward ?> XP</strong></span>
                </div>
                <div class="stat-pill" style="font-size: 0.75rem;">
                    <span class="material-symbols-outlined" style="font-size: 16px; color: var(--soft-purple);">diamond</span>
                    <span>+15 Permata</span>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: Mascot Speech Guidance Box -->
    <div class="mascot-speech-card mb-3" style="padding: 0.65rem 1rem; background: rgba(253, 210, 89, 0.2); border-left: 4px solid var(--yellow-shade); margin-bottom: 0.75rem;">
        <div class="mascot-speech-icon" style="width: 2.5rem; height: 2.5rem;">
            <span class="material-symbols-outlined" style="font-size: 24px;" id="mascot-face-icon">smart_toy</span>
        </div>
        <div style="flex: 1;">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.1rem;">
                <span style="font-size: 0.78rem; font-weight: 800; color: var(--primary);" id="mascot-name-badge">Robot Kiko:</span>
                <span class="badge-pill badge-blue" style="font-size: 0.65rem;" id="mascot-phase-badge">Panduan Gerakan</span>
            </div>
            <p style="font-size: 0.85rem; color: var(--on-surface); font-weight: 600;" id="mascot-speech-text">
                <?php if ($isLevel1): ?>
                “Halo Penjelajah Cilik! Kiko siap jalan! Untuk Misi 1 ini, Kiko hanya perlu <strong style="color: var(--tertiary);">MAJU 3 langkah lurus</strong> ke arah Timur untuk memetik Bintang Emas ⭐. Yuk klik tombol hijau <span class="badge-pill badge-mint" style="font-size: 0.7rem;">MAJU</span> sebanyak 3 kali!”
                <?php else: ?>
                “Awas rintangan karang di depan (2,3)! Putar robot dengan <strong style="color: var(--coral-shade);">BELOK KIRI</strong>, lalu <strong style="color: var(--tertiary);">MAJU 2 kali</strong> ke baris atas, <strong style="color: var(--secondary);">BELOK KANAN</strong>, dan <strong style="color: var(--tertiary);">MAJU 3 kali</strong> ke arah Bintang Emas!”
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- SECTION 3: Main Gameplay Split Layout (4x4 Grid Board + Command Console) -->
    <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;" class="xl:grid-cols-12">
        <!-- LEFT SIDE: 4x4 Grid Board (7 cols) -->
        <div class="xl:col-span-7" style="display: flex; flex-direction: column; gap: 0.75rem;">
            <div class="grid-board-card">
                <!-- Board Top Bar -->
                <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--card-stroke); padding-bottom: 0.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="material-symbols-outlined text-primary" style="font-size: 20px;">grid_view</span>
                        <span style="font-size: 0.95rem; font-weight: 800; color: var(--on-surface);">Papan Arena 4x4 (Grid Logika)</span>
                    </div>
                    <div>
                        <span class="badge-pill badge-blue" style="font-size: 0.75rem;" id="hud-compass-text">
                            🧭 Hadap: TIMUR (Kanan ➡️)
                        </span>
                    </div>
                </div>

                <!-- Interactive 4x4 Grid Arena -->
                <div class="board-arena" id="board-arena">
                    <!-- X Coordinates Header -->
                    <div class="grid-coord-row">
                        <div>X: 1</div>
                        <div>X: 2</div>
                        <div>X: 3</div>
                        <div>X: 4</div>
                    </div>

                    <!-- Inner Cells (4 rows x 4 cols) -->
                    <div class="grid-cells-container" id="robot-grid">
                        <?php for ($y = 1; $y <= 4; $y++): ?>
                            <?php for ($x = 1; $x <= 4; $x++): ?>
                                <?php
                                    $isStart = ($x === $startX && $y === $startY);
                                    $isGoal  = ($x === $targetX && $y === $targetY);
                                    $obsMatch = null;
                                    foreach ($obstacles as $obs) {
                                        if ($obs['x'] === $x && $obs['y'] === $y) {
                                            $obsMatch = $obs;
                                            break;
                                        }
                                    }

                                    $cellClass = 'grid-cell';
                                    if ($isStart) $cellClass .= ' grid-cell-start';
                                    elseif ($isGoal) $cellClass .= ' grid-cell-goal';
                                    elseif ($obsMatch) $cellClass .= ' grid-cell-obstacle';
                                ?>
                                <div class="<?= $cellClass ?>" id="cell-<?= $x ?>-<?= $y ?>" data-x="<?= $x ?>" data-y="<?= $y ?>">
                                    <?php if ($isStart): ?>
                                        <span class="cell-start-label">START</span>
                                        <span class="material-symbols-outlined" style="font-size: 18px; color: var(--primary-shade); opacity: 0.4;">trip_origin</span>
                                    <?php elseif ($isGoal): ?>
                                        <div class="goal-star-pill float-pulse" id="goal-star">
                                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">hotel_class</span>
                                        </div>
                                    <?php elseif ($obsMatch): ?>
                                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                                            <span class="material-symbols-outlined" style="font-size: 22px; color: var(--coral-shade);">terrain</span>
                                            <span style="font-size: 0.55rem; font-weight: 800; color: var(--coral-shade); line-height: 1;">KARANG</span>
                                        </div>
                                    <?php else: ?>
                                        <span class="material-symbols-outlined" style="font-size: 18px; color: var(--mint-shade); opacity: 0.25;">grass</span>
                                    <?php endif; ?>
                                    <span class="cell-coord-label"><?= $x ?>,<?= $y ?></span>
                                </div>
                            <?php endfor; ?>
                        <?php endfor; ?>

                        <!-- FLOATING ROBOT TOKEN CONTAINER -->
                        <div class="robot-token-wrapper" id="robot-token-wrapper">
                            <div class="robot-token" id="robot-mascot">
                                <span class="material-symbols-outlined" id="robot-symbol">smart_toy</span>
                                <span class="robot-token-name">Kiko</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Path Guidance Hint Strip -->
                <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding-top: 0.25rem; font-size: 0.78rem; color: var(--on-surface-variant); font-weight: 700;">
                    <span class="material-symbols-outlined text-mint" style="font-size: 16px;">explore</span>
                    <span>Posisi Mulai: <strong>(X: <?= $startX ?>, Y: <?= $startY ?>)</strong> &bull; Target Bintang: <strong>(X: <?= $targetX ?>, Y: <?= $targetY ?>)</strong></span>
                </div>
            </div>

            <!-- Concept Card Under Grid -->
            <div class="card" style="padding: 0.85rem 1rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                    <span class="material-symbols-outlined text-primary" style="font-size: 18px;">psychology</span>
                    <span style="font-size: 0.85rem; font-weight: 800; color: var(--on-surface);">Pesan Berpikir Komputasional</span>
                </div>
                <p style="font-size: 0.82rem; color: var(--on-surface-variant); line-height: 1.45;">
                    Komputer dan robot mengerjakan perintah persis satu demi satu dari atas ke bawah. Pastikan setiap langkah diperiksa arah hadapnya sebelum menekan tombol Jalankan Kode!
                </p>
            </div>
        </div>

        <!-- RIGHT SIDE: Command Block Workspace & Sequence Queue (5 cols) -->
        <div class="xl:col-span-5" style="display: flex; flex-direction: column; gap: 0.75rem;">
            <div class="card" style="padding: 1rem; display: flex; flex-direction: column; gap: 0.75rem;">
                <!-- Tab Visual vs Python Preview -->
                <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--card-stroke); padding-bottom: 0.5rem;">
                    <div style="display: flex; gap: 0.35rem;">
                        <button class="btn btn-primary btn-sm" id="tab-visual-btn" onclick="switchConsoleTab('visual')" style="padding: 0.25rem 0.75rem; font-size: 0.75rem;">
                            🧱 Blok Visual
                        </button>
                        <button class="btn btn-outline btn-sm" id="tab-python-btn" onclick="switchConsoleTab('python')" style="padding: 0.25rem 0.75rem; font-size: 0.75rem;">
                            🐍 Kode Python
                        </button>
                    </div>
                    <span style="font-size: 0.72rem; color: var(--on-surface-variant); font-weight: 700;">Sentuh / Klik</span>
                </div>

                <!-- SUB-PANEL 1: Available Command Palette (Tap to Add) -->
                <div id="palette-visual-section">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                        <span style="font-size: 0.85rem; font-weight: 800; color: var(--on-surface);">1. Blok Perintah Tersedia</span>
                        <span style="font-size: 0.7rem; color: var(--tertiary); font-weight: 700;">Klik tombol untuk menambah</span>
                    </div>

                    <div class="cmd-palette-grid">
                        <!-- Command: MAJU -->
                        <button class="cmd-btn cmd-btn-maju" onclick="gameEngine.addCommand('MAJU')" id="btn-add-maju">
                            <div class="cmd-btn-inner">
                                <div class="cmd-btn-icon">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">arrow_upward</span>
                                </div>
                                <div>
                                    <span class="cmd-btn-title">⬆️ MAJU (1 Petak)</span>
                                    <span class="cmd-btn-desc">Gerakkan Robot Kiko 1 kotak ke depan</span>
                                </div>
                            </div>
                            <div class="cmd-add-plus">+</div>
                        </button>

                        <!-- Command: BELOK KANAN -->
                        <button class="cmd-btn cmd-btn-right" onclick="gameEngine.addCommand('BELOK_KANAN')" id="btn-add-right">
                            <div class="cmd-btn-inner">
                                <div class="cmd-btn-icon">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">rotate_right</span>
                                </div>
                                <div>
                                    <span class="cmd-btn-title">↪️ BELOK KANAN (90°)</span>
                                    <span class="cmd-btn-desc">Putar robot searah jarum jam</span>
                                </div>
                            </div>
                            <div class="cmd-add-plus">+</div>
                        </button>

                        <!-- Command: BELOK KIRI -->
                        <button class="cmd-btn cmd-btn-left" onclick="gameEngine.addCommand('BELOK_KIRI')" id="btn-add-left">
                            <div class="cmd-btn-inner">
                                <div class="cmd-btn-icon">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">rotate_left</span>
                                </div>
                                <div>
                                    <span class="cmd-btn-title">↩️ BELOK KIRI (90°)</span>
                                    <span class="cmd-btn-desc">Putar robot berlawanan jarum jam</span>
                                </div>
                            </div>
                            <div class="cmd-add-plus">+</div>
                        </button>
                    </div>
                </div>

                <!-- SUB-PANEL 2: Python Code Preview (Toggled) -->
                <div id="palette-python-section" style="display: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                        <span style="font-size: 0.85rem; font-weight: 800; color: var(--on-surface);">🐍 Pratinjau Kode Python</span>
                        <span class="badge-pill badge-mint" style="font-size: 0.65rem;">Real-time</span>
                    </div>
                    <div class="python-preview-card">
                        <span class="python-comment"># <?= e($missionTitle) ?></span><br>
                        <span class="python-keyword">import</span> codequest.robot <span class="python-keyword">as</span> kiko<br><br>
                        <pre id="python-code-lines" style="font-family: inherit; margin: 0; white-space: pre-wrap; color: #7dd3fc;"></pre>
                        <span class="python-comment"># Target: Bintang Emas (<?= $targetX ?>, <?= $targetY ?>) ⭐</span>
                    </div>
                </div>

                <!-- SUB-PANEL 3: Sequence Tray (Urutan Perintah Robot) -->
                <div style="border-top: 1px solid var(--card-stroke); padding-top: 0.65rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="font-size: 0.85rem; font-weight: 800; color: var(--on-surface);">2. Urutan Perintahmu</span>
                            <span class="badge-pill badge-blue" id="queue-counter" style="font-size: 0.7rem;">0 / <?= $maxBlocks ?> Blok</span>
                        </div>
                        <button class="text-coral" style="font-size: 0.75rem; font-weight: 800; display: flex; align-items: center; gap: 2px;" onclick="gameEngine.clearCommands()">
                            <span class="material-symbols-outlined" style="font-size: 15px;">delete</span>
                            <span>Hapus Semua 🗑️</span>
                        </button>
                    </div>

                    <!-- Sequence Slot Cards List -->
                    <div class="sequence-slots-box" id="command-slots-container">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <!-- SUB-PANEL 4: Action Execution Buttons -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem; padding-top: 0.25rem;">
                    <!-- Primary 3D Tactile RUN Button -->
                    <button class="btn btn-run btn-lg" id="run-button" onclick="gameEngine.executeProgram()" style="width: 100%; font-size: 1.05rem;">
                        <span class="material-symbols-outlined" style="font-size: 24px;">play_circle</span>
                        <span>▶ JALANKAN KODE! (RUN)</span>
                    </button>

                    <!-- Secondary Step & Reset Buttons -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                        <button class="btn btn-outline btn-sm" id="step-button" onclick="gameEngine.stepProgram()" style="font-size: 0.75rem; padding: 0.45rem;">
                            <span class="material-symbols-outlined text-primary" style="font-size: 16px;">footprint</span>
                            <span>👣 Langkah demi Langkah</span>
                        </button>
                        <button class="btn btn-outline btn-sm" onclick="gameEngine.resetPositionOnly()" style="font-size: 0.75rem; padding: 0.45rem;">
                            <span class="material-symbols-outlined text-coral" style="font-size: 16px;">replay</span>
                            <span>🔄 Reset Posisi</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Teaser Card -->
            <div class="card" style="padding: 0.75rem 1rem; border-left: 4px solid var(--secondary-container); display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 0.65rem;">
                    <div style="width: 2.25rem; height: 2.25rem; border-radius: 50%; background: var(--secondary-container); display: flex; align-items: center; justify-content: center; color: var(--secondary); flex-shrink: 0;">
                        <span class="material-symbols-outlined" style="font-size: 18px;">emoji_events</span>
                    </div>
                    <div>
                        <span style="font-size: 0.68rem; font-weight: 800; text-transform: uppercase; color: var(--on-surface-variant); display: block;">Hadiah Kelulusan:</span>
                        <span style="font-size: 0.8rem; font-weight: 800; color: var(--on-surface);"><?= $isLevel1 ? 'Buka Kunci Level 2: Sequence Master' : 'Buka Kunci Level 3: Loop Adventure' ?></span>
                    </div>
                </div>
                <span class="material-symbols-outlined text-locked" style="font-size: 20px;">lock_open</span>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- ═══════════════ MODALS ═══════════════ -->

<!-- MODAL 1: Hint Modal (3-Tier Gradual Hints) -->
<div class="modal-overlay" id="hint-modal">
    <div class="modal-window">
        <div class="modal-header">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span class="material-symbols-outlined text-yellow" style="font-size: 24px;">lightbulb</span>
                <div>
                    <h3 class="modal-title">Sistem Petunjuk Misi <?= $levelId ?></h3>
                    <span style="font-size: 0.7rem; color: var(--on-surface-variant); font-weight: 700;">Panduan bertahap tanpa membocorkan keseruan</span>
                </div>
            </div>
            <button class="modal-close-btn" onclick="closeModal('hint-modal')">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div>
            <?php if ($isLevel1): ?>
            <!-- Hint 1 -->
            <div class="hint-tier-card">
                <div class="hint-tier-title text-primary">
                    <span class="material-symbols-outlined" style="font-size: 16px;">explore</span>
                    <span>Petunjuk 1 (Konsep): Arah Hadap</span>
                </div>
                <p class="hint-tier-body">
                    Robot Kiko saat ini sudah menghadap ke arah <strong>Timur (kanan ➡️)</strong>. Jalur menuju Bintang Emas adalah garis lurus, sehingga kamu tidak memerlukan perintah belok!
                </p>
            </div>
            <!-- Hint 2 -->
            <div class="hint-tier-card hint-tier-2">
                <div class="hint-tier-title text-secondary">
                    <span class="material-symbols-outlined" style="font-size: 16px;">straighten</span>
                    <span>Petunjuk 2 (Strategi): Jarak Kotak</span>
                </div>
                <p class="hint-tier-body">
                    Hitung jarak petak dari posisi awal <strong>(X: 1)</strong> ke petak Bintang <strong>(X: 4)</strong>: 4 dikurang 1 adalah <strong>3 petak</strong> ke depan.
                </p>
            </div>
            <!-- Hint 3 -->
            <div class="hint-tier-card hint-tier-3">
                <div class="hint-tier-title text-tertiary">
                    <span class="material-symbols-outlined" style="font-size: 16px;">check_circle</span>
                    <span>Petunjuk 3 (Solusi Terbimbing): Langkah Eksekusi</span>
                </div>
                <p class="hint-tier-body">
                    Susun 3 balok hijau <strong>[MAJU]</strong> di urutan perintah, lalu tekan tombol hijau besar <strong>JALANKAN KODE!</strong>
                </p>
            </div>
            <?php else: ?>
            <!-- Hint Misi 2 -->
            <div class="hint-tier-card">
                <div class="hint-tier-title text-primary">
                    <span class="material-symbols-outlined" style="font-size: 16px;">explore</span>
                    <span>Petunjuk 1 (Arah Awal): Hindari Karang</span>
                </div>
                <p class="hint-tier-body">
                    Di depanmu di (2, 3) ada batu karang besar. Jangan langsung MAJU! Putar robot ke arah <strong>Utara</strong> lebih dulu dengan <strong>BELOK KIRI</strong>.
                </p>
            </div>
            <div class="hint-tier-card hint-tier-2">
                <div class="hint-tier-title text-secondary">
                    <span class="material-symbols-outlined" style="font-size: 16px;">straighten</span>
                    <span>Petunjuk 2 (Jalur Atas): Naik ke Baris Y: 1</span>
                </div>
                <p class="hint-tier-body">
                    Setelah menghadap Utara, perintahkan Kiko <strong>MAJU 2 kali</strong> hingga mencapai koordinat (X:1, Y:1). Di baris 1 jalur lapang bebas karang!
                </p>
            </div>
            <div class="hint-tier-card hint-tier-3">
                <div class="hint-tier-title text-tertiary">
                    <span class="material-symbols-outlined" style="font-size: 16px;">check_circle</span>
                    <span>Petunjuk 3 (Menuju Target): Belok &amp; Petik Bintang</span>
                </div>
                <p class="hint-tier-body">
                    Di (1, 1), lakukan <strong>BELOK KANAN</strong> agar menghadap Timur, lalu <strong>MAJU 3 kali</strong> ke arah Bintang Emas di (4, 1)!
                </p>
            </div>
            <?php endif; ?>
        </div>

        <button class="btn btn-primary" onclick="closeModal('hint-modal'); if(gameEngine) gameEngine.usedHint = true;" style="width: 100%; margin-top: 0.5rem;">
            Paham, Ayo Coba! 👍
        </button>
    </div>
</div>

<!-- MODAL 2: Victory / Success Modal (PRD Section 15 & Design) -->
<div class="modal-overlay" id="victory-modal">
    <div class="modal-window text-center" style="max-width: 440px;">
        <div style="width: 4.5rem; height: 4.5rem; border-radius: 50%; background: var(--tertiary-fixed); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: 0 4px 0 var(--mint-shade);" class="animate-bounce">
            <span class="material-symbols-outlined text-tertiary" style="font-size: 44px;">verified</span>
        </div>

        <span class="badge-pill badge-yellow" style="margin-bottom: 0.5rem;">⭐ MISI <?= $levelId ?> BERHASIL DISELESAIKAN! ⭐</span>
        <h2 style="font-size: 1.5rem; color: var(--primary); margin-bottom: 0.35rem;">
            <?= $isLevel1 ? 'Hebat! Coding Explorer Tuntas! 🎉' : 'Hebat! Sequence Master Tuntas! 🎉' ?>
        </h2>
        <p style="font-size: 0.88rem; color: var(--on-surface-variant); margin-bottom: 1.25rem;">
            Kiko sukses menavigasi jalur logika dan berhasil memetik Bintang Emas berkat urutan instruksi cerdasmu!
        </p>

        <!-- Reward Breakdown Box -->
        <div class="card" style="background: var(--surface-container-low); padding: 0.85rem; display: flex; justify-content: space-around; align-items: center; margin-bottom: 1.25rem; box-shadow: var(--shadow-tactile-xs);">
            <div>
                <span style="font-size: 1.25rem; font-weight: 800; color: var(--secondary);">+<?= $xpReward ?> XP</span>
                <span class="text-muted" style="font-size: 0.7rem; display: block; font-weight: 700;">Pengalaman Logika</span>
            </div>
            <div style="width: 1px; height: 2rem; background: var(--card-stroke);"></div>
            <div>
                <span style="font-size: 1.25rem; font-weight: 800; color: var(--coral-shade);">+15 💎</span>
                <span class="text-muted" style="font-size: 0.7rem; display: block; font-weight: 700;">Permata Coder</span>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.65rem;">
            <?php if ($isLevel1): ?>
            <a href="<?= $baseUrl ?>/tantangan.php?level=2" class="btn btn-primary" style="width: 100%;">
                <span>Lanjut ke Misi 2: Sequence Master 🚀</span>
            </a>
            <?php else: ?>
            <a href="<?= $baseUrl ?>/peta-belajar.php" class="btn btn-primary" style="width: 100%;">
                <span>Kembali ke Peta Belajar (Lihat Level 3) 🗺️</span>
            </a>
            <?php endif; ?>
            <button class="btn btn-outline" onclick="gameEngine.closeVictoryModal()">
                Mainkan Ulang Misi 🔄
            </button>
        </div>
    </div>
</div>

<!-- MODAL 3: Retry / Diagnostic Modal (Failure State) -->
<div class="modal-overlay" id="retry-modal">
    <div class="modal-window text-center" style="max-width: 420px; border-color: rgba(186, 26, 26, 0.4);">
        <div style="width: 4rem; height: 4rem; border-radius: 50%; background: var(--error-container); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem; box-shadow: 0 3px 0 var(--error);">
            <span class="material-symbols-outlined" style="font-size: 38px; color: var(--error);">sentiment_dissatisfied</span>
        </div>

        <span class="badge-pill badge-coral" style="margin-bottom: 0.35rem;">HAMPIR BERHASIL!</span>
        <h3 style="font-size: 1.35rem; color: var(--on-surface); margin-bottom: 0.35rem;">Robot Kiko Belum Sampai ⭐</h3>
        <p style="font-size: 0.85rem; color: var(--on-surface-variant); margin-bottom: 1rem;" id="retry-diagnostic-msg">
            Robot Kiko berhenti di petak yang belum tepat. Bintang Emas berada di petak (X: <?= $targetX ?>, Y: <?= $targetY ?>).
        </p>

        <div style="background: rgba(253, 210, 89, 0.2); border-left: 3px solid var(--yellow-shade); padding: 0.65rem 0.85rem; border-radius: var(--radius-sm); text-align: left; margin-bottom: 1rem;">
            <span style="font-size: 0.75rem; font-weight: 800; color: var(--secondary);">💡 Saran Robot Kiko:</span>
            <p style="font-size: 0.78rem; color: var(--on-surface-variant); margin-top: 0.15rem;">
                Periksa kembali jumlah langkah maju dan arah putaran belokan. Kamu bisa membuka petunjuk bantuan!
            </p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <button class="btn btn-coral" onclick="gameEngine.closeRetryModal()" style="width: 100%;">
                Coba Lagi 🔄
            </button>
            <button class="btn btn-outline" onclick="gameEngine.closeRetryModal(); openModal('hint-modal');">
                Buka Petunjuk 💡
            </button>
        </div>
    </div>
</div>

<script>
// Switch between Visual Palette and Python Code Preview
function switchConsoleTab(tab) {
    const visualBtn = document.getElementById('tab-visual-btn');
    const pythonBtn = document.getElementById('tab-python-btn');
    const visualSec = document.getElementById('palette-visual-section');
    const pythonSec = document.getElementById('palette-python-section');

    if (tab === 'visual') {
        visualBtn.className = 'btn btn-primary btn-sm';
        pythonBtn.className = 'btn btn-outline btn-sm';
        visualSec.style.display = 'block';
        pythonSec.style.display = 'none';
    } else {
        pythonBtn.className = 'btn btn-primary btn-sm';
        visualBtn.className = 'btn btn-outline btn-sm';
        pythonSec.style.display = 'block';
        visualSec.style.display = 'none';
    }
}

// Inisialisasi Game Engine
let gameEngine = null;
document.addEventListener('DOMContentLoaded', () => {
    gameEngine = new CodeQuestEngine({
        levelId: <?= $levelId ?>,
        challengeId: <?= $levelId ?>,
        gridSize: 4,
        startX: <?= $startX ?? 1 ?>,
        startY: <?= $startY ?? 2 ?>,
        startAngle: <?= $startAngle ?? 0 ?>,
        targetX: <?= $targetX ?? 4 ?>,
        targetY: <?= $targetY ?? 2 ?>,
        obstacles: <?= json_encode($obstacles ?? []) ?>,
        maxBlocks: <?= $maxBlocks ?? 8 ?>,
        xpReward: <?= $xpReward ?? 50 ?>,
        initialCommands: <?= json_encode($defaultCommands ?? []) ?>,
        saveProgressUrl: '<?= $baseUrl ?>/api/save-progress.php',
        nextLevelUrl: '<?= $baseUrl ?>/tantangan.php?level=<?= min(6, $levelId + 1) ?>'
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
