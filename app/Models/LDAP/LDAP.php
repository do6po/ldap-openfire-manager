<?php

namespace App\Models\LDAP;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LDAP\LDAP
 *
 * @property int $id
 * @property string $name
 * @property string $hostname
 * @property int $port
 * @property string $username
 * @property string $password
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\LDAP whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\LDAP whereHostname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\LDAP whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\LDAP whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\LDAP wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\LDAP whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\LDAP whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\LDAP wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\LDAP whereUsername($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LDAP\Roster[] $rosters
 */
class LDAP extends Model
{
    const TABLE_NAME = 'ldap_servers';

    const DEFAULT_LDAP_PORT = 389;

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        'name',
        'hostname',
        'port',
        'username',
        'password',
    ];

    protected $attributes = [
        'port' => self::DEFAULT_LDAP_PORT,
    ];

    public static function attributes()
    {
        return [
            'id' => __('ID'),
            'name' => __('Server name'),
            'hostname' => __('Hostname'),
            'port' => __('Port'),
            'username' => __('Username'),
            'updated_at' => __('Updated at'),
            'created_at' => __('Created at'),
            'description' => __('Description'),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rosters()
    {
        return $this->hasMany(Roster::class, 'ldap_id', 'id');
    }
}
