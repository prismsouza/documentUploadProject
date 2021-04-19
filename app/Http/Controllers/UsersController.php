<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class UsersController extends Controller
{
    public $user = 0;
    const PRODEMGE_API_URL_BM_NUMBER = "http://www.bpms.mg.gov.br/cbmmg-bpms-frontend/rest/acessoExternoBombeiros/consultarBombeiroAuth?matricula=";
    const PRODEMGE_API_AUTH_KEY = "basic 48aee24f1e18a898260436381445069d";


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

    public static function isUserSuperAdmin()
    {
        if (User::where('masp', TokenController::$payload->number)->where('isSuperAdmin', 1)->first()) {
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
        if(!$this->isUserSuperAdmin())  return redirect(route('documents.index'));
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.index', ['users' => $users]);
    }

    public function create()
    {
        if(!$this->isUserSuperAdmin())  return redirect(route('documents.index'));
        return view('admin.create');
    }

    public function store(UserCreateRequest $request)
    {
        $request->validated();
        $users = User::onlyTrashed()->get()->sortBy('deleted_at');
        $json = $this->getMilitaryData($request);
        $json = json_decode($json);

        if (User::all()->where('masp', $request->masp)->first()) {
            $user = User::all()->where('masp', $request->masp)->first();
            return $this->update($request, $user);
        }

        else if ($users->where('masp', $request->masp)->first()) {
            $user = $users->where('masp', $request->masp)->first();
            $user->restore();
            $user->name = $json->name;
            $user->unit_oncreate = $json->unit_name;
            $user->save();
            return redirect(route('admin.index'))->with('status', 'Administrador ' . $user->masp . '  inserido com sucesso!');

        }
        $user = new User(request(['masp']));
        $user->name = $json->name;
        $user->unit_oncreate = $json->unit_name;
        $user->save();

        return redirect(route('admin.index'))->with('status', 'Administrador ' . $user->masp . '  inserido com sucesso!');
    }

    public function show(User $user)
    {
        if(!$this->isUserSuperAdmin())  return redirect(route('documents.index'));
        return view('users.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        if(!$this->isUserSuperAdmin())  return redirect(route('documents.index'));
        return view('users.edit', compact('users'));
    }

    public function update(UserCreateRequest $request, User $user)
    {
        if(!$this->isUserSuperAdmin())  return redirect(route('documents.index'));
        $request->validated();
        $json = $this->getMilitaryData($request);
        $json = json_decode($json);
        $user->name = $json->name;
        $user->unit_oncreate = $json->unit_name;
        $user->save();
        return redirect(route('admin.index'))->with('status', 'Administrador ' . $user->masp . '  já existe e foi atualizado');
    }

    public function destroy(User $user)
    {
        if(!$this->isUserSuperAdmin())  return redirect(route('documents.index'));
        if ($user->masp == '1729862' || $user->masp == '1292598')
            return redirect(route('admin.index'))->with('status', 'Não é possível excluir o ' . $user->masp);

        $user_masp = $user->masp;
        $user->delete();
        return redirect(route('admin.index'))->with('status', 'Administrador ' . $user_masp . ' apagado com sucesso');
    }

    public function getAdminUsers() {
        if(!$this->isUserSuperAdmin())  return redirect(route('documents.index'));
        return view('admin_panel');
    }


    public function getMilitaryData(Request $request)
    {
        $masp = substr($request->masp, 0, 6);
        $url = sprintf("%s%s", self::PRODEMGE_API_URL_BM_NUMBER, $masp);

        $response = Http::withHeaders([
            'Authorization' => self::PRODEMGE_API_AUTH_KEY
        ])->get($url);
        $military_data = new \stdClass();
        $military_data->number = sprintf("%s-%s", $response["bombeiroMilitar"]["numeroServidor"], $response["bombeiroMilitar"]["digitoVerificador"]);
        $name = explode(" ", $response["bombeiroMilitar"]["nomeServidor"]);
        $military_data->name = $response["bombeiroMilitar"]["nomeServidor"];
        $military_data->graduation = $response["bombeiroMilitar"]["postoGraduacao"];
        $military_data->unit_number = $response["bombeiroMilitar"]["unidade"]["codigo"];
        $military_data->unit_name = $response["bombeiroMilitar"]["unidade"]["nomeAbreviado"];
        return json_encode($military_data);
    }

    public function dumpArray($array) {
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
}
