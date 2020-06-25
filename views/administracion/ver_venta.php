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
                            ?>
                            <span id="saludo">Hola <span id="nickname"><?php echo $nickname; ?></span></span><br>
                            <a href="../../index.php">Ir a Inicio</a><form action="../../index.php">
                            <input type="submit" value="Salir" name="cerrarSesion"></form>
                        <?php
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

                <div><a href="visualizar_venta.php"><-REGRESAR</a></div>

                <?php
                if (isset($_GET['id'])) {
                    include("../../php/helpers/abrir_conexion.php");
                    $idVenta = $_GET['id'];

                    $resultado = mysqli_query($conexion, "select * from venta where idVenta = $idVenta");
                    $venta = mysqli_fetch_array($resultado);
                ?>
                    <h2>Venta #<?php echo $idVenta; ?></h2>

                    <div class="fila">
                        <div class="columna">
                            <div><b>Fecha: </b><?php echo $venta['fecha']; ?></div>
                            <div><b>Total: </b>$<?php echo $venta['montoTotal']; ?></div>
                            <?php
                            if (intval($venta['msi']) > 0) { ?>
                                <div><b>Pago: </b>Crédito a <?php echo $venta['msi']; ?>MSI</div>
                            <?php
                            } else { ?>
                                <div><b>Pago: </b>Contado</div>
                            <?php
                            }
                            ?>
                        </div>

                        <div class="columa">
                            <?php 
                                $resultado = mysqli_query($conexion,"select * from flete where idVentaF = $idVenta");
                                if($flete = mysqli_fetch_array($resultado)){?>
                                    <b>Flete # <?php echo $flete['idFlete']; ?></b>
                                    <div><b>Estado: </b><?php echo $flete['estado']; ?></div>
                                    <div><b>Fecha de entrega: </b><?php echo $flete['fechaEntrega']; ?></div>
                                <?php
                                }else{?>
                                    <b>Venta hecha en la tienda.</b>
                                <?php
                                }
                            ?>
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
                    <a href="../contacto.php">Contacto</a>
                </div>

            </div>
        </div>
    </footer>

    <script src="../../js/administracion/gestion_usuario.js"></script>
    <?php
    if ($mensaje_error != "") {
        echo '<script>alert(' + $mensaje_error + ')</script>';
    }
    ?>
</body>

</html>