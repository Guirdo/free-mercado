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
                            '<a href="../../index.php">Ir a Inicio</a>
                            <form action="../../index.php">
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

                <?php
                $mensaje_error = "";
                if (isset($_POST['modificarNombre'])) {
                    $nombre = $_POST['nombre'];
                    $id = $_GET['id'];
                    if ($nombre != "") {
                        include("../../php/helpers/abrir_conexion.php");

                        $contra = $_POST['contra'];
                        $resultado = mysqli_query($conexion, "select password from usuario where id = $idUsuario");

                        if ($consulta = mysqli_fetch_array($resultado)) {
                            $hash = $consulta['password'];
                            if (password_verify($contra, $hash)) {
                                mysqli_query($conexion, "update sucursal set nombre = '$nombre' where idSucursal = $id");

                                header("Location: visualizar_sucursales.php");
                            } else {
                                $mensaje_error = "Contraseña de administrador inválida.";
                            }
                        }

                        include("../../php/helpers/cerrar_conexion.php");
                    }
                }
                ?>

                <div class="contenedor scrolleable">
                    <table>
                        <thead>
                            <td>Id</td>
                            <td>Nombre</td>
                            <td>Opciones</td>
                        </thead>

                        <tbody>

                            <?php
                            include("../../php/helpers/abrir_conexion.php");

                            $resultado = mysqli_query($conexion, "select * from sucursal");

                            while ($consulta = mysqli_fetch_array($resultado)) { ?>
                                <tr>
                                    <td> <?php echo $consulta['idSucursal']; ?> </td>
                                    <td><?php echo $consulta['nombre']; ?></td>
                                    <td id="td-opciones"><button onclick="modificarSucursal('<?php echo $consulta['idSucursal'] ?>','<?php echo $consulta['nombre'] ?>')">Modificar</button>
                                </tr>
                            <?php
                            }

                            include("../../php/helpers/abrir_conexion.php");
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

    <script src="../../js/administracion/gestion_sucursales.js"></script>
    <?php
    if ($mensaje_error != "") {
        echo '<script>alert(' + $mensaje_error + ')</script>';
    }
    ?>
</body>

</html>