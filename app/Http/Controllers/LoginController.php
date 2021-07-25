<?php

namespace App\Http\Controllers;

use App\Enums\RoleType;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login.index', [
            'title' => 'ログイン',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->remember_me ?? false)) {
            $account = User::where('id', Auth::user()->id)->firstOrFail();
            $account->last_login_at = Carbon::now();
            if (!$account->save()) {
                Auth::logout();
                return redirect('login');
            }
            $routeName = "producer.dashboard.index";
            switch ($account->role) {
                case RoleType::PRODUCER:
                    $routeName = "producer.dashboard.index";
                    break;
                case RoleType::WHOLE_SALERS:
                    $routeName = "wholeSalers.dashboard";
                    break;
                case RoleType::RESTAURANT:
                    $routeName = "restaurant.dashboard";
                    break;
                case RoleType::RESTAURANT:
                    $routeName   = "users.profile";
                    break;
            }
            return redirect(route($routeName));
        }
        $this->setFlash(__('ユーザー名とパスワードが一致しません。'), 'error');
        return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        return redirect('login');
    }
}
