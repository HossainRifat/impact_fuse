@extends('layouts.app')

@section('content')
<div class="container-fluid hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 px-5">
                <h1 class="text-center">
                    Small changes makes a Big Impact on People’s lives
                </h1>
                <p class="text-light">
                    Imagine a world where everyone understands the UN Sustainable Development Goals (SDGs) and
                    actively contributes to achieving them. That's the vision that drives ImpactFuse Coalition. We
                    build a global community that values diversity and inclusivity, fostering collaboration to
                    tackle pressing social, environmental, and economic issues. Through creative projects and
                    community engagement, we inspire and empower individuals and organizations to make a meaningful
                    impact.
                </p>
            </div>
            <div class="col-md-6">
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner hero-banner">
                        <div class="carousel-item active">
                            <img src="assets/hero_banner.jpeg" class="d-block w-100" alt="">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/hero_banner.jpeg" class="d-block w-100" alt="">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/hero_banner.jpeg" class="d-block w-100" alt="">
                        </div>
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
                        <img src="assets/logo.png" alt="">
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
                            <img src="assets/donation.jpeg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section custom-section">
            <h1 class="theme-sec-title mb-5">We are in a mission to help the helpless</h1>
            <div class="row">
                <div class="col-md-6">
                    <div class="theme-card-fixed">
                        <h2 class="text-center fw-bolder mb-4">Our mission</h2>
                        <p class="mission-vision">
                            Our objective is to promote awareness and encourage action towards achieving the United
                            Nations Sustainable Development Goals (SDGs). We strive to empower individuals and
                            organizations to make a meaningful impact towards advancing the SDGs through creative
                            projects and community engagement. By increasing awareness and advocating for the SDG
                            goals,
                            we aim to address environmental, social, and economic challenges worldwide, and create a
                            more equitable and sustainable future for all.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="theme-card-fixed">
                        <h2 class="text-center fw-bolder mb-4">Our vision</h2>
                        <p class="mission-vision">
                            Our vision at ImpactFuse Coalition is for a world where every individual is familiar
                            with the Sustainable Development Goals and is empowered to contribute towards achieving
                            them. We aspire to create a global community that promotes sustainable practices, values
                            diversity and inclusively, and collaborates to tackle pressing social, environmental,
                            and economic issues.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="section custom-section">
            <h1 class="theme-sec-title mb-4">Services</h1>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="theme-card-image">
                        <img src="assets/hero_banner.jpeg" alt="">
                        <div class="card-body">
                            <h4 class="text-center fw-bolder mb-4">Graphics and Ui design</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="theme-card-image">
                        <img src="assets/hero_banner.jpeg" alt="">
                        <div class="card-body">
                            <h4 class="text-center fw-bolder mb-4">Graphics and Ui design</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="theme-card-image">
                        <img src="assets/hero_banner.jpeg" alt="">
                        <div class="card-body">
                            <h4 class="text-center fw-bolder mb-4">Graphics and Ui design</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="theme-card-image">
                        <img src="assets/hero_banner.jpeg" alt="">
                        <div class="card-body">
                            <h4 class="text-center fw-bolder mb-4">Graphics and Ui design</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="theme-card-image">
                        <img src="assets/hero_banner.jpeg" alt="">
                        <div class="card-body">
                            <h4 class="text-center fw-bolder mb-4">Graphics and Ui design</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="theme-card-image">
                        <img src="assets/hero_banner.jpeg" alt="">
                        <div class="card-body">
                            <h4 class="text-center fw-bolder mb-4">Graphics and Ui design</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section custom-section">
            <h1 class="theme-sec-title mb-5">Our Contribution To Sustainable Development Goals</h1>
            <div class="row">
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_1.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_2.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_3.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_4.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_5.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_6.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_7.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_8.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_9.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_10.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_11.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_12.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_13.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_14.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_15.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_16.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_17.png" alt="">
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <div class="goal-card">
                        <img src="assets/goal_18.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="section custom-section">
            <h1 class="theme-sec-title mb-4">Blogs</h1>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="blog-card">
                        <img src="assets/hero_banner.jpeg" alt="">
                        <div class="card-body">
                            <h4 class="fw-bolder">Graphics and Ui design</h4>
                            <p class="blog-date">Angel Pria | May 22, 2024</p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua.
                            </p>
                            <a href="">Read More <i class="move-right fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="blog-card">
                        <img src="assets/hero_banner.jpeg" alt="">
                        <div class="card-body">
                            <h4 class="fw-bolder">Graphics and Ui design</h4>
                            <p class="blog-date">Angel Pria | May 22, 2024</p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua.
                            </p>
                            <a href="">Read More <i class="move-right fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="blog-card">
                        <img src="assets/hero_banner.jpeg" alt="">
                        <div class="card-body">
                            <h4 class="fw-bolder">Graphics and Ui design</h4>
                            <p class="blog-date">Angel Pria | May 22, 2024</p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua.
                            </p>
                            <a href="">Read More <i class="move-right fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section custom-section">
            <h1 class="theme-sec-title mb-4">Upcoming events</h1>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="event-card"
                            style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <p class="event-date">May 22, 2024</p>
                                <p class="event-title">Graphics and Ui design</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="event-card"
                            style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <p class="event-date">May 22, 2024</p>
                                <p class="event-title">Graphics and Ui design</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="event-card"
                            style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <p class="event-date">May 22, 2024</p>
                                <p class="event-title">Graphics and Ui design</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="event-card"
                            style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <p class="event-date">May 22, 2024</p>
                                <p class="event-title">Graphics and Ui design</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="event-card"
                            style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <p class="event-date">May 22, 2024</p>
                                <p class="event-title">Graphics and Ui design</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="event-card"
                            style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <p class="event-date">May 22, 2024</p>
                                <p class="event-title">Graphics and Ui design</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="event-card"
                            style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <p class="event-date">May 22, 2024</p>
                                <p class="event-title">Graphics and Ui design</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="event-card"
                            style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <p class="event-date">May 22, 2024</p>
                                <p class="event-title">Graphics and Ui design</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="event-card"
                            style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <p class="event-date">May 22, 2024</p>
                                <p class="event-title">Graphics and Ui design</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="event-card"
                            style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <p class="event-date">May 22, 2024</p>
                                <p class="event-title">Graphics and Ui design</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="event-card"
                            style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <p class="event-date">May 22, 2024</p>
                                <p class="event-title">Graphics and Ui design</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="event-card"
                            style="background-image: url('assets/hero_banner.jpeg'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <p class="event-date">May 22, 2024</p>
                                <p class="event-title">Graphics and Ui design</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>
@endsection