@extends('layouts.app')

@section('content')

<div class="container-fluid page-overlay">
    <img src="{{get_image($page->photo?->photo)}}" alt="" class="page-photo" style="height: 284px;">
</div>

<div class="container-fluid body-section">
    <div class="container my-4">
        {!! $page->content !!}
    </div>
</div>

@endsection