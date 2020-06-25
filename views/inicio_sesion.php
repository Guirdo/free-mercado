<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/sesion/iniciosesion.css">
    <title>Free Mercado-Inicio sesión</title>
</head>

<body>
    <header>
        <img src="../assets/img/logo-freemercado.png" alt="free MERCADO" id="logo">
    </header>

    <main>
        <form method="POST" action="inicio_sesion.php">

            <div class="form-grupo">
                <label for="">E-mail:</label>
                <input type="text" name="email">
            </div>

            <div class="form-grupo">
                <label for="">Contraseña:</label>
                <input type="password" name="password">
            </div>

            <div class="boton-form">
                <button type="submit" name="btnIniciar">Iniciar sesión</button>
            </div>

        </form>

        <div class="contenedor">
            <a href="registro/registro.php">Registrarse</a> | <a href="#">Olvide mi contraseña</a>
        </div>

        <div class="contenedor">
            <?php
            if (isset($_POST['btnIniciar'])) {
                include("../php/helpers/abrir_conexion.php");

                $email = $_POST['email'];
                $password = $_POST['password'];

                if ($email == '' || $password == '') {
                    echo "<div id='mensaje-error'>
                            <p>Correo o contraseña vacios.</p>
                        </div>";
                } else {
                    $resultado = mysqli_query($conexion, "select * from usuario where email = '$email'");

                    if ($consulta = mysqli_fetch_array($resultado)) {
                        if (password_verify($password,$consulta['password'])) {
                            session_start();
                            $_SESSION['nickname'] = $consulta['nickname'];
                            $_SESSION['idUsuario'] = $consulta['id'];
                            header("Location: ../index.php");
                        } else {
                            echo "<div id='mensaje-error'>
                                    <p>Correo o contraseña incorrectos.</p>
                                </div>";
                        }
                    } else {
                        echo "<div id='mensaje-error'>
                            <p>Correo o contraseña incorrectos.</p>
                        </div>";
                    }
                }

                include("../../php/helpers/cerrar_conexion.php");
            }
            ?>
        </div>

    </main>



</body>

</html>