@extends('layouts.app')
@section('content')

    <section class="content-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('ldap.index') }}">{{ __('LDAP servers') }}</a>
            </li>
        </ol>
    </section>

    <section class="content">
        <div class="form-group">
            <a href="{{ route('ldap.create') }}" class="btn btn-success">{{ __('Add new server') }}</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Server name') }}</th>
                    <th>{{ __('Hostname') }}</th>
                    <th>{{ __('Port') }}</th>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('Control') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($servers as $server)
                    <tr>
                        <td>{{ $server->id }}</td>
                        <td>{{ $server->name }}</td>
                        <td>{{ $server->hostname }}</td>
                        <td>{{ $server->port }}</td>
                        <td>{{ $server->description }}</td>
                        <td></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection