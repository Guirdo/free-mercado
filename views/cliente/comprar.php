<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/estilos.css">
    <title>Free mercado - Comprar usted</title>
</head>

<body>

    <header>

        <div class="fila">
            <div>
                <a href="../../index.php"><img src="../../assets/img/logo-freemercado.png" id="logo-small"></a>
            </div>

            <div class="contenedor">

                <div id="cajaUsuario">

                    <?php
                    session_start();
                    $idUsuario = 0;
                    if (isset($_SESSION['nickname'])) {
                        include("../../php/helpers/abrir_conexion.php");
                        $idUsuario = $_SESSION['idUsuario'];
                        $nickname = $_SESSION["nickname"];
                    ?>
                        <span id="nickname"><?php echo $nickname; ?></span>
                    <?php
                    } else {
                        header("Location: ../../index.php");
                    }
                    ?>

                </div>
            </div>
        </div>

    </header>

    <main>
        <div class="columna">

            <div id="divDomicilio">
                <h3>Domicilio</h3>
                <p>
                    <?php
                    $resultado = mysqli_query($conexion, "select domicilio from cliente where idUsuario = $idUsuario");
                    $consulta = mysqli_fetch_array($resultado);

                    echo $consulta['domicilio'];
                    ?>
                </p>
            </div>

            <h3>Productos</h3>

            <?php
            $totalCompra = 0;
            if (isset($_GET['id']) && isset($_GET['cantidad'])) {
                $idProducto = $_GET['id'];
                $cantidad = $_GET['cantidad'];

                $resultado = mysqli_query($conexion, "select nombre,precio from producto where idProducto = $idProducto");
                $consulta = mysqli_fetch_array($resultado);

                $subTotal = $cantidad * $consulta['precio'];
                $nombrePro = $consulta['nombre'];
                $totalCompra = $subTotal;

            ?>
                <div class="item-carrito">
                    <img class="img-item-carrito" src="../../php/helpers/ver_imagen.php?id=<?php echo $idProducto; ?>" alt="">
                    <div>
                        <p><a href="../mostrador/ver_producto.php?id=<?php echo $idProducto; ?>"><?php echo $nombrePro; ?></a></p>
                    </div>
                    <div>
                        Cantidad: <b><?php echo $cantidad; ?></b>
                    </div>
                    <div>
                        <h4>$<?php echo $subTotal; ?></h4>
                    </div>
                </div>

                <div id="divTotal">
                    <div>
                        <h2>Total: $<?php echo $totalCompra; ?></h2>
                    </div>
                    <form action="comprar.php?id=<?php echo $idProducto; ?>&cantidad=<?php echo $cantidad; ?>" method="POST">
                        <div class="form-grupo">
                            <select name="msi" id="msi" onchange="calcularPagos()">
                                <option value="6">6</option>
                                <option value="12">12</option>
                                <option value="18">18</option>
                                <option value="24">24</option>
                            </select>
                            MSI
                        </div>
                        <div class="form-grupo" id="pagosMSI"></div>

                        <div class="form-grupo">
                            <label for="">Fecha de entrega: </label>
                            <?php
                            date_default_timezone_set('America/Mexico_City');
                            $fechaEntrega = date('Y-m-d', strtotime('+2 days'));
                            ?>
                            <input type="date" value="<?php echo $fechaEntrega; ?>" name="fechaEntrega">
                        </div>

                        <div class="form-grupo">
                            <label for="">Hora de entrega</label>
                            <input type="time" name="horaEntrega" value="13:30">
                        </div>
                        <div class="form-grupo">
                            <button name="confirmarCompra" id="btn-comprar">Confirmar compra</button>
                        </div>
                    </form>
                </div>
                <?php
            } else {
                if ($idUsuario != 0) {
                    $resultado = mysqli_query($conexion, "select idProductoP,cantidad,total from presupuesto where idUsuarioP = $idUsuario");
                    while ($consulta = mysqli_fetch_array($resultado)) {
                        $idProducto = $consulta['idProductoP'];
                        $cantidadPre = $consulta['cantidad'];
                        $totalPre = $consulta['total'];
                        $totalCompra += $totalPre;

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
                        </div>

                    <?php
                    }

                    if ($totalCompra != 0) {
                    ?>
                        <div id="divTotal">
                            <div>
                                <h2>Total: $<?php echo $totalCompra; ?></h2>
                            </div>
                            <form action="comprar.php" method="POST">
                                <div class="form-grupo">
                                    <label for="">Pago a crédito</label>
                                    <select name="msi" id="msi" onchange="calcularPagos()">
                                        <option value="6">6</option>
                                        <option value="12">12</option>
                                        <option value="18">18</option>
                                        <option value="24">24</option>
                                    </select>
                                    MSI
                                </div>
                                <div class="form-grupo" id="pagosMSI"></div>

                                <div class="form-grupo">
                                    <label for="">Fecha de entrega: </label>
                                    <?php
                                    date_default_timezone_set('America/Mexico_City');
                                    $fechaEntrega = date('Y-m-d', strtotime('+2 days'));
                                    ?>
                                    <input type="date" value="<?php echo $fechaEntrega; ?>" name="fechaEntrega">
                                </div>

                                <div class="form-grupo">
                                    <label for="">Hora de entrega</label>
                                    <input type="time" name="horaEntrega" value="13:30">
                                </div>
                                <div class="form-grupo">
                                    <button name="confirmarCompra" id="btn-comprar">Confirmar compra</button>
                                </div>
                        </div>
                    <?php
                    } else { ?>
                        <h3>Agregue un elemento al carrito o inicie sesión.</h3>
            <?php
                    }
                }
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

    <script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-firestore.js"></script>
    <script src="../../js/firebase/config.js"></script>
    <script src="../../js/firebase/registrarDeuda.js"></script>
    <script>
        calcularPagos();

        function calcularPagos() {
            total = "<?php echo $totalCompra; ?>";
            total = parseFloat(total);
            meses = document.getElementById('msi').value;
            pagos = total / parseInt(meses);
            document.getElementById('pagosMSI').innerHTML = "Pagos mensuales: " + parseFloat(pagos).toFixed(2);
        }
    </script>

    <?php
    $idVenta = 0;
    $total = 0;
    $msi = 0;
    if (isset($_POST['confirmarCompra'])) {

        if (isset($_GET['id']) && isset($_GET['cantidad'])) {
            $idProducto = $_GET['id'];
            $cantidad = $_GET['cantidad'];

            $resultado = mysqli_query($conexion, "select precio from producto where idProducto = $idProducto");
            $consulta = mysqli_fetch_array($resultado);
            $total = $cantidad * $consulta['precio'];

            $msi = $_POST['msi'];
            mysqli_query($conexion, "insert into venta(idUsuarioV,montoTotal,msi) values($idUsuario,$total,$msi)");
            $idVenta = $conexion->insert_id;

            mysqli_query($conexion, "insert into detalle_venta values($idVenta,$idProducto,$cantidad,$total)");

            mysqli_query($conexion, "update producto set cantidad = cantidad - $cantidad, numVendidos = numVendidos + $cantidad where idProducto = $idProducto");

            $fechaEntrega = $_POST['fechaEntrega'];
            $horaEntrega = $_POST['horaEntrega'];
            mysqli_query($conexion, "insert into flete(idVentaF,fechaEntrega,horaEntrega) values($idVenta,'$fechaEntrega','$horaEntrega')");

            //header("Location: ../../index.php");
        } else {
            $productos_comprados = array();
            $total = 0;
            $msi = $_POST['msi'];

            $resultado = mysqli_query($conexion, "select * from presupuesto where idUsuarioP = $idUsuario");
            while ($consulta = mysqli_fetch_array($resultado)) {
                array_push($productos_comprados, $consulta);
                $total += floatval($consulta['total']);
            }

            mysqli_query($conexion, "insert into venta(idUsuarioV,montoTotal,msi) values($idUsuario,$total,$msi)");
            $idVenta = $conexion->insert_id;

            foreach ($productos_comprados as $producto) {
                $idProducto = $producto['idProductoP'];
                $cantidad = $producto['cantidad'];
                $total = $producto['total'];

                mysqli_query($conexion, "insert into detalle_venta values($idVenta,$idProducto,$cantidad,$total)");

                mysqli_query($conexion, "update producto set cantidad = cantidad - $cantidad, numVendidos = numVendidos + $cantidad where idProducto = $idProducto");
            }

            $fechaEntrega = $_POST['fechaEntrega'];
            $horaEntrega = $_POST['horaEntrega'];

            mysqli_query($conexion, "insert into flete(idVentaF,fechaEntrega,horaEntrega) values($idVenta,'$fechaEntrega','$horaEntrega')");
            mysqli_query($conexion, "delete from presupuesto where idUsuarioP = $idUsuario");

            //header("Location: ../../index.php");
        }

    ?>
        <script>
            crear_credito('<?php echo $idUsuario; ?>', '<?php echo $idVenta; ?>', <?php echo $total; ?>, <?php echo $msi; ?>);
        </script>
    <?php
    }
    ?>




</body>

</html>