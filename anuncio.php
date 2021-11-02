<?php 
    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor seccion contenido-center">
        <h1>Casa en venta frente al bosque</h1>
        <picture>
            <source srcset="build/img/destacada.webp" type="image/webp">
            <source srcset="build/img/destacada.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada.jpg" alt="imagen de la propiedad">
        </picture>
        <div class="resumen-propiedad">
            <p class="precio">$3,000,000</p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p>3</p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p>3</p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p>4</p>
                </li>
            </ul>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla animi praesentium debitis nobis perspiciatis nesciunt velit, error aliquid voluptatibus eaque eius nam odit quia unde doloremque? Impedit, ratione fugit obcaecati voluptates, cupiditate vitae error commodi, quas doloribus nulla consectetur amet! Rerum dolorum laboriosam earum labore suscipit fugiat hic, est impedit!</p>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Illo laborum, impedit dolorem cum blanditiis at. Natus repellat, maxime nemo hic et eos perferendis voluptate provident ipsa commodi molestiae obcaecati accusamus doloribus repellendus illum ab voluptates veniam cupiditate! Unde, totam nulla?</p>
        </div>
    </main>
<?php
    incluirTemplate('footer');
?>