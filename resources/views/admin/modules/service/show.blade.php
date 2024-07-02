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
                                <td>{{$service->id}}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{$service->name}}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{$service->slug}}</td>
                            </tr>
                            @if($service->parent_id)
                            <tr>
                                <th>Parent Category</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <table class="table">
                                            <tr>
                                                <th>ID</th>
                                                <td>{{$service->parent?->id}}</td>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                                <td>{{$service->parent?->name}}</td>
                                            </tr>
                                        </table>
                                    </div>
    
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <th>Summary</th>
                                <td>{{$service->summary}}</td>
                            </tr>
                            <tr>
                                <th>Tools Used</th>
                                <td>
                                    @foreach(explode(',', $service->tool_used) as $tool)
                                        <span class="badge bg-primary">{{ trim($tool) }}</span>
                                    @endforeach
                                </td>
                            <tr>
                                <th>Photo</th>
                                <td class="d-flex justify-content-center">
                                    <a href="{{get_image($service->photo?->photo)}}">
                                        <img src="{{get_image($service->photo?->photo)}}" alt="{{$service->name}}"
                                        class="img-fluid shadow-sm rounded border" style="max-width: 100px;">
                                    </a>
                                    
                                </td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{!! $service->description !!}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($service->status == \App\Models\BlogCategory::STATUS_ACTIVE)
                                    <x-active :status="$service->status" />
                                    @else
                                    <x-inactive :status="$service->status" :title="'Inactive'" />
                                    {{\App\Models\BlogCategory::STATUS_LIST[$service->status] ?? null}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Featured</th>
                                <td>
                                    @if($service->is_featured == \App\Models\Service::IS_FEATURED)
                                    <x-active :status="$service->is_featured" /> Yes
                                    @else
                                    <x-inactive :status="$service->is_featured" :title="'Inactive'" /> No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Show on Home</th>
                                <td>
                                    @if($service->is_show_on_home == \App\Models\Service::IS_SHOW_ON_HOME)
                                    <x-active :status="$service->show_on_home" /> Yes
                                    @else
                                    <x-inactive :status="$service->show_on_home" :title="'Inactive'" /> No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Show on Menu</th>
                                <td>
                                    @if($service->is_show_on_menu == \App\Models\Service::IS_SHOW_ON_MENU)
                                    <x-active :status="$service->show_on_menu" /> Yes
                                    @else
                                    <x-inactive :status="$service->show_on_menu" :title="'Inactive'" /> No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>{{$service?->created_by?->name}}</td>
                            </tr>
                            <tr>
                                <th>Updated By</th>
                                <td>{{$service?->updated_by?->name}}</td>
                            </tr>
                            <tr>
                                <th>Created at</th>
                                <td>
                                    <x-created-at :created="$service->created_at" />
                                    <small class="text-success">{{$service->created_at->diffForHumans()}}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Updated at</th>
                                <td>
                                    <x-updated-at :created="$service->created_at" :updated="$service->updated_at" />
                                    <small class="text-success">{{$service->updated_at->diffForHumans()}}</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 mt-4">
                    <x-activity-log :logs="$service->activity_logs" />
                </div>
            </div>
        </div>
        <div class="tab-pane-custom d-none" id="nav-seo">
            @include('admin.modules.seo.partials.show')
        </div>
    </div>
</div>

@endsection