@extends('admin.layouts.app')
@section('content')

<div class="card body-card mb-4">
    <div class="card-body">
        <div class="row justify-content-center align-items-end">
            <div class="col-md-12">
                <table class="table table-striped table-hover table-bordered">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{$setting->id}}</td>
                        </tr>
                        <tr>
                            <th>Key</th>
                            <td>
                                <p class="fw-bold mb-0">{{ ucwords(str_replace('-', ' ', $setting->key)) }}</p>
                                <p class="fs-secondary">{{$setting->key}}</p>
                            </td>
                        </tr>
                        <tr>
                            <th>Value</th>
                            <td>{{$setting->value}}</td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td>
                                @if($setting->type == \App\Models\Setting::TYPE_WEB_DECORATION)
                                <span class="badge bg-primary">
                                    {{\App\Models\Setting::TYPE_LIST[$setting->type] ?? null}}
                                </span>
                                @else
                                <span class="badge bg-danger">
                                    {{\App\Models\Setting::TYPE_LIST[$setting->type] ?? null}}
                                </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($setting->status == \App\Models\Setting::STATUS_ACTIVE)
                                <x-active :status="$setting->status" />
                                @else
                                <x-inactive :status="$setting->status" :title="'Inactive'" />
                                {{\App\Models\Setting::STATUS_LIST[$setting->status] ?? null}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created By</th>
                            <td>{{$setting?->created_by?->name}}</td>
                        </tr>
                        <tr>
                            <th>Updated By</th>
                            <td>{{$setting?->updated_by?->name}}</td>
                        </tr>
                        <tr>
                            <th>Created at</th>
                            <td>
                                <x-created-at :created="$setting->created_at" />
                                <small class="text-success">{{$setting->created_at->diffForHumans()}}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Updated at</th>
                            <td>
                                <x-updated-at :created="$setting->created_at" :updated="$setting->updated_at" />
                                <small class="text-success">{{$setting->updated_at->diffForHumans()}}</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 mt-4">
                <x-activity-log :logs="$setting->activity_logs" />
            </div>
        </div>
    </div>
</div>

@endsection