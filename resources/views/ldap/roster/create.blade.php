<?php

use App\Models\LDAP\LDAP;

/** @var LDAP $server */
/** @var array $servers */

?>

<div class="modal fade" id="addRosterModal" tabindex="" role="dialog" aria-labelledby="addRosterModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open(['route' => 'ldap.roster.store', 'id' => 'roster-add-form']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="addRosterModalLabel">
                    {{ __('New roster for :ldap', ['ldap' => $server->name]) }}
                </h5>
                {!! Form::button('<span aria-hidden="true">&times;</span>', [
                    'class' => 'close',
                    'data-dismiss' => 'modal',
                    'aria-label' => 'Close',
                ]) !!}
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::text('name', null, [
                            'class' => 'form-control',
                            'placeholder' => __('Roster name'),
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('roster_path', null, [
                            'class' => 'form-control',
                            'placeholder' => __('Path'),
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('users_group', null, [
                        'class' => 'form-control',
                        'placeholder' => __('Users group'),
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::textarea('description', null, [
                        'class' => 'form-control',
                        'placeholder' => __('Description'),
                        'rows' => 4,
                    ]) !!}
                </div>
                @if(Route::currentRouteNamed('ldap.show'))
                    {!! Form::hidden('ldap_id', $server->id) !!}
                @else
                    {!! Form::select('ldap_id', $servers, [
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
        </div>
    </div>
</div>

@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest(\App\Http\Requests\RosterRequest::class, '#roster-add-form') !!}
@endsection