<?php

require_once __DIR__ . '/../config/db.php';

function listBadges()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM Badges");
    echo json_encode($stmt->fetchAll());
}

function getBadge($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM Badges WHERE id_badges = ?");
    $stmt->execute([$id]);
    $badge = $stmt->fetch();

    if ($badge) {
        echo json_encode($badge);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Badge not found']);
    }
}

function createBadge()
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['name'], $data['description'], $data['icon'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }

    $stmt = $pdo->prepare("
        INSERT INTO Badges (name, description, icon)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([
        $data['name'],
        $data['description'],
        $data['icon']
    ]);

    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
}

function updateBadge($id)
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    $stmt = $pdo->prepare("
        UPDATE Badges SET name = ?, description = ?, icon = ?
        WHERE id_badges = ?
    ");

    $stmt->execute([
        $data['name'] ?? null,
        $data['description'] ?? null,
        $data['icon'] ?? null,
        $id
    ]);

    echo json_encode(['success' => true]);
}

function deleteBadge($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM Badges WHERE id_badges = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true]);
}
