@extends('admin.layouts.app')
@section('content')
    <div class="card body-card">
        <div class="card-body">
            @include('admin.modules.banner.partials.search')
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="table-primary">
                        <th class="text-center">{{ __('SL') }}</th>
                        <th>{{ __('Image') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Location') }}</th>
                        <th>{{ __('Sort Order') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Date Time') }}
                            <x-tool-tip :title="'C = Created at, U = Updated at'" />
                        </th>
                        <th class="text-center">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                        <tr>
                            <td class="text-center">
                                <x-serial :serial="$loop->iteration" :collection="$banners" />
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ get_image($banner?->photo?->photo) }}" alt="image"
                                        class="img-thumbnail table-image" style="max-width: 60px;">
                                </div>
                            </td>
                            <td>{{ $banner->title }}</td>
                            <td>{{ $locations[$banner->location] }}</td>
                            <td>{{ $banner->sort_order }}</td>
                            <td>{{ $types[$banner->type] }}</td>
                            <td class="text-center">
                                @if ($banner->status == \App\Models\Banner::STATUS_ACTIVE)
                                    <x-active :status="$banner->status" />
                                @elseif($banner->status == \App\Models\Banner::STATUS_INACTIVE)
                                    <x-inactive :status="$banner->status" :title="'Inactive'" />
                                    {{ \App\Models\Banner::STATUS_LIST[$banner->status] ?? null }}
                                @else
                                    <x-active :status="$banner->status" :title="\App\Models\Banner::STATUS_LIST[$banner->status] ?? null" />
                                    {{ \App\Models\Banner::STATUS_LIST[$banner->status] ?? null }}
                                @endif
                            </td>
                            <td>
                                <x-date-time :created="$banner->created_at" :updated="$banner->updated_at" />
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <x-view-button :route="route('banner.show', $banner->id)"/>
                                    <x-edit-button :route="route('banner.edit', $banner->id)"/>
                                    <x-delete-button :route="route('banner.destroy', $banner->id)"/>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-data-not-found :colspan="9" />
                    @endforelse
                </tbody>
            </table>
            <x-pagination :collection="$banners" />
        </div>
    </div>
@endsection
