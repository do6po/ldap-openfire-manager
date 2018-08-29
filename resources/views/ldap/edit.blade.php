<?php
/** @var \App\Models\LDAP\LDAP $server */
?>

@extends('layouts.app')

@section('title', __('Edit LDAP server'))

@section('content')

    {{ Breadcrumbs::render('ldap.edit', $server) }}

    <section class="content">
        {!! Form::open(['route' => ['ldap.update', $server], 'method' => 'put' ]) !!}
        <div class="form-group">
            {!! Form::label('name', __('Name')) !!}
            {!! Form::text('name', $server->name, [
                    'class' => 'form-control',
                ]) !!}
        </div>
        <div class="row">
            <div class="col-10">
                <div class="form-group">
                    {!! Form::label('hostname', __('Hostname')) !!}
                    {!! Form::text('hostname', $server->hostname, [
                        'class' => 'form-control',
                    ]) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('port', __('Port')) !!}
                    {!! Form::text('port', $server->port, [
                        'class' => 'form-control',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('username', __('Username')) !!}
                    {!! Form::text('username', $server->username, [
                        'class' => 'form-control',
                    ]) !!}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('password', __('Password')) !!}
                    {!! Form::password('password', [
                        'class' => 'form-control',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('description', __('Description')) !!}
            {!! Form::textarea('description', $server->description, [
                'class' => 'form-control',
                'rows' => 6,
            ]) !!}
        </div>
        <div class="form-group text-right">
            <a href="{{ redirect()->getUrlGenerator()->previous() }}"
               class="btn btn-default">{{ __('Return') }}</a>
            {!! Form::submit(__('Save'), ['class' => 'btn btn-success']) !!}
        </div>
        {!! Form::close() !!}
    </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest(\App\Http\Requests\LDAPRequest::class) !!}
@endsection