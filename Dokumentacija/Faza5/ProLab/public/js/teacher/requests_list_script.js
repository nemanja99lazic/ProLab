$(document).ready(function (){
    $("#btn-prihvati-zahtev").click(function (){
        $(".alert-info").hide();
        let ispisAlertNode = document.getElementById("alert-ispis");
        ispisAlertNode.innerHTML = "Zahtev prihvacen";
        $(".alert-info").show().delay(3000).fadeOut(400);
    });

    $("#btn-odbij-zahtev").click(function (){
        $(".alert-info").hide();
        let ispisAlertNode = document.getElementById("alert-ispis");
        ispisAlertNode.innerHTML = "Zahtev odbijen";
        $(".alert-info").show().delay(3000).fadeOut(400);
    });

});