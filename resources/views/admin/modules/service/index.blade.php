@extends('admin.layouts.app')
@section('content')
<div class="card body-card">
    <div class="card-body">
        @include('admin.modules.service.partials.search')
        <table class="table table-striped table-hover">
            <thead>
                <tr class="table-primary">
                    <th class="text-center">{{ __('SL') }}</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th>Show on Home</th>
                    <th>Show on Menu</th>
                    <th>Date Time
                        <x-tool-tip :title="'C = Created at, U = Updated at'" />
                    </th>
                    <th class="text-center">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td class="text-center">
                        <x-serial :serial="$loop->iteration" :collection="$services" />
                    </td>
                    <td>
                        <div class="d-flex align-items-start">
                            @if($service->photo)
                            <img src="{{get_image($service->photo?->photo)}}" alt=""
                                class="img-fluid shadow-sm rounded border" style="max-width: 60px;">
                            @endif
                            @if($service->parent)
                            <div>
                                <p class="ms-2 fw-bold mb-0"> {{$service->name}}</p>
                                <p class="ms-2 text-secondary">{{$service->parent?->name}}</p>
                            </div>
                            @else
                            <p class="ms-2 fw-bold">{{$service->name}}</p>
                            @endif
                        </div>
                    </td>
                    <td>{{$service->slug}}</td>
                    <td class="text-center">
                        @if($service->status == \App\Models\Service::STATUS_ACTIVE)
                        <x-active :status="$service->status" />
                        @else
                        <x-inactive :status="$service->status" :title="'Inactive'" />
                        {{\App\Models\Service::STATUS_LIST[$service->status] ?? null}}
                        @endif
                    </td>
                    <td class="text-center">
                        @if($service->is_featured == \App\Models\Service::IS_FEATURED)
                        <x-active :status="$service->is_featured" />
                        @else
                        <x-inactive :status="$service->is_featured" :title="'Inactive'" />
                        @endif
                    </td>
                    <td class="text-center">
                        @if($service->is_show_on_home == \App\Models\Service::IS_SHOW_ON_HOME)
                        <x-active :status="$service->show_on_home" />
                        @else
                        <x-inactive :status="$service->show_on_home" :title="'Inactive'" />
                        @endif
                    </td>
                    <td class="text-center">
                        @if($service->is_show_on_menu == \App\Models\Service::IS_SHOW_ON_MENU)
                        <x-active :status="$service->show_on_menu" />
                        @else
                        <x-inactive :status="$service->show_on_menu" :title="'Inactive'" />
                        @endif
                    </td>
                    <td>
                        <x-date-time :created="$service->created_at" :updated="$service->updated_at" />
                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <x-view-button :route="route('service.show', $service->id)"/>
                            <x-edit-button :route="route('service.edit', $service->id)"/>
                            <x-delete-button :route="route('service.destroy', $service->id)"/>
                        </div>
                    </td>
                </tr>
                @empty
                <x-data-not-found :colspan="9" />
                @endforelse
            </tbody>
        </table>
        <x-pagination :collection="$services" />
    </div>
</div>
@endsection