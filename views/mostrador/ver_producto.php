<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/estilos.css">
    <title>Free mercado</title>
</head>

<body>

    <header>

        <div class="fila">
            <div>
                <img src="../../assets/img/logo-freemercado.png" id="logo">
            </div>

            <div class="contenedor">

                <?php
                session_start();
                include("../../php/helpers/abrir_conexion.php");
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
                    $tipoUsuario = "";
                    if (isset($_POST['cerrarSesion'])) {
                        session_destroy(); ?>
                        <div>
                            <a href="../registro/registro.php">Registro</a> | <a href="../inicio_sesion.php">Iniciar sesión</a>
                        </div>
                        <?php
                    } else {
                        if (isset($_SESSION['nickname'])) {
                            include("../../php/helpers/abrir_conexion.php");
                            $nickname = $_SESSION["nickname"];

                            $resultado = mysqli_query($conexion, "select tipo from usuario where id = $idUsuario");
                            $consulta = mysqli_fetch_array($resultado);

                            $tipoUsuario = $consulta['tipo'];

                            if ($tipoUsuario == "cliente") { ?>
                                <span id="saludo">Hola <span id="nickname"><?php echo $nickname; ?></span></span><br>
                                <a href="../cliente/menu.php">Mi cuenta</a>
                                <form action="ver_producto.php" method="POST">
                                    <input type="submit" value="Salir" name="cerrarSesion">
                                </form>
                    <?php
                            } else if ($consulta['tipo'] == "administrador") {
                                echo '<span id="saludo">Hola <span id="nickname">' . $nickname . '</span></span><br>' .
                                    '<a href="../administracion/menu.php">Administración</a><form action="ver_producto.php" method="POST">
                                <input type="submit" value="Salir" name="cerrarSesion">
                            </form>';
                            } else if ($consulta['tipo'] == "vendedor") {
                                echo '<span id="saludo">Hola <span id="nickname">' . $nickname . '</span></span><br>' .
                                    '<a href="../venta/visualizar_venta.php">Venta</a><form action="contacto.php" method="POST">
                                <input type="submit" value="Salir" name="cerrarSesion">
                            </form>';
                            }
                        } else {
                            echo "<div>
                        <a href='../registro/registro.php'>Registro</a> | <a href='../inicio_sesion.php'>Iniciar sesión</a>
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
                <li><a href="ver_categoria.php?categoria=1">Ropa</a></li>
                <li><a href="ver_categoria.php?categoria=2">Electrodomésticos</a></li>
                <li><a href="ver_categoria.php?categoria=3">Tecnología</a></li>
                <li><a href="ver_categoria.php?categoria=4">Juguetes</a></li>
                <li><a href="ver_categoria.php?categoria=5">Muebles</a></li>
                <li><a href="ver_categoria.php?categoria=6">Mascotas</a></li>
                <li><a href="ver_categoria.php?categoria=7">Tocomochos</a></li>
                <li><a href="../chat.php">Chat</a></li>
            </ul>
        </div>
    </nav>

    <main>

        <?php
        $idProducto = "";
        $cantidad = 0;
        $mensaje = "";
        if (isset($_GET['id'])) {
            include("../../php/helpers/abrir_conexion.php");

            $idProducto = $_GET['id'];
            $nombre = "";
            $descripcion = "";
            $precio = "";
            $categoria = "";
            $sucursal = "";
            $numVendidos = 0;

            $resultado = mysqli_query($conexion, "select * from producto where idProducto = $idProducto");

            if ($consulta = mysqli_fetch_array($resultado)) {
                $nombre = $consulta['nombre'];
                $descripcion = $consulta['descripcion'];
                $precio = $consulta['precio'];
                $cantidad = $consulta['cantidad'];
                $categoria = $consulta['categoria'];
                $numVendidos = $consulta['numVendidos'];
                $idSucursal = $consulta['idSucursalP'];

                $resultado = mysqli_query($conexion, "select nombre from sucursal where idSucursal = $idSucursal");
                $consulta = mysqli_fetch_array($resultado);
                $sucursal = $consulta['nombre'];
            }
        }

        if (isset($_POST['agregarCarrito'])) {
            if ($idUsuario != 0) {
                $cantidadCarrito = $_POST['cantidad'];

                $total = 0;
                $resultado = mysqli_query($conexion, "select precio from producto where idProducto = $idProducto");
                $consulta = mysqli_fetch_array($resultado);

                $total = $consulta['precio'] * $cantidadCarrito;

                mysqli_query($conexion, "insert into presupuesto values($idUsuario,$idProducto,$cantidadCarrito,$total)");

                if ($tipoUsuario == "cliente") {
                    header("Location: ../cliente/carrito_compras.php");
                }else{
                    header("Location: ../venta/carrito_venta.php");
                }
            } else {
                $mensaje = "Inicia sesión para agregar productos al carrito";
            }
        } else if (isset($_POST['comprar'])) {
            if ($idUsuario != 0) {
                $cantidad = $_POST['cantidad'];

                if ($tipoUsuario == "cliente") {
                    header("Location: ../cliente/comprar.php?id=$idProducto&cantidad=$cantidad");
                } else {
                    header("Location: ../venta/caja.php?id=$idProducto&cantidad=$cantidad");
                }
            } else {
                $mensaje = "Inicia sesión para realizar una compra.";
            }
        }

        ?>

        <div id="vistaProducto">
            <img id="img-producto-big" src="../../php/helpers/ver_imagen.php?id=<?php echo $idProducto; ?>" alt="<?php echo $nombre; ?>">

            <div id="info-producto">
                <div>(<?php echo $numVendidos; ?> vendidos)</div>
                <div id="nombre-pro"><?php echo $nombre; ?></div>
                <div>Vendedor: <?php echo $sucursal; ?></div>
                <div id="precio-pro">$<?php echo $precio; ?></div>
                <div>Hasta 12 MSI al pagar con tarjeta de crédito.</div>
                <div>Envío gratis a todo México</div>
                <?php
                if ($cantidad > 0) { ?>
                    <form action="ver_producto.php?id=<?php echo $idProducto; ?>" method="POST">
                        <div class="form-grupo">
                            <label for="">Cantidad: </label>
                            <input type="number" name="cantidad" value="1" min="1" max="<?php echo $cantidad; ?>">(<?php echo $cantidad; ?> disponibles)
                        </div>
                        <div clas="form-grupo">
                            <button type="submit" name="comprar" class="btn-form">Comprar ahora</button>
                            <button type="submit" name="agregarCarrito" class="btn-cancelar">Agregar al carrito</button>
                        </div>
                    </form>
                <?php
                } else { ?>
                    <div>
                        <h4>Producto pausado</h4>
                    </div>
                <?php
                }
                ?>
            </div>

            <div id="descripcion-pro">
                <h3>Descripción</h3>
                <p><?php echo $descripcion; ?></p>
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

    <?php
    if ($mensaje != "") { ?>
        <script>
            alert(<?php echo $mensaje; ?>);
        </script>
    <?php
    }
    ?>

</body>

</html>