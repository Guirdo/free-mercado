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

                <div class="contenedor scrolleable">
                    <table>
                        <thead>
                            <td>Id</td>
                            <td>Fecha</td>
                            <td>Total</td>
                            <td>Usuario</td>
                            <td></td>
                        </thead>

                        <tbody>

                            <?php

                            include("../../php/helpers/abrir_conexion.php");

                            $resultado = mysqli_query($conexion, "select * from venta");

                            while ($consulta = mysqli_fetch_array($resultado)) { 
                                $resultado1 = mysqli_query($conexion,"select nickname from usuario where id = ".$consulta['idUsuarioV']);
                                $consulta1 = mysqli_fetch_array($resultado1);
                                $nick = $consulta1['nickname'];
                                ?>
                                <tr>
                                    <td><?php echo $consulta['idVenta']; ?></td>
                                    <td><?php echo $consulta['fecha']; ?></td>
                                    <td><?php echo $consulta['montoTotal']; ?></td>
                                    <td><?php echo $nick; ?></td>
                                    <td id="td-opciones"><a href="ver_venta.php?id=<?php echo $consulta['idVenta']; ?>">VER DETALLES</a></td>
                                </tr>
                            <?php
                            }

                            include("../../php/helpers/cerrar_conexion.php");
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="contenedor" id="divDatosUsuario">

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