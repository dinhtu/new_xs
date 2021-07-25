@extends('layouts.guest')

@section('content')
<register 
	:data="{{ json_encode([
		'checkEmail' => route('checkEmail'),
		'registerUrl' => route('register.store'),
		'roles' => $roles
	]) }}"
></register>
@endsection
