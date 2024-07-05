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
                            <td>{{$post->id}}</td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td>{{$post->title}}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{$post->description}}</td>
                        </tr>
                        <tr>
                            <th>Photo</th>
                            <td class="d-flex justify-content-center">
                                <a href="{{\Illuminate\Support\Facades\Storage::url($post->photo?->photo)}}">
                                    <img src="{{\Illuminate\Support\Facades\Storage::url($post->photo?->photo)}}" alt="{{$post->name}}"
                                    class="img-fluid shadow-sm rounded border" style="max-width: 100px;">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Facebook</th>
                            <td>
                                @if($post->is_facebook == \App\Models\Post::IS_FACEBOOK)
                                <x-active :status="$post->is_facebook" />
                                @else
                                <x-inactive :status="$post->is_facebook" :title="'Inactive'" />
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Twitter</th>
                            <td>
                                @if($post->is_twitter == \App\Models\Post::IS_TWITTER)
                                <x-active :status="$post->is_twitter" />
                                @else
                                <x-inactive :status="$post->is_twitter" :title="'Inactive'" />
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Linkedin</th>
                            <td>
                                @if($post->is_linkedin == \App\Models\Post::IS_LINKEDIN)
                                <x-active :status="$post->is_linkedin" />
                                @else
                                <x-inactive :status="$post->is_linkedin" :title="'Inactive'" />
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Instagram</th>
                            <td>
                                @if($post->is_instagram == \App\Models\Post::IS_INSTAGRAM)
                                <x-active :status="$post->is_instagram" />
                                @else
                                <x-inactive :status="$post->is_instagram" :title="'Inactive'" />
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($post->status == \App\Models\Post::STATUS_ACTIVE)
                                <x-active :status="$post->status" />
                                {{\App\Models\Post::STATUS_LIST[$post->status] ?? null}}
                                @elseif($post->status == \App\Models\Post::STATUS_INACTIVE)
                                <x-inactive :status="$post->status" :title="'Inactive'" />
                                {{\App\Models\Post::STATUS_LIST[$post->status] ?? null}}
                                @else
                                <x-active :status="$post->status" :title="\App\Models\Post::STATUS_LIST[$post->status] ?? null" />
                                {{\App\Models\Post::STATUS_LIST[$post->status] ?? null}}
                                @endif
                            </td>
                        </tr>
                       
                        <tr>
                            <th>Created By</th>
                            <td>{{$post?->created_by?->name}}</td>
                        </tr>
                        <tr>
                            <th>Updated By</th>
                            <td>{{$post?->updated_by?->name}}</td>
                        </tr>
                        <tr>
                            <th>Created at</th>
                            <td>
                                <x-created-at :created="$post->created_at" />
                                <small class="text-success">{{$post->created_at->diffForHumans()}}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Updated at</th>
                            <td>
                                <x-updated-at :created="$post->created_at" :updated="$post->updated_at" />
                                <small class="text-success">{{$post->updated_at->diffForHumans()}}</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 mt-4">
                <x-activity-log :logs="$post->activity_logs" />
            </div>
        </div>
    </div>
</div>

@endsection