$(document).ready(function(){
    let subjectCode = $("#sifraPredmeta").val();
    let idAppointment = $("#sifraLaba").val();
    $("#nav-subject-tab").click(function () {
        window.location.href = '/student/subject/' + subjectCode+'/index';
    });
    $("#nav-lab-tab").click(function () {
        window.location.href = '/student/subject/' + subjectCode+'/lab';
    });
    $("#nav-project-tab").click(function () {
        window.location.href = '/student/subject/' + subjectCode+'/project';
    });

    $("#v-pill-joinAppointment").click(function () {
        window.location.href = '/student/subject/' + subjectCode+'/lab/'+idAppointment+'/join';
    });
    $("#v-pill-swapAppointments").click(function () {
        window.location.href = '/student/subject/' + subjectCode+'/lab/'+idAppointment+'/swap';
    });
    $("#v-pill-swapRequest").click(function () {
        window.location.href = '/student/subject/' + subjectCode+'/lab/'+idAppointment+'/request';
    });


});
