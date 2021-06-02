// Nemanja Lazic 2018/0004

$(document).ready(function (){
    let appointments = [];

    setAjaxHeader();
    setMinDateTime();
    postaviOnClickListenerZaDodajTermin();

    $(".close").click(function(){
        $("#alert").hide();
    })

    $("#btn-nazad").click(function(){
        let subjectCode = $("#btn-nazad").attr('data-code');
        let link = "/teacher/subject/" + subjectCode + "/lab";
        window.location = link;
    });

    $("#btn-definisi-lab").click(function(){

        let subjectCode = $("#btn-definisi-lab").attr('data-code');
        let labExerciseName = document.getElementById("ime-laba").value;
        let labExerciseDescription = document.getElementById("opis-laba").value;
        let labExerciseDateTime = document.getElementById("rok-laba").value;

        if(labExerciseName != "" && labExerciseDescription != "" && labExerciseDateTime != "")
        {
            datetimeSQLFormat = labExerciseDateTime.split('T');
            labExerciseDateTime = datetimeSQLFormat[0] + " " + datetimeSQLFormat[1] + ":00"; // predstavljanje u formatu pogodnom za upis u bazu

            $.ajax({
                type: "POST",
                url: '/teacher/subject/' + subjectCode + '/lab/addLab',
                data:   {
                            name: labExerciseName,
                            description: labExerciseDescription,
                            expiration: labExerciseDateTime,
                            appointments: appointments
                        }
            }).done(function(response){
                let porukaGreska = "Laboratorijska vežba uspešno kreirana."
                $("#alert").removeClass(); // Izbrisace sve klase
                $("#alert").addClass('alert alert-success alert-dismissible');
                $("#alert-tekst").text(porukaGreska);
                $(".alert").show().delay(3000).fadeOut(300);
                return;
            }).fail(function(responseObject, textStatus, error){
                let porukaGreska = "Greška na serveru!"
                $("#alert").removeClass(); // Izbrisace sve klase
                $("#alert").addClass('alert alert-danger alert-dismissible');
                $("#alert-tekst").text(porukaGreska);
                $(".alert").show().delay(3000).fadeOut(300);
                return;
            });
        }
        else
        {
            let porukaGreska = "Neko polje za unos laboratorijske vežbe nije uneseno. Sva polja su obavezna."
            $("#alert").removeClass(); // Izbrisace sve klase
            $("#alert").addClass('alert alert-danger alert-dismissible');
            $("#alert-tekst").text(porukaGreska);
            $(".alert").show().delay(3000).fadeOut(300);
            return;
        }
    });


    /**
     * Postavlja minimum za datum na danasnji dan
     */
    function setMinDateTime(){
        let currentDate = new Date();
        let day = currentDate.getDate();
        let month = currentDate.getMonth() + 1;
        let year = currentDate.getFullYear();
        day = (day < 10) ? ('0' + day) : day;
        month = (month < 10) ? ('0' + month) : month;
        let min = year + '-' + month + '-' + day + 'T00:00'; // format za datum vreme
        
        $(".datum-vreme-polje").attr('min', min);
    }

    /**
     * Treba da doda novi termin u tabelu i formu da pomeri za jedno mesto
     * 
     * @param {*} newAppointment - novi termin za upis u tabelu 
     */
    function srediTabeluTermina(newAppointment)
    {
        let rowForma = $("#forma-dodaj-lab");
        $("#tabela-termini").find("tbody").children().last().remove(); // uklonjena forma
        
        let noviTerminRow = $("<tr></tr>");
        let colSala = $("<td></td>").text(newAppointment.classroom);
        let colKapacitet = $("<td></td>").text(newAppointment.capacity);
        let colLokacija = $("<td></td>").text(newAppointment.location);
        let colDatumVreme = $("<td></td>").text(newAppointment.datetime);
        let colPrazno = $("<td></td>");
        noviTerminRow.append(colSala);
        noviTerminRow.append(colKapacitet);
        noviTerminRow.append(colLokacija);
        noviTerminRow.append(colDatumVreme);
        noviTerminRow.append(colPrazno);
        
        $("#tabela-termini").find("tbody").append(noviTerminRow);
        
        $("#tabela-termini").find("tbody").append(rowForma);
        postaviOnClickListenerZaDodajTermin();

    }

    function postaviOnClickListenerZaDodajTermin()
    {
        $("#btn-dodaj-termin").click(function(){
            let classroom = document.getElementById("sala").value;
            let capacity = document.getElementById("kapacitet").value;
            let location = document.getElementById("lokacija").value;
            let datetime = document.getElementById("datum-vreme").value;
           
            if(classroom != "" && capacity != "" && location != "" && datetime != "")
            {
                capacity = parseInt(capacity);
                datetimeSQLFormat = datetime.split("T");
                datetime = datetimeSQLFormat[0] + " " + datetimeSQLFormat[1] + ":00"; // primer: 2021-06-01T16:37 ----> 2021-06-01 16:37:00
                
                newAppointment = {classroom: classroom, capacity: capacity, location: location, datetime: datetime};
                appointments.push(newAppointment);
    
                srediTabeluTermina(newAppointment);
            }
            else
            {
                let porukaGreska = "Neko polje za unos termina nije uneseno."
                $("#alert").removeClass(); // Izbrisace sve klase
                $("#alert").addClass('alert alert-danger alert-dismissible');
                $("#alert-tekst").text(porukaGreska);
                $(".alert").show().delay(3000).fadeOut(300);
                return;
            }
        });
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