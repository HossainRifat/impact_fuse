@extends('admin.layouts.app')
@section('content')
    <div class="card body-card pt-5">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <table class="table table-striped table-hover table-bordered">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{$user->id}}</td>
                        </tr>
                        <tr>
                            <th>@lang('Name')</th>
                            <td>{{$user->name}}</td>
                        </tr>
                        <tr>
                            <th>@lang('Email')</th>
                            <td>{{$user->email}}</td>
                        </tr>
                        <tr>
                            <th>@lang('Phone')</th>
                            <td>{{$user->phone}}</td>
                        </tr>
                        <tr>
                            <th>@lang('Last Activity')</th>
                            <td>
                                @if($user->last_activity)
                                {!!  $user->last_activity ? '<span class="text-success">'. \Carbon\Carbon::parse($user->last_activity)->diffForHumans(). '</span>' : '<span class="text-danger">Never</span>'!!}
                                @else
                                    <span class="text-danger">No activity found</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('Status')</th>
                            <td>
                                @if($user->status == \App\Models\User::STATUS_ACTIVE)
                                    <x-active :status="$user->status"/>
                                @else
                                    <x-inactive :status="$user->status" :title="'Inactive'"/>
                                    {{\App\Models\Menu::STATUS_LIST[$user->status] ?? null}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('Created at')</th>
                            <td>
                                <x-created-at :created="$user->created_at"/>
                                <small class="text-success">{{$user->created_at->diffForHumans()}}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('Updated at')</th>
                            <td>
                                <x-updated-at :created="$user->created_at" :updated="$user->updated_at"/>
                                <small class="text-success">{{$user->updated_at->diffForHumans()}}</small>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 mt-4">
                    <x-activity-log :logs="$user->activity_logs"/>
                </div>
            </div>
        </div>
    </div>
@endsection
