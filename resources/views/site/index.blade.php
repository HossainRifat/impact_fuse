@extends('layouts.app')

@section('content')
<div class="container-fluid hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 px-5">
                <h1 class="text-center">
                    {{$site_data['hero-title']}}
                </h1>
                <p class="text-light">
                    {{$site_data['hero-subtitle']}}
                </p>
            </div>
            <div class="col-md-6">
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner hero-banner">
                        @foreach($banners as $index => $banner)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <a href="{{$banner->link}}">
                                <img src="{{ get_image($banner->photo?->photo) }}" class="d-block w-100" alt="">
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid body-section">
    <div class="container">
        <div class="custom-shape"></div>
        <div class="overlap-div">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-4 d-flex justify-content-center">
                    <div class="logo-card">
                        <img src="{{asset('site_assets/assets/logo.png')}}" alt="">
                    </div>
                </div>
                <div class="col-12 col-xl-8 justify-content-between align-items-center donation-div pe-0">
                    <div class="d-flex flex-row align-items-center">
                        <div class="make-donation text-center p-4">
                            <h1>Make a Donation</h1>
                            <h3>Every contribution, big or small, fuels our mission to create a more sustainable
                                future.
                            </h3>
                            <button class="btn btn-primary mt-4">Donate Now</button>
                        </div>
                        <div class="donation-img">
                            <img src="{{asset('site_assets/assets/donation.jpeg')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section custom-section" style="margin-top: -192px;">
            <h1 class="theme-sec-title mb-4">We are in a mission to help the helpless</h1>
            <div class="row">
                <div class="col-md-6">
                    <div class="theme-card-fixed">
                        <h2 class="text-center fw-bolder mb-4">Our mission</h2>
                        <p class="mission-vision">
                            {{$site_data['mission']}}
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-card-fixed">
                        <h2 class="text-center fw-bolder mb-4">Our vision</h2>
                        <p class="mission-vision">
                            {{$site_data['vision']}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="section custom-section">
            <h1 class="theme-sec-title mb-4">Services</h1>
            <div class="row justify-content-center">
                @foreach($services as $service)
                    <div class="col-md-4 mb-4">
                        <div class="theme-card-image">
                            <img src="{{get_image($service->photo?->photo)}}" alt="">
                            <div class="card-body">
                                <h4 class="text-center fw-bolder mb-4">{{$service->name}}</h4>
                                <p>
                                    {{Str::words($service->summary, 30, '...')}}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="section custom-section">
            <h1 class="theme-sec-title mb-5">Our Contribution To Sustainable Development Goals</h1>
            <div class="row">
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_1.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_2.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_3.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_4.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_5.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_6.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_7.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_8.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_9.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_10.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_11.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_12.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_13.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_14.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_15.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_16.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card">
                        <img src="{{asset('site_assets/assets/goal_17.png')}}" alt="">
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                    <div class="goal-card border">
                        <img src="{{asset('site_assets/assets/goal_18.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="section custom-section">
            <h1 class="theme-sec-title mb-4">Blogs</h1>
            <div class="row justify-content-center">
                @foreach($blogs as $blog)
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="blog-card">
                            <img src="{{get_image($blog->photo?->photo)}}" alt="">
                            <div class="card-body container d-flex flex-column justify-content-between">
                                <div>
                                    <h4 class="fw-bolder">{{$blog->title}}</h4>
                                    <p class="blog-date">{{$blog->created_by?->name ?? 'Author'}} | {{$blog->created_at->format('M d, Y')}}</p>
                                </div>
                                <p>
                                    {{Str::words($blog->summary, 16, '...')}}
                                </p>
                                <a href="{{route('home.blog', $blog->slug)}}">Read More <i class="move-right fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="section custom-section">
            <h1 class="theme-sec-title mb-4">Upcoming events</h1>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach($events as $event)
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
            </div>
        </div>
    </div>
</div>
@endsection