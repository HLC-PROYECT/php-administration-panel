function myAjax(id) {
    $.ajax({
        type: "POST",
        url: 'tarea.php',
        data:{action:id},
    });
}