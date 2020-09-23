<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public $user = 0;

    public static function setViewAsAdmin()
    {
        Session::put('user', TokenController::$payload->number);
        Session::put('admin', 1);
        return redirect()->back();
    }

    public static function setViewAsUser()
    {
        Session::put('user', TokenController::$payload->number);
        Session::put('admin', 0);
        return redirect()->back();
    }

    public static function isUserAdmin()
    {
        if (User::where('masp', TokenController::$payload->number)->first()) {
            return 1;
        }
        return 0;
    }

    public static function isAdminView()
    {
        return Session::get('admin');
    }

    public static function getMasp()
    {
        return TokenController::$payload->number;
    }

    public function getUserByMasp($masp)
    {
        return User::where('masp', $masp)->first();
    }

    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        //dd($users);
        return view('admin.admin_panel', ['users' => $users]);
    }

    public function create()
    {
        return view('admin.admins_create');
    }

    public function store(UserCreateRequest $request)
    {
        $request->validated();
        $users = User::onlyTrashed()->get()->sortBy('deleted_at');
        //dd ($request->masp); die();
        if (User::all()->where('masp', $request->masp)->first()) {
            $user = User::all()->where('masp', $request->masp)->first();
            return $this->update($request, $user);
        }

        else if ($users->where('masp', $request->masp)->first()) {
            $user = $users->where('masp', $request->masp)->first();
            $user->restore();
            return redirect(route('admins.index'))->with('status', 'Administrador ' . $user->masp . '  inserido com sucesso!');

        }
        $user = new User(request(['masp']));
        $user->save();
        return redirect(route('admins.index'))->with('status', 'Administrador ' . $user->masp . '  inserido com sucesso!');
    }

    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('users'));
    }

    public function update(UserCreateRequest $request, User $user)
    {
        $request->validated();
        return redirect(route('admins.index'))->with('status', 'Administrador ' . $user->masp . '  já existe e foi atualizado');
    }

    public function destroy(User $user)
    {

        if ($user->masp == '1729862' || $user->masp == '1292598')
            return redirect(route('admins.index'))->with('status', 'Não é possível excluir o ' . $user->masp);

        $user_masp = $user->masp;
        $user->delete();
        return redirect(route('admins.index'))->with('status', 'Administrador ' . $user_masp . ' apagado com sucesso');
    }

    public function getAdminUsers() {
        return view('admin_panel');
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
