@extends('adminlte::master')

@php($dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home'))

@if (config('adminlte.use_route_url', false))
    @php($dashboard_url = $dashboard_url ? route($dashboard_url) : '')
@else
    @php($dashboard_url = $dashboard_url ? url($dashboard_url) : '')
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')
    <style>
        .form-login {
            background-color: rgba(0, 0, 0, 0.55);
            padding-left: 20px;
            padding-right: 20px;
            border-radius: 15px;
            border-color: #d2d2d2;
            border-width: 5px;
            color: white;
            box-shadow: 0 1px 0 #cfcfcf;
        }
    </style>
    <div class="{{ $auth_type ?? 'login' }}-box form-login position-absolute" id="box" style="display: none">
        {{-- Logo --}}
        <div class="{{ $auth_type ?? 'login' }}-logo mt-3">
            <a href="{{ $dashboard_url }}" class="text-light">

                {{-- Logo Image --}}
                @if (config('adminlte.auth_logo.enabled', false))
                    <img src="{{ asset(config('adminlte.auth_logo.img.path')) }}"
                        alt="{{ config('adminlte.auth_logo.img.alt') }}"
                        @if (config('adminlte.auth_logo.img.class', null)) class="{{ config('adminlte.auth_logo.img.class') }}" @endif
                        @if (config('adminlte.auth_logo.img.width', null)) width="{{ config('adminlte.auth_logo.img.width') }}" @endif
                        @if (config('adminlte.auth_logo.img.height', null)) height="{{ config('adminlte.auth_logo.img.height') }}" @endif>
                @else
                    <img src="{{ asset(config('adminlte.logo_img')) }}" alt="{{ config('adminlte.logo_img_alt') }}"
                        height="50">
                @endif

                {{-- Logo Label --}}
                {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}

            </a>
        </div>

        {{-- Card Header --}}
        @hasSection('auth_header')
            <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                <h3 class="card-title float-none text-center" id="login-message" style="opacity: 0;">
                    @yield('auth_header')
                </h3>
            </div>
        @endif

        {{-- Card Body --}}
        @yield('auth_body')

        {{-- Card Footer --}}
        @hasSection('auth_footer')
            <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }} mb-3">
                @yield('auth_footer')
            </div>
        @endif
    </div>

    <div id="particles-js" style="width: 100%; height: 100%;"></div>
    <script src="{{ asset('js/particles.js') }}"></script>
    <script>
        particlesJS.load('particles-js', "{{ asset('js/particlesjs-config.json') }}", function() {
            console.log('callback - particles.js config loaded');
        });

        $(document).ready(function() {
            let width = $("#box").removeAttr('style').width();
            let height = $("#box").removeAttr('style').height();

            $("#box").width("1px");
            $("#box").height("2px");

            $("#box").show();
            
            $("#box").animate({
                height: height
            }, 1000);

            $("#box").animate({
                width: width
            }, 1000);

            setTimeout(() => {
                $("#login-message").animate({
                    opacity: 1,
                }, "slow");

                $("#box").removeAttr('style');
            }, 2000);
        });
    </script>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
