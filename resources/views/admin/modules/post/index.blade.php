@extends('admin.layouts.app')
@section('content')
    <div class="card body-card">
        <div class="card-body">
            @include('admin.modules.post.partials.search')
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="table-primary">
                        <th class="text-center">{{ __('SL') }}</th>
                        <th>{{ __('Image') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Facebook') }}</th>
                        <th>{{ __('Twitter') }}</th>
                        <th>{{ __('Linkedin') }}</th>
                        <th>{{ __('Instagram') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Post Time') }}</th>
                        <th>{{ __('Date Time') }}
                            <x-tool-tip :title="'C = Created at, U = Updated at'" />
                        </th>
                        <th class="text-center">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td class="text-center">
                                <x-serial :serial="$loop->iteration" :collection="$posts" />
                            </td>
                            <td>
                                @if($post->photo)
                                <div class="d-flex align-items-center">
                                    <img src="{{ get_image($post?->photo?->photo) }}" alt="image"
                                        class="img-thumbnail table-image" style="max-width: 60px;">
                                </div>
                                @endif
                            </td>
                            <td>{{ $post->title }}</td>
                            <td>{{ Str::limit($post->title, 80, '...') }}</td>
                            <td>
                                @if($post->is_facebook == \App\Models\Post::IS_FACEBOOK)
                                    <x-active :status="$post->is_facebook" />
                                @else
                                    <x-inactive :status="$post->is_facebook" :title="'Inactive'" />
                                @endif
                            </td>
                            <td>
                                @if($post->is_twitter == \App\Models\Post::IS_TWITTER)
                                    <x-active :status="$post->is_twitter" />
                                @else
                                    <x-inactive :status="$post->is_twitter" :title="'Inactive'" />
                                @endif
                            </td>
                            <td>
                                @if($post->is_linkedin == \App\Models\Post::IS_LINKEDIN)
                                    <x-active :status="$post->is_linkedin" />
                                @else
                                    <x-inactive :status="$post->is_linkedin" :title="'Inactive'" />
                                @endif
                            </td>
                            <td>
                                @if($post->is_instagram == \App\Models\Post::IS_INSTAGRAM)
                                    <x-active :status="$post->is_instagram" />
                                @else
                                    <x-inactive :status="$post->is_instagram" :title="'Inactive'" />
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($post->status == \App\Models\Post::STATUS_ACTIVE)
                                    <x-active :status="$post->status" />
                                @elseif($post->status == \App\Models\Post::STATUS_INACTIVE)
                                    <x-inactive :status="$post->status" :title="'Inactive'" />
                                @else
                                    <x-active :status="$post->status" :title="\App\Models\Post::STATUS_LIST[$post->status] ?? null" />
                                    {{ \App\Models\Post::STATUS_LIST[$post->status] ?? null }}
                                @endif
                            </td>
                            <td>{{ $post->post_time ? \Carbon\Carbon::parse($post->post_time)->format('d M y h:i A') : '' }}</td>
                            <td>
                                <x-date-time :created="$post->created_at" :updated="$post->updated_at" />
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <x-view-button :route="route('post.show', $post->id)"/>
                                    <x-delete-button :route="route('post.destroy', $post->id)"/>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-data-not-found :colspan="12" />
                    @endforelse
                </tbody>
            </table>
            <x-pagination :collection="$posts" />
        </div>
    </div>
@endsection
