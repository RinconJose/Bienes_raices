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
    </main>
<?php
    incluirTemplate('footer');
?>