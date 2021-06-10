/*
    - Nemanja Lazic 2018/0004
*/

$(document).ready(function(){
    //let max = 16777215;
    let max =   10000000;
    let colorNumber = Math.floor(Math.random() * max);
    let color = "#" + dopuniColorNumber(colorNumber.toString(16)); // Generisi random boju od #000000 do #FFFFFF
    let width = $("#student-circle-inicijali").css("width");
    $("#student-circle-inicijali").css({"height" : width,
                                        "font-size": (0.5 * parseFloat(width) + "px"),
                                        "line-height": width,
                                        "background-color": color});
    postaviInicijale();

    $(window).resize(function(){
        let width = $("#student-circle-inicijali").css("width");
        $("#student-circle-inicijali").css({"height" : width,
                                        "font-size": (0.5 * parseFloat(width) + "px"),
                                        "line-height": width,
                                        "background-color": color});
    });

    function postaviInicijale(){
        let imePrezime = $("#desno-ime-prezime").text().split(" ");
        let ime = imePrezime[0];
        let prezime = imePrezime[1];
        let inicijali = ime[0] + prezime[0];
        inicijali = inicijali.toUpperCase();
        $("#student-circle-inicijali").text(inicijali);
    }

    function dopuniColorNumber(colorNumber)
    {
        let brojCifara = 6;
        potrebanBrojNula = brojCifara - colorNumber.length;
        for(let i = 0; i < potrebanBrojNula; i++)
            colorNumber = "0" + colorNumber;
        return colorNumber;
    }
});
