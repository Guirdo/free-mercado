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
                    <li id="GestionVenta"><a href="visualizar_venta.php">Gestión ventas</a></li>
                    <li id="GestionFlete"><a href="visualizar_flete.php">Gestión flete</a></li>
                </ul>
            </div>

            <div id="principal">

                <?php
                include("../../php/helpers/abrir_conexion.php");
                    if(isset($_POST['encaminar'])){
                        $idFlete = $_GET['id'];

                        mysqli_query($conexion,"update flete set estado = 2 where idFlete = $idFlete");
                    }else if(isset($_POST['entregar'])){
                        date_default_timezone_set('America/Mexico_City');
                        $idFlete = $_GET['id'];
                        $fechaEntrega = date("Y-m-d");

                        mysqli_query($conexion,"update flete set estado = 3, fechaEntrega = '$fechaEntrega' where idFlete = $idFlete");
                    }
                ?>

                <div><a href="visualizar_flete.php"><-REGRESAR</a></div>

                <?php
                if (isset($_GET['id'])) {
                    include("../../php/helpers/abrir_conexion.php");
                    $idFlete = $_GET['id'];

                    $resultado = mysqli_query($conexion, "select * from flete where idFlete = $idFlete");
                    $flete = mysqli_fetch_array($resultado);

                    $idVenta = $flete['idVentaF'];
                ?>
                    <h2>Flete #<?php echo $idFlete; ?></h2>

                    <div class="fila">
                        <div class="columna">
                        <div><b>Estado: </b><?php echo $flete['estado']; ?></div>
                        <div><b>Fecha de entrega: </b><?php echo $flete['fechaEntrega']; ?></div>
                        <div><b>Hora de entrega: </b><?php echo $flete['horaEntrega']; ?></div>
                        <?php
                            if($flete['estado'] != "ENTREGADO"){
                        ?>
                        <div>
                            <form action="ver_flete.php?id=<?php echo $idFlete; ?>" method="POST">
                            <?php
                                if($flete['estado'] == "EN PREPARACION"){?>
                                    <button type="submit" name="encaminar">En caminar</button>
                                <?php
                                }else{?>
                                    <button type="submit" name="entregar">Entregar</button>
                                <?php
                                }
                            ?>
                            </form>
                        </div>
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