@extends('layouts.app')
@section('content')

    {{ Breadcrumbs::render('ldap.edit') }}

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest(\App\Http\Requests\LDAPServerRequest::class) !!}
@endsection