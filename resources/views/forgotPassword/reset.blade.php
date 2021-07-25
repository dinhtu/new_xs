@extends('layouts.guest')

@section('content')
<reset-password
  :data="{{ json_encode([
    'token' => $token,
    'updateUrl' => route('forgot_password.changePassword')
  ]) }}"
></reset-password>
@endsection
