idS="";
nombre="";
function modificarSucursal(id,nom) {
    idS = id;
    nombre = nom;
    console.log(nombre);
    document.getElementById("divDatosUsuario").innerHTML = '<div class="contenedor" id="divUsuario">' +
        '<div class="contenedor">' +
        '<h3>Datos de sucurusal #' + idS + '</h3>' +
        '</div>' +
        '<div class="contenedor">' +
        '<div class="datos" id="divNombre">' +
        '<div>' +
        '<div><label>Nombre: </label><span id="nombre">' + nombre + '</span></div>' +
        '<button onclick="modificarNombre()">Modificar</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
}

function eliminarSucursal(id) {
    document.getElementById('divDatosUsuario').innerHTML = '<div id="divEliminar">'+
    '<div class="datos">' +
        '<form action="menu.php?id='+id+'&tipo='+tipo+'" method="POST">' +
        '<div class="form-grupo">' +
        '<h4>¿Esta seguro de eliminar a la cuenta #'+id+'?</h4>' +
        '</div>' +
        '<div class="form-grupo">' +
        '<label for="">Introduzca su contraseña:</label>' +
        '<input type="password" name="password">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="eliminarUsuario">Confirmar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarEliminar()">Cancelar</button>' +
        '</div>' +
        '</form>' +
        '</div>' +
        '</div>';
}

function modificarNombre() {
    nombre = document.getElementById('nombre').innerHTML;
    document.getElementById('divNombre').innerHTML = '<form action="visualizar_sucursales.php?id=' + idS + '" method="POST">' +
        '<div class="form-grupo">' +
        '<label>Nombre: </label>' +
        '<input type="text" value="' + nombre + '" name="nombre">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<label>Contraseña: </label>' +
        '<input type="password" name="contra">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarNombre">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarNombre()">Cancelar</button>' +
        '</div>' +
        '</form>';
}

function cancelarNombre() {
    document.getElementById('divNombre').innerHTML = '<div>' +
        '<div><label>Nombre: </label><span id="nombre">' + nombre + '</span></div>' +
        '<button onclick="modificarNombre()">Modificar</button>' +
        '</div>';
}