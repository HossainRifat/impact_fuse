@extends('admin.layouts.app')
@section('content')

<div class="card body-card pt-5 mb-4">
    <div class="card-body">
        <div class="row justify-content-center align-items-end">
            <div class="col-md-12">
                <table class="table table-striped table-hover table-bordered">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{$banner->id}}</td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td>{{$banner->title}}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{$banner->description}}</td>
                        </tr>
                        <tr>
                            <th>Photo</th>
                            <td class="d-flex justify-content-center">
                                <a href="{{\Illuminate\Support\Facades\Storage::url($banner->photo?->photo)}}">
                                    <img src="{{\Illuminate\Support\Facades\Storage::url($banner->photo?->photo)}}" alt="{{$banner->name}}"
                                    class="img-fluid shadow-sm rounded border" style="max-width: 100px;">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Video</th>
                            <td class="text-center">
                                <iframe class="border shadow rounded" width="560" height="315" src="{{$banner->video_url}}" title="{{$banner->name}}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                            </td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td>{{$locations[$banner->location]}}</td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td>{{$types[$banner->type]}}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($banner->status == \App\Models\Banner::STATUS_ACTIVE)
                                <x-active :status="$banner->status" />
                                {{\App\Models\Banner::STATUS_LIST[$banner->status] ?? null}}
                                @elseif($banner->status == \App\Models\Banner::STATUS_INACTIVE)
                                <x-inactive :status="$banner->status" :title="'Inactive'" />
                                {{\App\Models\Banner::STATUS_LIST[$banner->status] ?? null}}
                                @else
                                <x-active :status="$banner->status" :title="\App\Models\Banner::STATUS_LIST[$banner->status] ?? null" />
                                {{\App\Models\Banner::STATUS_LIST[$banner->status] ?? null}}
                                @endif
                            </td>
                        </tr>
                       
                        <tr>
                            <th>Created By</th>
                            <td>{{$banner?->created_by?->name}}</td>
                        </tr>
                        <tr>
                            <th>Updated By</th>
                            <td>{{$banner?->updated_by?->name}}</td>
                        </tr>
                        <tr>
                            <th>Created at</th>
                            <td>
                                <x-created-at :created="$banner->created_at" />
                                <small class="text-success">{{$banner->created_at->diffForHumans()}}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Updated at</th>
                            <td>
                                <x-updated-at :created="$banner->created_at" :updated="$banner->updated_at" />
                                <small class="text-success">{{$banner->updated_at->diffForHumans()}}</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 mt-4">
                <x-activity-log :logs="$banner->activity_logs" />
            </div>
        </div>
    </div>
</div>

@endsection