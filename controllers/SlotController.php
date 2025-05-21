<?php

require_once __DIR__ . '/../config/db.php';

function listSlots()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM Slots");
    echo json_encode($stmt->fetchAll());
}

function getSlot($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM Slots WHERE id_slots = ?");
    $stmt->execute([$id]);
    $slot = $stmt->fetch();

    if ($slot) {
        echo json_encode($slot);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Slot not found']);
    }
}

function createSlot()
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['start_time'], $data['end_time'], $data['max_players'], $data['id_courts'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }

    $stmt = $pdo->prepare("
        INSERT INTO Slots (start_time, end_time, max_players, created_at, updated_at, id_courts)
        VALUES (?, ?, ?, NOW(), NOW(), ?)
    ");

    $stmt->execute([
        $data['start_time'],
        $data['end_time'],
        $data['max_players'],
        $data['id_courts']
    ]);

    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
}

function updateSlot($id)
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    $stmt = $pdo->prepare("
        UPDATE Slots SET 
        start_time = ?, end_time = ?, max_players = ?, id_courts = ?, updated_at = NOW()
        WHERE id_slots = ?
    ");

    $stmt->execute([
        $data['start_time'] ?? null,
        $data['end_time'] ?? null,
        $data['max_players'] ?? null,
        $data['id_courts'] ?? null,
        $id
    ]);

    echo json_encode(['success' => true]);
}

function deleteSlot($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM Slots WHERE id_slots = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true]);
}
