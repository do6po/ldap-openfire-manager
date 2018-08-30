<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 30.08.2018
 * Time: 19:10
 */

namespace Tests\Fixtures;

use App\Models\LDAP\Roster;
use LaravelFlux\Fixture\ActiveFixture;

class RosterFixtures extends ActiveFixture
{
    public $modelClass = Roster::class;

    public $depends = [
        LDAPFixture::class,
    ];

    public $dataFile = 'fixtures/rosters.php';
}