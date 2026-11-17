
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta · ValenSala</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <a class="logo" href="/">ValenSala</a>
        <a class="pill" href="/eventos">Volver a eventos</a>
    </header>
 
    <main class="main">
        <section class="card">
            <h1>Únete a ValenSala</h1>
            <p class="lead">Crea tu cuenta. La próxima noche de música te inspira.</p>
 
 
            <form method="POST" action="signin.php">
                <div class="field">
                    <label for="nombre">Nombre</label>
                    <div class="control">
                        <input type="text" id="nombre" name="nombre" required
                               value="">
                    </div>
                </div>
 
                <div class="field">
                    <label for="email">Correo electrónico</label>
                    <div class="control">
                        <input type="email" id="email" name="email" required
                               value="">
                    </div>
                </div>
 
                <div class="field">
                    <label for="telefono">Teléfono</label>
                    <div class="control">
                        <input type="tel" id="telefono" name="telefono" required
                               value="">
                    </div>
                </div>
 
                <button class="btn" type="submit">Crear cuenta</button>
            </form>
        </section>
    </main>
</body>
</html>
 