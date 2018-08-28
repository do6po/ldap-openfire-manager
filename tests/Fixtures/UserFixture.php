<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.08.18
 * Time: 16:48
 */

namespace Tests\Fixtures;


use App\Models\Users\User;
use LaravelFlux\Fixture\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
    public $dataFile = 'fixtures/users.php';
}