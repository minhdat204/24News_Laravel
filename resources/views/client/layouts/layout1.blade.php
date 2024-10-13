<!DOCTYPE html>
<!--
 24 News by FreeHTML5.co
 Twitter: https://twitter.com/fh5co
 Facebook: https://fb.com/fh5co
 URL: https://freehtml5.co
-->
<html lang="en" class="no-js">

@include('client.partials.shared.head')

<body @yield('body-class')>

    @include('client.partials.shared.header')

    @yield('content')

    @include('client.partials.shared.footer')

    @include('client.partials.shared.scripts')

    @yield('scripts')

</body>

</html>
