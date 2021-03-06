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
                    <strong>Dual 2 old ({{Carbon::parse($next)->addDays(-3)->format('Y-m-d')}})</strong>
                </div>
                <div class="card-body" id="dual">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev, '#dual']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next, '#dual']) }}"> Next</a>
                </div>
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        
                        @foreach ($dualResultOld2 as $item)
                            <tr class="{{isset($item['exist']) ? 'btn-success' : ''}}">
                                <td>{{$item['key']}}</td>
                                <td>{{$item['label']}}</td>
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
                    <strong>Dual 1 old ({{Carbon::parse($next)->addDays(-2)->format('Y-m-d')}})</strong>
                </div>
                <div class="card-body" id="dual">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev, '#dual']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next, '#dual']) }}"> Next</a>
                </div>
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        
                        @foreach ($dualResultOld1 as $item)
                            <tr class="{{isset($item['exist']) ? 'btn-success' : ''}}">
                                <td>{{$item['key']}}</td>
                                <td>{{$item['label']}}</td>
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
                    <strong>Dual ({{Carbon::parse($next)->addDays(-1)->format('Y-m-d')}})</strong>
                </div>
                <div class="card-body" id="dual">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev, '#dual']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next, '#dual']) }}"> Next</a>
                </div>
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        
                        @foreach ($dualResult as $item)
                            <tr class="{{isset($item['exist']) ? 'btn-success' : ''}}">
                                <td>{{$item['key']}}</td>
                                <td>{{$item['label']}}</td>
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
                    <strong>100 ({{Carbon::parse($next)->addDays(-1)->format('Y-m-d')}})</strong>
                </div>
                <div class="card-body" id="all">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev, '#all']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next, '#all']) }}"> Next</a>
                </div>
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($data100['data'] as $item)
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
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <strong>Duplicate ({{Carbon::parse($next)->addDays(-1)->format('Y-m-d')}})</strong>
                </div>
                <div class="card-body" id="all">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev, '#all']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next, '#all']) }}"> Next</a>
                </div>
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        @foreach ($arrCheck as $item)
                            <tr class="{{$item['exist'] ? 'btn-success' : ''}}">
                                <td>{{$item['key']}}</td>
                                <td>{{$item['event']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card" style="overflow: auto;">
                <div class="card-header" id="twoday">
                    <strong>two day ({{Carbon::parse($next)->addDays(-1)->format('Y-m-d')}})</strong>
                </div>
                <div class="card-body" id="twoday">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev, '#twoday']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next, '#twoday']) }}"> Next</a>
                </div>
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <thead>
                            <tr>
                                <td>stt</th>
                                <td>key</th>
                                <td>ratio</th>
                                <td>count</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($twoDay as $item)
                            <tr class="{{$item['exist'] ? 'btn-success' : ''}}">
                                <td>{{$item['stt']}}</td>
                                <td>{{$item['key1']}} | {{$item['key2']}}</td>
                                <td>{{$item['true']}}/{{$item['total']}}({{$item['ratio']}})</td>
                                <td>{{$item['count']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
        <div class="col-sm-12">
            <div class="card" style="overflow: auto;">
                <div class="card-header" id="all1">
                    <strong>new new ({{Carbon::parse($next)->addDays(-1)->format('Y-m-d')}})</strong>
                </div>
                <div class="card-body">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev, '#all1']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next, '#all1']) }}"> Next</a>
                </div>
                    <!-- <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                            @for($i = 0; $i <= 9 ; $i++)
                            <tr>
                                @for($j = 0; $j <= 9 ; $j++)
                                    @php
                                        $class = '';
                                        if(isset($arr[$i.$j])) {
                                            $class = 'btn-success';
                                        }
                                    @endphp
                                    <td class="{{$class}}">{{$i.$j}}<br>{{isset($arr[$i.$j]) && $arr[$i.$j] != 1 ? '('.$arr[$i.$j].')' : ''}}</td>
                                @endfor
                            </tr>
                            @endfor
                        </tbody>
                    </table> -->
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp tablexs">
                        <tbody>
                            <tr>
                                <td></td>
                                @php
                                $i = 1;
                                @endphp
                                @foreach ($dataTotal as $key => $item)
                                @php
                                $class = '';
                                if($i <= 10) {
                                    $class = 'btn-danger';
                                }
                                $i++;
                                @endphp
                                    <td class="{{$class}}">{{$key}}</td>
                                @endforeach
                            </tr>
                            @php
                            $first = true;
                            @endphp
                            @foreach ($dataConvert as $key => $item)
                            <tr>
                                <td>{{$key}}</td>
                                @foreach ($dataTotal as $keyTotal => $itemTotal)
                                @php
                                    $class = 'grey';
                                    if($key == $currentDate) {
                                        $class='btn-info';
                                    }
                                    if(isset($item[sprintf('%02d', $keyTotal)])) {
                                        $class = 'btn-success';
                                    }
                                    if(isset($item[sprintf('%02d', $keyTotal)]) && isset($item[sprintf('%02d', $keyTotal)]['special'])) {
                                        $class = 'btn-danger';
                                    }
                                    if ($first && isset($xsDetailsDay[sprintf('%02d', $keyTotal)])) {
                                        $class = 'btn-info';
                                    }
                                @endphp
                                <td class="{{$class}}">{{isset($item[sprintf('%02d', $keyTotal)]) ? $item[sprintf('%02d', $keyTotal)]['value'] : ''}}</td>
                                @endforeach
                            </tr>
                            @php
                            $first = false;
                            @endphp
                            @endforeach
                            <tr>
                                <td></td>
                                @foreach ($dataTotal as $key => $item)
                                    <td>{{$key}}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>Total</td>
                                @foreach ($dataTotal as $key => $item)
                                    <td>{{$item['value']}}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card" style="overflow: auto;">
                <div class="card-header" id="all68">
                    <strong>new new new  ({{Carbon::parse($next)->addDays(-1)->format('Y-m-d')}})</strong>
                </div>
                <div class="card-body">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev, '#all68']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next, '#all68']) }}"> Next</a>
                </div>
                <table class="table table-responsive-sm table-bordered table-striped text-center tmp tablexs">
                    <tr>
                        <td></td>
                        @foreach ($pairOfNumberCount as $key => $item)
                            <td>{{$key}}</td>
                        @endforeach
                    </tr>
                    @php
                            $first = true;
                            @endphp
                            @foreach ($pairOfNumberRes as $key => $item)
                            <tr>
                                <td>{{$key}}</td>
                                @foreach ($pairOfNumberCount as $keyTotal => $itemTotal)
                                @php
                                    $class = 'grey';
                                    if($key == $currentDate) {
                                        $class='btn-info';
                                    }
                                    if(isset($item[$keyTotal])) {
                                        $class = 'btn-success';
                                    }
                                    
                                    if ($first && (isset($xsDetailsDay[sprintf('%02d', $itemTotal['key'][0])]) || isset($xsDetailsDay[sprintf('%02d', $itemTotal['key'][1])]))) {
                                    }
                                @endphp
                                <td class="{{$class}}">{{isset($item[$keyTotal]) ? $item[$keyTotal] : ''}}</td>
                                @endforeach
                            </tr>
                            @php
                            $first = false;
                            @endphp
                            @endforeach
                            <tr>
                                <td></td>
                                @foreach ($pairOfNumberCount as $key => $item)
                                    <td>{{$key}}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td></td>
                                @foreach ($pairOfNumberCount as $key => $item)
                                    <td>{{$item['count']}}</td>
                                @endforeach
                            </tr>
                </table>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <strong>Special ({{Carbon::parse($next)->addDays(-1)->format('Y-m-d')}})</strong>
                </div>
                <div class="card-body" id="special">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev, '#special']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next, '#special']) }}"> Next</a>
                </div>
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp tablexs">
                        <tbody>
                            <tr>
                                <td>count old</td>
                                @php
                                    $class = '';
                                    if ($xsDaySpecialCurrent) {
                                        if ($countSpecial['less'] > $countSpecial['bigger']) {
                                            if ($xsDaySpecialCurrent->xsDetailNext->item < 50) {
                                                $class = 'btn-success';
                                            } else {
                                                $class = 'btn-danger';
                                            }
                                        }
                                    }
                                @endphp
                                <td class="{{$class}}">{{$countSpecial['less']}}</td>
                                @php
                                    $class = '';
                                    if ($xsDaySpecialCurrent) {
                                        if ($countSpecial['less'] < $countSpecial['bigger']) {
                                            if ($xsDaySpecialCurrent->xsDetailNext->item >= 50) {
                                                $class = 'btn-success';
                                            } else {
                                                $class = 'btn-danger';
                                            }
                                        }
                                    }
                                @endphp
                                <td class="{{$class}}">{{$countSpecial['bigger']}}</td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td>less ({{$countLess}})</td>
                                <td>bigger ({{$countBigger}})</td>
                            </tr>
                            @foreach ($dataSpecial as $key => $item)
                                <tr>
                                    <td>{{$item['date']}}</td>
                                    <td class="{{isset($item['less']) ? 'btn-success' : 'grey'}}">{{isset($item['less']) ? $item['less'] : ''}}</td>
                                    <td class="{{isset($item['bigger']) ? 'btn-success' : 'grey'}}">{{isset($item['bigger']) ? $item['bigger'] : ''}}</td>
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
                    <strong>D??? ??o??n All ({{Carbon::parse($next)->addDays(-1)->format('Y-m-d')}})</strong>
                </div>
                <div class="card-body" id="all">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev, '#all']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next, '#all']) }}"> Next</a>
                </div>
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($dataAll['data'] as $item)
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
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <strong>99 day ({{Carbon::parse($next)->addDays(-1)->format('Y-m-d')}})</strong>
                </div>
                <div class="card-body" id="all">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev, '#all']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next, '#all']) }}"> Next</a>
                </div>
                    <table class="table table-responsive-sm table-bordered table-striped text-center tmp">
                        <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($data6Month['data'] as $item)
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
        <div class="col-sm-4" style="display:none">
            <div class="card">
                <div class="card-header">
                <strong>Total : {{number_format($dataAll['totalInMonth'])}} ({{Carbon::parse($next)->addDays(-1)->format('Y-m')}})</strong>
                </div>
                <div class="card-body">
                <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prevMonth, '#all']) }}"> Prev</a>
                    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $nextMonth, '#all']) }}"> Next</a>
                </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <canvas id="myChart1"></canvas>
                        </div>
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
const data1 = {
  labels: {!! json_encode(array_keys($dataAll['dataInMonthMoney']), JSON_UNESCAPED_UNICODE) !!},
  datasets: [{
    label: 'month',
    data: JSON.parse('{{ json_encode(array_values($dataAll['dataInMonthMoney'])) }}'),
    backgroundColor: {!! json_encode(array_values($dataAll['backGround']), JSON_UNESCAPED_UNICODE) !!},
  }]
};
const config1 = {
  type: 'pie',
  data: data1,
  options: {}
};

$(function() {
    var myChart1 = new Chart(
        document.getElementById('myChart1'),
        config1
    );
});
</script>
@endsection