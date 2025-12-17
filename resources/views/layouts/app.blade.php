<x-layouts.base>


    @if(in_array(request()->route()->getName(), ['dashboard', 'profile', 'profile-example', 'users', 'bootstrap-tables', 'transactions',
<<<<<<< HEAD
    'buttons',
    'forms', 'modals', 'notifications', 'typography', 'upgrade-to-pro']))
=======
    'buttons', 'forms', 'modals', 'notifications', 'typography', 'upgrade-to-pro', 'purchasing-trend', 'cost-by-category', 'sales-trend', 'top-sales-breakdown', 'cost-vs-sales']))
>>>>>>> 4e6d9f2e2e3c9d56c03a6b917c96f3b2cae2a5b8

    {{-- Nav --}}
    @include('layouts.nav')
    {{-- SideNav --}}
    @include('layouts.sidenav')
    <main class="content">
        {{-- TopBar --}}
        @include('layouts.topbar')
        {{ $slot }}
        {{-- Footer --}}
        @include('layouts.footer')
    </main>

    @elseif(in_array(request()->route()->getName(), ['register', 'register-example', 'login', 'login-example',
    'forgot-password', 'forgot-password-example', 'reset-password','reset-password-example']))

    {{ $slot }}
    {{-- Footer --}}
    @include('layouts.footer2')


    @elseif(in_array(request()->route()->getName(), ['404', '500', 'lock']))

    {{ $slot }}

    @endif
</x-layouts.base>