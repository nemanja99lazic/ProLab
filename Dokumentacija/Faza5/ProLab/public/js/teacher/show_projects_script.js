$(document).ready(function(){
    
    setAjaxHeader();

    let code = null;
    let idProject = null;
    $(".btn-ukloni-projekat").click(function(){
        code = $(this).attr("data-code");
        idProject = $(this).attr("data-idProject");
        $(".modal").show();
    });
    $("#modal-btn-ukloni").click(function(){
        let myCode = code;
        let myIdProject = idProject;
        code = null;
        idProject = null;

        if(myCode != null && myIdProject != null)
        {   
            // Posalji ajax, CSRF token mora obavezno da se prosledi, inace javlja error
            $.ajax({
                type: "POST",
                url: '/teacher/subject/' + myCode + '/project/removeProject',
                data: {
                        idProject: myIdProject
                        }
            }).done(function(response){ // dobija jquery 
                $("#alert-ispis").html(response.message);
                document.getElementById(response.idProject).remove(); // izbrisi red iz tabele
                $(".alert").show().delay(3000).fadeOut(400);
            }).fail(function(response){
                $("#alert-ispis").html(response.message);
                $(".alert").show().delay(3000).fadeOut(400);
            });
        }

        $(".modal").hide();
    })

    $("#modal-btn-otkazi").click(function(){
        $(".modal").hide();
    });

    function setAjaxHeader()
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

});