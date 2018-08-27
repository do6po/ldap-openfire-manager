<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.08.18
 * Time: 13:00
 */

namespace App\Services\LDAP;


use Adldap\Adldap;
use App\Helpers\FlashMessageHelper;
use App\Models\LDAP\Server;

class LDAPService
{
    protected $ldap;

    public function __construct(Adldap $ldap)
    {
        $this->ldap = $ldap;
    }

    /**
     * @param Server $server
     */
    public function test(Server $server)
    {
        try {

            $this->connect($server);
            FlashMessageHelper::success(
                __('Connection successful.')
            );

        } catch (LDAPConnectException $exception) {

            FlashMessageHelper::error(
                __('Connection error.')
            );
        }
    }

    /**
     * @param Server $server
     * @return \Adldap\Connections\ProviderInterface
     * @throws LDAPConnectException
     */
    public function connect(Server $server)
    {
        try {
            $this->ldap->addProvider([
                'hosts' => [
                    $server->hostname
                ],
                'base_dn' => null,
                'username' => $server->username,
                'password' => $server->password,
            ]);

            return $this->ldap->connect();

        } catch (\Exception $exception) {

            throw new LDAPConnectException('LDAP connection error!');
        }
    }
}