<div class="row justify-content-center">
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Name', 'name')}}
            <x-required/>
            {{html()->text('name', null)->class('form-control '. ($errors->has('name') ? 'is-invalid' : ''))->placeholder(__('Enter name'))}}
            <x-validation-error :errors="$errors->first('name')"/>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Email', 'email')}}
            <x-required/>
            {{html()->text('email', null)->class('form-control '. ($errors->has('email') ? 'is-invalid' : ''))->placeholder(__('Enter email'))}}
            <x-validation-error :errors="$errors->first('email')"/>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Phone', 'phone')}}
            <x-required/>
            {{html()->text('phone', null)->class('form-control '. ($errors->has('phone') ? 'is-invalid' : ''))->placeholder(__('Enter phone'))}}
            <x-validation-error :errors="$errors->first('phone')"/>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Password', 'password')}}
            <x-required/>
            <div class="input-group">
                {{html()->password('password', null)->class('form-control '. ($errors->has('password') ? 'is-invalid' : ''))->placeholder(__('Enter password'))->disabled(isset($user))}}
                <div class="input-group-text">
                    <i class="fa fa-eye"></i>
                </div>
            </div>
            <x-validation-error :errors="$errors->first('password')"/>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Designation', 'designation')}}
            {{html()->text('designation')->class('form-control '. ($errors->has('	designation') ? 'is-invalid' : ''))->placeholder(__('Enter Designation'))}}
            <x-validation-error :errors="$errors->first('designation')"/>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Emergency Contact', 'emergency_contact')}}
            {{html()->text('emergency_contact')->class('form-control '. ($errors->has('	emergency_contact') ? 'is-invalid' : ''))->placeholder(__('Enter Emergency Contact'))}}
            <x-validation-error :errors="$errors->first('emergency_contact')"/>
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{html()->label('Department', 'department')}}
            {{html()->text('department', null)->class('form-control '. ($errors->has('department') ? 'is-invalid' : ''))->placeholder(__('Enter Department'))}}
            <x-validation-error :errors="$errors->first('department')"/>
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{html()->label('Responsibility', 'responsibility')}}
            {{html()->text('responsibility', null)->class('tom-select '. ($errors->has('responsibility') ? 'is-invalid' : ''))->placeholder(__('Enter Responsibility'))}}
            <x-validation-error :errors="$errors->first('responsibility')"/>
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
            {{html()->label('Start Date', 'start_date')}}
            {{html()->date('start_date')->class('form-control '. ($errors->has('start_date') ? 'is-invalid' : ''))->placeholder(__('Enter Joining Date'))}}
            <x-validation-error :errors="$errors->first('start_date')"/>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('End Date', 'end_date')}}
            {{html()->date('end_date')->class('form-control '. ($errors->has('end_date') ? 'is-invalid' : ''))->placeholder(__('Enter Retirement Date'))}}
            <x-validation-error :errors="$errors->first('end_date')"/>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Date of Birth', 'date_of_birth')}}
            {{html()->date('date_of_birth')->class('form-control '. ($errors->has('date_of_birth') ? 'is-invalid' : ''))->placeholder(__('Enter Date of Birth'))}}
            <x-validation-error :errors="$errors->first('date_of_birth')"/>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Sort Order', 'sort_order')}}
            {{html()->number('sort_order')->class('form-control '. ($errors->has('sort_order') ? 'is-invalid' : ''))->placeholder(__('Higer Number will be shown first'))}}
            <x-validation-error :errors="$errors->first('sort_order')"/>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('Status', 'status')}}
            <x-required/>
            {{html()->select('status', $status)->class('form-select '. ($errors->has('status') ? 'is-invalid' : ''))->placeholder(__('Select Menu Status'))}}
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
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{html()->label('CV', 'cv')}}
            <x-required/>
            {{html()->file('cv')->class('form-control '. ($errors->has('cv') ? 'is-invalid' : ''))}}
            <x-validation-error :errors="$errors->first('cv')"/>
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

        const settings = {
            plugins: ['remove_button'],
            persist: false,
            createOnBlur: true,
            create: true,
            delete:true
        };
        let tom_select = null;
        try{
            tom_select = new TomSelect(".tom-select", settings);
        }catch(e){
        }
    </script>
@endpush
