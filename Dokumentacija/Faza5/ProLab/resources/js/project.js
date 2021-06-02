"use strict";
/**
 * @author Sreten Živković 0008/2018
 *
 */


const $ = require("jquery");
class Project {
    static projectData = {};
    static setProjectData(pData) {
        Project.projectData = pData;
    }
    constructor() {
    }
    static getTeamTable(team) {
        let $div = $("<div>").addClass("col-6 pt-2");
        let $header = $("<div>");
        $header.append($("<h3>").text(team.teamName));

        let $join = $("<button>").text("Pridruži se").addClass("btn btn-dark");
        let $exit = $("<button>").text("Izađi").addClass("btn btn-dark");
        $div.append($join).append($exit).append($header);
        let $table = $("<table>");
        let $tbody = $("<tbody>");
        let $rh = $("<tr><th>Ime</th><th>Prezime</th><th>Indeks</th></tr>");
        $tbody.append($rh);
        console.log(team);
        team.students.forEach(student => {
            let $rt = $("<tr>");
            //console.log(student.idStudent, team.idLeader)
            if (student.idStudent == team.idLeader) {
                $rt.addClass("team-leader");
            }
            $rt.attr("data-id", student.idStudent);
            $rt.append($("<td>").text(student.forename));
            $rt.append($("<td>").text(student.surname));
            $rt.append($("<td>").text(student.index));
            $tbody.append($rt);
        });
        $table.append($tbody);
        $table.addClass("table table-striped table-hover text-center");
        $div.append($table)
        return $div;
    }
    loadData() {
        let code = Project.projectData.code;
        let ref = this;
        fetch("/student/subject/"+ code +"/team/available")
            .then(response => {
                //console.log("hello world fetch");
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
                for (let key in teamObject) {
                    let row = teamObject[key];
                    let first = row[0];
                    let team = {
                        idTeam: first.idTeam,
                        teamName: first.teamName,
                        idLeader: first.idLeader,
                        students: []
                    }
                    row.forEach(el=>{
                        team.students.push({
                            index: el.studentIndex,
                            forename: el.forename,
                            surname: el.surname,
                            idStudent: el.idStudent
                        });
                    })
                    teams.push(team);
                }
                ref.updateTeams(teams);
                return;
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }
    updateTeams(teams) {
        let $teamList = $("#team-list");
        $teamList.empty();
        teams.forEach(team=>{
            $teamList.append(Project.getTeamTable(team));
        });
        console.log(teams);

    }
    tabs() {

    }
    static getProjectData() {
        return Project.projectData;
    }
}

class CreateTeam{
    constructor() {
        this.$teamName = $("#form-team-name");
        this.$button = $("#form-team-sumbit");
        this.$message = $("#form-message");
        let ref = this;
        this.$button.on("click", ()=>{
           ref.submit();
        });
    }
    writeError(message) {
        this.$message.removeClass("text-success");
        this.$message.addClass("text-danger");
        this.$message.html(message);
    }
    writeSuccess(message) {
        this.$message.removeClass("text-danger");
        this.$message.addClass("text-success");
        this.$message.html(message);
    }
    clearInfo() {
        this.$message.empty();
    }
    submit() {
        console.log("submit")
        let ref = this;
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
            //this.$error.html(errorMessage);
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
            this.loadData();
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
                    console.log(error.error_number)
                    return;

            }
            this.writeError(errorMessage);
            //this.$error.html(errorMessage);
            console.log(error);
        });



    }

}


$(document).ready(()=>{
    //const project = window.project;
    //console.log(project);
    let $csrf = $("#csrf> input");
    window.projectData.csrf = $csrf.val();
    if (window.projectData.notExist) {
        return;
    }
    //console.log();
    Project.setProjectData(window.projectData);
    let p = new Project();
    //$("#main").append(Project.getTeamTable([]));
    p.loadData();
    $(".project-tab-button").each((i, ele)=>{
        let $button = $(ele);
        $button.on("click",() => {
            let $this = $button;
            let $tab = $($this.attr("data-tab-id"));
            console.log($this);
            if (!$this.hasClass("active")) {
                $(".project-tab-button").removeClass("active");
                $this.addClass("active");
                $(".project-tab").addClass("d-none");
                $tab.removeClass("d-none");
            }
        });

    });
    new CreateTeam();
});
