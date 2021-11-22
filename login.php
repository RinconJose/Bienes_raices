<?php 
    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <form class="formulario">
            <fieldset>
                <legend>
                    Email y Password
                </legend>

                <label for="email">E-mail</label>
                <input type="email" placeholder="Tu Email" id="emil">

                <label for="password">Password</label>
                <input type="tel" placeholder="Tu password" id="password">

                <input type="submit" value="Iniciar Seción" class="boton boton-verde">
            </fieldset>
        </form>
    </main>
<?php
    incluirTemplate('footer');
?>