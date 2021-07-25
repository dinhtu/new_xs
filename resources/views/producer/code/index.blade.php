@extends('layouts.producer')

@section('content')
<code-index 
	:data="{{ json_encode([
		'QRCodeImg' => asset("assets/img/commons/qr_code.svg")
	]) }}"
></code-index>
@endsection
