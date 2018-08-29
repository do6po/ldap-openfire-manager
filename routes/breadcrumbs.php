<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 25.08.2018
 * Time: 0:48
 */

use App\Models\LDAP\LDAP;

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