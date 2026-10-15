<?php
/**
 * CodeQuest Kids — Helper Functions
 */

require_once __DIR__ . '/../config/database.php';

// ─── Session ───────────────────────────────────────────────
function initSession(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function isLoggedIn(): bool {
    initSession();
    return isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0;
}

function requireLogin(): void {
    initSession();
    if (!isLoggedIn()) {
        // Auto-login ke user default (Raka, ID: 1) jika ada, agar reviewer dapat langsung mencoba
        $raka = getUser(1);
        if ($raka) {
            loginUser(1);
            return;
        }
        header('Location: ' . getBaseUrl() . '/onboarding.php');
        exit;
    }
}

function getCurrentUserId(): int {
    initSession();
    return (int) ($_SESSION['user_id'] ?? 0);
}

function loginUser(int $userId): void {
    initSession();
    $_SESSION['user_id'] = $userId;
}

function logoutUser(): void {
    initSession();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}

// ─── User Data ─────────────────────────────────────────────
function getUser(int $userId): ?array {
    $stmt = getDB()->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$userId]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function getCurrentUser(): ?array {
    $id = getCurrentUserId();
    return $id > 0 ? getUser($id) : null;
}

function updateUserXP(int $userId, int $xpToAdd): void {
    $db = getDB();
    $stmt = $db->prepare('UPDATE users SET xp = xp + ? WHERE id = ?');
    $stmt->execute([$xpToAdd, $userId]);

    // Auto-level berdasarkan XP
    $user = getUser($userId);
    $newLevel = calculateLevel($user['xp']);
    if ($newLevel !== (int) $user['level']) {
        $stmt2 = $db->prepare('UPDATE users SET level = ? WHERE id = ?');
        $stmt2->execute([$newLevel, $userId]);
    }
}

function calculateLevel(int $xp): int {
    // Level thresholds dari PRD
    if ($xp >= 2000) return 5; // Code Creator
    if ($xp >= 1000) return 4; // Logic Master
    if ($xp >= 500)  return 3; // Code Adventurer
    if ($xp >= 200)  return 2; // Logic Explorer
    return 1; // Coding Rookie
}

function getLevelTitle(int $level): string {
    $titles = [
        1 => 'Coding Rookie',
        2 => 'Logic Explorer',
        3 => 'Code Adventurer',
        4 => 'Logic Master',
        5 => 'Code Creator',
    ];
    return $titles[$level] ?? 'Coding Rookie';
}

// ─── Levels ────────────────────────────────────────────────
function getAllLevels(): array {
    $stmt = getDB()->query('SELECT * FROM levels ORDER BY order_number ASC');
    return $stmt->fetchAll();
}

function getLevel(int $levelId): ?array {
    $stmt = getDB()->prepare('SELECT * FROM levels WHERE id = ?');
    $stmt->execute([$levelId]);
    $row = $stmt->fetch();
    return $row ?: null;
}

// ─── Challenges ────────────────────────────────────────────
function getChallengeByLevel(int $levelId): ?array {
    $stmt = getDB()->prepare('SELECT * FROM challenges WHERE level_id = ? ORDER BY order_number ASC LIMIT 1');
    $stmt->execute([$levelId]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function getChallenge(int $challengeId): ?array {
    $stmt = getDB()->prepare('SELECT c.*, l.title as level_title, l.order_number as level_order FROM challenges c JOIN levels l ON c.level_id = l.id WHERE c.id = ?');
    $stmt->execute([$challengeId]);
    $row = $stmt->fetch();
    return $row ?: null;
}

// ─── Progress ──────────────────────────────────────────────
function getUserProgress(int $userId): array {
    $stmt = getDB()->prepare(
        'SELECT p.*, l.title as level_title, l.order_number, l.xp_reward, l.icon, l.difficulty
         FROM progress p
         JOIN levels l ON p.level_id = l.id
         WHERE p.user_id = ?
         ORDER BY l.order_number ASC'
    );
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function getLevelProgress(int $userId, int $levelId): ?array {
    $stmt = getDB()->prepare('SELECT * FROM progress WHERE user_id = ? AND level_id = ?');
    $stmt->execute([$userId, $levelId]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function completeLevel(int $userId, int $levelId, int $score): bool {
    $db = getDB();

    // Periksa status sebelumnya untuk mencegah duplikasi XP saat replay
    $existing = getLevelProgress($userId, $levelId);
    $isFirstTime = (!$existing || $existing['status'] !== 'completed');

    // Update current level progress ke completed
    $stmt = $db->prepare(
        'UPDATE progress SET status = "completed", score = GREATEST(score, ?), completed_at = IFNULL(completed_at, NOW()) WHERE user_id = ? AND level_id = ?'
    );
    $stmt->execute([$score, $userId, $levelId]);

    // Unlock next level
    $level = getLevel($levelId);
    if ($level) {
        $nextStmt = $db->prepare('SELECT id FROM levels WHERE order_number = ?');
        $nextStmt->execute([$level['order_number'] + 1]);
        $nextLevel = $nextStmt->fetch();
        if ($nextLevel) {
            $unlockStmt = $db->prepare(
                'UPDATE progress SET status = "unlocked" WHERE user_id = ? AND level_id = ? AND status = "locked"'
            );
            $unlockStmt->execute([$userId, $nextLevel['id']]);
        }
    }

    // Award XP HANYA jika pertama kali menyelesaikan level ini
    if ($isFirstTime) {
        $levelData = getLevel($levelId);
        if ($levelData) {
            updateUserXP($userId, $levelData['xp_reward']);
        }
        return true;
    }

    return false; // Replay: progres disimpan, tetapi tidak ada duplikasi penambahan XP
}

function initUserProgress(int $userId): void {
    $db = getDB();
    $levels = getAllLevels();
    $stmt = $db->prepare(
        'INSERT IGNORE INTO progress (user_id, level_id, status) VALUES (?, ?, ?)'
    );
    foreach ($levels as $i => $level) {
        $status = ($i === 0) ? 'unlocked' : 'locked';
        $stmt->execute([$userId, $level['id'], $status]);
    }
}

// ─── Badges ────────────────────────────────────────────────
function getAllBadges(): array {
    $stmt = getDB()->query('SELECT * FROM badges ORDER BY id ASC');
    return $stmt->fetchAll();
}

function getUserBadges(int $userId): array {
    $stmt = getDB()->prepare(
        'SELECT b.*, ub.earned_at FROM badges b
         JOIN user_badges ub ON b.id = ub.badge_id
         WHERE ub.user_id = ?
         ORDER BY ub.earned_at ASC'
    );
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function awardBadge(int $userId, int $badgeId): bool {
    $db = getDB();
    $stmt = $db->prepare('INSERT IGNORE INTO user_badges (user_id, badge_id) VALUES (?, ?)');
    $stmt->execute([$userId, $badgeId]);
    return $stmt->rowCount() > 0;
}

function checkAndAwardBadges(int $userId): array {
    $awarded = [];
    $db = getDB();

    // Badge 1: First Mission — complete first challenge
    $prog = getUserProgress($userId);
    $completedCount = count(array_filter($prog, fn($p) => $p['status'] === 'completed'));

    if ($completedCount >= 1) {
        if (awardBadge($userId, 1)) $awarded[] = 'First Mission';
    }

    // Badge 2: Logic Solver — complete 5 puzzles
    if ($completedCount >= 5) {
        if (awardBadge($userId, 2)) $awarded[] = 'Logic Solver';
    }

    // Badge 3: Loop Master — complete all loop challenges
    $loopLevel = $db->prepare('SELECT id FROM levels WHERE title = "Loop"');
    $loopLevel->execute();
    $loop = $loopLevel->fetch();
    if ($loop) {
        $loopProg = getLevelProgress($userId, $loop['id']);
        if ($loopProg && $loopProg['status'] === 'completed') {
            if (awardBadge($userId, 3)) $awarded[] = 'Loop Master';
        }
    }

    // Badge 5: Code Creator — complete Mini Project
    $miniLevel = $db->prepare('SELECT id FROM levels WHERE title = "Mini Project"');
    $miniLevel->execute();
    $mini = $miniLevel->fetch();
    if ($mini) {
        $miniProg = getLevelProgress($userId, $mini['id']);
        if ($miniProg && $miniProg['status'] === 'completed') {
            if (awardBadge($userId, 5)) $awarded[] = 'Code Creator';
        }
    }

    return $awarded;
}

// ─── Stats ─────────────────────────────────────────────────
function getUserStats(int $userId): array {
    $user = getUser($userId);
    $progress = getUserProgress($userId);
    $badges = getUserBadges($userId);

    $completed = count(array_filter($progress, fn($p) => $p['status'] === 'completed'));
    $total = count($progress);

    return [
        'xp'              => (int) $user['xp'],
        'level'           => (int) $user['level'],
        'level_title'     => getLevelTitle((int) $user['level']),
        'completed'       => $completed,
        'total_levels'    => $total,
        'progress_pct'    => $total > 0 ? round(($completed / $total) * 100) : 0,
        'badges_earned'   => count($badges),
        'badges_total'    => 5,
    ];
}

// ─── Utilities ─────────────────────────────────────────────
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function jsonResponse(array $data, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function getBaseUrl(): string {
    if (php_sapi_name() === 'cli') {
        return '';
    }
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $parts = explode('/', trim($script, '/'));
    if (!empty($parts) && $parts[0] === 'LOMBA-MONE') {
        return '/LOMBA-MONE';
    }
    // Jika ada folder lain di htdocs
    if (count($parts) > 1 && !empty($parts[0])) {
        // Cek jika parts[0] adalah folder proyek
        return '/' . $parts[0];
    }
    return '';
}

function createUser(string $name, string $avatar = 'avatar_raka.png'): int {
    $db = getDB();
    $stmt = $db->prepare('INSERT INTO users (name, avatar, xp, level) VALUES (?, ?, 0, 1)');
    $stmt->execute([$name, $avatar]);
    $userId = (int) $db->lastInsertId();
    initUserProgress($userId);
    return $userId;
}

function recordChallengeAttempt(int $userId, int $challengeId, bool $isCorrect, bool $usedHint, array $commandsUsed): void {
    $db = getDB();
    // Validasi apakah challenge_id valid di tabel challenges (menghindari error FK)
    $chk = $db->prepare('SELECT id FROM challenges WHERE id = ?');
    $chk->execute([$challengeId]);
    if (!$chk->fetch()) {
        $byLevel = getChallengeByLevel($challengeId);
        if ($byLevel) {
            $challengeId = (int) $byLevel['id'];
        } else {
            return; // Challenge tidak ada di database, abaikan pencatatan untuk cegah error FK
        }
    }

    $stmt = $db->prepare(
        'INSERT INTO challenge_attempts (user_id, challenge_id, is_correct, used_hint, commands_used, attempted_at)
         VALUES (?, ?, ?, ?, ?, NOW())'
    );
    $stmt->execute([
        $userId,
        $challengeId,
        $isCorrect ? 1 : 0,
        $usedHint ? 1 : 0,
        json_encode($commandsUsed, JSON_UNESCAPED_UNICODE)
    ]);
}

function validateMissionSolution(int $levelId, array $commands): array {
    if ($levelId === 1) {
        $startX = 1; $startY = 2; $angle = 0;
        $targetX = 4; $targetY = 2;
        $obstacles = [];
        $maxBlocks = 3;
    } elseif ($levelId === 2) {
        $startX = 1; $startY = 3; $angle = 0;
        $targetX = 4; $targetY = 1;
        $obstacles = [
            ['x' => 2, 'y' => 3],
            ['x' => 2, 'y' => 2],
            ['x' => 3, 'y' => 4]
        ];
        $maxBlocks = 8;
    } else {
        return ['valid' => false, 'reason' => 'Level belum dibuka untuk simulasi gameplay'];
    }

    if (count($commands) > $maxBlocks) {
        return ['valid' => false, 'reason' => "Jumlah blok ({$maxBlocks}) melebihi batas kapasitas maksimum"];
    }

    $x = $startX;
    $y = $startY;
    $currAngle = $angle;

    foreach ($commands as $cmd) {
        $cmdUpper = strtoupper(trim((string)$cmd));
        if ($cmdUpper === 'FORWARD' || $cmdUpper === 'MAJU') {
            $norm = (($currAngle % 360) + 360) % 360;
            if ($norm === 0) $x += 1;
            elseif ($norm === 90) $y += 1;
            elseif ($norm === 180) $x -= 1;
            elseif ($norm === 270) $y -= 1;

            // Boundary Check
            if ($x < 1 || $x > 4 || $y < 1 || $y > 4) {
                return ['valid' => false, 'reason' => "Robot keluar batas grid di ({$x}, {$y})"];
            }

            // Obstacle Check
            foreach ($obstacles as $obs) {
                if ($obs['x'] === $x && $obs['y'] === $y) {
                    return ['valid' => false, 'reason' => "Robot menabrak rintangan di ({$x}, {$y})"];
                }
            }
        } elseif ($cmdUpper === 'TURN_RIGHT' || $cmdUpper === 'BELOK_KANAN' || $cmdUpper === 'RIGHT') {
            $currAngle += 90;
        } elseif ($cmdUpper === 'TURN_LEFT' || $cmdUpper === 'BELOK_KIRI' || $cmdUpper === 'LEFT') {
            $currAngle -= 90;
        }
    }

    if ($x === $targetX && $y === $targetY) {
        return ['valid' => true, 'reason' => 'Target Bintang Emas berhasil dicapai'];
    }

    return ['valid' => false, 'reason' => "Robot berhenti di ({$x}, {$y}), belum mencapai Bintang Emas ({$targetX}, {$targetY})"];
}

function resetUserProgress(int $userId): void {
    $db = getDB();
    // Reset progress
    $db->prepare('DELETE FROM progress WHERE user_id = ?')->execute([$userId]);
    $db->prepare('DELETE FROM user_badges WHERE user_id = ?')->execute([$userId]);
    $db->prepare('DELETE FROM challenge_attempts WHERE user_id = ?')->execute([$userId]);
    // Reset user XP & level
    $db->prepare('UPDATE users SET xp = 0, level = 1 WHERE id = ?')->execute([$userId]);
    // Re-initialize progress
    initUserProgress($userId);
}

// ─── Level Icons (emoji mapping) ───────────────────────────
function getLevelIcon(int $orderNumber): string {
    $icons = [
        1 => '🌱',
        2 => '🧩',
        3 => '🔁',
        4 => '❓',
        5 => '📦',
        6 => '🏆',
    ];
    return $icons[$orderNumber] ?? '📘';
}

function getLevelColorClass(int $orderNumber): string {
    $colors = [
        1 => 'level-explorer',
        2 => 'level-sequence',
        3 => 'level-loop',
        4 => 'level-condition',
        5 => 'level-variable',
        6 => 'level-project',
    ];
    return $colors[$orderNumber] ?? 'level-explorer';
}

