@if(\View::hasSection('breadcrumbs'))
    <nav id="breadcrumbs" aria-label="breadcrumb">
        <ol class="breadcrumb">
            @section('breadcrumbs')
                <li class="breadcrumb-item active" aria-current="page">/</li>
            @show
        </ol>
    </nav>
@endif
