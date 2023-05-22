@extends('layouts.master')
@section('app')
    @php
        $configData = applClasses();
    @endphp

    <body
        class="vertical-layout vertical-menu-modern {{ $configData['verticalMenuNavbarType'] }} {{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }} {{ $configData['sidebarClass'] }} {{ $configData['footerType'] }} {{ $configData['contentLayout'] }}"
        data-open="click" data-menu="vertical-menu-modern"
        data-col="{{ $configData['showMenu'] ? $configData['contentLayout'] : '1-column' }}" data-framework="laravel"
        data-asset-path="{{ asset('/') }}">

        <!-- BEGIN: Header-->
        @if (Request::is('admin**') && !Request::is('admin/template/index'))
            @include('panels.navbar')
        @elseif (Request::is(
            'user/profile',
            'user/support**',
            'user/kyc**',
            'user/deposit**',
            'user/withdraw**',
            'user/livechat**'))
            @include('panels.user.navbar')
        @endif
        <!-- END: Header-->

        <!-- BEGIN: Main Menu-->
        @if (isset($configData['showMenu']) && $configData['showMenu'] === true)
            @if (Request::is('admin**'))
                @include('panels.sidebar')
            @elseif (Request::is(
                'user/profile',
                'user/support**',
                'user/kyc**',
                'user/deposit**',
                'user/withdraw**',
                'user/livechat**'))
                @include('panels.user.sidebar')
            @endif
        @endif

        <!-- END: Main Menu-->

        <!-- BEGIN: Content-->
        @if (Request::is(
            'admin**',
            'user/profile',
            'user/support**',
            'user/kyc**',
            'user/deposit**',
            'user/withdraw**',
            'user/livechat**'))
            <div class="app-content content {{ $configData['pageClass'] }}">
                <!-- BEGIN: Header-->
                <div class="content-overlay"></div>
                <div class="header-navbar-shadow"></div>

                @if (($configData['contentLayout'] !== 'default' && isset($configData['contentLayout'])) ||
                    Request::is('admin/tickets'))
                    <div class="chat-application">
                        <div
                            class="content-area-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
                            <div class="{{ $configData['sidebarPositionClass'] }}">
                                <div class="sidebar">
                                    {{-- Include Sidebar Content --}}
                                    @yield('content-sidebar')
                                </div>
                            </div>
                            <div class="{{ $configData['contentsidebarClass'] }}" style="width: 100%">
                                <div class="content-wrapper">
                                    <div class="content-body">
                                        {{-- Include Page Content --}}
                                        @yield('content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="content-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container-xxl p-0' : '' }}">
                        <div class="content-body" id="content-body">
                            {{-- Include Page Content --}}
                            @if (Request::is('admin**') && !Request::is('admin/template/index'))
                                @include('admin.partials.breadcrumb')
                            @endif
                            @yield('content')
                        </div>
                    </div>
                @endif
            </div>

            <!-- End: Content-->

            <div class="sidenav-overlay"></div>
            <div class="drag-target"></div>

            {{-- include footer --}}
            @if (!Request::is('admin/template/index'))
                @include('panels/footer')
            @endif

            {{-- include default scripts --}}
            @include('panels/scripts')
        @else
            <script>
                window.usermenuData = @json($usermenuData);
                window.configData = @json($configData);
                window.siteName = "{{ siteName() }}";
            </script>

            @yield('content')

            <!-- End: Content-->

            <div class="sidenav-overlay"></div>
            <div class="drag-target"></div>
            @include('panels/scripts')
        @endif
    @endsection
