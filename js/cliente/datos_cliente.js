nombre = "";
apellido = "";
sexo = "";
rfc = "";
salario = "";
domicilio = "";
nickname = "";
email = "";

function modificarNombre() {
    nombre = document.getElementById('nombre').innerHTML;
    apellido = document.getElementById('apellido').innerHTML;
    document.getElementById("divNombre").innerHTML = '<form action="datos_cliente.php" method="POST">' +
        '<div class="form-grupo">' +
        '<label for="">Nombre(s):</label>' +
        '<input type="text" value="' + nombre + '" name="nombres">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<label for="">Apellidos:</label>' +
        '<input type="text" value="' + apellido + '" name="apellidos">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarNombre">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarNombre()">Cancelar</button>' +
        '</div>' +
        '</form>';
}

function cancelarNombre() {
    document.getElementById("divNombre").innerHTML = '<div>' +
        '<div><label>Nombre: </label><span><span id="nombre">' + nombre + '</span> <span id="apellido">' + apellido + '</span></span></div>' +
        '<button onclick="modificarNombre()">Modificar</button>' +
        '</div>';
}

function modificarSexo() {
    sexo = document.getElementById('sexo').innerHTML;
    document.getElementById("divSexo").innerHTML = '<form action="datos_cliente.php" method="POST">' +
        '<div class="form-grupo">' +
        '<label for="">Sexo:</label>' +
        '<div id="radioSexos">' +
        '<input type="radio" name="sexo" value="1" id="sexoM">Masculino' +
        '<input type="radio" name="sexo" value="2" id="sexoF" checked>Femenino' +
        '</div>' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarSexo">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarSexo()">Cancelar</button>' +
        '</div>' +
        '</form>';

    if (sexo == "MASCULINO") {
        document.getElementById('sexoM').checked = true;
    } else {
        document.getElementById('sexoF').checked = true;
    }
}

function cancelarSexo() {
    document.getElementById('divSexo').innerHTML = '<div>' +
        '<div> <label>Sexo: </label><span id="sexo">' + sexo + '</span></div>' +
        '<button onclick="modificarSexo()">Modificar</button>' +
        '</div>';
}

function modificarRfc() {
    rfc = document.getElementById('rfc').innerHTML;
    document.getElementById('divRfc').innerHTML = '<form action="datos_cliente.php" method="POST">' +
        '<div class="form-grupo">' +
        '<label for="">RFC:</label>' +
        '<input type="text" value="' + rfc + '" name="rfc">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarRfc">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarRfc()">Cancelar</button>' +
        '</div>' +
        '</form>';
}

function cancelarRfc() {
    document.getElementById('divRfc').innerHTML = '<div>' +
        '<div><label>RFC:</label><span id="rfc">' + rfc + '</span></div>' +
        '<button onclick="modificarRfc()">Modificar</button>' +
        '</div>';
}

function modificarSalario() {
    salario = document.getElementById('salario').innerHTML;
    document.getElementById('divSalario').innerHTML = '<form action="datos_cliente.php" method="POST">' +
        '<div class="form-grupo">' +
        '<label for="">Salario:</label>' +
        '<input type="number" step="any" value="' + salario + '" name="salario">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarSalario">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarSalario()">Cancelar</button>' +
        '</div>' +
        '</form>';
}

function cancelarSalario() {
    document.getElementById('divSalario').innerHTML = '<div>' +
        '<div><label>Salario:</label><span>$<span id="salario">' + salario + '</span></span></div>' +
        '<button onclick="modificarSalario()">Modificar</button>' +
        '</div>';
}

function modificarDomicilio() {
    domicilio = document.getElementById('domicilio').innerHTML;
    console.log(domicilio);
    document.getElementById('divDomicilio').innerHTML = '<form action="datos_cliente.php" method="POST">' +
        '<div class="form-grupo">' +
        '<textarea name="domicilio"  cols="50" rows="3">' + domicilio + '</textarea>' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarDomicilio">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarDomicilio()">Cancelar</button>' +
        '</div>' +
        '</form>';
}

function cancelarDomicilio() {
    document.getElementById('divDomicilio').innerHTML = '<div>' +
        '<div><span id="domicilio">' + domicilio + '</span></div>' +
        '<button onclick="modificarDomiclio()">Modificar</button>' +
        '</div>';
}

function modificarNickname() {
    nickname = document.getElementById('nick').innerHTML;
    document.getElementById('divNickname').innerHTML = '<form action="datos_cliente.php" method="POST">' +
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
    document.getElementById('divEmail').innerHTML = '<form action="datos_cliente.php" method="POST">' +
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

function modificarContrasena() {
    nickname = document.getElementById('nick').innerHTML;
    document.getElementById('divContrasena').innerHTML = '<form action="datos_cliente.php" method="POST">' +
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


