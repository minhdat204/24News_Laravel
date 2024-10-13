@extends('client.layouts.layout1')

@section('content')
    @yield('content2')
    @include('client.partials.shared.trending')
@endsection
