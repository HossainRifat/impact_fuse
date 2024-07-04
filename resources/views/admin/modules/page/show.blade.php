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
                                <td>{{$page->id}}</td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td>{{$page->title}}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{$page->slug}}</td>
                            </tr>
                            <tr>
                                <th>Impression</th>
                                <td>{{$page->impression}}</td>
                            </tr>
                            <tr>
                                <th>Photo</th>
                                <td class="d-flex justify-content-center">
                                    <a href="{{\Illuminate\Support\Facades\Storage::url($page->photo?->photo)}}">
                                        <img src="{{\Illuminate\Support\Facades\Storage::url($page->photo?->photo)}}" alt="{{$page->name}}"
                                        class="img-fluid shadow-sm rounded border" style="max-width: 100px;">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($page->status == \App\Models\Page::STATUS_ACTIVE)
                                    <x-active :status="$page->status" />
                                    {{\App\Models\Page::STATUS_LIST[$page->status] ?? null}}
                                    @elseif($page->status == \App\Models\Page::STATUS_INACTIVE)
                                    <x-inactive :status="$page->status" :title="'Inactive'" />
                                    {{\App\Models\Page::STATUS_LIST[$page->status] ?? null}}
                                    @else
                                    <x-active :status="$page->status" :title="\App\Models\Page::STATUS_LIST[$page->status] ?? null" />
                                    {{\App\Models\Page::STATUS_LIST[$page->status] ?? null}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Show on Header</th>
                                <td>
                                    @if($page->is_show_on_header == \App\Models\Page::IS_SHOW_ON_HEADER)
                                        <x-active :status="$page->is_show_on_header" /> Yes
                                    @else
                                        <x-inactive :status="$page->is_show_on_header" :title="'Inactive'" /> No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Show on Footer</th>
                                <td>
                                    @if($page->is_show_on_footer == \App\Models\Page::IS_SHOW_ON_FOOTER)
                                        <x-active :status="$page->is_show_on_footer" /> Yes
                                    @else
                                        <x-inactive :status="$page->is_show_on_footer" :title="'Inactive'" /> No
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>{{$page?->created_by?->name}}</td>
                            </tr>
                            <tr>
                                <th>Updated By</th>
                                <td>{{$page?->updated_by?->name}}</td>
                            </tr>
                            <tr>
                                <th>Created at</th>
                                <td>
                                    <x-created-at :created="$page->created_at" />
                                    <small class="text-success">{{$page->created_at->diffForHumans()}}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Updated at</th>
                                <td>
                                    <x-updated-at :created="$page->created_at" :updated="$page->updated_at" />
                                    <small class="text-success">{{$page->updated_at->diffForHumans()}}</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 mt-4">
                    <x-activity-log :logs="$page->activity_logs" />
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
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection