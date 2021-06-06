@extends('layout.profesor.header_default')
@section("page-nav")
<script src="{{asset("js/layout/profesor_header_script.js")}}"></script>
    <a href="{{route("teacher.subject.list")}}" class="project-tab-button {{ request()->is('teacher/subject/list')  ? 'active' : ''}} nav-item ml-3 mr-1 nav-link btn-outline-dark">Predmeti</a>
    <a href="{{route("teacher.addsubject.get")}}" class="project-tab-button {{ request()->is('teacher/addSubject')  ? 'active' : ''}} nav-item mr-1 nav-link btn-outline-dark" data-tab-id="#project-info">Dodavanje predmeta</a>
    <a href="{{route("teacher.showRequestsList")}}" class="project-tab-button {{ request()->is('teacher/subject/request/list')  ? 'active' : ''}} nav-item mr-1 nav-link btn-outline-dark" data-tab-id="#team-list">Zahtevi</a>
@endsection
