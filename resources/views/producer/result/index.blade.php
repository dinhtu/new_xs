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
    <a class="btn btn-sm btn-success" href="{{ route('producer.result.index', ['day' => $prev]) }}"> Prev</a>
    <a class="btn btn-sm btn-success" href="{{ route('producer.result.index', ['day' => $next]) }}"> Next</a>
</div>
<div class="fade-in">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                <strong>HalfMonth. Total : {{number_format($totalHalfMonth)}}</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <canvas id="myChart1" height="200"></canvas>
                        </div>
                        <div class="col-sm-6">
                            <canvas id="myChart2" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                <strong>Current Month. Total : {{number_format($totalInMonth)}}</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <canvas id="myChart" height="200"></canvas>
                        </div>
                        <div class="col-sm-12">
                            <canvas id="myChart3" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card-footer">
    <a class="btn btn-sm btn-success" href="{{ route('producer.result.index', ['day' => $prev]) }}"> Prev</a>
    <a class="btn btn-sm btn-success" href="{{ route('producer.result.index', ['day' => $next]) }}"> Next</a>
</div>
@endsection
@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  var dataYear = {!! json_encode($dataInMonth, JSON_UNESCAPED_UNICODE) !!};
  var color = {!! json_encode($color, JSON_UNESCAPED_UNICODE) !!};
  var convertData = [];
    for (const [key, value] of Object.entries(dataYear)) {
      var item = {};
      item.label = key;
      item.backgroundColor = color[convertData.length];
      item.borderColor = color[convertData.length];
        item.data =value;
      // for (const [key1, value1] of Object.entries(value)) {
      //   item.data.push(value1);
      // }
      convertData.push(item);
    }
const data = {
  labels: {!! json_encode(array_keys($labelXMonth), JSON_UNESCAPED_UNICODE) !!},
  datasets: convertData
};
const config = {
  type: 'line',
  data,
  options: {}
};

const data1 = {
  labels: {!! json_encode(array_keys($dataHalfMonth), JSON_UNESCAPED_UNICODE) !!},
  datasets: [{
    label: 'half month',
    backgroundColor: 'rgb(255, 99, 132)',
    borderColor: 'rgb(255, 99, 132)',
    data: JSON.parse('{{ json_encode(array_values($dataHalfMonth)) }}'),
  }]
};
const config1 = {
  type: 'line',
  data: data1,
  options: {}
};
const data2 = {
  labels: {!! json_encode(array_keys($dataHalfMonth), JSON_UNESCAPED_UNICODE) !!},
  datasets: [{
    label: 'money',
    backgroundColor: 'blue',
    borderColor: 'blue',
    data: JSON.parse('{{ json_encode(array_values($dataHalfMonthMoney)) }}'),
  }]
};
const config2 = {
  type: 'line',
  data: data2,
  options: {}
};

const data3 = {
  labels: {!! json_encode(array_keys($dataInMonthMoney), JSON_UNESCAPED_UNICODE) !!},
  datasets: [{
    label: 'money',
    backgroundColor: 'blue',
    borderColor: 'blue',
    data: JSON.parse('{{ json_encode(array_values($dataInMonthMoney)) }}'),
  }]
};
const config3 = {
  type: 'line',
  data: data3,
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
  var myChart2 = new Chart(
    document.getElementById('myChart2'),
    config2
  );
  var myChart3 = new Chart(
    document.getElementById('myChart3'),
    config3
  );
});
</script>
@endsection