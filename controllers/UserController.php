<?php

require_once __DIR__ . '/../config/db.php';

function listUsers()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM Utilisateur");
    echo json_encode($stmt->fetchAll());
}

function getUser($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE id_utilisateur = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if ($user) {
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
    }
}

function createUser()
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['name'], $data['email'], $data['password'], $data['id_role'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }

    $stmt = $pdo->prepare("
        INSERT INTO Utilisateur (name, email, password, created_at, updated_at, is_verified, last_login, id_role)
        VALUES (?, ?, ?, NOW(), NOW(), ?, ?, ?)
    ");

    $stmt->execute([
        $data['name'],
        $data['email'],
        password_hash($data['password'], PASSWORD_DEFAULT),
        $data['is_verified'] ?? false,
        $data['last_login'] ?? null,
        $data['id_role']
    ]);

    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
}

function updateUser($id)
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    $stmt = $pdo->prepare("
        UPDATE Utilisateur SET 
        name = ?, email = ?, password = ?, is_verified = ?, last_login = ?, id_role = ?, updated_at = NOW()
        WHERE id_utilisateur = ?
    ");

    $stmt->execute([
        $data['name'] ?? null,
        $data['email'] ?? null,
        isset($data['password']) ? password_hash($data['password'], PASSWORD_DEFAULT) : null,
        $data['is_verified'] ?? false,
        $data['last_login'] ?? null,
        $data['id_role'] ?? null,
        $id
    ]);

    echo json_encode(['success' => true]);
}

function deleteUser($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM Utilisateur WHERE id_utilisateur = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true]);
}
