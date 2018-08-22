@extends('layouts.app')
@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('ldap.index') }}">{{ __('DASHBOARD') }}</a>
            </li>
            <li class="breadcrumb-item active">{{ __('Add LDAP server') }}</li>
        </ol>
    </section>
    <section class="content">
        {!! Form::open(['route' => 'ldap.store', 'files' => true, ]) !!}
        <div class="form-group">
            @include('input-validation', [
                'attribute' => 'name',
                'label' => __('Name'),
                'input' => Form::text('name', old('name'), [
                    'class' => 'form-control',
                    'placeholder' => __('Enter server name'),
                ]),
            ])
        </div>
        <div class="row">
            <div class="col-10">
                <div class="form-group">
                    @include('input-validation', [
                        'attribute' => 'hostname',
                        'label' => __('Hostname'),
                        'input' => Form::text('hostname', old('hostname'), [
                            'class' => 'form-control',
                            'placeholder' => __(''),
                        ]),
                    ])
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    @include('input-validation', [
                        'attribute' => 'port',
                        'label' => __('Port'),
                        'input' => Form::text('port', old('port'), [
                            'class' => 'form-control',
                            'placeholder' => __(''),
                        ]),
                    ])
                </div>
            </div>
        </div>
        <div class="form-group">
            @include('input-validation', [
                'attribute' => 'description',
                'label' => __('Description'),
                'input' => Form::textarea('description', old('description'), [
                    'class' => 'form-control',
                    'placeholder' => __(''),
                    'rows' => 6,
                ]),
            ])
        </div>
        <div class="form-group text-right">
            <a href="{{ redirect()->getUrlGenerator()->previous() }}"
               class="btn btn-default">{{ __('Return') }}</a>
            {!! Form::submit(__('Add'), ['class' => 'btn btn-success']) !!}
        </div>
        {!! Form::close() !!}
    </section>
@endsection