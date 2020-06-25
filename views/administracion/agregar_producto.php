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

                <div class="contenedor">
                    <h3>Agregar producto</h3>
                </div>

                <div class="contenedor">
                    <form enctype="multipart/form-data" id="form-usuario" method="POST" action="agregar_producto.php">

                        <div class="form-grupo">
                            <label for="">Nombre:</label>
                            <input type="text" name="nombre">
                        </div>

                        <div class="form-grupo">
                            <label for="">Descripción:</label>
                            <textarea name="descripcion" id="" cols="30" rows="3"></textarea>
                        </div>

                        <div class="form-grupo">
                            <label for="">Sucursal:</label>
                            <select name="sucursal">
                                <?php
                                include("../../php/helpers/abrir_conexion.php");
                                $i = 1;

                                $resultado = mysqli_query($conexion, "select nombre from sucursal");

                                while ($consulta = mysqli_fetch_array($resultado)) {
                                ?>
                                    <option value="<?php echo $i;
                                                    $i = $i + 1; ?>"><?php echo $consulta['nombre']; ?></option>
                                <?php
                                }
                                include("../../php/helpers/cerrar.php");
                                ?>
                            </select>
                        </div>

                        <div class="form-grupo">
                            <label for="">Categoría:</label>
                            <select name="categoria">
                                <option value="1">Ropa</option>
                                <option value="2">Electrodoméstico</option>
                                <option value="3">Tecnología</option>
                                <option value="4">Juguetes</option>
                                <option value="5">Muebles</option>
                                <option value="6">Mascotas</option>
                                <option value="7">Tocomochos</option>
                            </select>
                        </div>

                        <div class="form-grupo">
                            <label for="">Cantidad:</label>
                            <input type="number" name="cantidad">
                        </div>

                        <div class="form-grupo">
                            <label for="">Precio por unidad:</label>
                            <input type="number" step=".01" name="precio">
                        </div>

                        <div class="form-grupo">
                            <label for="">Foto de perfil:</label>
                            <input type="file" accept="image/*" name="foto" onchange="preview_image(event)">
                        </div>

                        <div class="form-grupo">
                            <div class="contenedor">
                                <img id="preview" alt="Preview">
                            </div>
                        </div>

                        <div class="form-grupo">
                            <div class="contenedor">
                                <button class="btn-form" type="submit" name="btnContinuar">Continuar</button>
                            </div>
                        </div>

                        <?php
                        $mensaje_error = "";

                        if (isset($_POST['btnContinuar'])) {
                            include("../../php/helpers/abrir_conexion.php");

                            $nombre = $_POST['nombre'];
                            $descripcion = $_POST['descripcion'];
                            $categoria = $_POST['categoria'];
                            $cantidad = $_POST['cantidad'];
                            $precio = $_POST['precio'];
                            $sucursal = $_POST['sucursal'];

                            if ($nombre != "" && $descripcion != "" && $cantidad != "" && $precio != "") {
                                include("../../php/helpers/cargar_imagen.php");
                                $descripcion = preg_replace('/\r|\n/','<br>',$descripcion);
                                mysqli_query($conexion, "insert into producto(nombre,descripcion,categoria,cantidad,precio,idSucursalP) values('$nombre','$descripcion',$categoria,$cantidad,$precio,$sucursal)");
                                
                                cargar_imagen("foto",$conexion->insert_id);

                                header("Location: visualizar_productos.php");
                            } else {
                                imprimirMensajeError("Campos vacíos.");
                            }
                            include("../../php/helpers/cerrar_conexion.php");
                        }

                        function imprimirMensajeError($mensaje)
                        {
                            echo '<div class="form-grupo">
                                    <div id="aviso1">
                                    <div id="mensaje1">' . $mensaje . '</div>
                                    </div>
                                    </div>';
                        }

                        ?>

                    </form>
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
</body>

</html>