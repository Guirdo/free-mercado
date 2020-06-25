<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../css/estilos.css">

    <title>Free mercado</title>
</head>

<body>

    <header id="cabecera">

        <div class="fila">
            <div>
                <img src="../../assets/img/logo-freemercado.png" id="logo">
            </div>

            <div class="contenedor">

                <div id="imgCarrito">
                    <a href="../cliente/carrito_compras.php"><img src="assets/icons/buy.png" alt=""></a>
                </div>

                <?php
                session_start();

                if (isset($_SESSION['idUsuario'])) {
                    $idUsuario = $_SESSION['idUsuario'];


                    include("../../php/helpers/abrir_conexion.php");
                    $resultado = mysqli_query($conexion, "select idClienteF from fotografia where idClienteF = " .
                        "(select idCliente from cliente where idUsuario = $idUsuario)");

                    if ($consulta = mysqli_fetch_array($resultado)) {
                        $idFoto = $consulta['idClienteF'];
                        echo '<img src="../../php/helpers/ver_foto.php?id=' . $idFoto . '" id="foto">';
                    } else {
                        echo '<img src="../../assets/img/user.png" id="foto">';
                    }
                }
                ?>

                <div id="cajaUsuario">

                    <?php

                    if (isset($_POST['cerrarSesion'])) {
                        session_destroy();
                        header("Location: ../../index.php");
                    } else {
                        if (isset($_SESSION['nickname'])) {
                            $nickname = $_SESSION["nickname"];

                            echo '<span id="saludo">Hola <span id="nickname">' . $nickname . '</span></span><br>' .
                                '<a href="menu.php">Mi cuenta</a><form action="../../index.php" method="POST">
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

    <nav>
        <div class="fila">
            <ul id="navbar">
                <li><a href="../../index.php">Inicio</a></li>
                <li><a href="../mostrador/ver_categoria.php?categoria=1">Ropa</a></li>
                <li><a href="../mostrador/ver_categoria.php?categoria=2">Electrodomésticos</a></li>
                <li><a href="../mostrador/ver_categoria.php?categoria=3">Tecnología</a></li>
                <li><a href="../mostrador/ver_categoria.php?categoria=4">Juguetes</a></li>
                <li><a href="../mostrador/ver_categoria.php?categoria=5">Muebles</a></li>
                <li><a href="../mostrador/ver_categoria.php?categoria=6">Mascotas</a></li>
                <li><a href="../mostrador/ver_categoria.php?categoria=7">Tocomochos</a></li>
                <li><a href="../chat.php">Chat</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <div class="fila">
            <div id="menu-lateral">
                <a href="menu.php">Resumen</a>
                <a href="datos_cliente.php">Mis datos</a>
                <a href="visualizar_compras.php">Compras</a>
            </div>

            <div id="principal">
                <div class="contenedor">
                    <h2>Hola <?php echo $nickname ?></h2>
                </div>

                <div class="fila">
                    <div class="contenedor">

                    </div>
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

</body>

</html>