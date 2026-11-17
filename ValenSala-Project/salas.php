
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

      
                <p class="lead">Todavía no hay salas registradas.</p>
           
                <div class="salas-grid">
                    
                </div>
          
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

