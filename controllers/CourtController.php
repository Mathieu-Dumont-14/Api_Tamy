<?php

require_once __DIR__ . '/../config/db.php';

function listCourts()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM Courts");
    echo json_encode($stmt->fetchAll());
}

function getCourt($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM Courts WHERE id_courts = ?");
    $stmt->execute([$id]);
    $court = $stmt->fetch();

    if ($court) {
        echo json_encode($court);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Court not found']);
    }
}

function createCourt()
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['name'], $data['surface_type'], $data['id_club'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }

    $stmt = $pdo->prepare("
        INSERT INTO Courts (name, surface_type, is_active, created_at, updated_at, id_club)
        VALUES (?, ?, ?, NOW(), NOW(), ?)
    ");

    $stmt->execute([
        $data['name'],
        $data['surface_type'],
        $data['is_active'] ?? true,
        $data['id_club']
    ]);

    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
}

function updateCourt($id)
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    $stmt = $pdo->prepare("
        UPDATE Courts SET 
        name = ?, surface_type = ?, is_active = ?, id_club = ?, updated_at = NOW()
        WHERE id_courts = ?
    ");

    $stmt->execute([
        $data['name'] ?? null,
        $data['surface_type'] ?? null,
        $data['is_active'] ?? true,
        $data['id_club'] ?? null,
        $id
    ]);

    echo json_encode(['success' => true]);
}

function deleteCourt($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM Courts WHERE id_courts = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true]);
}
