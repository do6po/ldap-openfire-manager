<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 30.08.2018
 * Time: 18:40
 */

namespace App\Models\LDAP;

use Illuminate\Database\Eloquent\Model;

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
}