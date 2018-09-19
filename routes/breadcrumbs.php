<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 25.08.2018
 * Time: 0:48
 */

use App\Models\LDAP\LDAP;
use App\Models\LDAP\Roster;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('DASHBOARD', route('dashboard'));
});

Breadcrumbs::for('ldap', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('LDAP servers', route('ldap.index'));
});

Breadcrumbs::for('ldap.create', function ($trail) {
    $trail->parent('ldap');
    $trail->push('Add new', route('ldap.create'));
});

Breadcrumbs::for('ldap.edit', function ($trail, LDAP $ldap) {
    $trail->parent('ldap');
    $trail->push('Edit', route('ldap.edit', $ldap));
});

Breadcrumbs::for('ldap.show', function ($trail, LDAP $ldap) {
    $trail->parent('ldap');
    $trail->push($ldap->name, route('ldap.show', $ldap));
});

Breadcrumbs::for('ldap.roster', function ($trail) {
    $trail->parent('ldap');
    $trail->push('Rosters', route('ldap.roster.index'));
});

Breadcrumbs::for('ldap.roster.show', function ($trail, Roster $roster) {
    $trail->parent('ldap.roster');
    $trail->push($roster->name, route('ldap.roster.show', $roster));
});