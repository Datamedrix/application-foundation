@extends($layout ?? 'layouts::default')

@section('breadcrumbs')
    @if(\Route::has('home'))
        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
    @else
        <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
    @endif
    <li class="breadcrumb-item active">@lang('app::pages.phpinfo.breadcrumb')</li>
@endsection

@section('styles')
    @parent

    <style type="text/css" rel="stylesheet" media="screen">
        .php-info pre {
            margin: 0;
        }
        .php-info a:link {
            color: #009;
            text-decoration: none;
            background-color: #ffffff;
        }
        .php-info a:hover {
            text-decoration: underline;
        }
        .php-info table {
            border-collapse: collapse;
            border: 0;
            width: 100%;
            box-shadow: 1px 2px 3px #ccc;
        }
        .php-info .center {
            text-align: center;
        }
        .php-info .center table {
            margin: 1em auto;
            text-align: left;
        }
        .php-info .center th {
            text-align: center !important;
        }
        .php-info td {
            border: 1px solid #666;
            font-size: 75%;
            vertical-align: baseline;
            padding: 4px 5px;
        }
        .php-info th {
            border: 1px solid #666;
            font-size: 75%;
            vertical-align: baseline;
            padding: 4px 5px;
        }
        .php-info h1 {
            font-size: 150%;
        }
        .php-info h2 {
            font-size: 125%;
        }
        .php-info .p {
            text-align: left;
        }
        .php-info .e {
            background-color: #ccf;
            min-width: 150px;
            font-weight: bold;
        }
        .php-info .h {
            background-color: #99c;
            font-weight: bold;
        }
        .php-info .v {
            background-color: #ddd;
            overflow-x: auto;
            word-wrap: break-word;
        }
        .php-info .v i {
            color: #999;
        }
        .php-info img {
            float: right;
            border: 0;
        }
        .php-info hr {
            width: 100%;
            background-color: #ccc;
            border: 0;
            height: 1px;
        }

        .server-info .table {
            border-collapse: collapse;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="server-info">
                <table class="table table-bordered">
                <tbody>
                    @foreach($serverInfo as $key => $value)
                        <tr>
                            <td><b>{{ $key }}</b></td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            <div class="php-info">
                {!! $phpInfo !!}
            </div>
        </div>
    </div>
@endsection
