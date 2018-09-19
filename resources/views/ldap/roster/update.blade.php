<?php

use App\Models\LDAP\LDAP;
use App\Models\LDAP\Roster;

/** @var LDAP $server */
/** @var Roster $roster */
/** @var array $servers */

?>

<div class="modal fade" id="{{ 'rosterUpdate-' . $roster->id }}" tabindex="" role="dialog" aria-labelledby="addRosterModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open(['method' => 'PUT', 'route' => ['ldap.roster.update', $roster], 'id' => 'roster-update-form-' . $roster->id]) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="addRosterModalLabel">
                    {{ __('New roster for :ldap', ['ldap' => $roster->ldap->name]) }}
                </h5>
                {!! Form::button('<span aria-hidden="true">&times;</span>', [
                    'class' => 'close',
                    'data-dismiss' => 'modal',
                    'aria-label' => 'Close',
                ]) !!}
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::text('name', $roster->name, [
                            'class' => 'form-control',
                            'placeholder' => __('Roster name'),
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('roster_path', $roster->roster_path, [
                            'class' => 'form-control',
                            'placeholder' => __('Path'),
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('users_group', $roster->users_group, [
                        'class' => 'form-control',
                        'placeholder' => __('Users group'),
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::textarea('description', $roster->description, [
                        'class' => 'form-control',
                        'placeholder' => __('Description'),
                        'rows' => 4,
                    ]) !!}
                </div>
                @if(Route::currentRouteNamed('ldap.show'))
                    {!! Form::hidden('ldap_id', $roster->ldap_id) !!}
                @else
                    {!! Form::select('ldap_id', $ldapServers, $roster->ldap_id, [
                        'class' => 'form-control',
                    ]) !!}
                @endif
            </div>
            <div class="modal-footer">
                {!! Form::button(__('Cancel'), [
                    'class' => 'btn btn-default',
                    'data-dismiss' => 'modal',
                ]) !!}
                {!! Form::submit(__('Add'), [
                    'class' => 'btn btn-success',
                ]) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('scripts')
    {!! JsValidator::formRequest(\App\Http\Requests\RosterRequest::class, '#roster-update-form-' . $roster->id) !!}
@endpush