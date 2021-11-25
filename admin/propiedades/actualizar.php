<?php

    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if( !$auth ) {
        header('location: /');
    }

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
    }

    var_dump($id);

    // Conección a la BD
    require '../../includes/config/database.php';
    $db = conectarDB();

    // Obtener los datos de la propiedad
    $consulta = "SELECT * FROM propiedades WHERE id = ${id}";
    $resultado = mysqli_query($db, $consulta);
    $propiedad = mysqli_fetch_assoc($resultado);

    // Consultar la BD para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    // Arreglo con mensaje de errores
    $errores = [];

    // Creando variables para guardar el contenido de los inputs por si salen errores
    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamiento = $propiedad['estacionamiento'];
    $vendedorId = $propiedad['vendedorId'];
    $imagenPropiedad = $propiedad['imagen'];

    // Ejecutar el código después de que el usuario envía el formulario
    if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";

        // echo "<pre>";
        // var_dump($_FILES);
        // echo "</pre>";

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
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
                <img src="/imagenes/<?php echo $imagenPropiedad ?>" alt="imagen de la propiedad" class="imagen-small">

                <label for="descrpcion">Descrpción:</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

            </fieldset>

            <fieldset>
                <legend>Información Propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input 
                    type="number" 
                    id="habitaciones" 
                    name="habitaciones" 
                    placeholder="Ej: 3" 
                    min="1" 
                    max=9
                    value="<?php echo $habitaciones; ?>">

                <label for="wc">Baños:</label>
                <input 
                    type="number" 
                    id="wc" 
                    name="wc" 
                    placeholder="Ej: 3" 
                    min="1" 
                    max=9
                    value="<?php echo $wc; ?>">

                <label for="estacionamiento">estacionamiento:</label>
                <input 
                    type="number" 
                    id="estacionamiento" 
                    name="estacionamiento" 
                    placeholder="Ej: 3" 
                    min="1" 
                    max=9
                    value="<?php echo $estacionamiento; ?>">

            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
                <select name="vendedor">
                    <option value="">-- Seleccione --</option>
                    <?php while( $row = mysqli_fetch_assoc($resultado) ) : ?>
                        <option <?php echo $vendedorId === $row['id'] ? 'selected' : ''; ?> value="<?php echo $row['id']; ?>"><?php echo $row['nombre'] . " " . $row['apellido']; ?></option>
                    <?php endwhile; ?>
                </select>
            </fieldset>
            <input type="submit" value="Actualizar propiedad" class="boton boton-verde">
        </form>
    </main>
<?php
    incluirTemplate('footer');
?>