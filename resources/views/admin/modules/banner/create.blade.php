@extends('admin.layouts.app')
@section('content')
<div class="card body-card">
    <div class="card-body">
        {{ html()->form('post', route('banner.store'))->id('create_form')->open() }}
        <div class="row mb-2 justify-content-center align-items-end">
            <div class="col-md-12">
                @include('admin.modules.banner.partials.form')
            </div>
            <div class="col-md-3">
                <x-submit-button :type="'create'" />
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>
</div>

@endsection