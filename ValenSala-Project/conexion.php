<?php
function conectar()
{
    $host = "192.168.67.229";   // IP de la VM
    $port = "5432";
    $db   = "ValenSala_DB";
    $user = "postgres";
    $pass = "1234";

    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
