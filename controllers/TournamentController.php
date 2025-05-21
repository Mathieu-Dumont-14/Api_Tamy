<?php

require_once __DIR__ . '/../config/db.php';

function listTournaments()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM Tournaments");
    echo json_encode($stmt->fetchAll());
}

function getTournament($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM Tournaments WHERE id_tournaments = ?");
    $stmt->execute([$id]);
    $tournament = $stmt->fetch();

    if ($tournament) {
        echo json_encode($tournament);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Tournament not found']);
    }
}

function createTournament()
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['name'], $data['id_club'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing name or id_club']);
        return;
    }

    $stmt = $pdo->prepare("
        INSERT INTO Tournaments (id_club, name, description, start_date, end_date, type_tournois, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
    ");

    $stmt->execute([
        $data['id_club'],
        $data['name'],
        $data['description'] ?? null,
        $data['start_date'] ?? null,
        $data['end_date'] ?? null,
        $data['type_tournois'] ?? null,
    ]);

    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
}

function updateTournament($id)
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    $stmt = $pdo->prepare("
        UPDATE Tournaments SET 
        id_club = ?, name = ?, description = ?, start_date = ?, end_date = ?, type_tournois = ?, updated_at = NOW()
        WHERE id_tournaments = ?
    ");

    $stmt->execute([
        $data['id_club'] ?? null,
        $data['name'] ?? null,
        $data['description'] ?? null,
        $data['start_date'] ?? null,
        $data['end_date'] ?? null,
        $data['type_tournois'] ?? null,
        $id
    ]);

    echo json_encode(['success' => true]);
}

function deleteTournament($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM Tournaments WHERE id_tournaments = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true]);
}
