$(document).ready(function (){
    $("#btn-termin-prijava").click(function (){
        $(".alert-danger").hide();
        let ispisGreske = document.getElementById("alert-nemogucaPrijava1");
        if(ispisGreske.getAttribute("about")=="greska"){
            ispisAlertNode.innerHTML = "Termin je pun. Pretražite ostale termine.";
            $(".alert-danger").show();
        }

    });


});
