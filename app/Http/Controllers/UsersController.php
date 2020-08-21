<?php


namespace App\Http\Controllers;

use App\User;

class UsersController extends Controller
{
    public $user = 0;
    public function index()
    {
        $users = User::all();
    }

    public function getAdminUsers() {
        $users = User::where('admin', '!=', 0)->get();
        return view('admin_panel', ['users' => $users]);
    }

}
