@extends('layouts.app')
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
                        <td>{{ $server->username }}</td>
                        <td>{{ $server->description }}</td>
                        <td>
                            {!! Form::open(['method' => 'DELETE', 'action' => ['LDAP\ServerController@destroy', $server]]) !!}
                            <a href="{{ route('ldap.edit', $server) }}" class="fa fa-pencil"></a>
                            {{ Form::button('<i class="fa fa-remove text-danger"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-link',
                                'onClick' => sprintf('return confirm("%s")', __('Are you sure?')),
                             ]) }}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $servers->links() }}
        </div>
    </section>
@endsection