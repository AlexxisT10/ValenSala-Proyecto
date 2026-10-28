<?php
    class Usuario
    {
       private $id = 0;
       private $nombre = "";
       private $email = "";
       private $password = "";
       private $rol = "";
       private $contadorUsuarios = 0;
       
       public function __construct($nombre,$email,$password,$rol)
       {
            $this->nombre = $nombre;
            $this->email = $email;
            $this->password = $password;
            $this->rol = $rol;
            this->id = $contadorUsuarios;
            $contadorUsuarios++;
       }

        public function registrar($nombre, $email,$password,$rol)
        {
            $usuario = new  Usuario($nombre,$email,$password,$rol);

            if ($_SERVER["REQUEST_METHOD"] === "POST") 
            {

                $nombre = trim($_POST["nombre"] ?? "");
                $email = trim($_POST["email"] ?? "");
                $password = $_POST["password"] ?? "";

                if ($nombre === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)
                || $password === "") 
                {
                    die("Introduce datos válidos.");
                }
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                try {
                        $sql = "INSERT INTO usuarios (nombre, email, password)
                                VALUES (:nombre, :email, :password)";
                        $consulta = $conexion->prepare($sql);

                        $consulta->execute
                        ([
                            ":nombre" => $nombre,
                            ":email" => $email,
                            ":password" => $passwordHash
                        ]);
                        echo "¡Usuario registrado correctamente!";
                    } catch (PDOException $e) {
                        if ($e->getCode() === "23000") 
                        {
                            echo "Ese correo ya está registrado.";
                        } else 
                        {
                            echo "No se ha podido registrar el usuario.";
                        }
                    }
            }

        }
        public function boolean esAdministrador($rol)
        {
            if($rol == "Admin")
                {
                    return true;
                }
                return false;

        }
        public function boolean esArtista($rol)
        {
            if($rol == "Artista")
            {
                return true;
            }
            return false;
        }
        public function iniciarSesion()
        {
              
        }

    }
?>