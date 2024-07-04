<div class="row align-items-center justify-content-center">
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{ html()->label(__('Page Title'))->for('title') }}
            {{ html()->text('title')->class('make-slug meta-title form-control ' . ($errors->has('title') ? 'is-invalid' : ''))->placeholder(__('Enter Page Title') ) }}
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
            {{ html()->label(__('Content'))->for('content') }}
            <x-required />
            {{ html()->textarea('content')->class('tinymce form-control ' . ($errors->has('content') ? 'is-invalid' : ''))->placeholder(__('Enter Content'))->rows(20) }}
            <x-validation-error :errors="$errors->first('content')" />
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
            {{ html()->checkbox('is_show_on_header')->class('form-check-input ' . ($errors->has('is_show_on_header') ? 'is-invalid' : ''))->id('is_show_on_header')}}
            {{ html()->label(__('Is Show on Header'))->for('is_show_on_header') }}
            <x-validation-error :errors="$errors->first('is_show_on_header')" />
        </div>
    </div>
    <div class="col-md-3 mb-4 mt-4">
        <div class="custom-form-group">
            {{ html()->checkbox('is_show_on_footer')->class('form-check-input ' . ($errors->has('is_show_on_footer') ? 'is-invalid' : ''))->id('is_show_on_footer')}}
            {{ html()->label(__('Is Show on Footer'))->for('is_show_on_footer') }}
            <x-validation-error :errors="$errors->first('is_show_on_footer')" />
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="custom-form-group">
            <x-media-library
            :inputname="'photo'"
            :multiple="false"
            :displaycolumn="12"
            :uniqueid="1"
        />
            <x-validation-error :errors="$errors->first('photo')" />
        </div>
    
        @isset($page->photo->photo)
            <img src="{{ get_image($page?->photo?->photo) }}" alt="image" class="img-thumbnail">
        @endisset
    </div>
</div>