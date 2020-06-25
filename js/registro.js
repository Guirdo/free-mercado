document.getElementById('contra2').addEventListener("keyup", function (event) {
    contra1 = document.getElementById('contra1').value;
    contra2 = document.getElementById('contra2').value;

    if (contra1 != contra2) {
        document.getElementById('aviso').innerHTML = "<div id='mensaje'>Contraseñas no coinciden</div>";
    } else {
        document.getElementById('aviso').innerHTML = "";
    }
});

document.getElementById('contra1').addEventListener("keyup", function (event) {
    contra1 = document.getElementById('contra1').value;
    contra2 = document.getElementById('contra2').value;

    if (contra1 != contra2 && contra2 != "") {
        document.getElementById('aviso').innerHTML = "<div id='mensaje'>Contraseñas no coinciden</div>";
    } else if (contra1.length < 8) {
        document.getElementById('aviso').innerHTML = "<div id='mensaje'>Contraseña de ser minimo de 8 caracteres</div>";
    } else {
        document.getElementById('aviso').innerHTML = "";
    }
})
