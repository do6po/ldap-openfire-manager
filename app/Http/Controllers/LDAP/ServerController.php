<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 20.08.18
 * Time: 12:50
 */

namespace App\Http\Controllers\LDAP;


use App\Http\Controllers\Controller;
use App\Http\Requests\LDAPServerRequest;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('ldap.create');
    }

    /**
     * @param LDAPServerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LDAPServerRequest $request)
    {
        Server::create($request->all());

        return redirect()->route('ldap.index');
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