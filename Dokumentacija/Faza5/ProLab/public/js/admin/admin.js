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
    let idStudent = "";

    $(".remove").click(function () {
        idTableRow = $(this).attr("name");
    });

    $(".delete-student").click(function (e) {
        idStudent = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: '/admin/users/student/'+ idStudent +'/delete',
        }).done(function(response) {
            $("#modal" + idStudent).modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $("#" + idTableRow).remove();
        });
    });

    $("#search-button").click(function () {
        localStorage.setItem('searchInput', $("#search-field").val());
    })
});

function setAjaxHeader() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}


