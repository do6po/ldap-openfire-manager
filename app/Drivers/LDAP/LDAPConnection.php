<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 05.10.18
 * Time: 12:50
 */

namespace App\Drivers\LDAP;


use Adldap\Adldap;
use App\Models\LDAP\LDAP;
use App\Models\LDAP\Roster;


class LDAPConnection
{
    protected $ldap;

    public function __construct(Adldap $ldap)
    {
        $this->ldap = $ldap;
    }

    /**
     * @param LDAP $server
     * @return bool
     */
    public function test(LDAP $server): bool
    {
        try {
            $this->connect($server);
            return true;
        } catch (LDAPConnectException $exception) {
            return false;
        }
    }

    /**
     * @param LDAP $server
     * @param Roster|null $roster
     * @return \Adldap\Connections\ProviderInterface
     * @throws LDAPConnectException
     */
    public function connect(LDAP $server, Roster $roster = null)
    {
        try {
            $this->ldap->addProvider([
                'hosts' => [
                    $server->hostname
                ],
                'base_dn' => !is_null($roster) ? $roster->roster_path : null,
                'username' => $server->username,
                'password' => $server->password,
            ]);

            return $this->ldap->connect();

        } catch (\Exception $exception) {

            throw new LDAPConnectException('LDAP connection error!');
        }
    }
}