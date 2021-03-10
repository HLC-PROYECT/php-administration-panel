onHiddenModal();

let joinSelector = document.getElementById('joinCourse');
joinSelector.addEventListener('change', function () {
    if (joinSelector.value !== 0) {
        $.ajax({
            url: "/course/join",
            type: "post",
            data: {
                courseToJoin: joinSelector.value
            },
            beforeSend: function () {
                $('#loader').removeClass('hidden')
            },
            success() {
                window.location.reload();
            },
            complete: function () {
                $('#loader').addClass('hidden')
            },
        });
    }
})

function onHiddenModal() {
    $("#addTask").on('hidden.bs.modal', function () {
        document.getElementById('addCourseLabel').innerHTML = 'New Course';
        document.getElementById('form_educationCenter').value = '';
        document.getElementById('form_startYear').value = '';
        document.getElementById('form_endYear').value = '';
        document.getElementById('form_description').value = '';
        document.getElementById('form_courseId').value = '';
    })
}

function onSelectorOrder(selector) {
    $.ajax({
        url: "/course/orderBy",
        type: "post",
        data: {
            orderBy: selector.value
        },
        success() {
            window.location.reload();
        }
    });
}


function leave(courseId) {
    $.ajax({
        url: "/course/leave",
        type: "post",
        data: {
            courseId: courseId
        },
        beforeSend: function () {
            $('#loader').removeClass('hidden')
        },
        success() {
            window.location.reload();
        },
        complete: function () {
            $('#loader').addClass('hidden')
        }
    });
}

function edit(courseId) {
    $.ajax({
        url: "/course/fetchCourse",
        type: "post",
        data: {
            courseId: courseId
        },
        success(response) {
            response = response.substring(response.indexOf('{'), response.indexOf('}') + 1);
            response = JSON.parse(response);
            document.getElementById('addCourseLabel').innerHTML = 'Edit course';
            document.getElementById('form_educationCenter').value = response.educationCenter;
            document.getElementById('form_startYear').value = response.startYear;
            document.getElementById('form_endYear').value = response.endYear;
            document.getElementById('form_description').value = response.description;
            document.getElementById('form_courseId').value = response.courseId;
            //Open modal
            $('#addTask').modal('show');
        }
    });
}

function remove(courseId) {
    $.ajax({
        url: "/course/delete",
        type: "post",
        data: {
            courseId: courseId
        },
        beforeSend: function () {
            $('#loader').removeClass('hidden')
        },
        success() {
            window.location.reload();
        },
        complete: function () {
            $('#loader').addClass('hidden')
        },
    });
}

function searchTable() {
    let input, filter, table, tr, i;
    let td0, td1, td2, td3, td4;
    let txtValue0, txtValue1, txtValue2, txtValue3, txtValue4;

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
            if (td0 || td1 || td2 || td3 || td4) {
                txtValue0 = td0.textContent || td0.innerText;
                txtValue1 = td1.textContent || td1.innerText;
                txtValue2 = td2.textContent || td2.innerText;
                txtValue3 = td3.textContent || td3.innerText;
                txtValue4 = td4.textContent || td4.innerText;
                if (
                    txtValue0.toUpperCase().indexOf(filter) > -1 ||
                    txtValue1.toUpperCase().indexOf(filter) > -1 ||
                    txtValue2.toUpperCase().indexOf(filter) > -1 ||
                    txtValue3.toUpperCase().indexOf(filter) > -1 ||
                    txtValue4.toUpperCase().indexOf(filter) > -1
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
