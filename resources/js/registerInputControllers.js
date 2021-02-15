var curso = document.getElementById("selector1")
var fnac = document.getElementById("selector2")

var codcurso = document.getElementById("codcurso")
var alumnmo = document.getElementById("alumno")
var profesor = document.getElementById("profesor")

//Cuando cargue la pagina se selecciona el alumno, para evitar bugs cuando le des a atras desde otra pagina
$( document ).ready(function() {
    alumnmo.checked = true
    curso.hidden = false
    fnac.hidden = false
    codcurso.required = true
});

//Observa los radiobuttons para añadir acciones
alumnmo.addEventListener("click", function () {
    curso.hidden = false
    fnac.hidden = false
    codcurso.required = true
});

profesor.addEventListener("click", function () {
    curso.hidden = true
    fnac.hidden = true
    codcurso.required = false
});

