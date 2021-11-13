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
                        <a href="#" class="boton-rojo-block">Eliminar</a>
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