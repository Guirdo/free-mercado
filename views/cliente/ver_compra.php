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

                <div><a href="visualizar_compras.php">REGRESAR</a></div>
                <?php
                $venta = "";
                if (isset($_GET['id'])) {
                    include("../../php/helpers/abrir_conexion.php");
                    $idVenta = $_GET['id'];

                    $resultado = mysqli_query($conexion, "select * from venta where idVenta = $idVenta");
                    $venta = mysqli_fetch_array($resultado);
                ?>
                    <h2>Número de compra #<?php echo $idVenta; ?></h2>

                    <div class="fila">
                        <div class="columna">
                            <div><b>Fecha: </b><?php echo $venta['fecha']; ?></div>
                            <div><b>Total: </b>$<?php echo $venta['montoTotal']; ?></div>
                        </div>

                        <div class="columa">
                            <?php
                            $resultado = mysqli_query($conexion, "select * from flete where idVentaF = $idVenta");
                            $flete = mysqli_fetch_array($resultado); ?>

                            <b>Flete # <?php echo $flete['idFlete']; ?></b>
                            <div><b>Estado: </b><?php echo $flete['estado']; ?></div>
                            <div><b>Fecha de entrega: </b><?php echo $flete['fechaEntrega']; ?></div>
                            <div><b>Hora de entrega: </b><?php echo $flete['horaEntrega']; ?></div>
                        </div>
                    </div>
                    <?php

                    $resultado = mysqli_query($conexion, "select * from detalle_venta where idVentaD = $idVenta");

                    while ($consulta = mysqli_fetch_array($resultado)) {
                        $resultado1 = mysqli_query($conexion, "select nombre from producto where idProducto = " . $consulta['idProducto']);
                        $consulta1 = mysqli_fetch_array($resultado1);
                    ?>
                        <div class="item-carrito">
                            <img class="img-item-carrito" src="../../php/helpers/ver_imagen.php?id=<?php echo $consulta['idProducto']; ?>" alt="">
                            <div>
                                <p><a href="../mostrador/ver_producto.php?id=<?php echo $consulta['idProducto']; ?>"><?php echo $consulta1['nombre']; ?></a></p>
                            </div>
                            <div>
                                Cantidad: <b><?php echo $consulta['cantidad']; ?></b>
                            </div>
                            <div>
                                <h4>$<?php echo $consulta['total']; ?></h4>
                            </div>
                        </div>
                    <?php
                    }

                    ?>
                    <div class="columna">
                        <div>
                            <h3>Crédito</h3>
                        </div>
                        <div>
                            <div><b>Pago: </b>Crédito a <?php echo $venta['msi']; ?>MSI</div>
                            <div><b>Pagos mensuales: </b>$<?php echo round(floatval($venta['montoTotal']) / intval($venta['msi']), 2); ?></div>
                        </div>
                        <div class="contenedor scrolleable">

                            <table>
                                <thead>
                                    <td>Mes</td>
                                    <td>Deuda</td>
                                    <td>Couta</td>
                                    <td>Total</td>
                                </thead>

                                <tbody>
                                    <?php
                                    $deuda = floatval($venta['montoTotal']);
                                    $plazo = intval($venta['msi']);
                                    $couta = round($deuda / $plazo, 2);
                                    $total = $deuda;


                                    for ($i = 1; $i <= $plazo; $i++) {
                                        $total = round($total - $couta, 2);
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $deuda; ?></td>
                                            <td><?php echo $couta; ?></td>
                                            <td><?php echo $total; ?></td>
                                        </tr>
                                    <?php
                                        $deuda = $total;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                <?php
                }
                ?>



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

    <script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-firestore.js"></script>
    <script src="../../js/firebase/config.js"></script>
    <script src="../../js/firebase/amortizacion.js"></script>

</body>

</html>