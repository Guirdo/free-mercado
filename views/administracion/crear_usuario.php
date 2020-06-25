<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../css/administracion.css">

    <title>Free mercado</title>
</head>

<body>

    <header id="cabecera">

        <div class="fila">

            <div>
                <img src="../../assets/img/logo-freemercado.png" id="logo">
            </div>

            <div class="contenedor">

                <?php
                session_start();

                if (isset($_SESSION['idUsuario'])) {
                    $idUsuario = $_SESSION['idUsuario'];
                }
                ?>

                <img src="../../assets/img/user.png" id="foto">

                <div id="cajaUsuario">

                    <?php

                    if (isset($_POST['cerrarSesion'])) {
                        session_destroy();
                        header("Location: ../../index.php");
                    } else {
                        if (isset($_SESSION['nickname'])) {
                            $nickname = $_SESSION["nickname"];

                            echo '<span id="saludo">Hola <span id="nickname">' . $nickname . '</span></span><br>' .
                                '<a href="../../index.php">Ir a Inicio</a><form action="../../index.php">
                                    <input type="submit" value="Salir" name="cerrarSesion"></form>';
                        } else {
                            header("Location: ../../index.php");
                        }
                    }
                    ?>

                </div>
            </div>
        </div>

    </header>

    <main>
        <div class="fila">
            <div id="menu-lateral">
                <ul class="acorh">
                    <li id="GestionUsuario"><a href="#GestionUsuario">Gestión Usuario</a>
                        <ul>
                            <li><a href="menu.php">Visualizar usuarios</a></li>
                            <li><a href="crear_usuario.php">Crear usuario</a></li>
                        </ul>
                    </li>
                    <li id="GestionCliente"><a href="#GestionCliente">Gestión clientes</a>
                        <ul>
                            <li><a href="visualizar_clientes.php">Visualizar clientes</a></li>
                        </ul>
                    </li>
                    <li id="GestionProducto"><a href="#GestionProducto">Gestión productos</a>
                        <ul>
                            <li><a href="visualizar_productos.php">Visualizar productos</a></li>
                            <li><a href="agregar_producto.php">Agregar producto</a></li>
                        </ul>
                    </li>
                    <li id="GestionSucursal"><a href="#GestionSucursal">Gestión sucursales</a>
                        <ul>
                            <li><a href="visualizar_sucursales.php">Visualizar sucursales</a></li>
                            <li><a href="agregar_sucursal.php">Agregar sucursal</a></li>
                        </ul>
                    </li>
                    <li id="GestionVenta"><a href="visualizar_venta.php">Gestión ventas</a></li>
                    <li id="GestionFlete"><a href="visualizar_flete.php">Gestión flete</a></li>
                </ul>
            </div>

            <div id="principal">

                <div class="contenedor">
                    <h3>Crear usuario</h3>
                </div>

                <div class="contenedor">
                    <form id="form-usuario" method="POST" action="crear_usuario.php">

                        <div class="form-grupo">
                            <label for="">Nickname:</label>
                            <input type="text" name="nickname">
                        </div>

                        <div class="form-grupo">
                            <label for="">E-mail:</label>
                            <input type="email" name="email">
                        </div>

                        <div class="form-grupo">
                            <label for="">Tipo:</label>
                            <select name="tipo">
                                <option value="vendedor">Vendedor</option>
                                <option value="administrador">Administrador</option>
                            </select>
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

                        <div class="form-grupo">
                            <div class="contenedor">
                                <button class="btn-form" type="submit" name="btnContinuar">Continuar</button>
                            </div>
                        </div>

                        <?php
                        $mensaje_error = "";

                        if (isset($_POST['btnContinuar'])) {
                            include("../../php/helpers/abrir_conexion.php");

                            $nickname = $_POST['nickname'];
                            $email = $_POST['email'];
                            $contra1 = $_POST['password'];
                            $contra2 = $_POST['passwordCon'];
                            $tipo = $_POST['tipo'];

                            if ($nickname != "" && $email != "" && $contra1 != "" && $contra2 != "") {
                                if (verificarNickname($nickname) && verificarEmail($email) && verificarContrasena($contra1, $contra2)) {
                                    $hash = password_hash($contra1, PASSWORD_DEFAULT);
                                    mysqli_query($conexion, "insert into usuario(nickname,email,password,tipo) values('$nickname','$email','$hash','$tipo')");

                                    header("Location: menu.php");
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
                            echo '<div class="form-grupo">
                                        <div id="aviso1">
                                        <div id="mensaje1">' . $mensaje . '</div>
                                        </div>
                                        </div>';
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
                </div>


            </div>
        </div>
    </main>

    <footer>
        <hr>
        <div class="fila">
            <div class="contenedor">
                <div>
                    <a href="../contacto.php">Contacto</a>
                </div>

            </div>
        </div>
    </footer>

    <script src="../../js/administracion/crear_usuario.js"></script>
</body>

</html>