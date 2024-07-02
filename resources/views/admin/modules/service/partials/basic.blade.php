<div class="row justify-content-center">
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            <label for="name">{{ __('Name') }}</label>
            <x-required />
            {{ html()->text('name')->class('meta-title form-control ' . ($errors->has('name') ? 'is-invalid' : ''))->placeholder('Enter Service Name') }}
            <x-validation-error :errors="$errors->first('name')" />
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            <label for="slug">{{ __('Slug') }}</label>
            <x-required />
            {{ html()->text('slug')->class('form-control ' . ($errors->has('slug') ? 'is-invalid' : ''))->placeholder('Enter Slug') }}
            <x-validation-error :errors="$errors->first('slug')" />
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{ html()->label(__('Tools Used'))->for('tool_used') }}
            <x-required />
            {{ html()->text('tool_used')->class('tom-select ' . ($errors->has('tool_used') ? 'is-invalid' : ''))->placeholder(__('Enter Tools Used') ) }}
            <x-validation-error :errors="$errors->first('tool_used')" />
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{ html()->label(__('Summary'))->for('summary') }}
            <x-required />
            {{ html()->textarea('summary')->class('meta-description form-control ' . ($errors->has('summary') ? 'is-invalid' : ''))->placeholder(__('Enter Summary'))->rows(4) }}
            <x-validation-error :errors="$errors->first('summary')" />
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            <label for="description">{{ __('Description') }}</label>
            <x-required />
            {{ html()->textarea('description')->class('tinymce form-control ' . ($errors->has('description') ? 'is-invalid' : ''))->placeholder('Enter Description')->rows(20) }}
            <x-validation-error :errors="$errors->first('description')" />
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            <label for="parent_id">{{ __('Parent ID') }}</label>
            {{ html()->select('parent_id', $services, null)->class('form-select select2 ' . ($errors->has('parent_id') ? 'is-invalid' : ''))->placeholder('Select Parent Service') }}
            <x-validation-error :errors="$errors->first('parent_id')" />
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            <label for="display_order">{{ __('Display Order') }}</label>
            {{ html()->text('display_order')->class('form-control ' . ($errors->has('display_order') ? 'is-invalid' : ''))->placeholder('Enter display order') }}
            <x-validation-error :errors="$errors->first('display_order')" />
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            <label for="status">{{ __('Status') }}</label>
            <x-required />
            {{ html()->select('status', $status)->class('form-select ' . ($errors->has('status') ? 'is-invalid' : ''))}}
            <x-validation-error :errors="$errors->first('status')" />
        </div>
    </div>
    <div class="col-md-2 mb-4 mt-4">
        <div class="custom-form-group">
            {{ html()->checkbox('is_featured')->class('form-check-input ' . ($errors->has('is_featured') ? 'is-invalid' : ''))->id('is_featured')}}
            {{ html()->label(__('Is Featured'))->for('is_featured') }}
            <x-validation-error :errors="$errors->first('is_featured')" />
        </div>
    </div>
    <div class="col-md-2 mb-4 mt-4">
        <div class="custom-form-group">
            {{ html()->checkbox('is_show_on_home')->class('form-check-input ' . ($errors->has('is_show_on_home') ? 'is-invalid' : ''))->id('is_show_on_home')}}
            {{ html()->label(__('Show on Home'))->for('is_show_on_home') }}
            <x-validation-error :errors="$errors->first('is_show_on_home')" />
        </div>
    </div>
    <div class="col-md-2 mb-4 mt-4">
        <div class="custom-form-group">
            {{ html()->checkbox('is_show_on_menu')->class('form-check-input ' . ($errors->has('is_show_on_menu') ? 'is-invalid' : ''))->id('is_show_on_menu')}}
            {{ html()->label(__('Show on Menu'))->for('is_show_on_menu') }}
            <x-validation-error :errors="$errors->first('is_show_on_menu')" />
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="custom-form-group">
            {{ html()->label('Service Photo')->for('photo') }}
            <x-media-library :inputname="'photo'" :multiple="false" :displaycolumn="12" :uniqueid="1" />
            <x-validation-error :errors="$errors->first('photo')" />
        </div>
        @isset($service?->photo?->photo)
        <img src="{{ get_image($service?->photo?->photo) }}" alt="image" class="img-thumbnail">
        @endisset
    </div>
</div>
