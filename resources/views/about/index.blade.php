@extends($layout ?? 'layouts::default')

@section('breadcrumbs')
    @if(\Route::has('home'))
        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
    @else
        <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
    @endif
    <li class="breadcrumb-item active" aria-current="page">@lang('app::pages.about.breadcrumb')</li>
@endsection

@section('content')
<div class="container">
    @if(app()->isDownForMaintenance())
        <div class="card alert alert-warning">
            <div class="card-body">
                <h5 class="card-title">@lang('app::pages.about.card.title.maintenance')<i class="fas fa-exclamation"></i></h5><br/>
                <p class="card-text">
                    @lang('app::messages.maintenance')
                </p>
            </div>
        </div><br/>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">@lang('app::pages.about.card.title.application')</h5><br/>
            <p class="card-text">
                <b>Name:</b>&nbsp;{{ $app['name'] }}<br/>
                <b>Environment:</b>&nbsp;{{ $app['environment'] }}<br/>
                <b>Version:</b>&nbsp;{{ $app['version'] }}
            </p>
        </div>
    </div><br/>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">@lang('app::pages.about.card.title.locale')</h5><br/>
            <p class="card-text">
                <b>Locale:</b>&nbsp;{{ $app['locale'] }}<br/>
            </p>

            <h6>@lang('app::pages.about.header.formats')</h6>
            <p class="card-text">
                <b>@lang('app::pages.about.label.number'):</b> {{ $app['locale']->numberFormat() }}<br/>
                <b>@lang('app::pages.about.label.currency'):</b> {{ $app['locale']->currencyFormat() }} ({{ $app['locale']->setting('intCurrencyNotation') }} / {{ $app['locale']->setting('currencySymbol') }})<br/>
                <b>@lang('app::pages.about.label.date'):</b> {{ $app['locale']->dateFormat() }}<br/>
                <b>@lang('app::pages.about.label.datetime'):</b> {{ $app['locale']->datetimeFormat() }}<br/>
                <b>@lang('app::pages.about.label.timestamp'):</b> {{ $app['locale']->timestampFormat() }}<br/>
                <b>@lang('app::pages.about.label.time'):</b> {{ $app['locale']->timeFormat() }}
            </p>

            <h6>@lang('app::pages.about.header.examples')</h6>
            <p class="card-text">
                <b>@lang('app::pages.about.label.integer'):</b> {{ $examples['positiveInteger'] }} / {{ $examples['negativeInteger'] }}<br/>
                <b>@lang('app::pages.about.label.float'):</b> {{ $examples['positiveFloat'] }} / {{ $examples['negativeFloat'] }}<br/>
                <b>@lang('app::pages.about.label.currency'):</b> {{ $examples['positiveCurrency'] }} / {{ $examples['negativeCurrency'] }}<br/>
                <b>@lang('app::pages.about.label.date'):</b> {{ $examples['currentDate'] }}<br/>
                <b>@lang('app::pages.about.label.datetime'):</b> {{ $examples['currentDatetime'] }}<br/>
                <b>@lang('app::pages.about.label.timestamp'):</b> {{ $examples['currentTimestamp'] }}<br/>
                <b>@lang('app::pages.about.label.time'):</b> {{ $examples['currentTime'] }}
            </p>
        </div>
    </div><br/>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">@lang('app::pages.about.card.title.framework')</h5><br/>
            <p class="card-text">
                @lang('app::pages.about.text.framework', ['name' => $framework['name'], 'version' => $framework['version']])
            </p>
        </div>
    </div><br/>
    <div class="mx-auto" style="width:300px">
        <i class="text-muted">Copyright (c) {{ now()->year }}, Datamedrix GmbH</i>
    </div><br/>
</div>
@endsection
