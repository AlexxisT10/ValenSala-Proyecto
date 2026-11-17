
<?php
require_once "conexion.php";

class Usuario
{
    private $id = 0;
    private $nombre;
    private $email;
    private $telefono;
    private $fechaRegistro;

    public function __construct($nombre, $email, $telefono, $fechaRegistro = null)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->fechaRegistro = $fechaRegistro;
    }

    
public function registrar(PDO $pdo)
{
    if (
        trim($this->nombre) === "" ||
        !filter_var($this->email, FILTER_VALIDATE_EMAIL) ||
        trim($this->telefono) === ""
    ) {
        throw new InvalidArgumentException("Introduce datos válidos.");
    }

    $sql = "INSERT INTO usuario (nombre, email, telefono, fecha_registro)
            VALUES (:nombre, :email, :telefono, CURRENT_DATE)";

    $consulta = $pdo->prepare($sql);

    $consulta->execute([
        ":nombre" => $this->nombre,
        ":email" => $this->email,
        ":telefono" => $this->telefono
    ]);

    return true;
}

}
?>