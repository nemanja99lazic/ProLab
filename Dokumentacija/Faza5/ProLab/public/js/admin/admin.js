$(document).ready(function () {
    setAjaxHeader();

    let subjectCode = $("#subjectCode").val();

    $("#v-pill-registerRequest").click(function () {
        window.location.href = '/admin/requests/register';
    });

    $("#v-pill-newSubjectRequest").click(function () {
        window.location.href = '/admin/requests/newSubjects';
    });

    $("#nav-subject-tab").click(function () {
        window.location.href = '/admin/subjects/list';
    });

    $("#nav-request-tab").click(function () {
        window.location.href = '/admin/requests/register';
    });

    // $("#nav-lab-tab").click(function () {
    //     window.location.href = '/admin/subjects/' + idStudent + '/lab/list';
    // });
    //
    // $("#nav-subjectPage-tab").click(function () {
    //     window.location.href = '/admin/subjects/' + idStudent;
    // });

    $("#nav-lab-tab").click(function () {
        window.location.href = '/admin/subjects/' + subjectCode + '/lab/list';
    });

    $("#nav-subjectPage-tab").click(function () {
        window.location.href = '/admin/subjects/' + subjectCode;
    });

    $("#nav-project-tab").click(function () {
        window.location.href = '/admin/subjects/' + subjectCode + '/project';
    });

    $("#nav-user-tab").click(function () {
        window.location.href = '/admin/users/search';
    });

    let idTableRow = "";
    let idUser = "";
    let userType = "";

    $(".remove").click(function () {
        idUser = idTableRow = $(this).attr("name");
    });

    $(".delete-user").click(function () {
        userType = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: '/admin/users/' + userType + '/'+ idUser +'/delete'
        }).done(function(response) {
            $("#modal" + idUser).modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $("#" + idTableRow).remove();
        });
    });

});

function setAjaxHeader() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}


