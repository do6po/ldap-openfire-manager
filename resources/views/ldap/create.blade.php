@extends('layouts.app')

@section('title', __('Add LDAP server'))

@section('content')

    {{ Breadcrumbs::render('ldap.create') }}

    <section class="content">
        {!! Form::open(['route' => 'ldap.store']) !!}
        <div class="form-group">
            {!! Form::label('name', __('Name')) !!}
            {!! Form::text('name', old('name'), [
                    'class' => 'form-control',
                    'placeholder' => __(''),
                ]) !!}
        </div>
        <div class="row">
            <div class="col-10">
                <div class="form-group">
                    {!! Form::label('hostname', __('Hostname')) !!}
                    {!! Form::text('hostname', old('hostname'), [
                        'class' => 'form-control',
                        'placeholder' => __(''),
                    ]) !!}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {!! Form::label('port', __('Port')) !!}
                    {!! Form::text('port', old('port'), [
                        'class' => 'form-control',
                        'placeholder' => __(''),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('username', __('Username')) !!}
                    {!! Form::text('username', old('username'), [
                        'class' => 'form-control',
                        'placeholder' => __(''),
                    ]) !!}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('password', __('Password')) !!}
                    {!! Form::password('password', [
                        'class' => 'form-control',
                        'placeholder' => __(''),
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('description', __('Description')) !!}
            {!! Form::textarea('description', old('description'), [
                'class' => 'form-control',
                'placeholder' => __(''),
                'rows' => 6,
            ]) !!}
        </div>
        <div class="form-group text-right">
            <a href="{{ redirect()->getUrlGenerator()->previous() }}"
               class="btn btn-default">{{ __('Return') }}</a>
            {!! Form::submit(__('Add'), ['class' => 'btn btn-success']) !!}
        </div>
        {!! Form::close() !!}
    </section>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest(\App\Http\Requests\LDAPRequest::class) !!}
@endsection