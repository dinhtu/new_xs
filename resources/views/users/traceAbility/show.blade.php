@extends('layouts.users')

@section('content')
<traceability-alert></traceability-alert>
<traceability-product-info
:data="{{ json_encode([
	'QRCodeImg' => asset("assets/img/commons/qr_code.svg")
	]) }}"
></traceability-product-info>
<traceability-default></traceability-default>
<traceability-product-basic></traceability-product-basic>
<traceability-product-detail></traceability-product-detail>
<traceability-product-distribution></traceability-product-distribution>
<traceability-control></traceability-control>
@endsection
