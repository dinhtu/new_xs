<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('forgotPassword.index', [
            'title' => 'パスワードをお忘れですか',
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
    public function store(ForgotPasswordRequest $request)
    {
        $account = User::where('email', $request->email)->firstOrFail();
        $account->reset_password_token = md5($request->email . random_bytes(25) . Carbon::now());;
        $account->reset_password_token_exprire = Carbon::now()->addMinutes(30);
        if (!$account->save()) {
            $this->setFlash(__('メールが一致しません。'), 'error');
        }
        $this->setFlash(__('please check mail!'));
        $mailContents = [
            'subject' => 'Successful account registration',
            'content' => [
                'text' => 'Have you requested a password change?',
                'link' => route('forgot_password.reset', $account->reset_password_token)
            ]
        ];

        Mail::to($account->email)->send(new ForgotPasswordMail($mailContents));
        return redirect(route('forgot_password.index'));
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

    public function reset($token)
    {
        $account = User::where([
            ['reset_password_token', $token],
            ['reset_password_token_exprire', '>=', Carbon::now()]
        ])->first();

        if ($account) {
            return view('forgotPassword.reset', [
                'token' => $token
            ]);
        }

        $this->setFlash(__('期限切れのリンク。'), 'error');
        return view('forgotPassword.index', [
            'title' => 'パスワードをお忘れですか',
        ]);
    }

    public function changePassword(ResetPasswordRequest $request)
    {
        $account = User::where([
            ['reset_password_token', $request->reset_password_token],
            ['reset_password_token_exprire', '>=', Carbon::now()]
        ])->first();
        if ($account) {
            $account->password = Hash::make($request->password);
            $account->reset_password_token = null;
            if ($account->save()) {
                $this->setFlash(__('change password success'));
                return redirect('login');
            }
        }

        $this->setFlash(__('期限切れのリンク。'), 'error');
        return view('forgotPassword.index', [
            'title' => 'パスワードをお忘れですか',
        ]);
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
}
