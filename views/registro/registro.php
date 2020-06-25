<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/sesion/registro.css">
    <title>Free Mercado-Registro</title>
</head>

<body>
    <header>
        <a href="../../index.php"><img src="../../assets/img/logo-freemercado.png" alt="free MERCADO" id="logo"></a>
    </header>

    <main>
        <form method="POST" action="registro.php">

            <div class="form-grupo">
                <label for="">Nickname:</label>
                <input type="text" name="nickname">
            </div>

            <div class="form-grupo">
                <label for="">E-mail:</label>
                <input type="email" name="email">
            </div>

            <div class="form-grupo">
                <label for="">Contraseña:</label>
                <input type="password" name="password" id="contra1">
            </div>

            <div class="form-grupo">
                <label for="">Confirmar contraseña:</label>
                <input type="password" name="passwordCon" id="contra2">
            </div>

            <div class="form-grupo">
                <div id="aviso">
                </div>
            </div>

            <div class="boton-form">
                <button type="submit" name="btnContinuar">Continuar</button>
            </div>

            <?php
            $mensaje_error = "";

            if (isset($_POST['btnContinuar'])) {
                include("../../php/helpers/abrir_conexion.php");

                $nickname = $_POST['nickname'];
                $email = $_POST['email'];
                $contra1 = $_POST['password'];
                $contra2 = $_POST['passwordCon'];

                if ($nickname != "" && $email != "" && $contra1 != "" && $contra2 != "") {
                    if (verificarNickname($nickname) && verificarEmail($email) && verificarContrasena($contra1, $contra2)) {
                        $hash = password_hash($contra1, PASSWORD_DEFAULT);
                        mysqli_query($conexion, "insert into usuario(nickname,email,password,tipo) values('$nickname','$email','$hash',1)");

                        header("Location: registro_cliente.php?nickname=$nickname");
                    } else {
                        imprimirMensajeError($mensaje_error);
                    }
                } else {
                    imprimirMensajeError("Campos vacíos.");
                }

                include("../../php/helpers/cerrar_conexion.php");
            }

            function imprimirMensajeError($mensaje)
            {
            ?>
                <div class="form-grupo">
                    <div id="aviso1">
                        <div id="mensaje1"><?php echo $mensaje; ?></div>
                    </div>
                </div>
            <?php
            }

            function verificarNickname($nick)
            {
                include("../../php/helpers/abrir_conexion.php");
                $resultado = mysqli_query($conexion, "select nickname from usuario where nickname = '$nick'");

                if ($consulta = mysqli_fetch_array($resultado)) {
                    global $mensaje_error;
                    $mensaje_error = $mensaje_error . 'Nickname ya está ocupado.<br>';
                    return false;
                }
                return true;
            }

            function verificarEmail($email)
            {
                include("../../php/helpers/abrir_conexion.php");
                $resultado = mysqli_query($conexion, "select email from usuario where email = '$email'");

                if ($consulta = mysqli_fetch_array($resultado)) {
                    global $mensaje_error;
                    $mensaje_error = $mensaje_error . 'Email ya asociado a otra cuenta.<br>';
                    return false;
                }
                return true;
            }

            function verificarContrasena($contra1, $contra2)
            {
                if (preg_match("/[A-Za-z0-9]{8,16}/", $contra1)) {
                    if ($contra1 == $contra2) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    global $mensaje_error;
                    $mensaje_error = $mensaje_error . 'Contraseña inválida.<br>';
                    return false;
                }
            }

            ?>

        </form>

        <script src="../../js/registro.js"></script>
</body>

</html>