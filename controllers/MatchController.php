<?php

require_once __DIR__ . '/../config/db.php';

function listMatches()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM Matches");
    echo json_encode($stmt->fetchAll());
}

function getMatch($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM Matches WHERE id_matches = ?");
    $stmt->execute([$id]);
    $match = $stmt->fetch();

    if ($match) {
        echo json_encode($match);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Match not found']);
    }
}

function createMatch()
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['round'], $data['id_slots'], $data['id_tournaments'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }

    $stmt = $pdo->prepare("
        INSERT INTO Matches (round, player_1, player_2, score, winner_id, id_slots, id_tournaments)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $data['round'],
        $data['player_1'] ?? null,
        $data['player_2'] ?? null,
        $data['score'] ?? null,
        $data['winner_id'] ?? null,
        $data['id_slots'],
        $data['id_tournaments']
    ]);

    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
}

function updateMatch($id)
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    $stmt = $pdo->prepare("
        UPDATE Matches SET 
        round = ?, player_1 = ?, player_2 = ?, score = ?, winner_id = ?, id_slots = ?, id_tournaments = ?
        WHERE id_matches = ?
    ");

    $stmt->execute([
        $data['round'] ?? null,
        $data['player_1'] ?? null,
        $data['player_2'] ?? null,
        $data['score'] ?? null,
        $data['winner_id'] ?? null,
        $data['id_slots'] ?? null,
        $data['id_tournaments'] ?? null,
        $id
    ]);

    echo json_encode(['success' => true]);
}

function deleteMatch($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM Matches WHERE id_matches = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true]);
}
