<?php $baseUrl = $baseUrl ?? getBaseUrl(); ?>
</main><!-- /.main-content -->

<?php if (isLoggedIn() && empty($hideNav)): ?>
<!-- Mobile Bottom Navigation -->
<nav class="mobile-bottom-nav" id="mobile-bottom-nav">
    <a href="<?= $baseUrl ?>/dashboard.php" class="bottom-nav-item <?= ($activePage ?? '') === 'dashboard' ? 'active' : '' ?>" id="bnav-home">
        <span class="material-symbols-rounded">home</span>
        <span class="bottom-nav-label">Beranda</span>
    </a>
    <a href="<?= $baseUrl ?>/peta-belajar.php" class="bottom-nav-item <?= ($activePage ?? '') === 'peta' ? 'active' : '' ?>" id="bnav-peta">
        <span class="material-symbols-rounded">map</span>
        <span class="bottom-nav-label">Peta</span>
    </a>
    <a href="<?= $baseUrl ?>/progress.php" class="bottom-nav-item <?= ($activePage ?? '') === 'progress' ? 'active' : '' ?>" id="bnav-progress">
        <span class="material-symbols-rounded">trending_up</span>
        <span class="bottom-nav-label">Progress</span>
    </a>
    <a href="<?= $baseUrl ?>/badges.php" class="bottom-nav-item <?= ($activePage ?? '') === 'badges' ? 'active' : '' ?>" id="bnav-badges">
        <span class="material-symbols-rounded">emoji_events</span>
        <span class="bottom-nav-label">Badge</span>
    </a>
    <a href="<?= $baseUrl ?>/profile.php" class="bottom-nav-item <?= ($activePage ?? '') === 'profile' ? 'active' : '' ?>" id="bnav-profile">
        <span class="material-symbols-rounded">person</span>
        <span class="bottom-nav-label">Profil</span>
    </a>
</nav>
<?php endif; ?>

<!-- Site Footer -->
<footer class="site-footer" id="site-footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <span class="logo-icon">🚀</span>
            <div>
                <strong>CodeQuest Kids</strong><br>
                <small>Petualangan Logika &amp; Computational Thinking Anak Indonesia.<br>
                Menyiapkan inovator cilik masa depan bersama Telkomsel M-ONE 2026.</small>
            </div>
        </div>
        <div class="footer-links">
            <a href="https://mone.telkomsel.com" target="_blank" rel="noopener"><strong>M-ONE 2026</strong></a>
            <span class="footer-sep">•</span>
            <span>Telkomsel Edukasi</span>
        </div>
        <div class="footer-copy">
            &copy; 2026 CodeQuest Kids • M-ONE Telkomsel Coding Competition. Hak Cipta Dilindungi.
        </div>
    </div>
</footer>

<!-- Global Scripts -->
<script src="<?= $baseUrl ?>/assets/js/app.js"></script>
<?php if (!empty($extraScripts)): ?>
<?php foreach ($extraScripts as $src): ?>
<script src="<?= e($src) ?>"></script>
<?php endforeach; ?>
<?php endif; ?>
<?php if (!empty($inlineScript)): ?>
<script><?= $inlineScript ?></script>
<?php endif; ?>
</body>
</html>
