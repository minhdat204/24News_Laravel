@extends('client.layouts.layout2')

@section('body-class')
    class="single"
@endsection

@section('scripts')
    <!-- Parallax -->
    <script src="{{ asset('client/js/jquery.stellar.min.js') }}"></script>
    <script>
        if (!navigator.userAgent.match(/Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i)) {
            $(window).stellar();
        }
    </script>
@endsection

@section('content2')
    @include('client.partials.single.title')
    @include('client.partials.single.main-content')
@endsection
