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
        padding:2px 2px !important
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
    @foreach ($arr as $key => $item)
    <div class="col-sm-4">
      <div class="card">
        <div class="card-header">
          <strong>search {{$key}}</strong>
        </div>
        <div class="card-footer">
          <a class="btn btn-sm btn-success" href="{{ route('producer.result.index', ['day' => $prev, '#dual']) }}"> Prev</a>
          <a class="btn btn-sm btn-success" href="{{ route('producer.result.index', ['day' => $next, '#dual']) }}"> Next</a>
        </div>
        <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
            <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($item as $key1 => $item1)
                @php
                    if($i > 100) {
                        continue;
                    }
                    $i++;
                @endphp
                <tr class="{{$item1['exist'] ? 'btn-success' : ''}}">
                    <td>{{$key1}} {{$item1['count'] != 0 && $item1['count'] != 1 ? '('.$item1['count'].')' : ''}}</td>
                    <td>{{$item1['value']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
    @endforeach
  </div>
</div>
@endsection