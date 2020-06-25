<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/sesion/registro.css">
    <title>Free Mercado-Registro</title>
</head>

<body>
    <header>
        <img src="../../assets/img/logo-freemercado.png" alt="free MERCADO" id="logo">
    </header>

    <main>

        <?php $idUsuario = $_GET['id']; ?>
        <form enctype="multipart/form-data" method="POST" action="subir_foto.php?id=<?php echo $idUsuario ?>">

            <div class="form-grupo">
                <div class="subtitulo-form">
                    Sube una foto
                </div>
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

            <div class="boton-form">
                <button type="submit" name="btnTerminar">Terminar</button>
            </div>

            <?php

            if (isset($_POST['btnTerminar'])) {
                include("../../php/helpers/cargar_foto.php");
                include("../../php/helpers/abrir_conexion.php");

                $resultado = mysqli_query($conexion, "select idCliente from cliente where idUsuario = $idUsuario");

                if ($consulta = mysqli_fetch_array($resultado)) {
                    $idCliente = $consulta['idCliente'];
                    cargar_foto("foto", $idCliente);

                    header("Location: ../../index.php");
                }
            }


            ?>

        </form>

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