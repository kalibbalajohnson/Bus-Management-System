<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <div class="simple-text logo-normal">
            {{ __('Menu') }}
        </div>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('home') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'routes' ? 'active' : '' }}">
                <a href="{{ route('routes') }}">
                    <i class="nc-icon nc-pin-3"></i>
                    <p>{{ __('Routes and stops') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'buses' ? 'active' : '' }}">
                <a href="{{ route('buses') }}">
                    <i class="nc-icon nc-bus-front-12"></i>
                    <p>{{ __('Buses') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'staff' ? 'active' : '' }}">
                <a href="{{ route('staff') }}">
                    <i class="nc-icon nc-single-02"></i>
                    <p>{{ __('Staff') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'passes' ? 'active' : '' }}">
                <a href="{{ route('passes') }}">
                    <i class="nc-icon nc-paper"></i>
                    <p>{{ __('Passes') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
