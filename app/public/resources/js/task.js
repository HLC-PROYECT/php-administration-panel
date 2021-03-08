$("#addTask").on('hidden.bs.modal', function () {
    document.getElementById('addTaskLabel').innerHTML = 'New task';
    document.getElementById('form_name').value = '';
    document.getElementById('form_description').value = '';
    document.getElementById('form_startDate').value = '';
    document.getElementById('form_endDate').value = '';
    document.getElementById('form_taskId').value = '';
})

function edit(taskId) {

    $.ajax({
        url: "/task/fetch",
        type: "post",
        data: {
            taskId: taskId
        },
        success(response) {
            response = response.substring(response.indexOf('{'), response.indexOf('}') + 1);
            response = JSON.parse(response);
            document.getElementById('addTaskLabel').innerHTML = 'Edit task';
            document.getElementById('form_name').value = response.name;
            document.getElementById('form_description').value = response.description;
            document.getElementById('form_startDate').value = response.startDate;
            document.getElementById('form_endDate').value = response.endDate;
            document.getElementById('form_taskId').value = response.taskId;
            document.getElementById('subjectId').value = response.subjectId;
            //Open modal
            $('#addTask').modal('show');
        }
    });
}

function remove(taskId) {
    $.ajax({
        url: "/task/delete",
        type: "post",
        data: {
            taskId: taskId
        },
        beforeSend: function () {
            $('#loader').removeClass('hidden')
        },
        success(response) {
            console.log('ok');
            window.location.reload();
        },
        complete: function () {
            $('#loader').addClass('hidden')
        },
    });
}

function send(taskId) {
    $.ajax({
        url: "/task/send",
        type: "post",
        data: {
            taskId: taskId
        },
        beforeSend: function () {
            $('#loader').removeClass('hidden')
        },
        success(response) {
            window.location.reload();
        },
        complete: function () {
            $('#loader').addClass('hidden')
        },
    });
}
