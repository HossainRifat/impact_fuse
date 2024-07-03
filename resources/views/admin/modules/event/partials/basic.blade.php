<div class="row align-items-center justify-content-center">
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{ html()->label(__('Event Title'))->for('title') }}
            <x-required />
            {{ html()->text('title')->class('make-slug meta-title form-control ' . ($errors->has('title') ? 'is-invalid' : ''))->placeholder(__('Enter Event Title') ) }}
            <x-validation-error :errors="$errors->first('title')" />
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{ html()->label(__('Slug'))->for('slug') }}
            <x-required />
            {{ html()->text('slug')->class('form-control ' . ($errors->has('slug') ? 'is-invalid' : ''))->placeholder(__('Enter Slug') ) }}
            <x-validation-error :errors="$errors->first('slug')" />
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{ html()->label(__('Category'))->for('categories') }}
            <x-required />
            {{ html()->select('categories[]', $categories, old('categories') ?? (isset($event) ? $event->categories->pluck('id') : null))->class('form-select select2 ' . ($errors->has('categories') ? 'is-invalid' : ''))->multiple() }}
            <x-validation-error :errors="$errors->first('categories')" />
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{ html()->label(__('Tag'))->for('tag') }}
            <x-required />
            {{ html()->text('tag')->class('meta-keywords ' . ($errors->has('tag') ? 'is-invalid' : ''))->placeholder(__('Enter Tag') ) }}
            <x-validation-error :errors="$errors->first('tag')" />
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
            {{ html()->label(__('Content'))->for('content') }}
            <x-required />
            {{ html()->textarea('content')->class('tinymce form-control ' . ($errors->has('content') ? 'is-invalid' : ''))->placeholder(__('Enter Content'))->rows(20) }}
            <x-validation-error :errors="$errors->first('content')" />
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{ html()->label(__('Start Date'))->for('start_date') }}
            <x-required/>
           {{ html()->datetime('start_date')->class('form-control ' . ($errors->has('start_date') ? 'is-invalid' : ''))->placeholder(__('Enter Start Date')) }}
            <x-validation-error :errors="$errors->first('start_date')" />
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{ html()->label(__('End Date'))->for('end_date') }}
            {{ html()->datetime('end_date')->class('form-control ' . ($errors->has('end_date') ? 'is-invalid' : ''))->placeholder(__('Enter End Date')) }}
            <x-validation-error :errors="$errors->first('end_date')" />
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{ html()->label(__('Video Url'))->for('video_url') }}
            {{ html()->text('video_url')->class('form-control ' . ($errors->has('video_url') ? 'is-invalid' : ''))->placeholder(__('Enter Youtube Video Url')) }}
            <x-validation-error :errors="$errors->first('video_url')" />
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="custom-form-group">
            {{ html()->label(__('Status'))->for('status') }}
            <x-required />
            {{ html()->select('status', $status, null)->class('form-select ' . ($errors->has('status') ? 'is-invalid' : '')) }}
            <x-validation-error :errors="$errors->first('status')" />
        </div>
    </div>
    <div class="col-md-3 mb-4 mt-4">
        <div class="custom-form-group">
            {{ html()->checkbox('is_featured')->class('form-check-input ' . ($errors->has('is_featured') ? 'is-invalid' : ''))->id('is_featured')}}
            {{ html()->label(__('Is Featured'))->for('is_featured') }}
            <x-validation-error :errors="$errors->first('is_featured')" />
        </div>
    </div>
    <div class="col-md-3 mb-4 mt-4">
        <div class="custom-form-group">
            {{ html()->checkbox('is_show_on_home')->class('form-check-input ' . ($errors->has('is_show_on_home') ? 'is-invalid' : ''))->id('is_show_on_home')}}
            {{ html()->label(__('Is Show on Home'))->for('is_show_on_home') }}
            <x-validation-error :errors="$errors->first('is_show_on_home')" />
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6">
        {{ html()->label(__('Photo'))->for('photo') }}
        <x-required />
        <div class="custom-form-group">
            <x-media-library
            :inputname="'photo'"
            :multiple="false"
            :displaycolumn="12"
            :uniqueid="1"
        />
            <x-validation-error :errors="$errors->first('photo')" />
        </div>
    
        @isset($event->photo->photo)
            <img src="{{ get_image($event?->photo?->photo) }}" alt="image" class="img-thumbnail">
        @endisset
    </div>
</div>