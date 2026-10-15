<?php
/**
 * CodeQuest Kids — API: Save Challenge Progress
 */

require_once __DIR__ . '/../includes/functions.php';
initSession();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'error' => 'Method not allowed'], 405);
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    jsonResponse(['success' => false, 'error' => 'Invalid JSON input'], 400);
}

// User handling (fallback to seed user ID: 1 if guest in local development)
$userId = getCurrentUserId();
if ($userId <= 0) {
    $userId = 1;
    loginUser(1);
}

$levelId     = (int) ($input['level_id'] ?? 1);
$challengeId = (int) ($input['challenge_id'] ?? 1);
$clientCorrect = !empty($input['is_correct']);
$usedHint    = !empty($input['used_hint']);
$score       = (int) ($input['score'] ?? 50);
$commands    = is_array($input['commands'] ?? null) ? $input['commands'] : [];

try {
    // Validasi solusi secara independen di sisi server
    $val = validateMissionSolution($levelId, $commands);
    $isCorrect = $val['valid'];

    // 1. Simpan setiap percobaan ke challenge_attempts
    recordChallengeAttempt($userId, $challengeId, $isCorrect, $usedHint, $commands);

    $isFirstComplete = false;
    $badgesAwarded   = [];

    if ($isCorrect) {
        // 2. Tandai level selesai & buka level selanjutnya (XP hanya bertambah jika pertama kali)
        $isFirstComplete = completeLevel($userId, $levelId, $score);

        // 3. Cek achievement badge
        $badgesAwarded = checkAndAwardBadges($userId);
    }

    $updatedUser = getUser($userId);
    $levelData   = getLevel($levelId);
    $xpEarned    = ($isCorrect && $isFirstComplete && $levelData) ? (int)$levelData['xp_reward'] : 0;

    jsonResponse([
        'success'           => true,
        'is_correct'        => $isCorrect,
        'validation_reason' => $val['reason'],
        'is_first_complete' => $isFirstComplete,
        'xp_awarded'        => $xpEarned,
        'new_xp'            => (int) $updatedUser['xp'],
        'user_level'        => (int) $updatedUser['level'],
        'badges_awarded'    => $badgesAwarded,
    ]);
} catch (Exception $e) {
    jsonResponse([
        'success' => false,
        'error'   => $e->getMessage()
    ], 500);
}
