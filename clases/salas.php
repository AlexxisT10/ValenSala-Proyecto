<?php
session_start();
$dir = is_dir(__DIR__ . "/clases") ? __DIR__ . "/clases/" : __DIR__ . "/";
require_once $dir . "conexion.php";
require_once $dir . "Sala.php";

$nombre = $_SESSION["nombre"] ?? "";
$pdo    = conectar();
Sala::insertarIniciales($pdo);
$salas  = Sala::listar($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salas · ValenSala</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <a class="logo" href="/">ValenSala</a>
        <a class="pill" href="/eventos">Volver a Inicio</a>
    </header>

    <main class="main main--top">
        <section class="salas">
            <h1><?= $nombre !== "" ? "Bienvenido, " . htmlspecialchars($nombre) : "Salas" ?></h1>
            <p class="lead">Estas son las salas de Valencia donde vive la música en directo.</p>

            <?php if (count($salas) === 0): ?>
                <p class="lead">Todavía no hay salas registradas.</p>
            <?php else: ?>
                <div class="salas-grid">
                    <?php foreach ($salas as $sala): ?>
                        <article class="sala-card">
                            <h2><?= htmlspecialchars($sala->getNombre()) ?></h2>
                            <p><?= htmlspecialchars($sala->getDireccion()) ?>, <?= htmlspecialchars($sala->getCiudad()) ?></p>
                            <span class="sala-aforo">Aforo: <?= $sala->getCapacidad() ?></span>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer class="footer">
        <strong>ValenSala · Tu próxima noche empieza aquí.</strong>
        <nav>
            <a href="/privacidad">Privacidad</a>
            <a href="/ayuda">¿Necesitas ayuda?</a>
        </nav>
    </footer>
</body>
</html>

