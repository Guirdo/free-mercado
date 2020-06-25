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
                    <a href="../cliente/carrito_compras.php"><img src="../../assets/icons/buy.png" alt=""></a>
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
                <a href="datos_clientes.php">Mis datos</a>
                <a href="visualizar_compras.php">Compras</a>
            </div>

            <div id="principal">

                <?php
                $mensaje_error = "";

                if (isset($_POST['modificarNombre'])) {
                    include("../../php/helpers/abrir_conexion.php");

                    $nombres = $_POST['nombres'];
                    $apellidos = $_POST['apellidos'];

                    if ($nombres != "" && $apellidos != "") {
                        $resultado = mysqli_query($conexion, "update cliente set nombres = '$nombres', apellidos = '$apellidos' where idUsuario = $idUsuario");
                    } else {
                        $mensaje_error = "Campos vacíos.";
                    }

                    include("../../php/helpers/cerrar_conexion.php");
                } else if (isset($_POST['modificarSexo'])) {
                    include("../../php/helpers/abrir_conexion.php");

                    $sexo = $_POST['sexo'];
                    $resultado = mysqli_query($conexion, "update cliente set sexo = '$sexo' where idUsuario = $idUsuario");

                    include("../../php/helpers/cerrar_conexion.php");
                } else if (isset($_POST['modificarRfc'])) {
                    include("../../php/helpers/abrir_conexion.php");

                    $rfc = $_POST['rfc'];
                    if (preg_match("/[A-Z]{4}[0-9]{6}([A-Z0-9][3])?/", $rfc)) {
                        $resultado = mysqli_query($conexion, "update cliente set rfc = '$rfc' where idUsuario = $idUsuario");
                    } else {
                        $mensaje_error = "RFC inválido.";
                    }

                    include("../../php/helpers/cerrar_conexion.php");
                } else if (isset($_POST['modificarSalario'])) {
                    include("../../php/helpers/abrir_conexion.php");
                    $salario = $_POST['salario'];

                    if (preg_match("/[0-9]{1,6}([.][0-9]{1,2})?/", $salario)) {
                        $resultado = mysqli_query($conexion, "update cliente set salario = '$salario' where idUsuario = $idUsuario");
                    } else {
                        $mensaje_error = "Salario inválido.";
                    }

                    include("../../php/helpers/cerrar_conexion.php");
                } else if (isset($_POST['modificarDomicilio'])) {
                    include("../../php/helpers/abrir_conexion.php");

                    $domicilio = $_POST['domicilio'];

                    if ($domicilio != "") {
                        $resultado = mysqli_query($conexion, "update cliente set domicilio = '$domicilio' where idUsuario = $idUsuario");
                    } else {
                        $mensaje_error = "Campo vacío.";
                    }

                    include("../../php/helpers/cerrar_conexion.php");
                } else if (isset($_POST['modificarNickname'])) {
                    $nick = $_POST['nickname'];
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
                                    session_start();
                                    $_SESSION['nickname'] = $nick;
                                    $resultado = mysqli_query($conexion, "update usuario set nickname = '$nick' where id = $idUsuario");

                                    header("Location: datos_cliente.php");
                                }
                            } else {
                                $mensaje_error = "Contraseña incorrecta.";
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

                    if ($correo != "") {
                        $resultado = mysqli_query($conexion, "select email from usuario where email = '$correo'");
                        if ($consulta = mysqli_fetch_array($resultado)) {
                            $mensaje_error = "Correo asociado ya a otra cuenta.";
                        } else {
                            $resultado = mysqli_query($conexion, "select password from usuario where id = $idUsuario");
                            if ($consulta = mysqli_fetch_array($resultado)) {
                                $hash = $consulta['password'];
                                if (password_verify($contra, $hash)) {
                                    $resultado = mysqli_query($conexion, "update usuario set email = '$correo' where id = $idUsuario");
                                } else {
                                    $mensaje_error = "Contraseña incorrecta.";
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

                    $resultado = mysqli_query($conexion, "select password from usuario where id = '$idUsuario'");
                    if ($consulta = mysqli_fetch_array($resultado)) {
                        $hash = $consulta['password'];
                        if (password_verify($contraAct, $hash)) {
                            $contraNueva1 = $_POST['contraNueva1'];
                            $contraNueva2 = $_POST['contraNueva2'];
                            if ($contraNueva1 == $contraNueva2) {
                                if (preg_match("/[A-Za-z0-9]{8,16}/", $contraNueva1)) {
                                    $hash = password_hash($contraNueva1, PASSWORD_DEFAULT);
                                    $resultado = mysqli_query($conexion, "update usuario set password = '$hash' where id = $idUsuario");
                                } else {
                                    $mensaje_error = "Contraseña nueva inválida. Debe contener un mínimo de 8 y un máximo de 16 caracteres alfanuméricos.";
                                }
                            } else {
                                $mensaje_error = "Contraseñas nuevas no coinciden.";
                            }
                        } else {
                            $mensaje_error = "Contraseña inválida";
                        }
                    }

                    include("../../php/helpers/cerrar_conexion.php");
                } else if (isset($_POST['modificarFoto'])) {
                    if (isset($_FILES['foto'])) {
                        $idCliente = $_GET['id'];
                        if ($_GET['foto']) {
                            include("../../php/helpers/cambiar_foto.php");
                            cambiar_foto("foto", $idCliente);
                        } else {
                            include("../../php/helpers/cargar_foto.php");
                            cargar_foto("foto", $idCliente);
                        }
                        header("Location: datos_cliente.php");
                    }
                } else if (isset($_POST['eliminarFoto'])) {
                    include("../../php/helpers/abrir_conexion.php");
                    $idCliente = $_GET['id'];
                    mysqli_query($conexion, "delete from fotografia where idClienteF = $idCliente");

                    include("../../php/helpers/cerrar_conexion.php");

                    header("Location: datos_cliente.php");
                }
                ?>

                <?php
                include("../../php/helpers/abrir_conexion.php");

                $email = "";
                $idCliente = "";
                $nombres = "";
                $apellidos = "";
                $sexo = "";
                $fechaNacimiento = "";
                $domicilio = "";
                $rfc = "";
                $salario = "";

                $resultado = mysqli_query($conexion, "select * from cliente where idUsuario = '$idUsuario'");
                if ($consulta = mysqli_fetch_array($resultado)) {
                    $idCliente = $consulta['idCliente'];
                    $nombres = $consulta['nombres'];
                    $apellidos = $consulta['apellidos'];
                    $sexo = $consulta['sexo'];
                    $rfc = $consulta['rfc'];
                    $domicilio = $consulta['domicilio'];
                    $fechaNacimiento = $consulta['fechaNacimiento'];
                    $salario = $consulta['salario'];
                }

                $resultado = mysqli_query($conexion, "select email from usuario where id = '$idUsuario'");
                if ($consulta = mysqli_fetch_array($resultado)) {
                    $email = $consulta['email'];
                }

                include("../../php/helpers/cerrar_conexion.php");
                ?>

                <div class="contenedor">
                    <h3>Datos de cuenta</h3>
                </div>
                <div class="contenedor">
                    <div class="datos" id="divNickname">
                        <div>
                            <div><label>Nickname: </label><span id="nick"><?php echo $nickname; ?></span></div>
                            <button onclick="modificarNickname()">Modificar</button>
                        </div>
                    </div>
                </div>
                <div class="contenedor">
                    <div class="datos" id="divEmail">
                        <div>
                            <div><label>Email: </label><span id="email"><?php echo $email; ?></span></div>
                            <button onclick="modificarEmail()">Modificar</button>
                        </div>
                    </div>
                </div>
                <div class="contenedor">
                    <div class="datos" id="divContrasena">
                        <div>
                            <div><label>Contraseña: </label><span>**********</span></div>
                            <button onclick="modificarContrasena()">Modificar</button>
                        </div>
                    </div>
                </div>

                <div class="contenedor">
                    <h3>Datos personales</h3>
                </div>
                <div class="contenedor">
                    <div class="datos" id="divNombre">
                        <div>
                            <div><label>Nombre: </label><span><span id="nombre"><?php echo $nombres ?></span> <span id="apellido"><?php echo $apellidos ?></span></span></div>
                            <button onclick="modificarNombre()">Modificar</button>
                        </div>
                    </div>
                </div>

                <div class="contenedor">
                    <div class="datos" id="divSexo">
                        <div>
                            <div><label>Sexo: </label><span id="sexo"><?php echo $sexo; ?></span></div>
                            <button onclick="modificarSexo()">Modificar</button>
                        </div>
                    </div>
                </div>

                <div class="contenedor">
                    <div class="datos" id="divRfc">
                        <div>
                            <div><label>RFC:</label><span id="rfc"><?php echo $rfc; ?></span></div>
                            <button onclick="modificarRfc()">Modificar</button>
                        </div>
                    </div>
                </div>

                <div class="contenedor">
                    <div class="datos" id="divSalario">
                        <div>
                            <div><label>Salario:</label><span>$<span id="salario"><?php echo $salario; ?></span></span></div>
                            <button onclick="modificarSalario()">Modificar</button>
                        </div>
                    </div>
                </div>
                <div class="contenedor">
                    <div class="datos">
                        <?php
                        include("../../php/helpers/abrir_conexion.php");
                        $tiene_foto = 0;

                        $resultado = mysqli_query($conexion, "select idClienteF from fotografia where idClienteF = $idCliente");

                        if ($consulta = mysqli_fetch_array($resultado)) {
                            $tiene_foto = 1;
                        }
                        ?>
                        <form enctype="multipart/form-data" action="datos_cliente.php?id=<?php echo $idCliente ?>&foto=<?php echo $tiene_foto; ?>" method="POST">
                            <div class="form-grupo">
                                <label for="">Foto de perfil: </label>
                                <input type="file" name="foto" accept="image/*" onchange="preview_image(event)">
                            </div>
                            <div class="form-grupo">
                                <?php
                                if ($tiene_foto) { ?>
                                    <img src="../../php/helpers/ver_foto.php?id=<?php echo $idCliente; ?>" id="preview" alt="Preview">
                                <?php
                                } else { ?>
                                    <img src="../../assets/img/user.png" id="preview" alt="Preview">
                                <?php
                                }
                                ?>
                            </div>
                            <div class="form-grupo">
                                <button class="btn-form" type="submit" name="modificarFoto">Subir</button>
                                <?php
                                if ($tiene_foto) { ?>
                                    <button class="btn-cancelar" type="submit" name="eliminarFoto">Eliminar</button>
                                <?php
                                }
                                ?>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="contenedor">
                    <h3>Domicilio</h3>
                </div>
                <div class="contenedor">
                    <div class="datos" id="divDomicilio">
                        <div>
                            <span id="domicilio"><?php echo $domicilio; ?></span>
                            <button onclick="modificarDomicilio()">Modificar</button>
                        </div>
                    </div>
                </div>

                <!-- 
                <div class="contenedor">
                    <h3>Eliminar cuenta</h3>
                </div>
                <div class="contenedor">
                    <div class="datos">
                        <form action="datos_cliente.php" method="POST">
                            <div class="form-grupo">
                                ¿Está realmente seguro de eliminar su cuenta? Esta acción es irreversible.
                            </div>
                            <div class="form-grupo">
                                <label for="">Introduzca su contraseña: </label>
                                <input type="password" name="contra">
                            </div>
                            <div class="form-grupo">
                                <button class="btn-cancelar" type="submit" name="eliminarCuenta">Eliminar</button>
                            </div>
                        </form>
                    </div>
                </div>
                -->

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

    <script src="../../js/cliente/datos_cliente.js"></script>
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
        echo '<script>
                    alert("' . $mensaje_error . '");
                </script>';
    }
    ?>
</body>

</html>