var creditos = firebase.firestore().collection('creditos');

function crear_credito(idUsuario, idVenta, montoTotal,plazo) {
    credito = credito_json(idUsuario,idVenta,montoTotal,plazo);
    creditos.add(credito).then(function (docRef) {
        console.log("Document written with ID: ", docRef.id);
        console.log("¡Crédito creado con exito!");
        location.href = "../../index.php";
    })
        .catch(function (error) {
            console.error("Error adding document: ", error);
        });
}


function credito_json(idUsuario, idVenta, montoTotal,plazo) {

    var data = {
        idUsuario: idUsuario,
        idVenta: idVenta,
        montoTotal: montoTotal,
        plazo: plazo,
        mesesPagados: 0
    };

    return data;
}