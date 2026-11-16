
<?php
class Evento
{
    private $id = 0;
    private $nombre = "";
    private $descripcion = "";
    private $fecha = "";      // formato "Y-m-d H:i:s"
    private $precio = 0.0;
    private $idSala = 0;
    private $idArtista = 0;
 
    public function __construct($nombre, $descripcion, $fecha, $precio, $idSala, $idArtista, $id = 0)
    {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
        $this->precio = (float) $precio;
        $this->idSala = (int) $idSala;
        $this->idArtista = (int) $idArtista;
        $this->id = (int) $id;
    }
 
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getDescripcion() { return $this->descripcion; }
    public function getFecha() { return $this->fecha; }
    public function getPrecio() { return $this->precio; }
    public function getIdSala() { return $this->idSala; }
    public function getIdArtista() { return $this->idArtista; }
 
    public function guardar(PDO $pdo)
    {
        if ($this->nombre === "" || $this->fecha === "" || $this->precio < 0) {
            throw new InvalidArgumentException("Datos del evento no válidos.");
        }
 
        $sql = "INSERT INTO eventos (nombre, descripcion, fecha, precio, id_sala, id_artista)
                VALUES (:nombre, :descripcion, :fecha, :precio, :id_sala, :id_artista)
                RETURNING id";
        $consulta = $pdo->prepare($sql);
        $consulta->execute([
            ":nombre" => $this->nombre,
            ":descripcion" => $this->descripcion,
            ":fecha" => $this->fecha,
            ":precio" => $this->precio,
            ":id_sala" => $this->idSala,
            ":id_artista" => $this->idArtista
        ]);
        $this->id = (int) $consulta->fetchColumn();
        return $this->id;
    }
 
    private static function desdeFila($fila)
    {
        return new Evento(
            $fila["nombre"],
            $fila["descripcion"],
            $fila["fecha"],
            $fila["precio"],
            $fila["id_sala"],
            $fila["id_artista"],
            $fila["id"]
        );
    }
 
    public static function obtenerPorId(PDO $pdo, $id)
    {
        $consulta = $pdo->prepare("SELECT * FROM eventos WHERE id = :id");
        $consulta->execute([":id" => $id]);
        $fila = $consulta->fetch(PDO::FETCH_ASSOC);
        return $fila ? self::desdeFila($fila) : null;
    }
 
    public static function listar(PDO $pdo)
    {
        $eventos = [];
        $consulta = $pdo->query("SELECT * FROM eventos ORDER BY fecha");
        foreach ($consulta->fetchAll(PDO::FETCH_ASSOC) as $fila) {
            $eventos[] = self::desdeFila($fila);
        }
        return $eventos;
    }
 
    public function entradasVendidas(PDO $pdo)
    {
        $consulta = $pdo->prepare(
            "SELECT COUNT(*) FROM entradas WHERE id_evento = :id AND estado = 'valida'"
        );
        $consulta->execute([":id" => $this->id]);
        return (int) $consulta->fetchColumn();
    }
 
    public function entradasDisponibles(PDO $pdo)
    {
        $sala = Sala::obtenerPorId($pdo, $this->idSala);
        if ($sala === null) {
            return 0;
        }
        return $sala->getCapacidad() - $this->entradasVendidas($pdo);
    }
 
    public function eliminar(PDO $pdo)
    {
        $consulta = $pdo->prepare("DELETE FROM eventos WHERE id = :id");
        return $consulta->execute([":id" => $this->id]);
    }
}
 