@extends('layouts.layouts')

@section('head')
    <link rel="icon" type="image/svg+xml" href="{{ asset('/images/logo/favicon-blanc.svg') }}">
    <link rel="alternate icon" href="{{ asset('/images/logo/favicon-blanc.ico') }}">
    <link rel="mask-icon" href="{{ asset('/images/logo/favicon-blanc.svg') }}" color="#{{ config('app.meta_color') }}">
    <meta content="{{ config('app.name') }}" property="og:title" />
    <meta content="Rejoins-nous et découvre une communauté construite autour de l’amour pour la survie ! Récolte des
         ressources, vend les ou achètes-en pour toi aussi créer ton propre village!" property="og:description" />
    <meta content="{{ url('/') }}" property="og:url" />
    <meta content="{{ asset('/images/logo/favicon-color.png') }}" property="og:image" />
    <meta content="{{ config('app.meta_color') }}" name="theme-color"/>
@endsection



@section('body')
    <style>p{
            color: white;
        }</style>
    <p>Coucou</p>
    <p>Blog page</p>


@endsection
