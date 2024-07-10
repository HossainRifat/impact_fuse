@extends('layouts.app')

@section('content')
<style>
    @keyframes glow {
        0% { box-shadow: 0 0 2px 2px #df1b1b99; }
        25% { box-shadow: 0 0 3px 3px #df1b1b; }
        50% { box-shadow: 0 0 4px 4px #df1b1b; }
        75% { box-shadow: 0 0 3px 3px #df1b1b; }
        100% { box-shadow: 0 0 2px 2px #df1b1b99; }
    }
    .glow-effect {
        animation: glow 1.5s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    }
</style>
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
                @if($event->video_url)
                    <div class="col-12 mb-2 blog-image" style="position: relative; display: inline-block;">
                        <img src="{{ get_image($event->photo?->photo) }}" alt="" 
                                style="width: 100%; display: block;">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#exampleModal" 
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                            <img src="{{asset('images/assets/play-alt.png')}}" alt="Play" 
                                    style="width: 64px; height: 64px;" class="glow-effect">
                        </a>
                    </div>
                @else
                    <div class="col-12 mb-2 blog-image" style="position: relative; display: inline-block;">
                        <img src="{{get_image($event->photo?->photo)}}" alt="">
                    </div>
                @endif
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">{{$event->title}}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @if($event->video_url)
                <div class="ratio ratio-16x9">
                    <iframe src="{{$event->video_url}}" allowfullscreen></iframe>
                </div>
            @endif
        </div>
      </div>
    </div>
  </div>
@endsection