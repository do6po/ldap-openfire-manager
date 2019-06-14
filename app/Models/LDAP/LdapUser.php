<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 22.10.18
 * Time: 13:31
 */

namespace App\Models\LDAP;


use Adldap\Models\User;

class LdapUser
{
    /**
     * @var User
     */
    protected $user;

    protected $aliases;

    public function __construct(User $user, AliasesCollection $aliases)
    {
        $this->user = $user;
        $this->aliases = $aliases;
    }

    public function getDn(): string
    {
        return $this->user->getDn();
    }

    public function getCommonName(): string
    {
        $commonName = $this->user->getCommonName();

        return $this->aliases->isset($commonName)
            ? $this->aliases->getByName($commonName)
            : $commonName;
    }

    public function getName(): string
    {
        $name = $this->user->getName();

        return $this->aliases->isset($name)
            ? $this->aliases->getByName($name)
            : $name;
    }
}