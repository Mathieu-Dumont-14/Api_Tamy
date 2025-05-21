<?php

require_once __DIR__ . '/../config/db.php';

function listPlayerStats()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM Player_stats");
    echo json_encode($stmt->fetchAll());
}

function getPlayerStats($id_utilisateur)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM Player_stats WHERE id_utilisateur = ?");
    $stmt->execute([$id_utilisateur]);
    $stats = $stmt->fetch();

    if ($stats) {
        echo json_encode($stats);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Stats not found']);
    }
}

function createOrUpdatePlayerStats()
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id_utilisateur'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing id_utilisateur']);
        return;
    }

    $stmt = $pdo->prepare("SELECT * FROM Player_stats WHERE id_utilisateur = ?");
    $stmt->execute([$data['id_utilisateur']]);
    $exists = $stmt->fetch();

    if ($exists) {
        $stmt = $pdo->prepare("
            UPDATE Player_stats
            SET total_matches = ?, total_wins = ?, total_looses = ?, total_reservations = ?
            WHERE id_utilisateur = ?
        ");
        $stmt->execute([
            $data['total_matches'] ?? 0,
            $data['total_wins'] ?? 0,
            $data['total_looses'] ?? 0,
            $data['total_reservations'] ?? 0,
            $data['id_utilisateur']
        ]);
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO Player_stats (id_utilisateur, total_matches, total_wins, total_looses, total_reservations)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['id_utilisateur'],
            $data['total_matches'] ?? 0,
            $data['total_wins'] ?? 0,
            $data['total_looses'] ?? 0,
            $data['total_reservations'] ?? 0
        ]);
    }

    echo json_encode(['success' => true]);
}
