<div class="card body-card mb-5">
    <div class="card-body">
        <div class="row justify-content-center align-items-end">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-12 mb-4">
                    <div class="custom-form-group">
                        {{ html()->label(__('Page Title'))->for('title') }}
                        {{ html()->text('title')->class('form-control ' . ($errors->has('title') ? 'is-invalid' : ''))->placeholder(__('Enter Page Title') ) }}
                        <x-validation-error :errors="$errors->first('title')" />
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="custom-form-group">
                        {{ html()->label(__('Description'))->for('description') }}
                        {{ html()->textarea('description')->class('form-control ' . ($errors->has('description') ? 'is-invalid' : ''))->placeholder(__('Enter Content'))->rows(5) }}
                        <x-validation-error :errors="$errors->first('description')" />
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="custom-form-group">
                        {{ html()->label(__('Video Url'))->for('video_url') }}
                        {{ html()->text('video_url')->class('form-control ' . ($errors->has('video_url') ? 'is-invalid' : ''))->placeholder(__('Youtube Video Url') ) }}
                        <x-validation-error :errors="$errors->first('video_url')" />
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="custom-form-group">
                        {{ html()->label(__('Location'))->for('location') }}
                        <x-required />
                        {{ html()->select('location', $locations)->class('form-select ' . ($errors->has('location') ? 'is-invalid' : ''))->placeholder(__('Select Location') )}}
                        <x-validation-error :errors="$errors->first('location')" />
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="custom-form-group">
                        {{ html()->label(__('Type'))->for('type') }}
                        <x-required />
                        {{ html()->select('type', $types)->class('form-select ' . ($errors->has('type') ? 'is-invalid' : ''))->placeholder(__('Select Type') )}}
                        <x-validation-error :errors="$errors->first('type')" />
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="custom-form-group">
                        {{ html()->label(__('Status'))->for('status') }}
                        <x-required />
                        {{ html()->select('status', $status)->class('form-select ' . ($errors->has('status') ? 'is-invalid' : '')) }}
                        <x-validation-error :errors="$errors->first('status')" />
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="custom-form-group">
                        {{ html()->label(__('Display Order'))->for('display_order') }}
                        {{ html()->text('display_order')->class('form-control ' . ($errors->has('display_order') ? 'is-invalid' : ''))->placeholder(__('Display Order Higher Top') ) }}
                        <x-validation-error :errors="$errors->first('display_order')" />
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="custom-form-group">
                        {{ html()->label(__('Photo'))->for('photo') }}
                        <x-required />
                        <x-media-library
                        :inputname="'photo'"
                        :multiple="false"
                        :displaycolumn="12"
                        :uniqueid="1"
                    />
                        <x-validation-error :errors="$errors->first('photo')" />
                    </div>
                
                    @isset($banner->photo->photo)
                        <img src="{{ get_image($banner?->photo?->photo) }}" alt="image" class="img-thumbnail">
                    @endisset
                </div>
            </div>               
        </div>
    </div>
</div>