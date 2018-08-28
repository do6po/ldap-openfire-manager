<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 23.08.18
 * Time: 11:32
 */

namespace App\Http\Controllers;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard');
    }
}