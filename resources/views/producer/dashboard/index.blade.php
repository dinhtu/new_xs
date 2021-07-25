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
<h1>{{$countExist}}</h1>/<h2>{{$total/}}</h2>
<div class="card-footer">
    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev]) }}"> Prev</a>
    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next]) }}"> Next</a>
</div>
<table class="table table-responsive-sm table-bordered table-striped text-center">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="12">
            <table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[0] as $item)
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
            </td>
        </tr>
        <tr>
            <td colspan="12"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[1] as $item)
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
            </table></td>
        </tr>
        <tr>
            <td colspan="6"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[2] as $item)
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
            </table></td>
            <td colspan="6"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[3] as $item)
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
            </table></td>
        </tr>
        <tr>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[4] as $item)
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
            </table></td>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[5] as $item)
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
            </table></td>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[6] as $item)
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
            </table></td>
        </tr>
        <tr>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[7] as $item)
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
            </table></td>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[8] as $item)
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
            </table></td>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[9] as $item)
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
            </table></td>
        </tr>
        <tr>
            <td colspan="3"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[10] as $item)
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
            </table></td>
            <td colspan="3"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[11] as $item)
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
            </table></td>
            <td colspan="3"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[12] as $item)
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
            </table></td>
            <td colspan="3"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[13] as $item)
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
            </table></td>
        </tr>
        <tr>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[14] as $item)
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
            </table></td>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[15] as $item)
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
            </table></td>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[16] as $item)
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
            </table></td>
        </tr>
        <tr>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[17] as $item)
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
            </table></td>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[18] as $item)
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
            </table></td>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[19] as $item)
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
            </table></td>
        </tr>
        <tr>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[20] as $item)
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
            </table></td>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[21] as $item)
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
            </table></td>
            <td colspan="4"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[22] as $item)
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
            </table></td>
        </tr>
        <tr>
            <td colspan="3"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[23] as $item)
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
            </table></td>
            <td colspan="3"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[24] as $item)
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
            </table></td>
            <td colspan="3"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[25] as $item)
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
            </table></td>
            <td colspan="3"><table class="table table-bordered table-striped text-center tmp">
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data[26] as $item)
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
            </table></td>
        </tr>
    </tbody>
</table>
<div class="card-footer">
    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $prev]) }}"> Prev</a>
    <a class="btn btn-sm btn-success" href="{{ route('producer.dashboard.index', ['day' => $next]) }}"> Next</a>
</div>
@endsection
