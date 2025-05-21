<?php

require_once __DIR__ . '/../config/db.php';

function listReservationUsers()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM Reservation_utilisateur");
    echo json_encode($stmt->fetchAll());
}

function getReservationUsers($id_reservation)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM Reservation_utilisateur WHERE id_reservation = ?");
    $stmt->execute([$id_reservation]);
    echo json_encode($stmt->fetchAll());
}

function addReservationUser()
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id_utilisateur'], $data['id_reservation'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }

    $stmt = $pdo->prepare("
        INSERT INTO Reservation_utilisateur (id_utilisateur, id_reservation)
        VALUES (?, ?)
    ");

    $stmt->execute([
        $data['id_utilisateur'],
        $data['id_reservation']
    ]);

    echo json_encode(['success' => true]);
}

function deleteReservationUser($id_utilisateur, $id_reservation)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("
        DELETE FROM Reservation_utilisateur 
        WHERE id_utilisateur = ? AND id_reservation = ?
    ");

    $stmt->execute([$id_utilisateur, $id_reservation]);

    echo json_encode(['success' => true]);
}
