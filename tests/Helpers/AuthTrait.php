<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.08.18
 * Time: 15:18
 */

namespace Tests\Helpers;


use App\Models\Users\User;

/**
 * Trait AuthTrait
 *
 * @method \Illuminate\Foundation\Testing\TestResponse be(User $user)
 *
 * @package Tests\Helpers
 */
trait AuthTrait
{
    protected function login($username = 'admin')
    {
        $user = new User([
            'name' => $username,
        ]);

        $this->be($user);
    }
}