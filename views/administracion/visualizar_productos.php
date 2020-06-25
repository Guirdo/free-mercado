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

                <?php
                if (isset($_POST['modificarNombre'])) {
                    $nom = $_POST['nombre'];
                    $idP = $_GET['id'];
                    if ($nom != "") {
                        include("../../php/helpers/abrir_conexion.php");

                        mysqli_query($conexion, "update producto set nombre = '$nom' where idProducto = $idP");

                        header("Location: visualizar_productos.php");
                        include("../../php/helpers/cerrar_conexion.php");
                    } else {
                        $mensaje_error = "Campo vacío.";
                    }
                } else if (isset($_POST['modificarDescripcion'])) {
                    $desc = $_POST['descripcion'];
                    $idP = $_GET['id'];
                    if ($desc != "") {

                        $desc = preg_replace('/\r|\n/', '<br>', $desc);

                        include("../../php/helpers/abrir_conexion.php");

                        mysqli_query($conexion, "update producto set descripcion = '$desc' where idProducto = $idP");

                        header("Location: visualizar_productos.php");
                        include("../../php/helpers/cerrar_conexion.php");
                    } else {
                        $mensaje_error = "Campo vacío.";
                    }
                } else if (isset($_POST['modificarCantidad'])) {
                    $cant = $_POST['cantidad'];
                    $idP = $_GET['id'];
                    if ($cant != "") {
                        include("../../php/helpers/abrir_conexion.php");

                        mysqli_query($conexion, "update producto set cantidad = $cant where idProducto = $idP");

                        header("Location: visualizar_productos.php");
                        include("../../php/helpers/cerrar_conexion.php");
                    } else {
                        $mensaje_error = "Campo vacío.";
                    }
                } else if (isset($_POST['modificarPrecio'])) {
                    $pre = $_POST['cantidad'];
                    $idP = $_GET['id'];
                    if ($pre != "") {
                        include("../../php/helpers/abrir_conexion.php");

                        mysqli_query($conexion, "update producto set precio = $pre where idProducto = $idP");

                        header("Location: visualizar_productos.php");
                        include("../../php/helpers/cerrar_conexion.php");
                    } else {
                        $mensaje_error = "Campo vacío.";
                    }
                } else if (isset($_POST['modificarCategoria'])) {
                    $cat = $_POST['categoria'];
                    $idP = $_GET['id'];

                    include("../../php/helpers/abrir_conexion.php");

                    mysqli_query($conexion, "update producto set categoria = '$cat' where idProducto = $idP");

                    header("Location: visualizar_productos.php");
                    include("../../php/helpers/cerrar_conexion.php");
                } else if (isset($_POST['subirImagen'])) {
                    $idP = $_GET['id'];

                    include("../../php/helpers/cambiar_imagen.php");
                    cambiar_imagen("foto", $idP);

                    header("Location: visualizar_productos.php");
                } else if (isset($_POST['eliminarProducto'])) {
                    $idP = $_GET['id'];
                    $contra = $_POST['password'];

                    if ($contra != "") {
                        include("../../php/helpers/abrir_conexion.php");

                        $resultado = mysqli_query($conexion, "select password from usuario where id = $idUsuario");

                        if ($consulta = mysqli_fetch_array($resultado)) {
                            $hash = $consulta['password'];
                            if (password_verify($contra, $hash)) {
                                mysqli_query($conexion, "delete from imagen where idProductoI = $idP");
                                mysqli_query($conexion, "delete from producto where idProducto = $idP");

                                header("Location: visualizar_productos.php");
                            } else {
                                $mensaje_error = "Contraseña de administrador inválida.";
                            }
                        }

                        include("../../php/helpers/cerrar_conexion.php");
                    }
                    header("Location: visualizar_productos.php");
                }
                ?>

                <div class="contenedor scrolleable">
                    <table>
                        <thead>
                            <td>Id</td>
                            <td>Nombre</td>
                            <td>Descripción</td>
                            <td>Cantidad</td>
                            <td>Precio ($)</td>
                            <td>Categoría</td>
                            <td>Opciones</td>
                        </thead>

                        <tbody>

                            <?php

                            include("../../php/helpers/abrir_conexion.php");

                            $resultado = mysqli_query($conexion, "select * from producto");

                            while ($consulta = mysqli_fetch_array($resultado)) { ?>
                                <tr>
                                    <td><?php echo $consulta['idProducto']; ?></td>
                                    <td><?php echo $consulta['nombre']; ?></td>
                                    <td><textarea readonly cols="26" rows="2"><?php echo $consulta['descripcion']; ?></textarea></td>
                                    <td><?php echo $consulta['cantidad']; ?></td>
                                    <td><?php echo $consulta['precio']; ?></td>
                                    <td><?php echo $consulta['categoria']; ?></td>
                                    <td id="td-opciones"><button onclick="modificarProducto('<?php echo $consulta['idProducto'] ?>','<?php echo $consulta['nombre'] ?>','<?php echo $consulta['descripcion']; ?>','<?php echo $consulta['cantidad'] ?>','<?php echo $consulta['precio'] ?>','<?php echo $consulta['categoria'] ?>')">Modificar</button>
                                        <button onclick="eliminarProducto('<?php echo $consulta['idProducto']; ?>')">Eliminar</button></td>
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

    <script src="../../js/administracion/gestion_productos.js"></script>
    <script>
        function preview_image(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <?php
    if ($mensaje_error != "") {
        echo '<script>alert(' + $mensaje_error + ')</script>';
    }
    ?>
</body>

</html>