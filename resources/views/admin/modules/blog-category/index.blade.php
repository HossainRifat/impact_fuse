@extends('admin.layouts.app')
@section('content')
<div class="card body-card">
    <div class="card-body">
        @include('admin.modules.blog-category.partials.search')
        <table class="table table-striped table-hover">
            <thead>
                <tr class="table-primary">
                    <th class="text-center">{{ __('SL') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Slug') }}</th>
                    <th>{{ __('Status') }}</th>

                    <th>{{ __('Date Time') }}
                        <x-tool-tip :title="'C = Created at, U = Updated at'" />
                    </th>
                    <th class="text-center">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td class="text-center">
                        <x-serial :serial="$loop->iteration" :collection="$categories" />
                    </td>
                    <td>
                        <div class="d-flex align-items-start">
                            @if($category->photo)
                            <img src="{{get_image($category->photo?->photo)}}" alt=""
                                class="img-fluid shadow-sm rounded border" style="max-width: 60px;">
                            @endif
                            @if($category->parent)
                            <div>
                                <p class="ms-2 fw-bold mb-0"> {{$category->name}}</p>
                                <p class="ms-2 text-secondary">{{$category->parent?->name}}</p>
                            </div>
                            @else
                            <p class="ms-2 fw-bold">{{$category->name}}</p>
                            @endif
                        </div>
                    </td>
                    <td>{{$category->slug}}</td>
                    <td class="text-center">
                        @if($category->status == \App\Models\BlogCategory::STATUS_ACTIVE)
                        <x-active :status="$category->status" />
                        @else
                        <x-inactive :status="$category->status" :title="'Inactive'" />
                        {{\App\Models\BlogCategory::STATUS_LIST[$category->status] ?? null}}
                        @endif
                    </td>
                    <td>
                        <x-date-time :created="$category->created_at" :updated="$category->updated_at" />
                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <x-view-button :route="route('blog-category.show', $category->id)"/>
                            <x-edit-button :route="route('blog-category.edit', $category->id)"/>
                            <x-delete-button :route="route('blog-category.destroy', $category->id)"/>
                        </div>
                    </td>
                </tr>
                @empty
                <x-data-not-found :colspan="6" />
                @endforelse
            </tbody>
        </table>
        <x-pagination :collection="$categories" />
    </div>
</div>
@endsection