<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 20.08.18
 * Time: 12:50
 */

namespace App\Http\Controllers\LDAP;


use App\Http\Controllers\Controller;
use App\Models\LDAP\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servers = Server::paginate();

        return view('ldap.index', [
            'servers' => $servers,
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param  \App\Models\LDAP\Server  $servers
     * @return \Illuminate\Http\Response
     */
    public function show(Server $servers)
    {
        //
    }

    /**
     * @param  \App\Models\LDAP\Server  $servers
     * @return \Illuminate\Http\Response
     */
    public function edit(Server $servers)
    {
        //
    }

    /**
     * @param Request $request
     * @param Server $servers
     */
    public function update(Request $request, Server $servers)
    {
        //
    }

    /**
     * @param Server $servers
     */
    public function destroy(Server $servers)
    {
        //
    }
}