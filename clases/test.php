<?php
require_once "conexion.php";
$pdo = conectar();
echo "Conectado: " . $pdo->query("SELECT version()")->fetchColumn();