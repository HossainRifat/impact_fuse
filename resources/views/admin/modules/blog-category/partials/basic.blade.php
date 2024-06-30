<div class="row justify-content-center">
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            <label for="name">{{ __('Category Name') }}</label>
            <x-required />
            {{ html()->text('name')->class('meta-title form-control ' . ($errors->has('name') ? 'is-invalid' : ''))->placeholder('Enter Category name') }}
            <x-validation-error :errors="$errors->first('name')" />
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            <label for="slug">{{ __('Category Slug') }}</label>
            <x-required />
            {{ html()->text('slug')->class('form-control ' . ($errors->has('slug') ? 'is-invalid' : ''))->placeholder('Enter Category slug') }}
            <x-validation-error :errors="$errors->first('slug')" />
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            <label for="description">{{ __('Category Description') }}</label>
            {{ html()->textarea('description')->class('tinymce form-control ' . ($errors->has('description') ? 'is-invalid' : ''))->placeholder('Enter Category Description')->rows(10) }}
            <x-validation-error :errors="$errors->first('description')" />
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            <label for="parent_id">{{ __('Parent ID') }}</label>
            {{ html()->select('parent_id', $categories, null)->class('form-select select2 ' . ($errors->has('parent_id') ? 'is-invalid' : ''))->placeholder('Select Parent Category') }}
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
            {{ html()->select('status', $status)->class('form-select ' . ($errors->has('status') ? 'is-invalid' : ''))}}
            <x-validation-error :errors="$errors->first('status')" />
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="custom-form-group">
            {{ html()->label('Category Photo')->for('photo') }}
            <x-media-library :inputname="'photo'" :multiple="false" :displaycolumn="12" :uniqueid="1" />
            <x-validation-error :errors="$errors->first('photo')" />
        </div>
        @isset($category?->photo?->photo)
        <img src="{{ get_image($category?->photo?->photo) }}" alt="image" class="img-thumbnail">
        @endisset
    </div>
</div>
