<?php 

    

    //Importar DB
    require '../includes/config/database.php';
    $db = conectarDB();

    // Escribir el Query
    $query = "SELECT * FROM propiedades";

    // Consultar la DB
    $respuestaConsulta = mysqli_query($db, $query);

    // Muestra mensaje condicional "Agregado propiedad"
    $respuesta = $_GET['respuesta'] ?? null;

    if( $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id) {
            // Elimina la imagen de la propiedad
            $query = "SELECT imagen FROM propiedades WHERE id = ${id}";
            $resultado = mysqli_query($db, $query);
            $propiedad = mysqli_fetch_assoc($resultado);

            unlink('./../imagenes/' . $propiedad['imagen']);

            // Elimina la propiedad
            $query = "DELETE FROM propiedades WHERE id = ${id}";
            $resultado = mysqli_query($db, $query);
            if( $resultado ) {
                header('location: /admin?resultado=3');
            }
        }

        var_dump($id);
    }

    // Incluye template
    require '../includes/funciones.php';
    incluirTemplate('header');
    
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <?php if( intval($respuesta) === 1 ): ?>
            <p class="alerta exito">Anuncio creado correctamente.</p>
        <?php elseif( intval( $respuesta ) === 2 ): ?>
            <p class="alerta exito">Anuncio actualizado correctamente.</p>
        <?php elseif( intval( $respuesta ) === 3 ): ?>
            <p class="alerta exito">Anuncio Eliminado Correctamente.</p>
        <?php endif; ?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody><!-- Mostrar los resultados de la consulta -->
            <?php while( $propiedad = mysqli_fetch_assoc( $respuestaConsulta ) ): ?>
                <tr>
                    <td><?php echo $propiedad['id'] ?></td>
                    <td><?php echo $propiedad['titulo'] ?></td>
                    <td><img src="../imagenes/<?php echo $propiedad['imagen'] ?>" class="imagen-tabla" alt=""></td>
                    <td>$<?php echo $propiedad['precio'] ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="../admin/propiedades/actualizar.php?id=<?php echo $propiedad['id'] ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

    </main>
<?php

    // Cerrar la conexión de la DB
    mysqli_close($db);

    incluirTemplate('footer');
?>