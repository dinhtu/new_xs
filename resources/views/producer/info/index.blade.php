@extends('layouts.producer')

@section('content')
<info-index 
	:data="{{ json_encode([
		'QRCodeImg' => asset('assets/img/commons/qr_code.svg')
	]) }}"
></info-index>
@endsection
