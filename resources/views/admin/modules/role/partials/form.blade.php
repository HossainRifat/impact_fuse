
 <div class="custom-form-group">
    <label for="name">{{__('Role Name')}}</label>
    {{ html()->text('name')->class('form-control form-control-sm '. ($errors->has('name') ? 'is-invalid' : ''))->placeholder('Enter role name')}}
   <x-validation-error :errors="$errors->first('name')"/>
</div>