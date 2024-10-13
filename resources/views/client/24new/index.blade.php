@extends('client.layouts.layout1')

@section('content')
    @include('client.partials.index.banner')
    @include('client.partials.shared.trending')
    @include('client.partials.index.news')
    @include('client.partials.index.videonews')
    @include('client.partials.shared.news-content')
@endsection
