<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.09.18
 * Time: 12:25
 */

namespace Tests\Unit\app\Services\LDAP;


use App\Services\LDAP\LDAPService;
use app\Services\LDAP\NotFoundRosterPathException;
use Tests\Helpers\PrivateMethodTrait;
use Tests\TestCase;

class LDAPServiceTest extends TestCase
{
    use PrivateMethodTrait;

    /**
     * @var LDAPService
     */
    protected $service;


    public function setUp()
    {
        parent::setUp();
        $this->service = app()->make(LDAPService::class);
    }
}