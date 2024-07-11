@extends('admin.layouts.app')
@section('content')
    <div class="card body-card pt-5">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <table class="table table-striped table-hover table-bordered">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{$user->id}}</td>
                        </tr>
                        <tr>
                            <th>@lang('Name')</th>
                            <td>{{$user->name}}</td>
                        </tr>
                        <tr>
                            <th>@lang('Email')</th>
                            <td>{{$user->email}}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{$user->phone}}</td>
                        </tr>
                        <tr>
                            <th>Emergency Contact</th>
                            <td>{{$user->emergency_contact ?? 'N/A'}}</td>
                        </tr>
                        <tr>
                            <th>Designation</th>
                            <td>{{$user->designation ?? 'N/A'}}</td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td>{{$user->department ?? 'N/A'}}</td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td>{{ \Carbon\Carbon::parse($user->start_date)->format('d M, Y') }}</td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td>{{ \Carbon\Carbon::parse($user->end_date)->format('d M, Y') }}</td>
                        </tr>
                        <tr>
                            <th>Responsibility</th>
                            @if($user->responsibility)
                                <td>
                                    @foreach(explode(',', $user->responsibility) as $responsibility)
                                        <span class="badge bg-primary">{{$responsibility}}</span>
                                    @endforeach
                                </td>
                            @else
                                <td>N/A</td>
                            @endif
                        </tr>
                        <tr>
                            <th>@lang('Profile Photo')</th>
                            <td>
                                @if($user->profile_photo)
                                    <a href="{{ get_image($user->profile_photo->photo) }}" target="_blank">
                                        <img src="{{ get_image($user->profile_photo->photo) }}" alt="profile photo" width="120" class="border rounded shadow">
                                    </a>
                                @else
                                    <span class="text-danger">No photo found</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>CV</th>
                            <td>
                                @if($user->cv)
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{$user->cv?->photo}}">
                                        <a href="{{route('show-file', ['file'=>$user->cv?->photo, 'action'=>'view'])}}" class="btn btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{route('show-file', ['file'=>$user->cv?->photo, 'action'=>'download'])}}" class="btn btn-success">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <form action="{{route('delete-file')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="media_gallery_id" value="{{$user->cv?->id}}">
                                            <button type="button" class="btn btn-danger delete_swal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-danger">N/A</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('Role')</th>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge bg-primary">{{$role->name}}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{$user->address ?? 'N/A'}}</td>
                        </tr>
                        <tr>
                            <th>Note</th>
                            <td>{{$user->note ?? 'N/A'}}</td>
                        </tr>
                        <tr>
                            <th>Sort Order</th>
                            <td>{{$user->sort_order ?? 'N/A'}}</td>
                        </tr>
                        <tr>
                            <th>@lang('Last Activity')</th>
                            <td>
                                @if($user->last_activity)
                                {!!  $user->last_activity ? '<span class="text-success">'. \Carbon\Carbon::parse($user->last_activity)->diffForHumans(). '</span>' : '<span class="text-danger">Never</span>'!!}
                                @else
                                    <span class="text-danger">No activity found</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('Status')</th>
                            <td>
                                @if($user->status == \App\Models\User::STATUS_ACTIVE)
                                    <x-active :status="$user->status"/>
                                @else
                                    <x-inactive :status="$user->status" :title="'Inactive'"/>
                                    {{\App\Models\Menu::STATUS_LIST[$user->status] ?? null}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('Created at')</th>
                            <td>
                                <x-created-at :created="$user->created_at"/>
                                <small class="text-success">{{$user->created_at->diffForHumans()}}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('Updated at')</th>
                            <td>
                                <x-updated-at :created="$user->created_at" :updated="$user->updated_at"/>
                                <small class="text-success">{{$user->updated_at->diffForHumans()}}</small>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 mt-4">
                    <x-activity-log :logs="$user->activity_logs"/>
                </div>
            </div>
        </div>
    </div>
@endsection
