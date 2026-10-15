<?php
/**
 * CodeQuest Kids — API: Reset Student Progress (Testing / Replay)
 */

require_once __DIR__ . '/../includes/functions.php';
initSession();

header('Content-Type: application/json; charset=utf-8');

$userId = getCurrentUserId();
if ($userId <= 0) {
    $userId = 1;
}

try {
    resetUserProgress($userId);
    jsonResponse([
        'success' => true,
        'message' => 'Progress berhasil direset ke Level 1!'
    ]);
} catch (Exception $e) {
    jsonResponse([
        'success' => false,
        'error'   => $e->getMessage()
    ], 500);
}
