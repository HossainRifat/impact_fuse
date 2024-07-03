@extends('admin.layouts.app')
@section('content')
    <div class="card body-card">
        <div class="card-body">
            @include('admin.modules.event.partials.search')
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="table-primary">
                        <th class="text-center">{{ __('SL') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Slug') }}</th>
                        <th>{{ __('Impression') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Featured') }}</th>
                        <th>{{ __('Show on Home') }}</th>
                        <th>{{ __('Date Time') }}
                            <x-tool-tip :title="'C = Created at, U = Updated at'" />
                        </th>
                        <th class="text-center">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td class="text-center">
                                <x-serial :serial="$loop->iteration" :collection="$events" />
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ get_image($event?->photo?->photo) }}" alt="image"
                                        class="img-thumbnail table-image" style="max-width: 60px;">
                                    <span class="ms-2">{{ $event->title }}</span>
                                </div>
                            </td>
                            <td>{{ $event->slug }}</td>
                            <td class="text-center">{{ $event->impression }}</td>
                            <td class="text-center">
                                @if ($event->status == \App\Models\Event::STATUS_ACTIVE)
                                    <x-active :status="$event->status" />
                                @elseif($event->status == \App\Models\Event::STATUS_INACTIVE)
                                    <x-inactive :status="$event->status" :title="'Inactive'" />
                                    {{ \App\Models\Event::STATUS_LIST[$event->status] ?? null }}
                                @else
                                    <x-active :status="$event->status" :title="\App\Models\Event::STATUS_LIST[$event->status] ?? null" />
                                    {{ \App\Models\Event::STATUS_LIST[$event->status] ?? null }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($event->is_featured == \App\Models\Event::IS_FEATURED)
                                <x-active :status="$event->is_featured" />
                                @else
                                <x-inactive :status="$event->is_featured" :title="'Inactive'" />
                                @endif
                            </td>
                            <td class="text-center">
                                @if($event->is_show_on_home == \App\Models\Event::IS_SHOW_ON_HOME)
                                <x-active :status="$event->show_on_home" />
                                @else
                                <x-inactive :status="$event->show_on_home" :title="'Inactive'" />
                                @endif
                            </td>
                            <td>
                                <x-date-time :created="$event->created_at" :updated="$event->updated_at" />
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <x-view-button :route="route('event.show', $event->id)"/>
                                    <x-edit-button :route="route('event.edit', $event->id)"/>
                                    <x-delete-button :route="route('event.destroy', $event->id)"/>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-data-not-found :colspan="9" />
                    @endforelse
                </tbody>
            </table>
            <x-pagination :collection="$events" />
        </div>
    </div>
@endsection
