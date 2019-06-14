<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 22.10.18
 * Time: 16:58
 */

namespace App\Models\LDAP;


class AliasesCollection
{
    protected $aliases = [];

    public function isset(string $name)
    {
        return false;
    }

    public function getByName(string $name)
    {
        return '';
    }
}