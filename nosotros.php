<?php 
    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor seccion">
        <h1>Conoce sobre nosotros</h1>
        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/nosotros.jpg" alt="Sobre Nosotros">
                </picture>
            </div>
            <div class="texto-nosotros">
                <blockquote>
                    25 Anos de experiencia
                </blockquote>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla animi praesentium debitis nobis perspiciatis nesciunt velit, error aliquid voluptatibus eaque eius nam odit quia unde doloremque? Impedit, ratione fugit obcaecati voluptates, cupiditate vitae error commodi, quas doloribus nulla consectetur amet! Rerum dolorum laboriosam earum labore suscipit fugiat hic, est impedit!</p>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Illo laborum, impedit dolorem cum blanditiis at. Natus repellat, maxime nemo hic et eos perferendis voluptate provident ipsa commodi molestiae obcaecati accusamus doloribus repellendus illum ab voluptates veniam cupiditate! Unde, totam nulla?</p>
            </div>
        </div>
    </main>
    <section class="contenedor seccion">
        <h2>Más sobre nosotros</h2>
        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Quasi ipsa, deleniti reprehenderit tempora cupiditate ex voluptates libero maiores iure? Aperiam.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono precio" loading="lazy">
                <h3>Precio</h3>
                <p>Quasi ipsa, deleniti reprehenderit tempora cupiditate ex voluptates libero maiores iure? Aperiam.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono tiempo" loading="lazy">
                <h3>Tiempo</h3>
                <p>Quasi ipsa, deleniti reprehenderit tempora cupiditate ex voluptates libero maiores iure? Aperiam.</p>
            </div>
        </div>
    </section>
<?php
    incluirTemplate('footer');
?>