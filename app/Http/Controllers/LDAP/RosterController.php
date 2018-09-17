<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 28.08.2018
 * Time: 19:37
 */

namespace App\Http\Controllers\LDAP;

use App\Http\Controllers\Controller;
use App\Http\Requests\RosterRequest;
use App\Models\LDAP\Roster;

class RosterController extends Controller
{
    public function store(RosterRequest $request)
    {
        Roster::create($request->all());

        return back();
    }
}