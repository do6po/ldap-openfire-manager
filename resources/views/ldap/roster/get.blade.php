<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 05.10.18
 * Time: 13:34
 */

/** @var array $rosterArray */
/** @var \App\Models\LDAP\Roster $roster */

?>
@extends('layouts.app')

@section('title', __('Roster: :name', ['name' => $roster->name]))

@section('content')

    {{ Breadcrumbs::render('ldap.roster.get', $roster) }}

    @php
        echo '<pre>' . $tree . '</pre>';
    @endphp

@endsection
