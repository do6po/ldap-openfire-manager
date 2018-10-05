<?php
/** @var \App\Models\LDAP\roster $roster */
/** @var array roster $ldapServers */
?>

@extends('layouts.app')

@section('title', __('Roster: :name', ['name' => $roster->name]))

@section('content')

    {{ Breadcrumbs::render('ldap.roster.show', $roster) }}

    <section class="content">
        <div class="form-group">
            <a href="#" class="btn btn-primary"
               data-toggle="modal"
               data-target="{{ '#rosterUpdate-' . $roster->id }}">
                {{ __('Edit') }}
            </a>
            <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-default">
                {{ __('Cancel') }}
            </a>

            <a href="{{ route('ldap.roster.get', $roster) }}"
               class="btn btn-info pull-right">
                {{ __('Get roster') }}
            </a>

        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <td>
                        {{ __('ID') }}
                    </td>
                    <td>
                        {{ $roster->id }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('Name') }}
                    </td>
                    <td>
                        {{ $roster->name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('Roster path') }}
                    </td>
                    <td>
                        {{ $roster->roster_path }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('Filter by group') }}
                    </td>
                    <td>
                        {{ $roster->users_group }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('Description') }}
                    </td>
                    <td>
                        {{ $roster->description }}
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('LDAP server') }}
                    </td>
                    <td>
                        <a href="{{ route('ldap.show', $roster->ldap_id) }}">
                            {{ $roster->ldap->name }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ __('Last update at') }}
                    </td>
                    <td>
                        {{ $roster->updated_at }}
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

@push('modals')
    @include('ldap.roster.update', [
        'roster' => $roster,
        'ldapServers' => $ldapServers,
    ])
@endpush