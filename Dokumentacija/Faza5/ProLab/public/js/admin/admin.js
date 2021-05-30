$(document).ready(function () {
    let idStudent = $("#idS").val();

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

    $("#nav-lab-tab").click(function () {
        window.location.href = '/admin/subjects/' + idStudent + '/lab/list';
    });

    $("#nav-subjectPage-tab").click(function () {
        window.location.href = '/admin/subjects/' + idStudent;
    });
})
