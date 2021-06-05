$(document).ready(function() {
    $(".kreiraj-lab").click(function(){
        let subjectCode = $("#btn-kreiraj-lab").attr('data-code');
        let link = "/teacher/subject/" + subjectCode + "/lab/addLab";
        window.location = link;
    });
});