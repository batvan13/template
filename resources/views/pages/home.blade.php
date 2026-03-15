@extends('layouts.app')

@section('title', 'Начало')
@section('description', 'Начална страница')

@section('content')
    @include('sections.home.hero')
    @include('sections.home.services')
    @include('sections.home.about-preview')
    @include('sections.home.gallery-preview')
    @include('sections.home.contact-preview')
@endsection
