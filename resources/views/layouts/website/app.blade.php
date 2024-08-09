<!DOCTYPE html>
<html lang="en">
@include('layouts.website.head')
<body>
    <div class="content-wrapper home">
        @include('layouts.website.header')
        @yield('content')

        @include('layouts.website.footer')
        @include('layouts.website.scripts')
    </div>
    @livewireScripts

</body>
</html>
