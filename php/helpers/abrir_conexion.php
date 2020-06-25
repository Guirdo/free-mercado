<?php

    $host = "localhost";
    $basedatos = "freemercado";
    $usuariodb = "freeman";
    $clave = "}wCb<Hn3(C#f5!+/";

    //Lista de tablas
    $tabla_usuario = "usuario";

    error_reporting(0);

    $conexion = new mysqli($host,$usuariodb,$clave,$basedatos);

    if($conexion->connect_errno){
        echo 'Nuestro sitio experimenta fallos...';
        exit();
    }

?>