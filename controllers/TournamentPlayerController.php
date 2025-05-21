<?php

require_once __DIR__ . '/../config/db.php';

function listTournamentPlayers()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM Tournament_players");
    echo json_encode($stmt->fetchAll());
}

function getPlayersByTournament($id_tournament)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM Tournament_players WHERE id_tournaments = ?");
    $stmt->execute([$id_tournament]);
    echo json_encode($stmt->fetchAll());
}

function addPlayerToTournament()
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id_utilisateur'], $data['id_tournaments'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing id_utilisateur or id_tournaments']);
        return;
    }

    $stmt = $pdo->prepare("
        INSERT INTO Tournament_players (id_utilisateur, id_tournaments)
        VALUES (?, ?)
    ");
    $stmt->execute([$data['id_utilisateur'], $data['id_tournaments']]);

    echo json_encode(['success' => true]);
}

function removePlayerFromTournament($id_utilisateur, $id_tournament)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("
        DELETE FROM Tournament_players
        WHERE id_utilisateur = ? AND id_tournaments = ?
    ");
    $stmt->execute([$id_utilisateur, $id_tournament]);

    echo json_encode(['success' => true]);
}
