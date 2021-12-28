<?php

namespace App;

class Propiedad {

    // Base de datos
    protected static $db;
    protected static $columnaDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

    // Errores ó Validación
    protected static $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    // Definir la conexión a la BD
    public static function setDB($database) {
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d') ?? '';
        $this->vendedorId = $args['vendedorId'] ?? 1;
    }

    public function guardar() {
        if( isset($this->id) ) {
            //actualizar
            $this->actualizar();
        } else {
            // Creando un nuevo registro
            $this->crear();
        }
    }

    public function crear() {

        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = "INSERT INTO propiedades ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);

        return $resultado;
    }

    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach( $atributos as $key => $value ) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE propiedades SET ";
        $query .= join(', ', $valores); 
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";

        $resultado = self::$db->query($query);
        
        if( $resultado ) {
            // Redireccionar al usuario
            header('Location: /admin?respuesta=2');
        }
        return $resultado;

    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(self::$columnaDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizando = [];

        foreach ($atributos as $key => $value) {
            $sanitizando[$key] = self::$db->escape_string($value);
        }
        return $sanitizando;
    }

    // Subida de archivos
    public function setImagen($imagen) {
        // Elimina la imagen previa
        if( isset( $this->id )) {
            // Comprobar si existe el archivo
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);

            if( $existeArchivo ) {
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }

        // Asignar al atributo de imagen el nombre de la imagen
        if($imagen) {
            $this->imagen = $imagen;
        }
    }


    // Validación
    public static function getErrores() {
        return self::$errores;
    }

    public function validar() {
        if( !$this->titulo ) {
            self::$errores[] = "Debes añadir un titulo";
        }

        if( !$this->precio ) {
            self::$errores[] = "El precio es obligatorio";
        }

        if( strlen( $this->descripcion ) < 50 ) {
            self::$errores[] = "La descripcion es obligatorio y debe tener al menos 50 caracteres";
        }

        if( !$this->habitaciones ) {
            self::$errores[] = "La cantidad de habitaciones es obligatorio";
        }

        if( !$this->wc ) {
            self::$errores[] = "La cantidad de baños es obligatorio";
        }

        if( !$this->estacionamiento) {
            self::$errores[] = "La cantidad de estacionamientos es obligatorio";
        }

        if( !$this->vendedorId ) {
            self::$errores[] = "Elige un vendedor";
        }

        if( !$this->imagen ) {
            self::$errores[] = "La imagen es obligatoria";
        }

        return self::$errores;
    }

    // Lista todos los registros
    public static function all() {
        $query = "SELECT * FROM propiedades";

        $resultado = self::consultarSQL($query);

        return $resultado;

    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM propiedades WHERE id = ${id}";

        $resultado = self::consultarSQL($query);

        return array_shift( $resultado );
    }

    public static function consultarSQL($query) {
        // Consultar DB
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }

        //Liberar la memoria
        $resultado->free();

        //Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new self;

        foreach( $registro as $key => $value ) {
            if( property_exists( $objeto, $key ) ) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Sincronizar el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar( $args = [] ) {
        foreach( $args as $key => $value ) {
            if( property_exists($this, $key) && !is_null(($value)) ) {
                $this->$key = $value;
            }
        }
    }

}