@extends('layouts.producer')
@php
$max = 10;
use Carbon\Carbon;
@endphp
<style>
    .tmp tbody tr.btn-success:nth-of-type(odd) {
        background-color: #2eb85c !important;
    }
    .btn-exit-old {
        background-color: #f9b115 !important;
    }
    .btn-exit-old-and-day {
        background-color: #39f !important;
    }
    .tablexs th, .tablexs td{
        padding:1px 1px !important;
        width: 5px;
    }
    .tablexs {
    /* width: 100%; */ /* Optional */
    /* border-collapse: collapse; */
    border-spacing: 0;
    border: 2px solid black;
}

.tablexs tbody,
.tablexs thead { display: block; }

thead tr th { 
    height: 30px;
    line-height: 30px;
    /* text-align: left; */
}

.tablexs tbody {
    height: 900px;
    overflow-y: auto;
    overflow-x: hidden;
}
</style>
@section('content')

<div class="fade-in">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <strong>First ({{Carbon::parse($next)->addDays(-1)->format('Y-m-d')}})</strong>
                </div>
                <div class="card-body" id="dual">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.mute.index', ['day' => $prev, '#dual']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.mute.index', ['day' => $next, '#dual']) }}"> Next</a>
                </div>
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        
                        @foreach ($resultFirst as $item)
                            <tr class="{{$item['exist'] ? 'btn-success' : ''}}">
                                <td>{{$item['key']}} {{$item['exist'] && $item['count'] != 1 ? '('.$item['count'].')' : ''}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <strong>Last ({{Carbon::parse($next)->addDays(-1)->format('Y-m-d')}})</strong>
                </div>
                <div class="card-body" id="dual">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.mute.index', ['day' => $prev, '#dual']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.mute.index', ['day' => $next, '#dual']) }}"> Next</a>
                </div>
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        
                        @foreach ($resultLast as $item)
                            <tr class="{{$item['exist'] ? 'btn-success' : ''}}">
                                <td>{{$item['key']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @foreach ($resultDup as $key => $item)
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <strong>Duplicate {{$key}} ({{Carbon::parse($next)->addDays(-1)->format('Y-m-d')}})</strong>
                </div>
                <div class="card-body" id="dual">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.mute.index', ['day' => $prev, '#dual']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.mute.index', ['day' => $next, '#dual']) }}"> Next</a>
                </div>
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        
                        @foreach ($item as $key1 => $item1)
                            <tr class="{{$item1['exist'] ? 'btn-success' : ''}}">
                                <td>{{$item1['key']}}</td>
                                <td>{{$item1['value']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

</script>
@endsection