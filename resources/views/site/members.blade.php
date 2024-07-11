@extends('layouts.app')

@section('content')
<div class="container-fluid page-overlay">
    <div class="container-fluid body-section">
        <div class="container my-5">
            <div class="row justify-content-center mb-5">
                <div class="col-12 my-4">
                    <h1 class="theme-sec-title">Face Behind the Movement</h1>
                </div>
                <div class="col-12">
                    <p class="text-justify text-center font-size-nav">{{$site_data['member-page']}}</p>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                @foreach($members as $member)
                <div class="col-12 col-lg-6 col-xl-4 mb-4">
                    <div class="member-card">
                        <img src="{{get_image($member->photo?->photo)}}" alt="">
                        <h3 class="my-2">{{$member->name}}</h3>
                        <p class="fw-bold mb-0">{{$member->designation}}</p>
                        <p class="text-secondary">{{ \Carbon\Carbon::parse($member->start_date)->format('d M, Y') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection