
<?php
$dir = is_dir(__DIR__ . "/clases") ? __DIR__ . "/clases/" : __DIR__ . "/";
require_once $dir . "conexion.php";
require_once $dir . "Usuario.php";
 
$mensaje  = "";
$nombre   = "";
$email    = "";
$telefono = "";
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre   = trim($_POST["nombre"] ?? "");
    $email    = trim($_POST["email"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
 
    try {
        $pdo = conectar();
 
        $usuario = new Usuario($nombre, $email, $telefono);
        $usuario->registrar($pdo);
 
        session_start();
        $_SESSION["nombre"] = $nombre;
        header("Location: salas.php");
        exit;
 
    } catch (PDOException $e) {
        if ($e->getCode() === "23505") {
            $mensaje = "Ese email ya está registrado.";
        } else {
            $mensaje = "Error de base de datos: " . $e->getMessage();
        }
    } catch (Exception $e) {
        $mensaje = $e->getMessage();
    }
}
?>
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
 
            <?php if ($mensaje !== ""): ?>
                <p class="error"><?= htmlspecialchars($mensaje) ?></p>
            <?php endif; ?>
 
            <form method="POST" action="signin.php">
                <div class="field">
                    <label for="nombre">Nombre</label>
                    <div class="control">
                        <input type="text" id="nombre" name="nombre" required
                               value="<?= htmlspecialchars($nombre) ?>">
                    </div>
                </div>
 
                <div class="field">
                    <label for="email">Correo electrónico</label>
                    <div class="control">
                        <input type="email" id="email" name="email" required
                               value="<?= htmlspecialchars($email) ?>">
                    </div>
                </div>
 
                <div class="field">
                    <label for="telefono">Teléfono</label>
                    <div class="control">
                        <input type="tel" id="telefono" name="telefono" required
                               value="<?= htmlspecialchars($telefono) ?>">
                    </div>
                </div>
 
                <button class="btn" type="submit">Crear cuenta</button>
            </form>
        </section>
    </main>
</body>
</html>
 