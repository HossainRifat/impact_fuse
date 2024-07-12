@extends('layouts.app')
@push('head')
<link rel="stylesheet" href="{{asset('site_assets/css/contact-us.css')}}">
@endpush
@section('content')

<section class="ftco-section mt-5 pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="wrapper">
                    <div class="row no-gutters">
                        <div class="col-lg-8 col-md-7 order-md-last d-flex align-items-stretch">
                            <div class="contact-wrap w-100 p-md-5 p-4">
                                <h3 class="mb-4">{{$contact_data['contact-us-form-title'] ?? 'Get in touch'}}</h3>
                                <div id="form-message-warning" class="mb-4"></div>
                                <div id="form-message-success" class="mb-4">
                                    @isset($success)
                                    <p class="color-theme">{{ $success }}</p>
                                    @endif
                                </div>

                                <form method="POST" action="{{route('home.contact-us.store')}}" id="contactForm" name="contactForm" class="contactForm">
                                    @csrf
                                    <input type="hidden" name="route" value="{{ request()->url() }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label class="label" for="name">Full Name</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="Name" value="{{old('name')}}" required>
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label class="label" for="email">Email Address</label>
                                                <input type="email" class="form-control" name="email" id="email"
                                                    placeholder="Email" value="{{{old('email')}}}" required>
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <div class="form-group">
                                                <label class="label" for="subject">Subject</label>
                                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" value="{{old('subject')}}">
                                                @error('subject')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <div class="form-group">
                                                <label class="label" for="#">Message</label>
                                                <textarea name="message" class="form-control" id="message" cols="30" rows="4" placeholder="Message" value="{{old('message')}}" required></textarea>
                                                @error('message')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <div class="form-group">
                                                <input type="submit" value="Send Message" class="btn btn-primary">
                                                <div class="submitting"></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 d-flex align-items-stretch">
                            <div class="info-wrap bg-primary w-100 p-md-5 p-4">
                                <h3>{{$contact_data['contact-us-title'] ?? 'Let\'s get in touch'}}</h3>
                                <p class="mb-4">{{$contact_data['contact-us-subtitle'] ?? 'We\'re open for any suggestion or just to have a chat'}}</p>
                                <div class="dbox w-100 d-flex align-items-start gap-4">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-map-marker"></span>
                                    </div>
                                    <div class="text pl-3">
                                        <p><span>Address:</span> {{$contact_data['address'] ?? ''}}
                                        </p>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-center gap-4">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-phone"></span>
                                    </div>
                                    <div class="text pl-3">
                                        <p><span>Phone:</span> <a href="tel://{{$contact_data['phone'] ?? ''}}" class="text-decoration-none">{{$contact_data['phone'] ?? ''}}</a></p>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-center gap-4">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-paper-plane"></span>
                                    </div>
                                    <div class="text pl-3">
                                        <p><span>Email:</span> <a
                                                href="{{$contact_data['email'] ?? ''}}" class="text-decoration-none">{{$contact_data['email'] ?? ''}}</a></p>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-center gap-4">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-globe"></span>
                                    </div>
                                    <div class="text pl-3">
                                        <p><span>Website</span> <a href="{{$contact_data['website'] ?? '#'}}" class="text-decoration-none">{{$contact_data['website'] ?? ''}}</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection