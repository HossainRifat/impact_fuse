@extends('layouts.app')

@section('content')
<div class="container-fluid page-overlay header-margin">
    <div class="container-fluid body-section">
        <div class="container my-5">
            <div class="row mb-5">
                <div class="col-12">
                    <a href="" class="color-theme">
                        <i class="fa-solid fa-arrow-left"></i>&nbsp;Back&nbsp;
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h1 class="title-theme">{{$blog->title}}</h1>
                </div>
                <div class="col-12 mb-2">
                    <h5 class="color-theme fw-bold">{{$blog->summary}}</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2 blog-image">
                    <img src="{{get_image($blog->photo?->photo)}}" alt="">
                </div>
                <div class="col-md-12">
                    <p class="fs-6 fw-bold text-secondary">{{$blog->created_by?->name ?? 'Author'}} | {{ \Carbon\Carbon::parse($blog->created_at)->format('d M, Y') }}</p>
                </div>
            </div>
            <div class="row mb-4 mt-2">
                <div class="col-12">
                    {!! $blog->content !!}
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Categories</h4>
                </div>
                <div class="col-12">
                    @foreach($blog->categories as $category)
                        <span class="badge text-bg-secondary ">{{$category->name}}</span>
                    @endforeach
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Tags</h4>
                </div>
                <div class="col-12">
                    @foreach(explode(',', $blog->tag) as $tag)
                        <span class="badge text-bg-primary">{{$tag}}</span>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h4>More Blogs</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="swiper mySwiper-blog">
                        <div class="swiper-wrapper">
                            @foreach($related_blogs as $blog)
                                <div class="swiper-slide">
                                    <div class="blog-card mb-2">
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
                </div>

            </div>
        </div>
    </div>
</div>
@endsection