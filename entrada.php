<?php 
    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor seccion contenido-centrado">
        <h1>Guia para la decoración de tu hogar</h1>
        <picture>
            <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada.jpg" alt="imagen de la propiedad">
        </picture>
        <p class="informacion-meta">Escrito el: <span>20/10/2021</span> por: <span>Admin</span></p>
        <div class="resumen-propiedad">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla animi praesentium debitis nobis perspiciatis nesciunt velit, error aliquid voluptatibus eaque eius nam odit quia unde doloremque? Impedit, ratione fugit obcaecati voluptates, cupiditate vitae error commodi, quas doloribus nulla consectetur amet! Rerum dolorum laboriosam earum labore suscipit fugiat hic, est impedit!</p>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Illo laborum, impedit dolorem cum blanditiis at. Natus repellat, maxime nemo hic et eos perferendis voluptate provident ipsa commodi molestiae obcaecati accusamus doloribus repellendus illum ab voluptates veniam cupiditate! Unde, totam nulla?</p>
        </div>
    </main>
<?php
    incluirTemplate('footer');
?>