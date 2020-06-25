<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Free mercado - Chat</title>
</head>

<body>

    <header>

        <div class="fila">
            <div>
                <img src="../assets/img/logo-freemercado.png" id="logo">
            </div>

            <div class="contenedor">

            <?php
                session_start();
                include("php/helpers/abrir_conexion.php");
                $idUsuario = 0;

                $enlace_carrito = "../cliente/carrito_compras.php";
                if (isset($_POST['idUsuario'])) {
                    $idUsuario = $_SESSION['idUsuario'];
                    $resultado = mysqli_query($conexion, "select tipo from usuario where id = $idUsuario");

                    if ($consulta = mysqli_fetch_array($resultado)) {
                        if ($consulta['tipo'] != "cliente") {
                            $enlace_carrito = "views/venta/carrito_venta.php";
                        }
                    }
                }
                ?>

                <div id="imgCarrito">
                    <a href="<?php echo $enlace_carrito; ?>"><img src="assets/icons/buy.png" alt=""></a>
                </div>

                <?php
                if (isset($_SESSION['idUsuario']) && !isset($_POST['cerrarSesion'])) {
                    $idUsuario = $_SESSION['idUsuario'];

                    include("../php/helpers/abrir_conexion.php");
                    $resultado = mysqli_query($conexion, "select idClienteF from fotografia where idClienteF = " .
                        "(select idCliente from cliente where idUsuario = $idUsuario)");

                    if ($consulta = mysqli_fetch_array($resultado)) {
                        $idFoto = $consulta['idClienteF'];
                        echo '<img src="../php/helpers/ver_foto.php?id=' . $idFoto . '" id="foto">';
                    } else {
                        echo '<img src="../assets/img/user.png" id="foto">';
                    }
                }
                ?>

                <div id="cajaUsuario">

                    <?php

                    if (isset($_POST['cerrarSesion'])) {
                        session_destroy();
                        $idUsuario = 0;
                        echo "<div>
                        <a href='registro/registro.php'>Registro</a> | <a href='inicio_sesion.php'>Iniciar sesión</a>
                        </div>";
                    } else {
                        if (isset($_SESSION['nickname'])) {
                            include("../php/helpers/abrir_conexion.php");
                            $nickname = $_SESSION["nickname"];

                            $resultado = mysqli_query($conexion, "select tipo from usuario where id = $idUsuario");
                            $consulta = mysqli_fetch_array($resultado);

                            if ($consulta['tipo'] == "cliente") {
                                echo '<span id="saludo">Hola <span id="nickname">' . $nickname . '</span></span><br>' .
                                    '<a href="cliente/menu.php">Mi cuenta</a>';
                            } else if ($consulta['tipo'] == "administrador") {
                                echo '<span id="saludo">Hola <span id="nickname">' . $nickname . '</span></span><br>' .
                                    '<a href="administracion/menu.php">Administración</a>';
                            }else if ($consulta['tipo'] == "vendedor") {
                                echo '<span id="saludo">Hola <span id="nickname">' . $nickname . '</span></span><br>' .
                                    '<a href="venta/visualizar_venta.php">Venta</a><form action="contacto.php" method="POST">
                                <input type="submit" value="Salir" name="cerrarSesion">
                            </form>';
                            }
                            ?>
                            <form action="chat.php" method="POST">
                                <input type="submit" value="Salir" name="cerrarSesion">
                            </form>
                    <?php
                        } else {
                            echo "<div>
                        <a href='registro/registro.php'>Registro</a> | <a href='inicio_sesion.php'>Iniciar sesión</a>
                        </div>";
                        }
                    }
                    ?>

                </div>
            </div>
        </div>


    </header>

    <nav>
        <div class="fila">
            <ul id="navbar">
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="mostrador/ver_categoria.php?categoria=1">Ropa</a></li>
                <li><a href="mostrador/ver_categoria.php?categoria=2">Electrodomésticos</a></li>
                <li><a href="mostrador/ver_categoria.php?categoria=3">Tecnología</a></li>
                <li><a href="mostrador/ver_categoria.php?categoria=4">Juguetes</a></li>
                <li><a href="mostrador/ver_categoria.php?categoria=5">Muebles</a></li>
                <li><a href="mostrador/ver_categoria.php?categoria=6">Mascotas</a></li>
                <li><a href="mostrador/ver_categoria.php?categoria=7">Tocomochos</a></li>
                <li><a href="chat.php">Chat</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <div id="chat">

            <?php
            if (isset($_POST['enviarMensaje'])) {
                include("../php/helpers/abrir_conexion.php");
                $id = $_GET['id'];
                $nick = $_GET['nick'];
                $mensaje = $_POST['mensaje'];
                $mensaje = preg_replace('/\r\n|\n/', '<br>', $mensaje);

                $resultado = mysqli_query($conexion, "select tipo from usuario where id = $id");
                $consulta = mysqli_fetch_array($resultado);
                $tipo = $consulta['tipo'];

                $archivo = fopen("../chat/chat.txt", "a+");

                fputs($archivo, $id . "\n");
                fputs($archivo, $nick . "\n");
                fputs($archivo, $tipo . "\n");
                fputs($archivo, $mensaje . "\n");

                fclose($archivo);

                header("Location: chat.php");
            }
            ?>

            <div id="mensajes">

                <?php
                if ($archivo = fopen("../chat/chat.txt", "r")) {
                    while (!feof($archivo)) {
                        $id = fgets($archivo);
                        $nick = fgets($archivo);
                        $tipo = fgets($archivo);
                        $mensaje = fgets($archivo);

                        if ($id != "") {
                            $clase_mensaje = "";
                            $tipo = preg_replace('/\n/', "", $tipo);

                            if ($tipo == "administrador" || $tipo == "vendedor") {
                                $clase_mensaje = "msj-admin";
                            } else {
                                if (intval($id) === intval($idUsuario)) {
                                    $clase_mensaje = "msj-propio";
                                    $nick = "Tú";
                                } else {
                                    $clase_mensaje = "msj-cliente";
                                }
                            }


                ?>
                            <div class="mensaje <?php echo $clase_mensaje; ?>">
                                <div><span><?php echo $nick; ?></span></div>
                                <div><?php echo $mensaje; ?></div>
                            </div>
                <?php
                        }
                    }
                    fclose($archivo);
                }

                ?>

            </div>

            <div id="cuadro-envio-mensaje">
                <?php
                if (isset($_SESSION['idUsuario']) && !isset($_POST['cerrarSesion'])) { ?>
                    <form action="chat.php?id=<?php echo $idUsuario; ?>&nick=<?php echo $nickname; ?>" method="post">
                        <textarea name="mensaje" cols="50" rows="4"></textarea>
                        <button id="btn-enviar" name="enviarMensaje" type="submit">Enviar</button>
                    </form>
                <?php
                } else { ?>
                    <div>
                        <h2>Inicie sesión para poder usar el chat</h2>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
    </main>

    <footer>
        <hr>
        <div class="fila">
            <div class="contenedor">
                <div>
                    <a href="contacto.php">Contacto</a>
                </div>

            </div>
        </div>
    </footer>

    <script>
        var objDiv = document.getElementById("mensajes");
        objDiv.scrollTop = objDiv.scrollHeight;
    </script>
</body>

</html>