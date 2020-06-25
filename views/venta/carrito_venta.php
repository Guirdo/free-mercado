<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/estilos.css">
    <title>Free mercado - Carrito de venta</title>
</head>

<body>

    <header>

        <div class="fila">
            <div>
                <img src="../../assets/img/logo-freemercado.png" id="logo">
            </div>

            <div class="contenedor">

                <div id="imgCarrito">
                    <a href="../cliente/carrito_compras.php"><img src="../../assets/icons/buy.png" alt=""></a>
                </div>

                <?php
                session_start();
                $idUsuario = 0;

                if (isset($_SESSION['idUsuario']) && !isset($_POST['cerrarSesion'])) {
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
                        echo "<div>
                        <a href='../registro/registro.php'>Registro</a> | <a href='../inicio_sesion.php'>Iniciar sesion</a>
                        </div>";
                    } else {
                        if (isset($_SESSION['nickname'])) {
                            include("../../php/helpers/abrir_conexion.php");
                            $nickname = $_SESSION["nickname"];

                            $resultado = mysqli_query($conexion, "select tipo from usuario where id = $idUsuario");
                            $consulta = mysqli_fetch_array($resultado);

                            if ($consulta['tipo'] == "cliente") {
                                echo '<span id="saludo">Hola <span id="nickname">' . $nickname . '</span></span><br>' .
                                    '<a href="../cliente/menu.php">Mi cuenta</a><form action="../../index.php" method="POST">
                                <input type="submit" value="Salir" name="cerrarSesion">
                            </form>';
                            } else if ($consulta['tipo'] == "administrador") {
                                echo '<span id="saludo">Hola <span id="nickname">' . $nickname . '</span></span><br>' .
                                    '<a href="../administracion/menu.php">Administracion</a><form action="../../index.php" method="POST">
                                <input type="submit" value="Salir" name="cerrarSesion">
                            </form>';
                            }
                        } else {
                            echo "<div>
                        <a href='../registro/registro.php'>Registro</a> | <a href='../inicio_sesion.php'>Iniciar sesion</a>
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
                <li><a href="../../index.php">Inicio</a></li>
                <li><a href="../mostrador/ver_categoria.php?categoria=1">Ropa</a></li>
                <li><a href="../mostrador/ver_categoria.php?categoria=2">Electrodomesticos</a></li>
                <li><a href="../mostrador/ver_categoria.php?categoria=3">Tecnologia</a></li>
                <li><a href="../mostrador/ver_categoria.php?categoria=4">Jueguetes</a></li>
                <li><a href="../mostrador/ver_categoria.php?categoria=5">Muebles</a></li>
                <li><a href="../mostrador/ver_categoria.php?categoria=6">Mascotas</a></li>
                <li><a href="../mostrador/ver_categoria.php?categoria=7">Tocomochos</a></li>
                <li><a href="../chat.php">Chat</a></li>
            </ul>
        </div>
    </nav>

    <main>

        <?php
            if(isset($_POST['eliminarProducto'])){
                $idProducto = $_GET['id'];

                mysqli_query($conexion,"delete from presupuesto where idUsuarioP = $idUsuario and idProductoP = $idProducto");

                header("Location: carrito_venta.php");
            }else if(isset($_POST['comprarTodo'])){
                header("Location: caja.php");
            }
        ?>

        <div class="columna">

            <?php
            $totalCarrito = 0;
            if ($idUsuario != 0) {
                $resultado = mysqli_query($conexion, "select idProductoP,cantidad,total from presupuesto where idUsuarioP = $idUsuario");

                while ($consulta = mysqli_fetch_array($resultado)) {
                    $idProducto = $consulta['idProductoP'];
                    $cantidadPre = $consulta['cantidad'];
                    $totalPre = $consulta['total'];
                    $totalCarrito += $totalPre;

                    $resultado1 = mysqli_query($conexion, "select nombre from producto where idProducto = $idProducto");
                    $consulta1 = mysqli_fetch_array($resultado1);
                    $nombrePro = $consulta1['nombre'];
            ?>
                    <div class="item-carrito">
                        <img class="img-item-carrito" src="../../php/helpers/ver_imagen.php?id=<?php echo $idProducto; ?>" alt="">
                        <div>
                            <p><a href="../mostrador/ver_producto.php?id=<?php echo $idProducto; ?>"><?php echo $nombrePro; ?></a></p>
                        </div>
                        <div>
                            Cantidad: <b><?php echo $cantidadPre; ?></b>
                        </div>
                        <div>
                            <h4>$<?php echo $totalPre; ?></h4>
                        </div>

                        <form action="carrito_compras.php?id=<?php echo $idProducto; ?>" method="POST">
                            <button type="submit" name="eliminarProducto">Eliminar</button>
                        </form>
                    </div>

                <?php
                }

                if ($totalCarrito != 0) {
                ?>
                    <div id="divTotal">
                        <div>
                            <h2>Total: $<?php echo $totalCarrito; ?></h2>
                        </div>
                        <form action="carrito_compras.php" method="POST">
                            <button name="comprarTodo" id="btn-comprar">Comprar todo</button>
                        </form>
                    </div>
                <?php
                } else { ?>
                    <h3>Aún no ha agregado algún producto al carrito.</h3>
                <?php
                }
            } else { ?>
                <h3>Inicie sesión para agregar productos al carrito</h3>
            <?php
            }
            ?>
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