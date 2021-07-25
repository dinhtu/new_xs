<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\RoleType;
use App\Enums\StatusCode;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Mail\RegisterSuccess;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = [
            [
                'label' => '生産者',
                'id' => RoleType::PRODUCER,
            ],
            [
                'label' => '卸売業者',
                'id' => RoleType::WHOLE_SALERS,
            ],
            [
                'label' => '飲食店',
                'id' => RoleType::RESTAURANT
            ],
        ];

        return view('register.index', [
            'title' => '新規登録',
            'roles' => $roles
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
    public function store(RegisterRequest $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->name = '';
        $user->role = RoleType::getRoleID($request->role);
        $user->password = Hash::make($request->password);
        if ($user->save()) {
            $mailContents = [
                'subject' => 'Successful account registration',
                'content' => 'Successful account registration'
            ];

            Mail::to($user->email)->send(new RegisterSuccess($mailContents));
            return redirect('login');
        }
        $this->setFlash(__('登録に失敗しました。'), 'error');
        return redirect(route('register.index'));
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

    public function checkEmail (Request $request)
    {
        $valid = !User::where(function ($query) use ($request) {
            $query->where('email', $request["value"]);
        })->exists();

        return response()->json([
            'valid' => $valid,
        ], StatusCode::OK);
    }
}
