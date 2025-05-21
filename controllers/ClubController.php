<?php

require_once __DIR__ . '/../config/db.php';

function listClubs()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM Club");
    echo json_encode($stmt->fetchAll());
}

function getClub($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM Club WHERE id_club = ?");
    $stmt->execute([$id]);
    $club = $stmt->fetch();

    if ($club) {
        echo json_encode($club);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Club not found']);
    }
}

function createClub()
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['name'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing name']);
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO Club (name, adresse, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
    $stmt->execute([$data['name'], $data['adresse'] ?? null]);

    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
}

function updateClub($id)
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    $stmt = $pdo->prepare("UPDATE Club SET name = ?, adresse = ?, updated_at = NOW() WHERE id_club = ?");
    $stmt->execute([
        $data['name'] ?? null,
        $data['adresse'] ?? null,
        $id
    ]);

    echo json_encode(['success' => true]);
}

function deleteClub($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM Club WHERE id_club = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true]);
}
