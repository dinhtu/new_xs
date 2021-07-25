@extends('layouts.wholeSalers')
@php
    use \Carbon\Carbon;
@endphp

@section('content')
<past-traceability :data="{{json_encode([
    'startDate' => Carbon::now()->addMonths(-1)->format('Y/m/d'),
    'endDate' => Carbon::now()->format('Y/m/d'),
    'QRCodeImg' => asset('./assets/img/commons/qr_code.svg'),
])}}"/>
@endsection
