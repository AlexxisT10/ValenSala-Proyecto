<?php
class Sala
{
    private $id = 0;
    private $nombre = "";
    private $capacidad = 0;
    private $direccion = "";
    private $ciudad = "";

    public function __construct($nombre, $capacidad, $direccion = "", $ciudad = "", $id = 0)
    {
        $this->nombre = $nombre;
        $this->capacidad = (int) $capacidad;
        $this->direccion = $direccion;
        $this->ciudad = $ciudad;
        $this->id = (int) $id;
    }

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getCapacidad() { return $this->capacidad; }
    public function getDireccion() { return $this->direccion; }
    public function getCiudad() { return $this->ciudad; }

    public function guardar(PDO $pdo)
    {
        if ($this->nombre === "" || $this->capacidad <= 0) {
            throw new InvalidArgumentException("Nombre y capacidad válidos son obligatorios.");
        }

        $sql = "INSERT INTO sala (nombre, direccion, ciudad, capacidad)
                VALUES (:nombre, :direccion, :ciudad, :capacidad)
                RETURNING id_sala";
        $consulta = $pdo->prepare($sql);
        $consulta->execute([
            ":nombre" => $this->nombre,
            ":direccion" => $this->direccion,
            ":ciudad" => $this->ciudad,
            ":capacidad" => $this->capacidad
        ]);
        $this->id = (int) $consulta->fetchColumn();
        return $this->id;
    }

    public static function obtenerPorId(PDO $pdo, $id)
    {
        $consulta = $pdo->prepare("SELECT * FROM sala WHERE id_sala = :id");
        $consulta->execute([":id" => $id]);
        $fila = $consulta->fetch(PDO::FETCH_ASSOC);

        if (!$fila) {
            return null;
        }
        return self::desdeFila($fila);
    }

    public static function insertarIniciales(PDO $pdo)
    {
        $total = (int) $pdo->query("SELECT COUNT(*) FROM sala")->fetchColumn();
        if ($total > 0) {
            return;
        }
        $salas = [
            new Sala("Sala Repvblica", 900, "Valencia", "Valencia"),
            new Sala("Sala Moon", 500, "Valencia", "Valencia")
        ];
        foreach ($salas as $sala) {
            $sala->guardar($pdo);
        }
    }

    public static function listar(PDO $pdo)
    {
        $salas = [];
        $consulta = $pdo->query("SELECT * FROM sala ORDER BY nombre");
        foreach ($consulta->fetchAll(PDO::FETCH_ASSOC) as $fila) {
            $salas[] = self::desdeFila($fila);
        }
        return $salas;
    }

    public function eliminar(PDO $pdo)
    {
        $consulta = $pdo->prepare("DELETE FROM sala WHERE id_sala = :id");
        return $consulta->execute([":id" => $this->id]);
    }

    private static function desdeFila($fila)
    {
        return new Sala($fila["nombre"], $fila["capacidad"], $fila["direccion"], $fila["ciudad"], $fila["id_sala"]);
    }
}
