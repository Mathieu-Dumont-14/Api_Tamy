<?php

require_once __DIR__ . '/../config/db.php';

function listUserBadges()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM user_badges");
    echo json_encode($stmt->fetchAll());
}

function getBadgesByUser($id_utilisateur)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM user_badges WHERE id_utilisateur = ?");
    $stmt->execute([$id_utilisateur]);
    echo json_encode($stmt->fetchAll());
}

function assignBadgeToUser()
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id_utilisateur'], $data['id_badges'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }

    $stmt = $pdo->prepare("
        INSERT INTO user_badges (id_utilisateur, id_badges, earned_at)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $data['id_utilisateur'],
        $data['id_badges'],
        $data['earned_at'] ?? date('Y-m-d H:i:s')
    ]);

    echo json_encode(['success' => true]);
}

function removeBadgeFromUser($id_utilisateur, $id_badges)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("
        DELETE FROM user_badges
        WHERE id_utilisateur = ? AND id_badges = ?
    ");
    $stmt->execute([$id_utilisateur, $id_badges]);

    echo json_encode(['success' => true]);
}
