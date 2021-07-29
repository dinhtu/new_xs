@extends('layouts.producer')
@php
$max = 10;
@endphp
<style>
    .tmp tbody tr.btn-success:nth-of-type(odd) {
        background-color: #2eb85c !important;
    }
</style>
@section('content')
<div class="card-footer">
    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev]) }}"> Prev</a>
    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next]) }}"> Next</a>
</div>
<div class="fade-in">
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                <strong>Dự đoán 3</strong>
                </div>
                <div class="card-body">
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($arrAll3 as $item)
                            @php
                            if($i > $max) {
                                continue;
                            }
                            $i++;
                            @endphp
                            <tr class="{{$item['exist'] ? 'btn-success' : ''}}">
                                <td>{{$item['key']}}</td>
                                <td>{{$item['value']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                <strong>Dự đoán 5</strong>
                </div>
                <div class="card-body">
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($arrAll5 as $item)
                            @php
                            if($i > $max) {
                                continue;
                            }
                            $i++;
                            @endphp
                            <tr class="{{$item['exist'] ? 'btn-success' : ''}}">
                                <td>{{$item['key']}}</td>
                                <td>{{$item['value']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                <strong>Dự đoán 7</strong>
                </div>
                <div class="card-body">
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($arrAll7 as $item)
                            @php
                            if($i > $max) {
                                continue;
                            }
                            $i++;
                            @endphp
                            <tr class="{{$item['exist'] ? 'btn-success' : ''}}">
                                <td>{{$item['key']}}</td>
                                <td>{{$item['value']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card-footer">
    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev]) }}"> Prev</a>
    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next]) }}"> Next</a>
</div>
@endsection
