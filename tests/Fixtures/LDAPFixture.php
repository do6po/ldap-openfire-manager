<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 20.08.18
 * Time: 14:28
 */

namespace Tests\Fixtures;


use App\Models\LDAP\LDAP;
use LaravelFlux\Fixture\ActiveFixture;

class LDAPFixture extends ActiveFixture
{
    public $modelClass = LDAP::class;
    public $dataFile = 'fixtures/ldap_servers.php';
}