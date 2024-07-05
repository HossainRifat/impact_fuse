@extends('admin.layouts.app')
@section('content')
<div class="card body-card">
    <div class="card-body">
        @include('admin.modules.setting.partials.search')
        <table class="table table-striped table-hover">
            <thead>
                <tr class="table-primary">
                    <th class="text-center">{{ __('SL') }}</th>
                    <th>{{ __('Key') }}</th>
                    <th>{{ __('Value') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Date Time') }}
                        <x-tool-tip :title="'C = Created at, U = Updated at'" />
                    </th>
                    <th class="text-center">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($settings as $setting)
                <tr>
                    <td class="text-center">
                        <x-serial :serial="$loop->iteration" :collection="$settings" />
                    </td>
                    <td class="text-start">
                        <p class="fw-bold mb-0">{{ ucwords(str_replace('-', ' ', $setting->key)) }}</p>
                        <p class="fs-secondary">{{$setting->key}}</p>
                    </td>
                    <td>
                        {{Str::limit($setting->value, 80, '...')}}
                    </td>
                    <td class="text-center">
                        @if($setting->status == \App\Models\Setting::STATUS_ACTIVE)
                        <x-active :status="$setting->status" />
                        @else
                        <x-inactive :status="$setting->status" :title="'Inactive'" />
                        {{\App\Models\Setting::STATUS_LIST[$setting->status] ?? null}}
                        @endif
                    </td>
                    <td>
                        <x-date-time :created="$setting->created_at" :updated="$setting->updated_at" />
                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <x-view-button :route="route('setting.show', $setting->id)"/>
                            <x-edit-button :route="route('setting.edit', $setting->id)"/>
                            <x-delete-button :route="route('setting.destroy', $setting->id)"/>
                        </div>
                    </td>
                </tr>
                @empty
                <x-data-not-found :colspan="6" />
                @endforelse
            </tbody>
        </table>
        <x-pagination :collection="$settings" />
    </div>
</div>
@endsection