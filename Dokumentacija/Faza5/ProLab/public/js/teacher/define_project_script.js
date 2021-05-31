/* 
    Nemanja Lazic 2018/0004
*/

$(document).ready(function(){
    setAjaxHeader();
    setMinDate();

    $("button.close").click(function(){
        $(".modal").hide();
    });

    $("#btn-nazad").click(function(){
        let subjectCode = $(this).attr('data-code');
        let backlink = "/teacher/subject/" + subjectCode + "/project";
        window.location = backlink;
    });

    let naziv = "";
    let minBrClanova = "";
    let maxBrClanova = "";
    let rok = "";
    $("#btn-potvrdi-definisanje").click(function(){
        naziv = document.getElementById("nazivProjekta").value;
        minBrClanova = parseInt(document.getElementById("minBrojClanova").value);
        maxBrClanova = parseInt(document.getElementById("maxBrojClanova").value);
        rok = document.getElementById("rok").value;

        if(naziv == "" || minBrClanova == "" || maxBrClanova == "" || rok == "")
        {
            alert('Neko polje nije uneseno. Proverite da li ste uneli sva polja u formi.');
            return;
        }

        if(minBrClanova > maxBrClanova){
            let porukaGreska = "Uneseni minimalan broj članova je veći od maksimalnog broja članova."
            $("#alert").removeClass(); // Izbrisace sve klase
            $("#alert").addClass('alert alert-danger alert-dismissible');
            $("#alert-tekst").text(porukaGreska);
            $(".alert").show().delay(3000).fadeOut(300);
            //$(".alert").removeClass('alert-danger');
            //$("#alert-tekst").text('');
            return;
        }

        // Dopuni modal
        $("#modal-naziv-projekta").text(naziv);
        $("#modal-min-broj-clanova").text(minBrClanova);
        $("#modal-max-broj-clanova").text(maxBrClanova);
        $("#modal-rok").text(rok);

        $(".modal").show();
    });

    $("#modal-btn-potvrdi").click(function(){
        let subjectCode = $("#btn-nazad").attr('data-code'); // u tom buttonu imamo upisan kod naseg predmeta kao atribut
        let myNaziv = naziv;
        let myMinBrClanova = minBrClanova;
        let myMaxBrClanova = maxBrClanova;
        let myRok = rok;
        naziv = "";
        minBrClanova = "";
        maxBrClanova = "";
        rok = "";

        if(myNaziv != "" && myMinBrClanova != "" && myMaxBrClanova != "" && myRok != "")
        {
            $.ajax({
                type: "POST",
                url: '/teacher/subject/' + subjectCode + '/project/define',
                data: { nazivProjekta: myNaziv,
                        minBrojClanova: myMinBrClanova, 
                        maxBrojClanova: myMaxBrClanova,
                        rok: myRok,
                        code: subjectCode
                      }
            }).done(function(response){
                let poruka = response.message;
                $("#alert").removeClass(); // Izbrisace sve klase
                $("#alert").addClass('alert alert-success alert-dismissible');
                $("#alert-tekst").text(poruka);
                $(".alert").show().delay(3000).fadeOut(300);
            }).fail(function(responseObject, textStatus, error) {   // 
                let poruka = 'GREŠKA! ' + responseObject.responseJSON['message'];
                $("#alert").removeClass(); // Izbrisace sve klase
                $("#alert").addClass('alert alert-danger alert-dismissible');
                $("#alert-tekst").text(poruka);
                $(".alert").show().delay(3000).fadeOut(300);
          });
        }
        else
        {
            alert("Greska!");
        }
        $(".modal").hide();
    });

    $("#modal-btn-izmeni").click(function(){
        $(".modal").hide();
    });

    /**
     * Postavlja donje ogranicenje za datum na danasnji, da korisnik ne bi mogao da unese
     * datum koji je prosao
     */
    function setMinDate(){
        let currentDate = new Date();
        let day = currentDate.getDate();
        let month = currentDate.getMonth() + 1;
        let year = currentDate.getFullYear();
        day = (day < 10) ? ('0' + day) : day;
        month = (month < 10) ? ('0' + month) : month;
        let min = year + '-' + month + '-' + day;
        
        $("#rok").attr('min', min);
    }
    /**
     * Ubacivanje csrf tokena u header ajax zahteva
     */
    function setAjaxHeader()
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
});