<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @hasSection('title')
            @yield('title') - {{ config('app.name') }}
        @else
            {{ config('app.name') }}
        @endif
    </title>
    @yield('head')
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
</head>
<body class="theme-light">
    <x-public.header></x-public.header>
    <x-public.sidemenu></x-public.sidemenu>
    <div id="Container" data--Sidebaropen="true">
        <div id="Content">
            @yield('body')
        </div>
        <x-public.sidebar></x-public.sidebar>
    </div>
    @yield('footer')



    <script src="{{ mix('/js/app.js') }}"></script>
    @stack('scripts')
</html>
