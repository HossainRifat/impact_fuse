@extends('admin.layouts.app')
@section('content')
    <div class="card body-card pt-5">
        <div class="card-body">
            {{ html()->modelForm($user, 'PUT', route('user.update', $user->id))->id('create_form')->attribute('enctype', 'multipart/form-data')->open() }}
            {{html()->hidden('type', 'user')->id('type')->value(old('type') ?? request()->type)}}
            <div class="row justify-content-center align-items-end">
                <div class="col-md-12 mb-4">
                    @include('admin.modules.user.partials.form')
                </div>
                <div class="col-md-2">
                    <x-submit-button :type="'update'"/>
                </div>
            </div>
            {{html()->form()->close()}}
        </div>
    </div>

@endsection
