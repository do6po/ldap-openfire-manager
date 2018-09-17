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
            </tr>
        @endforeach
        </tbody>
    </table>
</div>