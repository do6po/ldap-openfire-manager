<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 20.08.18
 * Time: 14:28
 */

namespace Tests\Fixtures;


use App\Models\LDAP\Server;
use LaravelFlux\Fixture\ActiveFixture;

class ServerFixture extends ActiveFixture
{
    public $modelClass = Server::class;
    public $dataFile = 'fixtures/servers.php';
}