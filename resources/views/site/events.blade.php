@extends('layouts.app')

@section('content')
<div class="container-fluid page-overlay header-margin">
    <div class="container-fluid body-section">
        <div class="container my-5">
            <div class="row justify-content-center mb-4">
                <div class="col-12">
                    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner hero-banner">
                            @foreach($featured_events as $index => $event)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <div class="blog-feature-card"
                                        style="background-image: url('{{ get_image($event->photo?->photo) }}'); background-size: cover; background-position: center;">
                                        <div class="card-body">
                                            <h4 class="text-white">Featured</h4>
                                            <h2 class="text-white">{{ $event->title }}</h2>
                                            <p class="text-white">{{ $event->summary }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <h4>Upcoming Events</h4>
                </div>
            </div>
            <div class="row">
                @foreach($upcoming_events as $event)
                    <div class="col-12 mb-4">
                        <div class="event-long-card d-sm-flex flex-row">
                            <div
                                class="event-date bg-theme d-flex flex-column justify-content-center align-items-center p-4">
                                <h1 class="text-white date">{{ \Carbon\Carbon::parse($event->start_date)->format('d') }}</h1>
                                <h1 class="text-white month">{{ strtoupper(\Carbon\Carbon::parse($event->start_date)->format('M')) }}</h1>
                            </div>
                            <div class="event-image">
                                <img src="{{get_image($event->photo?->photo)}}" alt="event-image" class="img-fluid">
                            </div>
                            <div class="event-info">
                                <a href="{{route('home.event-detail', $event->slug)}}" class="text-decoration-none text-dark">
                                    <h2>{{$event->title}}</h2>
                                    <p>{{$event->summary}}</p>
                                </a>
                            </div>
                            <div class="event-share d-flex flex-column justify-content-center gap-2 align-items-center">
                                <i class="fa-brands fa-square-facebook"></i>
                                <i class="fa-brands fa-square-twitter"></i>
                                <i class="fa-brands fa-linkedin"></i>
                                <i class="fa-brands fa-square-instagram"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-12 mt-4 mb-2">
                    <h4>All Events</h4>
                </div>
            </div>
            <div class="row">
                @foreach($events as $event)
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
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
            <div class="row justify-content-end">
                <div class="col-12">
                    {!!$events->links('admin.global-partials.bootstrap-5')!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection