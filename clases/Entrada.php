
<?php
class Sala
{
    private $id = 0;
    private $nombre = "";
    private $capacidad = 0;
    private $ubicacion = "";
 
    public function __construct($nombre, $capacidad, $ubicacion = "", $id = 0)
    {
        $this->nombre = $nombre;
        $this->capacidad = (int) $capacidad;
        $this->ubicacion = $ubicacion;
        $this->id = (int) $id;
    }
 
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getCapacidad() { return $this->capacidad; }
    public function getUbicacion() { return $this->ubicacion; }
 
    public function guardar(PDO $pdo)
    {
        if ($this->nombre === "" || $this->capacidad <= 0) {
            throw new InvalidArgumentException("Nombre y capacidad válidos son obligatorios.");
        }
 
        $sql = "INSERT INTO salas (nombre, capacidad, ubicacion)
                VALUES (:nombre, :capacidad, :ubicacion)
                RETURNING id";
        $consulta = $pdo->prepare($sql);
        $consulta->execute([
            ":nombre" => $this->nombre,
            ":capacidad" => $this->capacidad,
            ":ubicacion" => $this->ubicacion
        ]);
        $this->id = (int) $consulta->fetchColumn();
        return $this->id;
    }
 
    public static function obtenerPorId(PDO $pdo, $id)
    {
        $consulta = $pdo->prepare("SELECT * FROM salas WHERE id = :id");
        $consulta->execute([":id" => $id]);
        $fila = $consulta->fetch(PDO::FETCH_ASSOC);
 
        if (!$fila) {
            return null;
        }
        return new Sala($fila["nombre"], $fila["capacidad"], $fila["ubicacion"], $fila["id"]);
    }
 
    public static function listar(PDO $pdo)
    {
        $salas = [];
        $consulta = $pdo->query("SELECT * FROM salas ORDER BY nombre");
        foreach ($consulta->fetchAll(PDO::FETCH_ASSOC) as $fila) {
            $salas[] = new Sala($fila["nombre"], $fila["capacidad"], $fila["ubicacion"], $fila["id"]);
        }
        return $salas;
    }
 
    public function eliminar(PDO $pdo)
    {
        $consulta = $pdo->prepare("DELETE FROM salas WHERE id = :id");
        return $consulta->execute([":id" => $this->id]);
    }
}
 