@extends('admin.layouts.app')
@section('content')
    <div class="card body-card">
        <div class="card-body">
            @include('admin.modules.inquiry.partials.search')
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="table-primary">
                        <th class="text-center">{{ __('SL') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Message') }}</th>
                        <th>{{ __('IP') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Date Time') }}
                            <x-tool-tip :title="'C = Created at, U = Updated at'" />
                        </th>
                        <th class="text-center">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inquiry)
                        <tr>
                            <td class="text-center">
                                <x-serial :serial="$loop->iteration" :collection="$inquiries" />
                            </td>
                            <td>{{ $inquiry->name }}</td>
                            <td>{{ $inquiry->email }}</td>
                            <td>
                                @if($inquiry->subject)
                                <p class="fw-bold">{{$inquiry->subject}}</p>
                                @endif
                                <p class="{{$inquiry->subject ? 'text-secondary' : ''}}">{{Str::limit($inquiry->message, 80, '...')}}</p>
                            </td>
                            <td>{{ $inquiry->ip }}</td>
                            <td class="text-center">
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
                            <td>
                                <x-date-time :created="$inquiry->created_at" :updated="$inquiry->updated_at" />
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <x-view-button :route="route('inquiry.show', $inquiry->id)"/>
                                    <x-edit-button :route="route('inquiry.edit', $inquiry->id)"/>
                                    <x-delete-button :route="route('inquiry.destroy', $inquiry->id)"/>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-data-not-found :colspan="10" />
                    @endforelse
                </tbody>
            </table>
            <x-pagination :collection="$inquiries" />
        </div>
    </div>
@endsection
