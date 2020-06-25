<!DOCTYPE html>
<html lang="en">

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
        <?php $nickname = $_GET['nickname']; ?>

        <form action="registro_cliente.php?nickname=<?php echo $nickname; ?>" method="POST">
            <div class="form-grupo">
                <div class="subtitulo-form">
                    Información personal
                </div>
            </div>

            <div class="form-grupo">
                <label for="">Nombre(s):</label>
                <input type="text" name="nombres">
            </div>

            <div class="form-grupo">
                <label for="">Apellidos:</label>
                <input type="text" name="apellidos">
            </div>

            <div class="form-grupo">
                <label for="">Sexo:</label>
                <div id="radioSexos">
                    <input type="radio" name="sexo" value="1" checked>Masculino
                    <input type="radio" name="sexo" value="2">Femenino
                </div>
            </div>

            <div class="form-grupo">
                <label for="">RFC:</label>
                <input type="text" name="rfc">
            </div>

            <div class="form-grupo">
                <label for="">Fecha nacimiento:</label>
                <input type="date" name="fechaNacimiento">
            </div>

            <div class="form-grupo">
                <label for="">Domicilio:</label>
                <textarea name="domicilio" id="" cols="30" rows="3"></textarea>
            </div>

            <div class="form-grupo">
                <label for="">Salario mensual:</label>
                <input type="number" step="any" name="salario">
            </div>

            <div class="boton-form">
                <button type="submit" name="btnContinuar">Continuar</button>
            </div>

            <?php
            if (isset($_POST['btnContinuar'])) {

                $nombres = $_POST['nombres'];
                $apellidos = $_POST['apellidos'];
                $sexo = $_POST['sexo'];
                $rfc = $_POST['rfc'];
                $fechaNacimiento = $_POST['fechaNacimiento'];
                $domicilio = $_POST['domicilio'];
                $salario = $_POST['salario'];

                if (
                    $nombres != "" && $apellidos != "" && $rfc != "" && $fechaNacimiento != ""
                    && $domicilio != "" && $salario != ""
                ) {

                    include("../../php/helpers/abrir_conexion.php");

                    $idUsuario = darIdUsuario($nickname);

                    $query = "insert into cliente(nombres,apellidos,sexo,fechaNacimiento,rfc,domicilio,salario,idUsuario) values('$nombres','$apellidos',$sexo,'$fechaNacimiento','$rfc','$domicilio',$salario,$idUsuario)";
                    mysqli_query($conexion, $query);

                    include("../../php/helpers/cerrar_conexion.php");

                    header("Location: subir_foto.php?id=$idUsuario");
                }
            }

            function darIdUsuario($nickname)
            {
                include("../../php/helpers/abrir_conexion.php");
                $idUsuario = "";

                $resultado = mysqli_query($conexion, "select id from usuario where nickname = '$nickname'");

                if ($consulta = mysqli_fetch_array($resultado)) {
                    $idUsuario = $consulta['id'];
                }

                return intval($idUsuario);
            }

            ?>

        </form>
    </main>

</body>

</html>