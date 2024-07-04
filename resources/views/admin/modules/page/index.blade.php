@extends('admin.layouts.app')
@section('content')
    <div class="card body-card">
        <div class="card-body">
            @include('admin.modules.page.partials.search')
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="table-primary">
                        <th class="text-center">{{ __('SL') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Slug') }}</th>
                        <th>{{ __('Impression') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Show on Header') }}</th>
                        <th>{{ __('Show on Footer') }}</th>
                        <th>{{ __('Date Time') }}
                            <x-tool-tip :title="'C = Created at, U = Updated at'" />
                        </th>
                        <th class="text-center">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                        <tr>
                            <td class="text-center">
                                <x-serial :serial="$loop->iteration" :collection="$pages" />
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ get_image($page?->photo?->photo) }}" alt="image"
                                        class="img-thumbnail table-image" style="max-width: 60px;">
                                    <span class="ms-2">{{ $page->title }}</span>
                                </div>
                            </td>
                            <td>{{ $page->slug }}</td>
                            <td class="text-center">{{ $page->impression }}</td>
                            <td class="text-center">
                                @if ($page->status == \App\Models\Page::STATUS_ACTIVE)
                                    <x-active :status="$page->status" />
                                @elseif($page->status == \App\Models\Page::STATUS_INACTIVE)
                                    <x-inactive :status="$page->status" :title="'Inactive'" />
                                    {{ \App\Models\Page::STATUS_LIST[$page->status] ?? null }}
                                @else
                                    <x-active :status="$page->status" :title="\App\Models\Page::STATUS_LIST[$page->status] ?? null" />
                                    {{ \App\Models\Page::STATUS_LIST[$page->status] ?? null }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($page->is_show_on_header == \App\Models\Page::IS_SHOW_ON_HEADER)
                                <x-active :status="$page->is_show_on_header" />
                                @else
                                <x-inactive :status="$page->is_show_on_header" :title="'Inactive'" />
                                @endif
                            </td>
                            <td class="text-center">
                                @if($page->is_show_on_footer == \App\Models\Page::IS_SHOW_ON_FOOTER)
                                <x-active :status="$page->is_show_on_footer" />
                                @else
                                <x-inactive :status="$page->is_show_on_footer" :title="'Inactive'" />
                                @endif
                            </td>
                            <td>
                                <x-date-time :created="$page->created_at" :updated="$page->updated_at" />
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <x-view-button :route="route('page.show', $page->id)"/>
                                    <x-edit-button :route="route('page.edit', $page->id)"/>
                                    <x-delete-button :route="route('page.destroy', $page->id)"/>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-data-not-found :colspan="9" />
                    @endforelse
                </tbody>
            </table>
            <x-pagination :collection="$pages" />
        </div>
    </div>
@endsection
