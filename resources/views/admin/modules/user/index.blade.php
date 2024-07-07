@extends('admin.layouts.app')
@section('content')
    <div class="card body-card">
        <div class="card-body">
            @include('admin.modules.user.partials.search')
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Date Time
                        <x-tool-tip :title="'C = Created at, U = Updated at'"/>
                    </th>
                    <th class="text-end">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="text-center">
                            <x-serial :serial="$loop->iteration" :collection="$users"/>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($user->profile_photo)
                                    <img src="{{ get_image($user->profile_photo->photo) }}" alt="" width="60" height="60" class="border rounded me-2">
                                @endif
                                <div class="d-flex flex-column justify-content-center gap-0">
                                    <p class="fw-bold mb-0">{{ $user->name }}</p>
                                    <p class="text-muted mb-0">{{ $user->designation }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{$user->phone}}
                        </td>
                        <td>
                            {{$user->email}}    
                        </td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary">{{$role->name}}</span>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @if($user->status == \App\Models\User::STATUS_ACTIVE)
                                <x-active :status="$user->status"/>
                            @else
                                <x-inactive :status="$user->status" :title="'Inactive'"/>
                                {{\App\Models\User::STATUS_LIST[$user->status] ?? null}}
                            @endif
                        </td>
                        <td>
                            <x-date-time :created="$user->created_at" :updated="$user->updated_at"/>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <x-view-button :route="route('user.show', $user->id)"/>
                                <x-edit-button :route="route('user.edit', $user->id)"/>
                                <x-delete-button :route="route('user.destroy', $user->id)"/>
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-data-not-found :colspan="7"/>
                @endforelse
                </tbody>
            </table>
            
            <x-pagination :collection="$users"/>
        </div>
    </div>
@endsection
