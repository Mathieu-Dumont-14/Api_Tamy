<?php

require_once __DIR__ . '/../config/db.php';

function listReservations()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM Reservation");
    echo json_encode($stmt->fetchAll());
}

function getReservation($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM Reservation WHERE id_reservation = ?");
    $stmt->execute([$id]);
    $reservation = $stmt->fetch();

    if ($reservation) {
        echo json_encode($reservation);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Reservation not found']);
    }
}

function createReservation()
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id_slots'], $data['status'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing id_slots or status']);
        return;
    }

    $stmt = $pdo->prepare("
        INSERT INTO Reservation (status, created_at, updated_at, id_slots)
        VALUES (?, NOW(), NOW(), ?)
    ");

    $stmt->execute([
        $data['status'],
        $data['id_slots']
    ]);

    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
}

function updateReservation($id)
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    $stmt = $pdo->prepare("
        UPDATE Reservation SET 
        status = ?, id_slots = ?, updated_at = NOW()
        WHERE id_reservation = ?
    ");

    $stmt->execute([
        $data['status'] ?? null,
        $data['id_slots'] ?? null,
        $id
    ]);

    echo json_encode(['success' => true]);
}

function deleteReservation($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM Reservation WHERE id_reservation = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true]);
}
