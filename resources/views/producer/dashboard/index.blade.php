@extends('layouts.producer')
@php
$max = 15;
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
</style>
@section('content')

<div class="fade-in">
    <div class="row">
        <div class="col-sm-7">
            <div class="card">
                <div class="card-header">
                <strong>Dự đoán 3</strong>
                </div>
                <div class="card-body">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev]) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next]) }}"> Next</a>
                </div>
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
                            $class = '';
                                if ($item['exist']) {
                                    $class = 'btn-success';
                                }
                                if ($item['existOld']) {
                                    $class = 'btn-exit-old';
                                }
                                if ($item['existOld'] && $item['exist']) {
                                    $class = 'btn-exit-old-and-day';
                                }
                            @endphp
                            <tr class="{{$class}}">
                                <td>{{sprintf('%02d', $item['key']);}} {{$item['exist'] && $item['count'] != 1 ? '('.$item['count'].')' : ''}}</td>
                                <td>{{$item['value']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="card">
                <div class="card-header">
                <strong>Ratio. Total : {{number_format($totalInMonth)}}</strong>
                </div>
                <div class="card-body">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prevMonth]) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $nextMonth]) }}"> Next</a>
                </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                <strong>Year. Total : {{number_format($totalYear)}}</strong>
                </div>
                <div class="card-body">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prevMonth]) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $nextMonth]) }}"> Next</a>
                </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <canvas id="myChart1"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                <strong>special</strong>
                </div>
                <div class="card-body">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev]) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next]) }}"> Next</a>
                </div>
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($special as $item)
                            @php
                            if($i > 15) {
                                continue;
                            }
                            $i++;
                            $class = '';
                                if ($item['exist']) {
                                    $class = 'btn-success';
                                }
                            @endphp
                            <tr class="{{$class}}">
                                <td>{{sprintf('%02d', $item['key']);}}</td>
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
@endsection
@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const data = {
  labels: {!! json_encode(array_keys($dataInMonthMoney), JSON_UNESCAPED_UNICODE) !!},
  datasets: [{
    label: 'month',
    data: JSON.parse('{{ json_encode(array_values($dataInMonthMoney)) }}'),
    backgroundColor: {!! json_encode(array_values($backGround), JSON_UNESCAPED_UNICODE) !!},
  }]
};
const config = {
  type: 'pie',
  data,
  options: {}
};

const data1 = {
  labels: {!! json_encode(array_keys($dataInYear), JSON_UNESCAPED_UNICODE) !!},
  datasets: [{
    label: 'year',
    backgroundColor: 'red',
    borderColor: 'red',
    data: JSON.parse('{{ json_encode(array_values($dataInYear)) }}'),
  }]
};
const config1 = {
  type: 'line',
  data: data1,
  options: {}
};

$(function() {
    var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
  var myChart1 = new Chart(
    document.getElementById('myChart1'),
    config1
  );
 
});
</script>
@endsection