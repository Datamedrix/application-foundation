@if(\View::hasSection('routerView'))
    <router-view>
        @section('routerView')
        @show
    </router-view>
@endif
