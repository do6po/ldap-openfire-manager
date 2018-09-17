<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 16.09.2018
 * Time: 2:25
 */

/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\LDAP\Roster[] $rosters */

?>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Roster name') }}</th>
            <th>{{ __('Path') }}</th>
            <th>{{ __('Filter ') }}</th>
            <th>{{ __('Description') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($rosters as $roster)
            <tr>
                <td>{{ $roster->id }}</td>
                <td>{{ $roster->name }}</td>
                <td>{{ $roster->roster_path }}</td>
                <td>{{ $roster->users_group }}</td>
                <td>{{ $roster->description }}</td>
                <td>
                    <a href="#"
                       class="fa fa-trash"
                       data-toggle="modal"
                       data-target="{{ '#rosterDeleteConfirm-' . $roster->id }}">
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@section('modals')
    @foreach($rosters as $roster)
        @include('layouts._confirm', [
            'id' => 'rosterDeleteConfirm-' . $roster->id,
            'route' => ['ldap.roster.destroy', $roster->id],
            'message' => __("Delete roster: :rosterName. Are you sure?", ['rosterName' => $roster->name]),
            'buttonName' => __('Delete'),
            'buttonClass' => 'btn btn-danger',
            'method' => 'DELETE',
        ])
    @endforeach
@endsection