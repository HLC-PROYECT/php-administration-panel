function edit(subjectId, event) {
    const subject = $(event).data('domain');
    const formSubject = document.querySelector('form[action="/subject/save"]');
    formSubject.querySelector('#addSubjectLabel').innerHTML = 'Edit subject';
    formSubject.querySelector('input[name="name"]').value = subject.name;
    formSubject.querySelector('input[name="nHours"]').value = subject.numHours;
    formSubject.querySelector('input[name="endingYear"]').value = subject.yearEnd;
    formSubject.querySelector('select[name="course"]').value = subject.course.courseId;
    formSubject.querySelector('select[name="teacher"]').value = subject.teacher.identificationDocument;
    formSubject.querySelector('button[name="submit"]').innerHTML = 'Update';
    formSubject.querySelector('input[name="id"]').value = subject.subjectId;
    $(formSubject).attr('action', '/subject/update');
    $('#addSubject').modal('show');
}

function addTask(subjectId, event) {
    const subject = $(event).data('domain');
    const formTask = document.querySelector('form[action="/task/save"]');
    formTask.querySelector('#addTaskLabel').innerHTML = 'Add task to ' + subject.name;

    const subjectSelector = formTask.querySelector('select[name="subjectId"]');
    subjectSelector.value = subjectId;
    subjectSelector.style.display = 'none';

    const subjectInput = formTask.querySelector('#subjectName');
    subjectInput.value = subject.name;
    subjectInput.style.display = 'block';

    $('#addTask').modal('show');
}

function onSelectorOrder(selector) {
    $.ajax({
        url: "/subject/orderBy",
        type: "post",
        data: {
            orderBy: selector.value
        },
        success() {
            window.location.reload();
        }
    });
}

function searchTable(){
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
            if (td0 || td1 || td2 || td3 || td4 ) {
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