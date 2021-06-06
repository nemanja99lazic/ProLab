@extends('layout.profesor.header_default')
@section("page-nav")
<script src="{{asset("js/layout/profesor_header_script.js")}}"></script>
    <a href="{{route("teacher.subject.index", $code)}}" class="project-tab-button {{ request()->is('teacher/subject/*/index')  ? 'active' : ''}} nav-item ml-3 mr-1 nav-link btn-outline-dark">Stranica predmeta</a>
    <a href="{{route("teacher.showLabs", $code)}}" class="project-tab-button {{ request()->is('teacher/subject/*/lab') || request()->is('teacher/subject/*/lab/*')  ? 'active' : ''}} nav-item mr-1 nav-link btn-outline-dark" data-tab-id="#project-info">Laboratorijske vežbe</a>
    <a href="{{route("teacher.showProjects", $code)}}" class="project-tab-button {{ request()->is('teacher/subject/*/project') || request()->is('teacher/subject/*/project/*')  ? 'active' : ''}} nav-item mr-1 nav-link btn-outline-dark" data-tab-id="#team-list">Projekat</a>
@endsection
