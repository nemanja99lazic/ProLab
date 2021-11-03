"use strict";
/**
 * @author Sreten Živković 0008/2018
 *
 */
const $ = require("jquery");

class Project {
    static projectData = {};
    static myTeamData = null;
    static instance = null;
    static getInstance() {
        if (Project.instance == null) {
            Project.instance = new Project();
        }
        return Project.instance;
    }
    static setProjectData(pData) {
        Project.projectData = pData;
    }
    static setMyTeamData(mData) {
        Project.myTeamData = mData;
    }
    static getMyTeamData() {
        return Project.myTeamData;
    }

    constructor() {
    }
    static getTeamTableMemberList(team) {
        let students = team.students;
        return students.map(student => {
            let $rt = $("<tr>");
            $rt.addClass("d-flex");
            //console.log(student.idStudent, team.idLeader)
            if (student.idStudent == team.idLeader) {
                $rt.addClass("team-leader");
            }
            $rt.attr("data-id", student.idStudent);
            $rt.append($("<td>").addClass("col-4").text(student.forename));
            $rt.append($("<td>").addClass("col-4").text(student.surname));
            $rt.append($("<td>").addClass("col-4").text(student.index));
            return $rt;
        });
    }
    static getTeamTable(team) {
        let mtd = Project.getMyTeamData();
        let $div = $("<div>").addClass("col-md-6 col-12 pt-2");
        let $table = $("<table>");
        $table.append(
          $("<tr>").addClass("text-center").append(
                $("<td>").attr("colspan", "3").append(
                                    $("<h3>").text(team.teamName)
                )
              )
        );
        let $tbody = $("<tbody>");
        let $rh = $("<tr class='w-100 d-flex'><th class='col-4'>Ime</th><th class='col-4'>Prezime</th><th class='col-4'>Indeks</th></tr>");
        $tbody.append($rh);
        console.log(team);
        Project.getTeamTableMemberList(team).forEach($el=>{
            $tbody.append($el);
        })

        $table.append($tbody);
        $table.addClass("table border text-center");
        let lockStatus = "";
        if (team.isLocked) {
            lockStatus = "Zaključan";
        } else {
            lockStatus = "Otključan";
        }
        $table.append(
          $("<tr>").addClass("text-center").append($("<td>").attr("colspan", "3").text(lockStatus))
        );
        if (!team.isLocked && !mtd.inTeam) {//!team.isLocked
            let $join = $("<button>").text("Pridruži se").addClass("btn btn-dark");
            let teamId = team.idTeam;
            $join.on("click",()=>{
                let pData = Project.getProjectData();
                console.log("join")
                fetch("/student/subject/"+ pData.code +"/team/"+ teamId +"/join",{
                    headers: {
                        "X-CSRF-TOKEN": pData.csrf
                    },
                    'Content-Type': 'application/x-www-form-urlencoded',
                    method: "POST"
                })
                .then(response=>response.json())
                .then(json=>{
                    if (json.status != "ok") {

                        return;
                    }
                    Project.getInstance().loadData();
                })
            });
            $table.append(
                $("<tr>")
                    .append($("<td>").attr("colspan", "3").append($join)).addClass("text-center p-2")
            );
        }

        $div.append($table);
        return $div;



    }

    /**
     * Učitava podatke pomoću AJAX-a sa putanje /student/subject/{code}/team/available
     *
     */
    loadData() {
        let code = Project.projectData.code;
        let ref = this;
        fetch("/student/subject/"+ code +"/team/available")
            .then(response => {
                return response.json()
            })
            .then(data => {
                let teamObject = {};
                for (let key in data) {
                    let row = data[key];
                    let idTeam = row.idTeam;
                    if (!!teamObject[idTeam]) {
                        teamObject[idTeam].push(row);
                    } else {
                        teamObject[idTeam] = [row];
                    }
                }
                let teams = [];
                let myId = Project.getProjectData().idUser;
                let isLeader = false;
                let inTeam = false;
                let myTeamId = -1;
                let myTeam = null;
                for (let key in teamObject) {
                    let row = teamObject[key];
                    let first = row[0];
                    if (first.idLeader == myId) {
                        isLeader = true;
                        inTeam = true;
                        myTeamId = first.idTeam;
                    }
                    let team = {
                        idTeam: first.idTeam,
                        teamName: first.teamName,
                        idLeader: first.idLeader,
                        isLocked: first.locked,
                        students: []
                    }
                    row.forEach(el=>{
                        if (el.idStudent == myId) {
                            myTeamId = el.idTeam;
                            inTeam = true;
                        }
                        team.students.push({
                            index: el.studentIndex,
                            forename: el.forename,
                            surname: el.surname,
                            idStudent: el.idStudent
                        });
                    });
                    if (first.idTeam == myTeamId) {
                        myTeam = team;
                    }
                    teams.push(team);
                }

                ref.updateTeams({teams,myTeamData:{myId,isLeader,inTeam, myTeamId, myTeam}});

            })
            .catch((error) => {
                //TODO ako server pukne
                console.error('Error:', error);
            });
    }

    /**
     * Ažurira deo stranice namenjenom timu u kojem je student učlanjen
     * Kreira formu za upravljanje timom
     */
    updateMyTeam() {
        console.log("update my team")
        let $showLeader = $(".show-leader");
        let $teamMembers = $("#my-team-members");
        let $myTeamName = $("#my-team-name");
        let mtd = Project.getMyTeamData();
        let $myTeam = $("#my-team");
        let $exitButton = $("#delete-exit-my-team");
        let $lockStatus = $("#locked-status");
        let hideClass = "d-none";
        if (!mtd.inTeam) {
            $myTeam.addClass(hideClass);
            return;
        } else {
            $myTeam.removeClass(hideClass);
        }
        $myTeamName.text(mtd.myTeam.teamName);
        console.log(mtd)
        if (!mtd.isLeader) {
            $showLeader.addClass(hideClass);
            $exitButton.text("Napusti tim");
        } else {
            $showLeader.removeClass(hideClass);
            $exitButton.text("Obriši tim");
        }
        if (mtd.myTeam.students.length <= Project.getProjectData().min) {
            $("#lock-team-button").addClass("d-none")
        } else {
            $("#lock-team-button").removeClass("d-none");
        }
        if (mtd.myTeam.isLocked) {
            $lockStatus.text("Zaključan");
        } else {
            $lockStatus.text("Otključan");
        }
        $teamMembers.empty();
        let $table = $("<table>");
        $table.addClass("table text-center w-100");
        let $rh = $("<tr class='w-100 d-flex'><th class='col-4'>Ime</th><th class='col-4'>Prezime</th><th class='col-4'>Indeks</th></tr>");
        $table.append($rh);
        Project.getTeamTableMemberList(mtd.myTeam).forEach($el=>$table.append($el));
        $teamMembers.append($table);
    }

    /**
     * Ažurira stranicu po prijemu novog stanja sa servera
     * @param obj
     */
    updateTeams(obj) {
        console.log(obj)
        let {teams, myTeamData} = obj;
        Project.setMyTeamData(myTeamData);
        Project.setMyTeamData(myTeamData);
        this.updateMyTeam();
        let $teamList = $("#other-teams");
        $teamList.empty();
        teams.forEach(team=>{
            if (team.idTeam != myTeamData.myTeamId)
                $teamList.append(Project.getTeamTable(team, myTeamData));
        });
    }

    static getProjectData() {
        return Project.projectData;
    }
}

class CreateTeam {
    constructor() {
        this.$teamName = $("#form-team-name");
        this.$button = $("#form-team-sumbit");
        this.$message = $("#form-message");
        let ref = this;
        this.$button.on("click", ()=>{
           ref.submit();
        });
    }

    /**
     * Ispisuje gresku prilikom kreiranja novog tima
     * @param message
     */
    writeError(message) {
        this.$message.removeClass("text-success");
        this.$message.addClass("text-danger");
        this.$message.html(message);
    }

    /**
     * ispisuje poruku o uspesnom kreiranju tima
     * @param message
     */
    writeSuccess(message) {
        this.$message.removeClass("text-danger");
        this.$message.addClass("text-success");
        this.$message.html(message);
    }

    /**
     * Resetuje stanje polja za obaveštenja
     */
    clearInfo() {
        this.$message.empty();
    }

    /**
     *  obradjuje unos imena, i šalje na server zahtev za kreiranje tima
     *  ispisuje grešku u slučaju lošeg formata imena tima
     *  ispisuje grešku, ako se ona desi na serveru
     */
    submit() {
        console.log("submit")
        let project = Project.getInstance();
        let teamName = this.$teamName.val();
        //console.log(teamName)
        let errorMessage = "";
        if (teamName.length <= 4) {
            errorMessage += "Ime tima mora biti duže od 4 znaka<br />";
        }
        if (teamName.length > 60) {
            errorMessage += "Ime tima mora biti kraće od 60 znaka<br />";
        }
        if (!/^[a-zA-Z\d\s\-_]+$/.test(teamName)) {
            errorMessage += "Ime sme da sadrži slova, cifre, -, _ i razmak<br />";
        }
        if (errorMessage.length > 0) {
            this.writeError(errorMessage);
            return;
        }
        this.clearInfo();

        let pData = Project.getProjectData();
        let body = new URLSearchParams();
        body.append("teamname", teamName);
            //this.$button.attr("disabled","disabled");
        fetch("/student/subject/" + pData.code + "/team/create", {
            method: "POST",
            'Content-Type': 'application/x-www-form-urlencoded',
            body: body,
            headers: {
                "X-CSRF-TOKEN": pData.csrf
            }
        }).then(
            data=>data.json()
        ).then(json=>{
            if (json.status != "ok") {
                throw json;
            }
            this.writeSuccess("Uspešno ste kreirali tim");
            project.loadData();
        }).catch(error=>{
            console.log("catch");
            let errorMessage = "";
            switch (error.error_number) {
                case 1:
                    errorMessage = "Loš format";
                    break;
                case 2:
                    errorMessage = "Predmet ne postoji";
                    break;
                case 3:
                    errorMessage = "Projekat ne postoji";
                    break;
                case 4:
                    errorMessage = "Isteklo vreme za prijavu projekta";
                    break;
                case 5:
                    errorMessage = "Već ste u timu";
                    break;
                case 6:
                    errorMessage = "Niste prijavljeni na predmet";
                    break;
                default:
                    //errorMessage = "Greška na serveru";
                    return;

            }
            this.writeError(errorMessage);
            console.log(error);
        });

    }

}


$(document).ready(()=>{

    let $csrf = $("#csrf> input");
    window.projectData.csrf = $csrf.val();

    //ako projekat ne postoji
    //nema potrebe da se učitava stranica
    if (window.projectData.notExist) {
        return;
    }
    //console.log();
    Project.setProjectData(window.projectData);
    let p = Project.getInstance();
    p.loadData();
    $(".project-tab-button").each((i, ele)=>{
        let $button = $(ele);
        $button.on("click",() => {
            let $this = $button;
            let $tab = $($this.attr("data-tab-id"));

            if (!$this.hasClass("active")) {
                $(".project-tab-button").removeClass("active");
                $this.addClass("active");
                $(".project-tab").addClass("d-none");
                $tab.removeClass("d-none");
            }
        });

    });
    new CreateTeam();
    let fetchOptions = {
        headers: {
            "X-CSRF-TOKEN": Project.getProjectData().csrf
        },
        'Content-Type': 'application/x-www-form-urlencoded',
        method: "POST"
    };
    $("#delete-exit-my-team").on("click", ()=> {
        let mtd = Project.getMyTeamData();
        let pd = Project.getProjectData();
        fetch("/student/subject/" + pd.code + "/team/" + mtd.myTeamId + "/exit", fetchOptions)
            .then(response => response.json())
            .then(json=>{
                if (json.status != "ok") {

                }
                p.loadData();
            }).catch(error=>{

            });

    });

    $("#lock-team-button").on("click", ()=> {
        let mtd = Project.getMyTeamData();
        let pd = Project.getProjectData();
        fetch("/student/subject/" + pd.code + "/team/" + mtd.myTeamId + "/lock", fetchOptions)
            .then(response => response.json())
            .then(json=>{
                if (json.status != "ok") {

                }
                p.loadData();
            }).catch(error=>{

        });
    });
    $("#unlock-team-button").on("click", ()=> {
        let mtd = Project.getMyTeamData();
        let pd = Project.getProjectData();
        fetch("/student/subject/" + pd.code + "/team/" + mtd.myTeamId + "/unlock", fetchOptions)
            .then(response => response.json())
            .then(json=>{
                if (json.status != "ok") {

                }
                p.loadData();
            }).catch(error=>{

        });
    });
});
