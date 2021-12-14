<?php

    require '../../includes/app.php';

    use App\Propiedad;

    estaAutenticado();

    // Conección a la BD
    $db = conectarDB();

    // Consultar la BD para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    // Arreglo con mensaje de errores
    $errores = Propiedad::getErrores();

    // Creando variables para guardar el contenido de los inputs por si salen errores
    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedorId = '';

    // Ejecutar el código después de que el usuario envía el formulario
    if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

        $propiedad = new Propiedad($_POST);

        $errores = $propiedad->validar();

        if( empty($errores) ) {
            // Asignar files a una variable
            $imagen = $_FILES['imagen'];
    
    
            
    
            // echo "<pre>";
            // var_dump($errores);
            // echo "</pre>";
    
            // Revisar que el arreglo de errores este vacío

            /* SUBIDA DE ARCHIVOS */

            // Crear carpeta
            $carpetaImagenes = '../../imagenes/';

            if( !is_dir($carpetaImagenes) ) {
                mkdir($carpetaImagenes);
            }

            // Generar nombre único para las imagenes
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

            // Subir la imagen a la carpeta imagenes
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

            

            // echo $query;
            // exit;

            $resultado = mysqli_query($db, $query);

            if( $resultado ) {
                // Redireccionar al usuario
                header('location: /admin?respuesta=1');
            }
        }



    }

    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

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
                <select name="vendedorId">
                    <option value="">-- Seleccione --</option>
                    <?php while( $row = mysqli_fetch_assoc($resultado) ) : ?>
                        <option <?php echo $vendedorId === $row['id'] ? 'selected' : ''; ?> value="<?php echo $row['id']; ?>"><?php echo $row['nombre'] . " " . $row['apellido']; ?></option>
                    <?php endwhile; ?>
                </select>
            </fieldset>
            <input type="submit" value="Crear propiedad" class="boton boton-verde">
        </form>
    </main>
<?php
    incluirTemplate('footer');
?>