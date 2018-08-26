<?php

/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\LDAP\Server[] $servers */

?>

@extends('layouts.app')

@section('title', __('LDAP servers list'))

@section('content')

    {{ Breadcrumbs::render('ldap') }}

    <section class="content">
        <div class="form-group">
            <a href="{{ route('ldap.create') }}" class="btn btn-success">{{ __('Add new server') }}</a>
        </div>
        {{ $servers->links() }}
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Server name') }}</th>
                    <th>{{ __('Hostname') }}</th>
                    <th>{{ __('Port') }}</th>
                    <th>{{ __('Username') }}</th>
                    <th>{{ __('Description') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($servers as $server)
                    <tr>
                        <td>{{ $server->id }}</td>
                        <td>
                            <a href="{{ route('ldap.show', $server) }}">
                                {{ $server->name }}
                            </a>
                        </td>
                        <td>{{ $server->hostname }}</td>
                        <td>{{ $server->port }}</td>
                        <td>{{ $server->username }}</td>
                        <td>{{ $server->description }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $servers->links() }}
    </section>
@endsection