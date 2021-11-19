<?php 

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if( !$id ) {
        header('location: /');
    }

    require 'includes/funciones.php';
    incluirTemplate('header');

    // Conectar base de dato
    require './includes/config/database.php';
    $db = conectarDB();

    // Consultar base de datos
    $consulta = "SELECT * FROM propiedades WHERE id = ${id}";

    // Obtener los datos
    $resultado = mysqli_query($db, $consulta);

    if( !$resultado -> num_rows ){
        header('location: /');
    }

    $propiedad = mysqli_fetch_assoc($resultado);
?>
    
    <main class="contenedor seccion contenido-center">
        <h1><?php echo $propiedad['titulo'] ?></h1>
        <img loading="lazy" src="imagenes/<?php echo $propiedad['imagen'] ?>" alt="imagen de la propiedad">
        <div class="resumen-propiedad">
            <p class="precio"><?php echo $propiedad['precio'] ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad['wc'] ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad['estacionamiento'] ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad['habitaciones'] ?></p>
                </li>
            </ul>
            <p><?php echo $propiedad['descripcion'] ?></p>
        </div>
    </main>
<?php

    mysqli_close($db);

    incluirTemplate('footer');
?>