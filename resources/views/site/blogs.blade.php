@extends('layouts.app')

@section('content')
<div class="container-fluid page-overlay header-margin">
    <div class="container-fluid body-section">
        <div class="container my-5">
            <div class="row justify-content-center mb-5">
                <div class="col-12">
                    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner hero-banner">
                            @foreach($featured_blogs as $index => $blog)
                                <div class="carousel-item active">
                                    <div class="blog-feature-card"
                                        style="background-image: url('{{get_image($blog->photo?->photo)}}'); background-size: cover; background-position: center;">
                                        <div class="card-body">
                                            <h4 class="text-white">Featured</h4>
                                            <h2 class="text-white">{{$blog->title}}</h2>
                                            <p class="text-white">{{$blog->summary}}</p>
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
                    <h4>More Blogs</h4>
                </div>
            </div>
            <div class="row">
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
            <div class="row justify-content-end">
                <div class="col-12">
                    {!!$blogs->links('admin.global-partials.bootstrap-5')!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection