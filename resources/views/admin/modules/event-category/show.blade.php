@extends('admin.layouts.app')
@section('content')

<div class="card body-card pt-5 mb-4">
    <div class="card-body">
        <div class="nav-tab mb-4">
            <ul>
                <li class="nav-tab-item active">
                    <a href="#nav-basic">
                        Basic information
                    </a>
                </li>
                <li class="nav-tab-item">
                    <a href="#nav-seo">
                        Meta information
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-pane-custom" id="nav-basic">
            <div class="row justify-content-center align-items-end">
                <div class="col-md-12">
                    <table class="table table-striped table-hover table-bordered">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{$event_category->id}}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{$event_category->name}}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{$event_category->slug}}</td>
                            </tr>
                            @if($event_category->parent_id)
                            <tr>
                                <th>Parent Category</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <table class="table">
                                            <tr>
                                                <th>ID</th>
                                                <td>{{$event_category->parent?->id}}</td>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                                <td>{{$event_category->parent?->name}}</td>
                                            </tr>
                                        </table>
                                    </div>
    
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <th>Photo</th>
                                <td class="d-flex justify-content-center">
                                    <a href="{{get_image($event_category->photo?->photo)}}">
                                        <img src="{{get_image($event_category->photo?->photo)}}" alt="{{$event_category->name}}"
                                        class="img-fluid shadow-sm rounded border" style="max-width: 100px;">
                                    </a>
                                    
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($event_category->status == \App\Models\EventCategory::STATUS_ACTIVE)
                                    <x-active :status="$event_category->status" />
                                    @else
                                    <x-inactive :status="$event_category->status" :title="'Inactive'" />
                                    {{\App\Models\EventCategory::STATUS_LIST[$event_category->status] ?? null}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{!! $event_category->description !!}</td>
                            </tr>
                            <tr>
                                <th>Meta Title</th>
                                <td>{{$event_category->seo?->title}}</td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>{{$event_category?->created_by?->name}}</td>
                            </tr>
                            <tr>
                                <th>Updated By</th>
                                <td>{{$event_category?->updated_by?->name}}</td>
                            </tr>
                            <tr>
                                <th>Created at</th>
                                <td>
                                    <x-created-at :created="$event_category->created_at" />
                                    <small class="text-success">{{$event_category->created_at->diffForHumans()}}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Updated at</th>
                                <td>
                                    <x-updated-at :created="$event_category->created_at" :updated="$event_category->updated_at" />
                                    <small class="text-success">{{$event_category->updated_at->diffForHumans()}}</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 mt-4">
                    <x-activity-log :logs="$event_category->activity_logs" />
                </div>
            </div>
        </div>
        <div class="tab-pane-custom d-none" id="nav-seo">
            @include('admin.modules.seo.partials.show')
        </div>
    </div>
</div>

@endsection