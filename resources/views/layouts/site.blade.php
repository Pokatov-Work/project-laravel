<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>{{$pageTitle}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicons/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/quasar@2.0.1/dist/quasar.prod.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/css/app.css">

    <x-onessa5core::page-meta-show :metaList="$page->meta_list"></x-onessa5core::page-meta-show>
    <script>
        const locale = '<?=app()->getLocale()?>';
        window.locale = '<?=app()->getLocale()?>';
    </script>
</head>

<body>
@include('layouts.analitics')
@yield('page-script-data')

<div id="app">
    <q-layout>
        @include('layouts.header')
        @yield('content')
        @include('layouts.footer')
    </q-layout>
</div>

<script src="/js/manifest.js"></script>
<script src="/js/vendor.js"></script>
<script src="/js/app.js"></script>
@yield('page-script')

<!-- скрипты аналитики begin-->
@if (!empty($siteSettings->analytics))
    {!! $siteSettings->analytics !!}
@endif<!-- скрипты аналитики end-->
</body>

</html>
