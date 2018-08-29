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
use App\Models\LDAP\LDAP;

class LDAPService
{
    protected $ldap;

    public function __construct(Adldap $ldap)
    {
        $this->ldap = $ldap;
    }

    /**
     * @param LDAP $server
     */
    public function test(LDAP $server)
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
     * @param LDAP $server
     * @return \Adldap\Connections\ProviderInterface
     * @throws LDAPConnectException
     */
    public function connect(LDAP $server)
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