<?php

require_once __DIR__ . '/../config/db.php';

function listRoles()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM Role");
    echo json_encode($stmt->fetchAll());
}

function getRole($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM Role WHERE id_role = ?");
    $stmt->execute([$id]);
    $role = $stmt->fetch();

    if ($role) {
        echo json_encode($role);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Role not found']);
    }
}

function createRole()
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['name'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing role name']);
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO Role (name) VALUES (?)");
    $stmt->execute([$data['name']]);

    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
}

function updateRole($id)
{
    $pdo = getPDO();
    $data = json_decode(file_get_contents('php://input'), true);

    $stmt = $pdo->prepare("UPDATE Role SET name = ? WHERE id_role = ?");
    $stmt->execute([
        $data['name'] ?? null,
        $id
    ]);

    echo json_encode(['success' => true]);
}

function deleteRole($id)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM Role WHERE id_role = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true]);
}
