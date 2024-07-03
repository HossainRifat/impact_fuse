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
                <li class="nav-tab-item">
                    <a href="#nav-preview">
                        Preview Content
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
                                <td>{{$event->id}}</td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td>{{$event->title}}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{$event->slug}}</td>
                            </tr>
                            <tr>
                                <th>Categories</th>
                                <td>
                                    @foreach($event->categories as $category)
                                    <span class="badge bg-primary">{{$category->name}}</span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>Impression</th>
                                <td>{{$event->impression}}</td>
                            </tr>
                            <tr>
                                <th>Photo</th>
                                <td class="d-flex justify-content-center">
                                    <a href="{{\Illuminate\Support\Facades\Storage::url($event->photo?->photo)}}">
                                        <img src="{{\Illuminate\Support\Facades\Storage::url($event->photo?->photo)}}" alt="{{$event->name}}"
                                        class="img-fluid shadow-sm rounded border" style="max-width: 100px;">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Video</th>
                                <td class="text-center">
                                    <iframe class="border shadow rounded" width="560" height="315" src="{{$event->video_url}}" title="{{$event->name}}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($event->status == \App\Models\Event::STATUS_ACTIVE)
                                    <x-active :status="$event->status" />
                                    {{\App\Models\Event::STATUS_LIST[$event->status] ?? null}}
                                    @elseif($event->status == \App\Models\Event::STATUS_INACTIVE)
                                    <x-inactive :status="$event->status" :title="'Inactive'" />
                                    {{\App\Models\Event::STATUS_LIST[$event->status] ?? null}}
                                    @else
                                    <x-active :status="$event->status" :title="\App\Models\Event::STATUS_LIST[$event->status] ?? null" />
                                    {{\App\Models\Event::STATUS_LIST[$event->status] ?? null}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Featured</th>
                                <td>
                                    @if($event->is_featured == \App\Models\Event::IS_FEATURED)
                                    <x-active :status="$event->is_featured" />
                                        Yes
                                    @else
                                    <x-inactive :status="$event->is_featured" :title="'Inactive'" />
                                        No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Show on Home</th>
                                <td>
                                    @if($event->is_show_on_home == \App\Models\Event::IS_SHOW_ON_HOME)
                                    <x-active :status="$event->is_show_on_home" />
                                        Yes
                                    @else
                                    <x-inactive :status="$event->is_show_on_home" :title="'Inactive'" />
                                        No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Start Date</th>
                                <td>{{\Carbon\Carbon::parse($event->start_date)->format('d M, Y h:i A')}}</td>
                            </tr>
                            <tr>
                                <th>End Date</th>
                                <td>{{\Carbon\Carbon::parse($event->end_date)->format('d M, Y h:i A')}}</td>
                            </tr>
                            <tr>
                                <th>Tag</th>
                                @php $tags = explode(',', $event->tag); @endphp
                                <td>
                                    @foreach($tags as $tag)
                                    <span class="badge bg-primary">{{$tag}}</span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>Summary</th>
                                <td>{{$event->summary}}</td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>{{$event?->created_by?->name}}</td>
                            </tr>
                            <tr>
                                <th>Updated By</th>
                                <td>{{$event?->updated_by?->name}}</td>
                            </tr>
                            <tr>
                                <th>Created at</th>
                                <td>
                                    <x-created-at :created="$event->created_at" />
                                    <small class="text-success">{{$event->created_at->diffForHumans()}}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Updated at</th>
                                <td>
                                    <x-updated-at :created="$event->created_at" :updated="$event->updated_at" />
                                    <small class="text-success">{{$event->updated_at->diffForHumans()}}</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 mt-4">
                    <x-activity-log :logs="$event->activity_logs" />
                </div>
            </div>
        </div>
        <div class="tab-pane-custom d-none" id="nav-seo">
            @include('admin.modules.seo.partials.show')
        </div>
        <div class="tab-pane-custom d-none" id="nav-preview">
            <div class="row justify-content-center align-items-end">
                <div class="col-md-12 mt-4">
                    <div class="border p-4 m-2">
                        {!! $event->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection