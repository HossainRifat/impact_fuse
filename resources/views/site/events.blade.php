@extends('layouts.app')

@section('content')
<div class="container-fluid page-overlay header-margin">
    <div class="container-fluid body-section">
        <div class="container my-5">
            <div class="row justify-content-center mb-4">
                <div class="col-12">
                    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner hero-banner">
                            <div class="carousel-item active">
                                <div class="blog-feature-card"
                                    style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                                    <div class="card-body">
                                        <h4 class="text-white">Featured</h4>
                                        <h2 class="text-white">Graphics and Ui design</h2>
                                        <p class="text-white">Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                            text ever since the 1500s, when an unknown printer took a galley of type
                                            and scrambled it to make a type specimen book. There are many variations
                                            of passages of Lorem Ipsum available, but the majority have suffered
                                            alteration in some form, by injected humour, or randomised words which
                                            don't look even slightly believable</p>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="blog-feature-card"
                                    style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                                    <div class="card-body">
                                        <h4 class="text-white">Featured</h4>
                                        <h2 class="text-white">Graphics and Ui design</h2>
                                        <p class="text-white">Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                            text ever since the 1500s, when an unknown printer took a galley of type
                                            and scrambled it to make a type specimen book. There are many variations
                                            of passages of Lorem Ipsum available, but the majority have suffered
                                            alteration in some form, by injected humour, or randomised words which
                                            don't look even slightly believable</p>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="blog-feature-card"
                                    style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                                    <div class="card-body">
                                        <h4 class="text-white">Featured</h4>
                                        <h2 class="text-white">Graphics and Ui design</h2>
                                        <p class="text-white">Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                            text ever since the 1500s, when an unknown printer took a galley of type
                                            and scrambled it to make a type specimen book. There are many variations
                                            of passages of Lorem Ipsum available, but the majority have suffered
                                            alteration in some form, by injected humour, or randomised words which
                                            don't look even slightly believable</p>
                                    </div>
                                </div>
                            </div>
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
                <div class="col-12 mb-4">
                    <div class="event-long-card d-sm-flex flex-row">
                        <div
                            class="event-date bg-theme d-flex flex-column justify-content-center align-items-center p-4">
                            <h1 class="text-white date">12</h1>
                            <h1 class="text-white month">JUN</h1>
                        </div>
                        <div class="event-image">
                            <img src="assets/hero_banner.jpeg" alt="event-image" class="img-fluid">
                        </div>
                        <div class="event-info">
                            <h2>Graphics and Ui design</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                Ipsum
                                has been the industry's standard dummy text ever since the 1500s, when an unknown
                                printer took a galley of type and scrambled it to make a type specimen book. There
                                are
                                many variations.</p>
                        </div>
                        <div class="event-share d-flex flex-column justify-content-center gap-2 align-items-center">
                            <i class="fa-brands fa-square-facebook"></i>
                            <i class="fa-brands fa-square-x-twitter"></i>
                            <i class="fa-brands fa-linkedin"></i>
                            <i class="fa-brands fa-square-instagram"></i>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="event-long-card d-sm-flex flex-row">
                        <div
                            class="event-date bg-theme d-flex flex-column justify-content-center align-items-center p-4">
                            <h1 class="text-white date">12</h1>
                            <h1 class="text-white month">JUN</h1>
                        </div>
                        <div class="event-image">
                            <img src="assets/hero_banner.jpeg" alt="event-image" class="img-fluid">
                        </div>
                        <div class="event-info">
                            <h2>Graphics and Ui design</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                Ipsum
                                has been the industry's standard dummy text ever since the 1500s, when an unknown
                                printer took a </p>
                        </div>
                        <div class="event-share d-flex flex-column justify-content-center gap-2 align-items-center">
                            <i class="fa-brands fa-square-facebook"></i>
                            <i class="fa-brands fa-square-x-twitter"></i>
                            <i class="fa-brands fa-linkedin"></i>
                            <i class="fa-brands fa-square-instagram"></i>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="event-long-card d-sm-flex flex-row">
                        <div
                            class="event-date bg-theme d-flex flex-column justify-content-center align-items-center p-4">
                            <h1 class="text-white date">12</h1>
                            <h1 class="text-white month">JUN</h1>
                        </div>
                        <div class="event-image">
                            <img src="assets/hero_banner.jpeg" alt="event-image" class="img-fluid">
                        </div>
                        <div class="event-info">
                            <h2>Graphics and Ui design</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                Ipsum
                                has been the industry's standard dummy text ever since the 1500s, when an unknown
                                printer took a galley of type and scrambled it to make a type specimen book. There
                                are
                                many variations.</p>
                        </div>
                        <div class="event-share d-flex flex-column justify-content-center gap-2 align-items-center">
                            <i class="fa-brands fa-square-facebook"></i>
                            <i class="fa-brands fa-square-x-twitter"></i>
                            <i class="fa-brands fa-linkedin"></i>
                            <i class="fa-brands fa-square-instagram"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-4 mb-2">
                    <h4>All Events</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="event-card"
                        style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                        <div class="card-body">
                            <p class="event-date">May 22, 2024</p>
                            <p class="event-title">Graphics and Ui design</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="event-card"
                        style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                        <div class="card-body">
                            <p class="event-date">May 22, 2024</p>
                            <p class="event-title">Graphics and Ui design</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="event-card"
                        style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                        <div class="card-body">
                            <p class="event-date">May 22, 2024</p>
                            <p class="event-title">Graphics and Ui design</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="event-card"
                        style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                        <div class="card-body">
                            <p class="event-date">May 22, 2024</p>
                            <p class="event-title">Graphics and Ui design</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="event-card"
                        style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                        <div class="card-body">
                            <p class="event-date">May 22, 2024</p>
                            <p class="event-title">Graphics and Ui design</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="event-card"
                        style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                        <div class="card-body">
                            <p class="event-date">May 22, 2024</p>
                            <p class="event-title">Graphics and Ui design</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="event-card"
                        style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                        <div class="card-body">
                            <p class="event-date">May 22, 2024</p>
                            <p class="event-title">Graphics and Ui design</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="event-card"
                        style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                        <div class="card-body">
                            <p class="event-date">May 22, 2024</p>
                            <p class="event-title">Graphics and Ui design</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="event-card"
                        style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                        <div class="card-body">
                            <p class="event-date">May 22, 2024</p>
                            <p class="event-title">Graphics and Ui design</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="event-card"
                        style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                        <div class="card-body">
                            <p class="event-date">May 22, 2024</p>
                            <p class="event-title">Graphics and Ui design</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="event-card"
                        style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                        <div class="card-body">
                            <p class="event-date">May 22, 2024</p>
                            <p class="event-title">Graphics and Ui design</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection