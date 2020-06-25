<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Free mercado - Contacto</title>
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
                                    '<a href="cliente/menu.php">Mi cuenta</a><form action="contacto.php" method="POST">
                                <input type="submit" value="Salir" name="cerrarSesion">
                            </form>';
                            } else if ($consulta['tipo'] == "administrador") {
                                echo '<span id="saludo">Hola <span id="nickname">' . $nickname . '</span></span><br>' .
                                    '<a href="administracion/menu.php">Administracion</a><form action="contacto.php" method="POST">
                                <input type="submit" value="Salir" name="cerrarSesion">
                            </form>';
                            } else if ($consulta['tipo'] == "vendedor") {
                                echo '<span id="saludo">Hola <span id="nickname">' . $nickname . '</span></span><br>' .
                                    '<a href="venta/visualizar_venta.php">Venta</a><form action="contacto.php" method="POST">
                                <input type="submit" value="Salir" name="cerrarSesion">
                            </form>';
                            }
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
        <div class='fila'>
            <div id="principal">
                <div class="contenedor">
                    <p>Sígueme en instagram: <a href="https://www.instagram.com/guirdo21/">@guirdo21</a></p>
                </div>

                <div class="contenedor">
                    <p>Escucha mi podcast: <a href="https://www.facebook.com/charlasfritas">Charlas Fritas</a></p>
                </div>

                <div class="contenedor">
                    <p>Suscríbete a mi canal de programación: <a href="https://www.youtube.com/channel/UCA1l6cFTOSyEGIiAUN901_g">El Pica código</a></p>
                </div>
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

</body>

</html>