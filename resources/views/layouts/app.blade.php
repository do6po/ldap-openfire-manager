<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Openfire importer - @yield('title') </title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet"/>
</head>
<body>

@include('layouts._header')

<div class="container-fluid">
    <div class="row">

        @include('layouts._sidebar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

            @include('layouts._alert')

            @yield('content')

        </main>
    </div>
</div>

@include('layouts._footer')

@stack('modals')

<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

@stack('scripts')

</body>

</html>