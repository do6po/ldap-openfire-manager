<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 30.08.2018
 * Time: 18:40
 */

namespace App\Models\LDAP;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LDAP\Roster
 *
 * @property int $id
 * @property string $name
 * @property string|null $roster_path
 * @property string|null $users_group
 * @property string|null $description
 * @property int $ldap_id
 *
 * @property LDAP $ldap
 *
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\Roster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\Roster whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\Roster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\Roster whereLdapId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\Roster whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\Roster whereRosterPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\Roster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LDAP\Roster whereUsersGroup($value)
 * @mixin \Eloquent
 */
class Roster extends Model
{
    const TABLE_NAME = 'rosters';

    protected $fillable = [
        'name',
        'roster_path',
        'users_group',
        'description',
        'ldap_id',
    ];

    public function ldap()
    {
        return $this->hasOne(LDAP::class, 'id', 'ldap_id');
    }
}