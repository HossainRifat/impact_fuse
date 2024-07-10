@extends('layouts.app')

@section('content')
<div class="container-fluid page-overlay header-margin">
    <div class="container-fluid body-section">
        <div class="container my-5">
            <div class="row mb-5">
                <div class="col-12">
                    <a href="{{route('home.events')}}" class="color-theme">
                        <i class="fa-solid fa-arrow-left"></i>&nbsp;Back&nbsp;
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h1 class="title-theme">{{$event->title}}</h1>
                </div>
                <div class="col-12 mb-2">
                    <h4 class="color-theme">
                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y h:i A') }}
                        @if($event->end_date)
                            - {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y h:i A') }}
                        @endif
                    </h4>
                </div>
                <div class="col-12 mb-2">
                    <h5 class="text-justify lh-base">{{$event->summary}}</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2 blog-image">
                    <img src="{{get_image($event->photo?->photo)}}" alt="">
                </div>
                <div class="col-md-12">
                    <p class="fs-6 fw-bold text-secondary">Organized by ImpactFuse | {{ \Carbon\Carbon::parse($event->start_date)->format('d M, Y') }}</p>
                </div>
            </div>
            <div class="row mb-4 mt-2">
                <div class="col-12">
                   {!! $event->content !!}
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Categories</h4>
                </div>
                <div class="col-12">
                    @foreach($event->categories as $category)
                        <span class="badge text-bg-secondary ">{{$category->name}}</span>
                    @endforeach
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Tags</h4>
                </div>
                <div class="col-12">
                    @foreach(explode(',', $event->tag) as $tag)
                        <span class="badge text-bg-primary">{{$tag}}</span>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h4>More Events</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach($related_events as $event)
                                <div class="swiper-slide">
                                    <a href="{{ route('home.event-detail', $event->slug) }}" class="stretched-link">
                                        <div class="event-card"
                                            style="background-image: url('{{ get_image($event->photo?->photo) }}'); background-size: cover; background-position: center;">
                                            <div class="card-body">
                                                <p class="event-date">{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</p>
                                                <p class="event-title">{{ $event->title }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection