<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="antialiased">
        <!-- Background with Image -->
        <div 
            class="fixed inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('images/login-bg.jpg') }}'); background-color: #0a0a0a;"
        >
            <!-- Dark Overlay - More Transparent to Show Background Image -->
            <div class="absolute inset-0 bg-black/35"></div>
        </div>

        <!-- Content Container -->
        <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
