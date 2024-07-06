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
                            <td>{{$inquiry->id}}</td>
                        </tr>
                        <tr>
                            <th>Full Name</th>
                            <td>{{$inquiry->name}}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{$inquiry->email}}</td>
                        </tr>
                        
                        <tr>
                            <th>Subject</th>
                            <td>{{$inquiry->subject}}</td>
                        </tr>
                        <tr>
                            <th>Message</th>
                            <td>{{$inquiry->message}}</td>
                        </tr>
                        <tr>
                            <th>IP Address</th>
                            <td>{{$inquiry->ip}}</td>
                        </tr>
                        <tr>
                            <th>Route</th>
                            <td>{{$inquiry->route}}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($inquiry->status == \App\Models\Inquiry::STATUS_ACTIVE)
                                    <x-active :status="$inquiry->status" />
                                @elseif($inquiry->status == \App\Models\Inquiry::STATUS_INACTIVE)
                                    <x-inactive :status="$inquiry->status" :title="'Inactive'" />
                                    {{ \App\Models\Inquiry::STATUS_LIST[$inquiry->status] ?? null }}
                                @elseif($inquiry->status == \App\Models\Inquiry::STATUS_NEW)
                                    <span class="badge bg-info">{{ \App\Models\Inquiry::STATUS_LIST[$inquiry->status] ?? null }}</span>
                                @elseif($inquiry->status == \App\Models\Inquiry::STATUS_SEEN)
                                    <span class="badge bg-success">{{ \App\Models\Inquiry::STATUS_LIST[$inquiry->status] ?? null }}</span>
                                @else
                                    <x-active :status="$inquiry->status" :title="\App\Models\Inquiry::STATUS_LIST[$inquiry->status] ?? null" />
                                    {{ \App\Models\Inquiry::STATUS_LIST[$inquiry->status] ?? null }}
                                @endif
                            </td>
                        </tr>
                       
                        <tr>
                            <th>Created By</th>
                            <td>{{$inquiry?->created_by?->name}}</td>
                        </tr>
                        <tr>
                            <th>Updated By</th>
                            <td>{{$inquiry?->updated_by?->name}}</td>
                        </tr>
                        <tr>
                            <th>Created at</th>
                            <td>
                                <x-created-at :created="$inquiry->created_at" />
                                <small class="text-success">{{$inquiry->created_at->diffForHumans()}}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Updated at</th>
                            <td>
                                <x-updated-at :created="$inquiry->created_at" :updated="$inquiry->updated_at" />
                                <small class="text-success">{{$inquiry->updated_at->diffForHumans()}}</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 mt-4">
                <x-activity-log :logs="$inquiry->activity_logs" />
            </div>
        </div>
    </div>
</div>

@endsection