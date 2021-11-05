<?php 

    // echo "<pre>";
    // var_dump($_GET);
    // echo "</pre>";
    $respuesta = $_GET['respuesta'] ?? null;

    require '../includes/funciones.php';
    incluirTemplate('header');
    
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <?php if( intval($respuesta) === 1 ): ?>
            <p class="alerta exito">Anuncio creado correctamente.</p>
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
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Casa en la playa</td>
                    <td><img src="/imagenes/484c3712057ef20c653c84283d7f5232.jpg" class="imagen-tabla" alt=""></td>
                    <td>120000000</td>
                    <td>
                        <a href="#" class="boton-rojo-block">Eliminar</a>
                        <a href="#" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            </tbody>
        </table>

    </main>
<?php
    incluirTemplate('footer');
?>