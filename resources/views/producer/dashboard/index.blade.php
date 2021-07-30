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
        <div class="col-sm-7">
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
        <div class="col-sm-5">
            <div class="card">
                <div class="card-header">
                <strong>Ratio. Total : {{number_format($totalInMonth)}}</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                <strong>Dự đoán 2</strong>
                </div>
                <div class="card-body">
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($arrAll2 as $item)
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
                <strong>Dự đoán 1</strong>
                </div>
                <div class="card-body">
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($arrAll1 as $item)
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

$(function() {
    var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
 
});
</script>
@endsection