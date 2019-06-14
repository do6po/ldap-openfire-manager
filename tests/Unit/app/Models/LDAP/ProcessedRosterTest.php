<?php

namespace Tests\Unit\app\Models\LDAP;

use Adldap\Models\User;
use App\Models\LDAP\LdapUser;
use App\Models\LDAP\ProcessedRoster;
use Tests\TestCase;


class ProcessedRosterTest extends TestCase
{
//    public function testCountable()
//    {
//        $this->assertEquals(0, count(ProcessedRoster::create()));
//    }

    public function testCreateUser()
    {
        $userName = 'new name';
        $user = $this->generateUser($userName);
        $this->assertEquals($userName, $user->getName());
    }

    /**
     * @param $userName
     * @return \Mockery\MockInterface|LdapUser
     */
    private function generateUser($userName)
    {
        return \Mockery::mock(LdapUser::class)
            ->shouldReceive('getName')
            ->andReturn($userName)
            ->getMock();
    }

    private function generateUsers()
    {

    }
}
