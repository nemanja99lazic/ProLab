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
        console.log(team)
        let $table = $("<table>");
        let $tbody = $("<tbody>");
        let $rh = $("<tr><th>Ime</th><th>Prezime</th><th>Indeks</th></tr>");
        $tbody.append($rh);

        team.students.forEach(student => {
            let $rt = $("<tr>");
            $rt.attr("data-id", student.idStudent);
            $rt.append($("<td>").text(student.forename));
            $rt.append($("<td>").text(student.surname));
            $rt.append($("<td>").text(student.index));
            $tbody.append($rt);
        });
        $table.append($tbody);
        $table.addClass("table table-striped table-hover text-center");

        return $("<div>").append($table).addClass("col-6 pt-2");
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
       let $main = $("#main");
       //$main.html("");
        teams.forEach(team=>{
            $main.append(Project.getTeamTable(team));
        })
        console.log(teams);

    }
}

$(document).ready(()=>{
    const project = window.project;
    console.log(project);
    let p = new Project(project);
    //$("#main").append(Project.getTeamTable([]));
    p.loadData(project.code);
});
