<?php

namespace App\Models\LDAP;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LDAP\Server
 *
 * @property int $id
 * @property string $name
 * @property string $hostname
 * @property int $port
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\Server whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\Server whereHostname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\Server whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\Server wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\Server whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Server extends Model
{
    const DEFAULT_LDAP_PORT = 389;

    protected $fillable = ['name', 'hostname', 'port'];
}
