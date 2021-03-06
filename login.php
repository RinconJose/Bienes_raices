<?php

    // Incluye header
    require 'includes/app.php';
    $db = conectarDB();

    // Autenticar el usuario
    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';

        $email = mysqli_real_escape_string( $db, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) );
        $password = mysqli_real_escape_string( $db, $_POST['password'] );

        if(!$email) {
            $errores[] = "El email es obligatorio o no es válido";
        }
        if(!$password) {
            $errores[] = "El password es obligatorio o no es válido";
        }
        if(empty($errores)) {

            // Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '${email}' ";
            $resultado = mysqli_query($db, $query);

            if( $resultado->num_rows ) {
                // Resvisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                // var_dump($usuario);

                // Verificar si el password es correcto
                $auth = password_verify($password, $usuario['password']);

                if( $auth ) {
                    // El usuario está autenticado, iniciar sesión
                    session_start();

                    // Agregar elementos a la sesión
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /admin');

                } else {
                    // El password es incorrecto
                    $errores[] = 'El password es incorrecto';
                }

            } else {
                $errores[] = "Elusuario no existe";
            }
        }
    }



    incluirTemplate('header');
?>
    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form method="POST" class="formulario">
            <fieldset>
                <legend>
                    Email y Password
                </legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu Email" id="emil" required>

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu password" id="password" required>

                <input type="submit" value="Iniciar Seción" class="boton boton-verde">
            </fieldset>
        </form>
    </main>
<?php
    incluirTemplate('footer');
?>