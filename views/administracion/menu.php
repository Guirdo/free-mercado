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
                                <input type="submit" value="Salir" name="cerrarSesion">
                            </form>';
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

                if (isset($_POST['modificarNickname'])) {
                    $nick = $_POST['nickname'];
                    $idU = $_GET['id'];
                    if ($nick != $nickname || $nick != "") {
                        include("../../php/helpers/abrir_conexion.php");

                        $contra = $_POST['contra'];
                        $resultado = mysqli_query($conexion, "select password from usuario where id = $idUsuario");

                        if ($consulta = mysqli_fetch_array($resultado)) {
                            $hash = $consulta['password'];
                            if (password_verify($contra, $hash)) {
                                $resultado = mysqli_query($conexion, "select nickname from usuario where nickname = '$nick'");
                                if ($consulta = mysqli_fetch_array($resultado)) {
                                    $mensaje_error = "Usuario no disponible.";
                                } else {
                                    $resultado = mysqli_query($conexion, "update usuario set nickname = '$nick' where id = $idU");

                                    header("Location: datos_cliente.php");
                                }
                            } else {
                                $mensaje_error = "Contraseña de administrador inválida.";
                            }
                        }
                        include("../../php/helpers/cerrar_conexion.php");
                    } else {
                        $mensaje_error = "No se hizo ningún cambio al nombre de usuario.";
                    }
                } else if (isset($_POST['modificarEmail'])) {
                    include("../../php/helpers/abrir_conexion.php");

                    $correo = $_POST['email'];
                    $contra = $_POST['contra'];
                    $idU = $_GET['id'];

                    if ($correo != "") {
                        $resultado = mysqli_query($conexion, "select email from usuario where email = '$correo'");
                        if ($consulta = mysqli_fetch_array($resultado)) {
                            $mensaje_error = "Correo asociado ya a otra cuenta.";
                        } else {
                            $resultado = mysqli_query($conexion, "select password from usuario where id = $idUsuario");
                            if ($consulta = mysqli_fetch_array($resultado)) {
                                $hash = $consulta['password'];
                                if (password_verify($contra, $hash)) {
                                    $resultado = mysqli_query($conexion, "update usuario set email = '$correo' where id = $idU");
                                } else {
                                    $mensaje_error = "Contraseña de administrador inválida.";
                                }
                            }
                        }
                    } else {
                        $mensaje_error = "Correo inválido.";
                    }

                    include("../../php/helpers/cerrar_conexion.php");
                } else if (isset($_POST['modificarContrasena'])) {
                    include("../../php/helpers/abrir_conexion.php");
                    $contraAct = $_POST['contraAct'];
                    $idU = $_GET['id'];

                    $resultado = mysqli_query($conexion, "select password from usuario where id = '$idUsuario'");
                    if ($consulta = mysqli_fetch_array($resultado)) {
                        $hash = $consulta['password'];
                        if (password_verify($contraAct, $hash)) {
                            $contraNueva1 = $_POST['contraNueva1'];
                            $contraNueva2 = $_POST['contraNueva2'];
                            if ($contraNueva1 == $contraNueva2) {
                                if (preg_match("/[A-Za-z0-9]{8,16}/", $contraNueva1)) {
                                    $hash = password_hash($contraNueva1, PASSWORD_DEFAULT);
                                    $resultado = mysqli_query($conexion, "update usuario set password = '$hash' where id = $idU");
                                } else {
                                    $mensaje_error = "Contraseña nueva inválida. Debe contener un mínimo de 8 y un máximo de 16 caracteres alfanuméricos.";
                                }
                            } else {
                                $mensaje_error = "Contraseñas nuevas no coinciden.";
                            }
                        } else {
                            $mensaje_error = "Contraseña de administrador inválida.";
                        }
                    }

                    include("../../php/helpers/cerrar_conexion.php");
                } else if (isset($_POST['modificarTipo'])) {
                    include("../../php/helpers/abrir_conexion.php");
                    $tipo = $_POST['tipo'];
                    $contra = $_POST['contra'];
                    $idU = $_GET['id'];

                    $resultado = mysqli_query($conexion, "select password from usuario where id = $idUsuario");

                    if ($consulta = mysqli_fetch_array($resultado)) {
                        $hash = $consulta['password'];
                        if (password_verify($contra, $hash)) {
                            $resultado = mysqli_query($conexion, "update usuario set tipo = '$tipo' where id = $idU");
                        } else {
                            $mensaje_error = "Contraseña de administrador inválida.";
                        }
                    }
                    include("../../php/helpers/cerrar_conexion.php");
                } else if (isset($_POST['eliminarUsuario'])) {
                    include("../../php/helpers/abrir_conexion.php");
                    $tipo = $_GET['tipo'];
                    $idU = $_GET['id'];
                    $contra = $_POST['password'];

                    $resultado = mysqli_query($conexion, "select password from usuario where id = $idUsuario");

                    if ($consulta = mysqli_fetch_array($resultado)) {
                        $hash = $consulta['password'];
                        if (password_verify($contra, $hash)) {
                            if ($tipo == "cliente") {
                                $resultado = mysqli_query($conexion, "select idCliente from cliente where idUsuario = $idU");
                                if ($consulta = mysqli_fetch_array($resultado)) {
                                    $idCliente = $consulta['idCliente'];
                                    $resultado = mysqli_query($conexion, "delete from fotografia where idClienteF = $idCliente");
                                    $resultado = mysqli_query($conexion, "delete from cliente where idCliente = $idCliente");
                                    $resultado = mysqli_query($conexion, "delete from usuario where id = $idU");
                                } else {
                                    $resultado = mysqli_query($conexion, "delete from usuario where id = $idU");
                                }
                            } else {
                                $resultado = mysqli_query($conexion, "delete from usuario where id = $idU");
                            }
                        } else {
                            $mensaje_error = "Contraseña de administrador inválida.";
                        }
                    }
                    include("../../php/helpers/cerrar_conexion.php");
                }
                ?>

                <div class="contenedor scrolleable">
                    <table>
                        <thead>
                            <td>Id</td>
                            <td>Nickname</td>
                            <td>Email</td>
                            <td>Tipo</td>
                            <td>Opciones</td>
                        </thead>

                        <tbody>

                            <?php

                            include("../../php/helpers/abrir_conexion.php");

                            $resultado = mysqli_query($conexion, "select id,nickname,email,tipo from usuario");

                            while ($consulta = mysqli_fetch_array($resultado)) { ?>
                                <tr>
                                    <td><?php echo $consulta['id']; ?></td>
                                    <td><?php echo $consulta['nickname']; ?></td>
                                    <td><?php echo $consulta['email']; ?></td>
                                    <td><?php echo $consulta['tipo']; ?></td>

                                    <?php
                                    if ($consulta['tipo'] == "cliente") { ?>
                                        <td id="td-opciones"><button onclick="eliminarUsuario( '<?php echo $consulta['id']; ?>' , '<?php echo $consulta['tipo']; ?>')">Eliminar</button></td>
                                </tr>
                            <?php
                                    } else { ?>
                                <td id="td-opciones"><button onclick="modificarUsuario('<?php echo $consulta['id']; ?> ',' <?php echo $consulta['nickname']; ?> ','<?php echo $consulta['email']; ?> ','<?php echo $consulta['tipo']; ?>')">Modificar</button>
                                    <button onclick="eliminarUsuario( '<?php echo $consulta['id']; ?>' , '<?php echo $consulta['tipo']; ?>')">Eliminar</button></td>
                                </tr>
                        <?php
                                    }
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

    <script src="../../js/administracion/gestion_usuario.js"></script>
    <?php
    if ($mensaje_error != "") {
        echo '<script>alert(' + $mensaje_error + ')</script>';
    }
    ?>
</body>

</html>