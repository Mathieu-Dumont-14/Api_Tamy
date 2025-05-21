<?php
// config/db.php

function getPDO()
{
    $host = '51.159.112.229';
    $port = '5442';
    $db   = 'TamyDevBDD';
    $user = 'TamyDev';
    $pass = 'T[H+.ps75rH3t2';

    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

    try {
        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database connection failed']);
        exit;
    }
}
