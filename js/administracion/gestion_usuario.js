tipo = "";
idU = "";
nickname = "";
email = "";

function modificarUsuario(id, nick, ema, tip) {
    idU = id;
    tipo = tip;
    nickname = nick;
    email = ema;
    document.getElementById("divDatosUsuario").innerHTML = '<div class="contenedor" id="divUsuario">' +
        '<div class="contenedor">' +
        '<h3>Datos de cuenta #' + idU + '</h3>' +
        '</div>' +
        '<div class="contenedor">' +
        '<div class="datos" id="divNickname">' +
        '<div>' +
        '<div><label>Nickname: </label><span id="nick">' + nickname + '</span></div>' +
        '<button onclick="modificarNickname()">Modificar</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="contenedor">' +
        '<div class="datos" id="divEmail">' +
        '<div>' +
        '<div><label>Email: </label><span id="email">' + email + '</span></div>' +
        '<button onclick="modificarEmail()">Modificar</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="contenedor">' +
        '<div class="datos" id="divTipo">' +
        '<div>' +
        '<div><label>Tipo: </label><span id="tipo">' + tipo + '</span></div>' +
        '<button onclick="modificarTipo()">Modificar</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="contenedor">' +
        '<div class="datos" id="divContrasena">' +
        '<div>' +
        '<div><label>Contraseña: </label><span>**********</span></div>' +
        '<button onclick="modificarContrasena()">Modificar</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
}

function eliminarUsuario(id, tipo) {
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

function modificarNickname() {
    nickname = document.getElementById('nick').innerHTML;
    document.getElementById('divNickname').innerHTML = '<form action="menu.php?id=' + idU + '" method="POST">' +
        '<div class="form-grupo">' +
        '<label>Nickname: </label>' +
        '<input type="text" value="' + nickname + '" name="nickname">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<label>Contraseña: </label>' +
        '<input type="password" name="contra">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarNickname">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarNickname()">Cancelar</button>' +
        '</div>' +
        '</form>';
}

function cancelarNickname() {
    document.getElementById('divNickname').innerHTML = '<div>' +
        '<div><label>Nickname: </label><span id="nick">' + nickname + '</span></div>' +
        '<button onclick="modificarNickname()">Modificar</button>' +
        '</div>';
}

function modificarEmail() {
    email = document.getElementById('email').innerHTML;
    document.getElementById('divEmail').innerHTML = '<form action="menu.php?id=' + idU + '" method="POST">' +
        '<div class="form-grupo">' +
        '<label>Email: </label>' +
        '<input type="text" value="' + email + '" name="email">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<label>Contraseña: </label>' +
        '<input type="password" name="contra">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarEmail">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarEmail()">Cancelar</button>' +
        '</div>' +
        '</form>';
}

function cancelarEmail() {
    document.getElementById('divEmail').innerHTML = '<div>' +
        '<div><label>Email: </label><span id="email">' + email + '</span></div>' +
        '<button onclick="modificarEmail()">Modificar</button>' +
        '</div>';
}

function modificarTipo() {
    tipo = document.getElementById('tipo').innerHTML;
    document.getElementById('divTipo').innerHTML = '<form action="menu.php?id=' + idU + '" method="POST">' +
        '<div class="form-grupo">' +
        '<label>Tipo: </label>' +
        '<select name="tipo">' +
        '<option id="vendedor" value="vendedor">Vendedor</option>' +
        '<option id="administrador" value="administrador">Administrador</option>' +
        ' </select>' +
        '</div>' +
        '<div class="form-grupo">' +
        '<label>Contraseña: </label>' +
        '<input type="password" name="contra">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarTipo">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarTipo()">Cancelar</button>' +
        '</div>' +
        '</form>';

    document.getElementById(tipo).selected = true;
}

function cancelarTipo() {
    document.getElementById('divTipo').innerHTML = '<div>' +
        '<div><label>Nickname: </label><span id="tipo">' + tipo + '</span></div>' +
        '<button onclick="modificarTipo()">Modificar</button>' +
        '</div>';
}

function modificarContrasena() {
    nickname = document.getElementById('nick').innerHTML;
    document.getElementById('divContrasena').innerHTML = '<form action="menu.php?id=' + idU + '" method="POST">' +
        '<div class="form-grupo">' +
        '<label>Contraseña actual: </label>' +
        '<input type="password" name="contraAct">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<label>Contraseña nueva: </label>' +
        '<input type="password" name="contraNueva1">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<label>Confirmar: </label>' +
        '<input type="password" name="contraNueva2">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarContrasena">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarContrasena()">Cancelar</button>' +
        '</div>' +
        '</form>';
}

function cancelarContrasena() {
    document.getElementById('divContrasena').innerHTML = '<div>' +
        '<div><label>Contraseña: </label><span>**********</span></div>' +
        '<button onclick="modificarContrasena()">Modificar</button>' +
        '</div>';
}
