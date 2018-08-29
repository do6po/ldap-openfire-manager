<?php
/** @var \App\Models\LDAP\LDAP $server */
?>

@extends('layouts.app')

@section('title', __('LDAP server: :name', ['name' => $server->name]))

@section('content')

    {{ Breadcrumbs::render('ldap.show', $server) }}

    <section class="content">
        <div class="form-group">
            {!! Form::open(['method' => 'DELETE', 'route' => ['ldap.destroy', $server]]) !!}
            <a href="{{ route('ldap.edit', $server) }}" class="btn btn-primary">
                {{ __('Edit') }}
            </a>
            <a href="{{ route('ldap.test', $server) }}" class="btn btn-info">
                {{ __('Test connection') }}
            </a>
            <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-default">
                {{ __('Cancel') }}
            </a>
            {{ Form::button(__('Delete'), [
                'type' => 'submit',
                'class' => 'btn btn-danger pull-right',
                'onClick' => sprintf('return confirm("%s")', __('Are you sure?')),
             ]) }}
            {!! Form::close() !!}
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <td>
                        {{ __('ID') }}
                    </td>
                    <td>
                        {{ $server->id }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('Name') }}
                    </td>
                    <td>
                        {{ $server->name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('Hostname') }}
                    </td>
                    <td>
                        {{ $server->hostname }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('Port') }}
                    </td>
                    <td>
                        {{ $server->port }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('Username') }}
                    </td>
                    <td>
                        {{ $server->username }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('Last update at') }}
                    </td>
                    <td>
                        {{ $server->updated_at }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('Description') }}
                    </td>
                    <td>
                        {{ $server->description }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
    <section class="content">
        <div class="form-group">

        </div>
    </section>
@endsection