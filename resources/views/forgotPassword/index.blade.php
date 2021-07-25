@extends('layouts.guest')

@section('content')
<forgot-password
	:data="{{ json_encode([
		'forgotPasswordUrl' => route('forgot_password.store') 
	]) }}"
></forgot-password>
@endsection
