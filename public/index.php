<?php

header('Content-Type: application/json');

// Gérer les méthodes PUT et DELETE
if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_REQUEST);
}

// Inclure le routeur
require_once __DIR__ . '/../routes/api.php';
