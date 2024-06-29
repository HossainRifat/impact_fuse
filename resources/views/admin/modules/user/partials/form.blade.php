<div class="row justify-content-center">
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Name', 'name')}}
            <x-required/>
            {{html()->text('name', null)->class('form-control form-control-sm '. ($errors->has('name') ? 'is-invalid' : ''))->placeholder(__('Enter name'))}}
            <x-validation-error :errors="$errors->first('name')"/>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Email', 'email')}}
            <x-required/>
            {{html()->text('email', null)->class('form-control form-control-sm '. ($errors->has('email') ? 'is-invalid' : ''))->placeholder(__('Enter email'))}}
            <x-validation-error :errors="$errors->first('email')"/>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Phone', 'phone')}}
            <x-required/>
            {{html()->text('phone', null)->class('form-control form-control-sm '. ($errors->has('phone') ? 'is-invalid' : ''))->placeholder(__('Enter phone'))}}
            <x-validation-error :errors="$errors->first('phone')"/>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Password', 'password')}}
            <x-required/>
            <div class="input-group">
                {{html()->password('password', null)->class('form-control form-control-sm '. ($errors->has('password') ? 'is-invalid' : ''))->placeholder(__('Enter password'))->disabled(isset($user))}}
                <div class="input-group-text">
                    <i class="fa fa-eye"></i>
                </div>
            </div>
            <x-validation-error :errors="$errors->first('password')"/>
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{html()->label('Address', 'address')}}
            {{html()->textarea('address', null)->class('form-control '. ($errors->has('address') ? 'is-invalid' : ''))->placeholder(__('Enter Address'))->rows(5)}}
            <x-validation-error :errors="$errors->first('address')"/>
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{html()->label('Note', 'note')}}
            {{html()->textarea('note', null)->class('form-control '. ($errors->has('note') ? 'is-invalid' : ''))->placeholder(__('Lead\'s note'))->rows(10)}}
            <x-validation-error :errors="$errors->first('note')"/>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Status', 'status')}}
            <x-required/>
            {{html()->select('status', $status)->class('form-select form-select-sm'. ($errors->has('status') ? 'is-invalid' : ''))->placeholder(__('Select Menu Status'))}}
            <x-validation-error :errors="$errors->first('status')"/>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Role', 'role_id')}}
            <x-required/>
            <div class="row">
                @php
                    $roleIds = [];
                    if(isset($user->roles)){
                        $roleIds = $user->roles?->pluck('id')->toArray();
                    }elseif (old('role_id')) {
                        $roleIds = old('role_id');
                    }
                @endphp
                @foreach($roles as $key=>$value)
                    <div class="col-md-4">
                        <div class="form-check">
                            <input name="role_id[]" class="form-check-input" type="checkbox" value="{{$key}}" id="role_check_box_{{$key}}" {{in_array($key, $roleIds) ? 'checked' : ''}}>
                            <label class="form-check-label" for="role_check_box_{{$key}}">
                                {{$value}}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            <x-validation-error :errors="$errors->first('role_id')"/>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-4">
        <x-media-library
            :inputname="'photo'"
            :multiple="false"
            :displaycolumn="12"
            :uniqueid="1"
        />
        @php
            $photo = isset($user->profile_photo->photo) ? \Illuminate\Support\Facades\Storage::url($user->profile_photo->photo) : null;
        @endphp
        @if($photo)
            <img src="{{url($photo)}}" alt="image" class="img-thumbnail">
        @endif
    </div>
</div>

@push('scripts')
       <script>
            $('.input-group-text').on('click', function () {
                $(this).children('i').toggleClass('fa-eye-slash');
                let type = $(this).siblings('input').attr('type');
                if (type == 'password') {
                    $(this).siblings('input').attr('type', 'text');
                } else {
                    $(this).siblings('input').attr('type', 'password');
                }
            })
        </script>
@endpush
