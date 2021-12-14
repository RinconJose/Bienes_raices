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
        $this->imagen = $args['imagen'] ?? 'imagen.jpg';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d') ?? '';
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    public function guardar() {

        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = "INSERT INTO propiedades ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);

        debuguear($resultado);
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

        if( strlen(!$this->descripcion) < 50 ) {
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

        // if( !$this->imagen['name'] || $this->imagen['error'] ) {
        //     $errores[] = "La imagen es obligatoria";
        // }

        // // Validar por tamaño de la imagen (1mb máximo)
        // $medida = 1000 * 1000;

        // if($this->imagen['size'] > $this->medida) {
        //     $errores[] = "La imagen es muy pesada";
        // }
        
        return self::$errores;
    }
}