$(document).ready(function (){
    $("#btn-prihvati-zahtev").click(function (){
        $(".alert-info").hide();
        let ispisAlertNode = document.getElementById("alert-ispis");
        ispisAlertNode.innerHTML = "Zahtev prihvacen";
        $(".alert-info").show();
    });

    $("#btn-odbij-zahtev").click(function (){
        $(".alert-info").hide();
        let ispisAlertNode = document.getElementById("alert-ispis");
        ispisAlertNode.innerHTML = "Zahtev odbijen";
        $(".alert-info").show();
    });
    $("#btn-termin-prijava").click(function (){
        $(".alert-danger").hide();
        let ispisAlertNode = document.getElementById("alert-nemogucaPrijava");
        ispisAlertNode.innerHTML = "Termin je pun. Vaša prijava je odbijena.";
        $(".alert-danger").show();
    });

});
