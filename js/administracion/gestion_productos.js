id = "";
nombre = "";
descripcion = "";
cantidad = "";
precio = "";
categoria = "";

function modificarProducto(idP, nom, desc, cant, pre, cat) {
    id = idP;
    nombre = nom;
    descripcion = desc;
    cantidad = cant;
    precio = pre;
    categoria = cat;
    document.getElementById("divDatosUsuario").innerHTML = '<div class="contenedor" id="divUsuario">' +
        '<div class="contenedor">' +
        '<h3>Datos de producto #' + idP + '</h3>' +
        '</div>' +
        '<div class="contenedor">' +
        '<div class="datos" id="divNombre">' +
        '<div>' +
        '<div><label>Nombre: </label><span id="nombre">' + nombre + '</span></div>' +
        '<button onclick="modificarNombre()">Modificar</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="contenedor">' +
        '<div class="datos" id="divDescripcion">' +
        '<div>' +
        '<div><label>Descripcion: </label><span id="descripcion">' + descripcion + '</span></div>' +
        '<button onclick="modificarDescripcion()">Modificar</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="contenedor">' +
        '<div class="datos" id="divCantidad">' +
        '<div>' +
        '<div><label>Cantidad: </label><span id="cantidad">' + cantidad + '</span></div>' +
        '<button onclick="modificarCantidad()">Modificar</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="contenedor">' +
        '<div class="datos" id="divPrecio">' +
        '<div>' +
        '<div><label>Precio ($): </label><span id="precio">' + precio + '</span></div>' +
        '<button onclick="modificarPrecio()">Modificar</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="contenedor">' +
        '<div class="datos" id="divCategoria">' +
        '<div>' +
        '<div><label>Categoria: </label><span id="categoria">' + categoria + '</span></div>' +
        '<button onclick="modificarCategoria()">Modificar</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="contenedor">' +
        '<div class="datos" id="divImagen">' +
        '<form enctype="multipart/form-data" action="visualizar_productos.php?id=' + id + '" method="POST">' +
        '<div class="form-grupo">' +
        '<label for="">Imagen:</label>' +
        '<input type="file" accept="image/*" name="foto" onchange="preview_image(event)">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<div class="contenedor">' +
        '<img src="../../php/helpers/ver_imagen.php?id=' + id + '" id="preview" alt="Preview">' +
        '</div>' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="subirImagen">Subir</button>' +
        '</div>' +
        '</form>' +
        '</div>' +
        '</div>' +
        '</div>';
}

function eliminarProducto(id) {
    document.getElementById('divDatosUsuario').innerHTML = '<div id="divEliminar">'+
    '<div class="datos">' +
        '<form action="visualizar_productos.php?id='+id+'" method="POST">' +
        '<div class="form-grupo">' +
        '<h4>¿Esta seguro de eliminar el producto #'+id+'?</h4>' +
        '</div>' +
        '<div class="form-grupo">' +
        '<label for="">Introduzca su contraseña:</label>' +
        '<input type="password" name="password">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="eliminarProducto">Confirmar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarEliminar()">Cancelar</button>' +
        '</div>' +
        '</form>' +
        '</div>' +
        '</div>';
}

function cancelarEliminar(){
    document.getElementById('divDatosUsuario').innerHTML = "";
}

function modificarNombre() {
    document.getElementById('divNombre').innerHTML = '<form action="visualizar_productos.php?id='+id+'" method="POST">' +
        '<div class="form-grupo">' +
        '<label>Nombre: </label>' +
        '<input type="text" value="' + nombre + '" name="nombre">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarNombre">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarNombre()">Cancelar</button>' +
        '</div>' +
        '</form>';
}

function cancelarNombre() {
    document.getElementById('divNombre').innerHTML = '<div>' +
        '<div><label>Nickname: </label><span id="nombre">' + nombre + '</span></div>' +
        '<button onclick="modificarNombre()">Modificar</button>' +
        '</div>';
}

function modificarDescripcion() {
    document.getElementById('divDescripcion').innerHTML = '<form action="visualizar_productos.php?id='+id+'" method="POST">' +
        '<div class="form-grupo">' +
        '<label>Descripcion: </label>' +
        '<textarea name="descripcion" cols="30" rows="4">' + descripcion + '</textarea>' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarDescripcion">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarDescripcion()">Cancelar</button>' +
        '</div>' +
        '</form>';
}

function cancelarDescripcion() {
    document.getElementById('divDescripcion').innerHTML = '<div>' +
        '<div><label>Nickname: </label><span id="descripcion">' + descripcion + '</span></div>' +
        '<button onclick="modificarDescripcion()">Modificar</button>' +
        '</div>';
}

function modificarCantidad() {
    document.getElementById('divCantidad').innerHTML = '<form action="visualizar_productos.php?id='+id+'" method="POST">' +
        '<div class="form-grupo">' +
        '<label>Cantidad: </label>' +
        '<input type="number" value="' + cantidad + '" name="cantidad">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarCantidad">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarCantidad()">Cancelar</button>' +
        '</div>' +
        '</form>';
}

function cancelarCantidad() {
    document.getElementById('divCantidad').innerHTML = '<div>' +
        '<div><label>Cantidad: </label><span id="cantidad">' + cantidad + '</span></div>' +
        '<button onclick="modificarCantidad()">Modificar</button>' +
        '</div>';
}

function modificarPrecio() {
    document.getElementById('divPrecio').innerHTML = '<form action="visualizar_productos.php?id='+id+'" method="POST">' +
        '<div class="form-grupo">' +
        '<label>Precio: </label>' +
        '<input type="number" step="0.01" value="' + precio + '" name="precio">' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarPrecio">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarPrecio()">Cancelar</button>' +
        '</div>' +
        '</form>';
}

function cancelarPrecio() {
    document.getElementById('divPrecio').innerHTML = '<div>' +
        '<div><label>Cantidad: </label><span id="precio">' + precio + '</span></div>' +
        '<button onclick="modificarPrecio()">Modificar</button>' +
        '</div>';
}

function modificarCategoria() {
    document.getElementById('divCategoria').innerHTML = '<form action="visualizar_productos.php?id='+id+'" method="POST">' +
        '<div class="form-grupo">' +
        '<label>Categoria: </label>' +
        '<select id="categorias" name="categoria">' +
        '<option value="1">Ropa</option>' +
        '<option value="2">Electrodomestico</option>' +
        '<option value="3">Tecnologia</option>' +
        '<option value="4">Juguetes</option>' +
        '<option value="5">Muebles</option>' +
        '<option value="6">Mascotas</option>' +
        '</select>' +
        '</div>' +
        '<div class="form-grupo">' +
        '<button class="btn-form" type="submit" name="modificarCategoria">Modificar</button>' +
        '<button class="btn-form btn-cancelar" onclick="cancelarCategoria()">Cancelar</button>' +
        '</div>' +
        '</form>';

    opciones = document.getElementById('categorias');
    for (i = 0; i < 6; i++) {
        if(opciones.options[i].text.toUpperCase() == categoria.toUpperCase()){
            opciones.options[i].selected = true;
            break;
        }
    }
}

function cancelarCategoria() {
    document.getElementById('divCategoria').innerHTML = '<div>' +
        '<div><label>Categoria: </label><span id="categoria">' + categoria + '</span></div>' +
        '<button onclick="modificarCategoria()">Modificar</button>' +
        '</div>';
}