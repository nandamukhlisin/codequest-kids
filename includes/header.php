<?php
/**
 * CodeQuest Kids — Header Template
 * Menyediakan HTML head, navigation bar, dan Google Fonts
 *
 * Variabel yang harus di-set sebelum include:
 *   $pageTitle  — judul halaman (string)
 *   $activePage — 'home'|'dashboard'|'peta'|'tantangan'|'progress'|'badges'|'profile'
 *   $bodyClass  — (opsional) class tambahan untuk <body>
 *   $hideNav    — (opsional) true untuk menyembunyikan navigasi
 */

require_once __DIR__ . '/functions.php';
initSession();

$user     = isLoggedIn() ? getCurrentUser() : null;
$stats    = $user ? getUserStats($user['id']) : null;
$baseUrl  = getBaseUrl();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CodeQuest Kids — Platform pembelajaran coding interaktif untuk anak SD. Belajar coding seperti bermain game!">
    <title><?= e($pageTitle ?? 'CodeQuest Kids') ?> — CodeQuest Kids</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&family=Nunito+Sans:wght@400;600;700;800&family=Space+Grotesk:wght@500;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
</head>
<body class="<?= e($bodyClass ?? '') ?>">

<?php if (empty($hideNav)): ?>
<header class="site-header" id="site-header">
    <div class="header-inner">
        <!-- Logo -->
        <a href="<?= $baseUrl ?>/" class="header-logo" id="nav-logo">
            <span class="logo-icon">🚀</span>
            <div class="logo-text">
                <span class="logo-title">CodeQuest <span class="logo-accent">Kids</span></span>
                <span class="logo-badge">M-ONE 2026</span>
            </div>
        </a>

        <!-- Desktop Navigation -->
        <nav class="header-nav" id="main-nav">
            <?php if ($user): ?>
            <a href="<?= $baseUrl ?>/dashboard.php" class="nav-link <?= ($activePage ?? '') === 'dashboard' ? 'active' : '' ?>" id="nav-dashboard">Beranda / Dashboard</a>
            <a href="<?= $baseUrl ?>/peta-belajar.php" class="nav-link <?= ($activePage ?? '') === 'peta' ? 'active' : '' ?>" id="nav-peta">Peta Belajar</a>
            <a href="<?= $baseUrl ?>/progress.php" class="nav-link <?= ($activePage ?? '') === 'progress' ? 'active' : '' ?>" id="nav-progress">Progress Belajar</a>
            <a href="<?= $baseUrl ?>/badges.php" class="nav-link <?= ($activePage ?? '') === 'badges' ? 'active' : '' ?>" id="nav-badges">Koleksi Badge</a>
            <?php else: ?>
            <a href="<?= $baseUrl ?>/#fitur" class="nav-link" id="nav-fitur">Fitur</a>
            <a href="<?= $baseUrl ?>/#cara-belajar" class="nav-link" id="nav-cara">Cara Belajar</a>
            <a href="<?= $baseUrl ?>/#kurikulum" class="nav-link" id="nav-kurikulum">Kurikulum</a>
            <?php endif; ?>
        </nav>

        <!-- User Info / CTA -->
        <div class="header-actions">
            <?php if ($user): ?>
            <div class="header-stats">
                <span class="stat-pill stat-xp" id="header-xp">
                    <span class="material-symbols-rounded">bolt</span>
                    <?= number_format($stats['xp']) ?> XP
                </span>
                <span class="stat-pill stat-gems" id="header-gems">
                    <span class="material-symbols-rounded">diamond</span>
                    <?= $stats['badges_earned'] ?>
                </span>
            </div>
            <a href="<?= $baseUrl ?>/profile.php" class="header-user" id="nav-profile">
                <span class="user-avatar"><?= mb_substr($user['name'], 0, 1) ?></span>
                <div class="user-info">
                    <span class="user-name"><?= e($user['name']) ?></span>
                    <span class="user-level"><?= e($stats['level_title']) ?></span>
                </div>
            </a>
            <?php else: ?>
            <a href="<?= $baseUrl ?>/onboarding.php" class="btn btn-primary btn-sm" id="nav-cta-mulai">Mulai Petualangan</a>
            <?php endif; ?>
        </div>

        <!-- Mobile menu toggle -->
        <button class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Toggle menu">
            <span class="material-symbols-rounded">menu</span>
        </button>
    </div>
</header>
<?php endif; ?>

<main class="main-content" id="main-content">
