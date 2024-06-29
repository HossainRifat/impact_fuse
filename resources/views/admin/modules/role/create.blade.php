@extends('admin.layouts.app')
@section('content')
    <div class="card body-card pt-5">
        <div class="card-body">
            {{-- {!! Form::open(['route' => 'role.store', 'method' => 'post', 'id' => 'create_form']) !!} --}}
            {{ html()->form('POST', route('role.store'))->id('create_form')->open() }}
            <div class="row justify-content-center align-items-center mb-2">
                <div class="col-md-6">
                    @include('admin.modules.role.partials.form')
                </div>
            </div>
            <div class="row justify-content-center align-items-center mb-4">
                <div class="col-md-2">
                    <x-submit-button :type="'create'"/>
                </div>
            </div>

            {{-- {!! Form::close() !!} --}}
            {{ html()->form()->close() }}
        </div>
    </div>

@endsection
