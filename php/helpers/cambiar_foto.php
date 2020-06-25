<?php

function cambiar_foto($foto,$idCliente){
    include("abrir_conexion.php");

    if ((isset($_FILES[$foto])) && ($_FILES[$foto] != '')) {
        $file = $_FILES[$foto]; //Asignamos el contenido del parametro a una variable para su mejor manejo
    
        $temName = $file['tmp_name']; //Obtenemos el directorio temporal en donde se ha almacenado el archivo;
        $fileName = $file['name']; //Obtenemos el nombre del archivo
        $fileExtension = substr(strrchr($fileName, '.'), 1); //Obtenemos la extensiÃ³n del archivo.
    
        //Comenzamos a extraer la informaciÃ³n del archivo
        $fp = fopen($temName, "rb"); //abrimos el archivo con permiso de lectura
        $contenido = fread($fp, filesize($temName)); //leemos el contenido del archivo
        //Una vez leido el archivo se obtiene un string con caracteres especiales.
        $contenido = addslashes($contenido); //se escapan los caracteres especiales
        fclose($fp); //Cerramos el archivo
    
        //Insertando los datos
        //Creando el query
        $query = "update fotografia set nombreArchivo = '$fileName', extension = '$fileExtension', binario = '$contenido' where idClienteF = $idCliente";
        //Ejecutando el Query
        $result = mysqli_query($conexion, $query);
    
        include("cerrar_conexion.php");
    }
}