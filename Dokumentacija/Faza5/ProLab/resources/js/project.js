"use strict";
/**
 * @author Sreten Živković 0008/2018
 *
 */


const $ = require("jquery");

class Project {

    constructor(projectData) {
        Project.projectData = projectData;

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
    loadData(code) {
        let ref = this;
        fetch("/student/subject/"+ code +"/team/available")
            .then(response => {
                console.log("hello world fetch");
                return response.json()}
            )
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

}

$(document).ready(()=>{
    const project = window.project;
    console.log(project);
    let p = new Project(project);
    //$("#main").append(Project.getTeamTable([]));
    p.loadData(project.code);
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
});
