@extends('layouts.producer')
@php
    use \Carbon\Carbon;
@endphp

@section('content')
<read-history-index :data="{{json_encode([
    'startDate' => Carbon::now()->addMonths(-1)->format('Y/m/d'),
    'endDate' => Carbon::now()->format('Y/m/d'),
])}}"></read-history-index>
@endsection
