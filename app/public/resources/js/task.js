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

function onSelectorFilter(selector) {

    $.ajax({
        url: "/task/filterBy",
        type: "post",
        data: {
            filterBy: selector.value
        },
        success() {
            window.location.reload();
        }
    });
}


function searchTable() {
    console.log("asfsdf");
    let input, filter, table, tr, i;
    let td0, td1, td2, td3,td4,td5,td6;
    let txtValue0, txtValue1, txtValue2, txtValue3,txtValue4,txtValue5,txtValue6;

    input = document.getElementById("searchBar");
    filter = input.value.toUpperCase();
    table = document.getElementById("tabla");

    if (table) {
        tr = table.getElementsByTagName("tr");
        let emptyView = document.getElementById("coursesNotFound");

        for (i = 0; i < tr.length; i++) {
            td0 = tr[i].getElementsByTagName("td")[0];
            td1 = tr[i].getElementsByTagName("td")[1];
            td2 = tr[i].getElementsByTagName("td")[2];
            td3 = tr[i].getElementsByTagName("td")[3];
            td4 = tr[i].getElementsByTagName("td")[4];
            td5 = tr[i].getElementsByTagName("td")[5];
            td6 = tr[i].getElementsByTagName("td")[6];
            if (td0 || td1 || td2 || td3) {
                txtValue0 = td0.textContent || td0.innerText;
                txtValue1 = td1.textContent || td1.innerText;
                txtValue2 = td2.textContent || td2.innerText;
                txtValue3 = td3.textContent || td3.innerText;
                txtValue4 = td4.textContent || td4.innerText;
                txtValue5 = td5.textContent || td5.innerText;
                txtValue6 = td6.textContent || td6.innerText;
                if (
                    txtValue0.toUpperCase().indexOf(filter) > -1 ||
                    txtValue1.toUpperCase().indexOf(filter) > -1 ||
                    txtValue2.toUpperCase().indexOf(filter) > -1 ||
                    txtValue3.toUpperCase().indexOf(filter) > -1 ||
                    txtValue4.toUpperCase().indexOf(filter) > -1 ||
                    txtValue5.toUpperCase().indexOf(filter) > -1 ||
                    txtValue6.toUpperCase().indexOf(filter) > -1
                ) {
                    tr[i].style.display = "";
                    document.getElementById("tabla").style.display = "";
                    emptyView.style.display = "none"
                } else {
                    //Hidden table
                    document.getElementById("tabla").style.display = "none";
                    //Show empty view
                    emptyView.style.display = ""
                    tr[i].style.display = "none";
                }
            }
        }
    }
}