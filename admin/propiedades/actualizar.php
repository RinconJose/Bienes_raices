<?php

use App\Propiedad;

require '../../includes/app.php';

    estaAutenticado();

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
    }

    // Obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);

    // debuguear($propiedad);


    // Consultar la BD para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    // Arreglo con mensaje de errores
    $errores = [];

    // Creando variables para guardar el contenido de los inputs por si salen errores
    

    // Ejecutar el código después de que el usuario envía el formulario
    if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";

        $titulo = mysqli_real_escape_string( $db, $_POST['titulo'] );
        $precio = mysqli_real_escape_string( $db, $_POST['precio'] );
        $descripcion = mysqli_real_escape_string( $db, $_POST['descripcion'] );
        $habitaciones = mysqli_real_escape_string( $db, $_POST['habitaciones'] );
        $wc = mysqli_real_escape_string( $db, $_POST['wc'] );
        $estacionamiento = mysqli_real_escape_string( $db, $_POST['estacionamiento'] );
        $vendedorId = mysqli_real_escape_string( $db, $_POST['vendedor'] );
        $creado = date('Y/m/d');

        // Asignar files a una variable
        $imagen = $_FILES['imagen'];

        if( !$titulo ) {
            $errores[] = "Debes añadir un titulo";
        }

        if( !$precio ) {
            $errores[] = "El precio es obligatorio";
        }

        if( strlen($descripcion) < 50 ) {
            $errores[] = "La descripcion es obligatorio y debe tener al menos 50 caracteres";
        }

        if( !$habitaciones ) {
            $errores[] = "La cantidad de habitaciones es obligatorio";
        }

        if( !$wc ) {
            $errores[] = "La cantidad de baños es obligatorio";
        }

        if( !$estacionamiento) {
            $errores[] = "La cantidad de estacionamientos es obligatorio";
        }

        if( !$vendedorId ) {
            $errores[] = "Elige un vendedor";
        }

        // Validar por tamaño de la imagen (1mb máximo)
        $medida = 1000 * 1000;

        if($imagen['size'] > $medida) {
            $errores[] = "La imagen es muy pesada";
        }

        // echo "<pre>";
        // var_dump($errores);
        // echo "</pre>";

        // Revisar que el arreglo de errores este vacío
        if( empty($errores) ) {

            // Crear carpeta
            $carpetaImagenes = '../../imagenes/';

            if( !is_dir($carpetaImagenes) ) {
                mkdir($carpetaImagenes);
            }

            $nombreImagen = '';

            /* SUBIDA DE ARCHIVOS */
            if($imagen['name']) {
                // Eliminar Imagen previa
                unlink($carpetaImagenes . $propiedad['imagen']); //Elimina un archivo

                // Generar nombre único para las imagenes
                $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

                // Subir la imagen a la carpeta imagenes
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
            } else {
                $nombreImagen = $propiedad['imagen'];
            }

            // Insertar en la base de datos
            $query = " UPDATE propiedades SET titulo = '${titulo}', precio = '${precio}', imagen = '${nombreImagen}', descripcion = '${descripcion}', habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento}, vendedorId = ${vendedorId} WHERE id = ${id}";

            // echo $query;

            // exit;

            $resultado = mysqli_query($db, $query);

            if( $resultado ) {
                // Redireccionar al usuario
                header('Location: /admin?respuesta=2');
            }
        }



    }



    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php'; ?>

            <input type="submit" value="Actualizar propiedad" class="boton boton-verde">
        </form>
    </main>
<?php
    incluirTemplate('footer');
?>