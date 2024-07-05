<div class="card body-card mb-5">
    <div class="card-body">
        <div class="row justify-content-center align-items-end">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-12 mb-4">
                    <div class="custom-form-group">
                        {{ html()->label(__('Post Title'))->for('title') }}
                        {{ html()->text('title')->class('form-control ' . ($errors->has('title') ? 'is-invalid' : ''))->placeholder(__('Enter Page Title') ) }}
                        <x-validation-error :errors="$errors->first('title')" />
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="custom-form-group">
                        {{ html()->label(__('Description'))->for('description') }}
                        <x-required />
                        {{ html()->textarea('description')->class('form-control ' . ($errors->has('description') ? 'is-invalid' : ''))->placeholder(__('Enter Content'))->rows(5) }}
                        <x-validation-error :errors="$errors->first('description')" />
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-3 mb-4 mt-4">
                    <div class="custom-form-group">
                        {{ html()->checkbox('is_post_immediate')->class('form-check-input ' . ($errors->has('is_post_immediate') ? 'is-invalid' : ''))->id('is_post_immediate')->checked(true)}}
                        {{ html()->label(__('Post Immidiatly?'))->for('is_post_immediate') }}
                        <x-validation-error :errors="$errors->first('is_post_immediate')" />
                    </div>
                </div>
                <div class="col-md-9 mb-4" id="time-div" style="display: none">
                    <div class="custom-form-group">
                        {{ html()->label(__('Post Time'))->for('post_time') }}
                        {{ html()->dateTime('post_time')->class('form-control ' . ($errors->has('post_time') ? 'is-invalid' : ''))->placeholder(__('Enter Post Time') ) }}
                        <x-validation-error :errors="$errors->first('post_time')" />
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-3 mb-4 mt-4">
                    <div class="custom-form-group">
                        {{ html()->checkbox('is_facebook')->class('form-check-input ' . ($errors->has('is_facebook') ? 'is-invalid' : ''))->id('is_facebook')->checked(true)}}
                        {{ html()->label(__('Facebook'))->for('is_facebook') }}
                        <x-validation-error :errors="$errors->first('is_facebook')" />
                    </div>
                </div>
                <div class="col-md-3 mb-4 mt-4">
                    <div class="custom-form-group">
                        {{ html()->checkbox('is_twitter')->class('form-check-input ' . ($errors->has('is_twitter') ? 'is-invalid' : ''))->id('is_twitter')->checked(true)}}
                        {{ html()->label(__('Twitter'))->for('is_twitter') }}
                        <x-validation-error :errors="$errors->first('is_twitter')" />
                    </div>
                </div>
                <div class="col-md-3 mb-4 mt-4">
                    <div class="custom-form-group">
                        {{ html()->checkbox('is_linkedin')->class('form-check-input ' . ($errors->has('is_linkedin') ? 'is-invalid' : ''))->id('is_linkedin')->checked(true)}}
                        {{ html()->label(__('Linkedin'))->for('is_linkedin') }}
                        <x-validation-error :errors="$errors->first('is_linkedin')" />
                    </div>
                </div>
                <div class="col-md-3 mb-4 mt-4">
                    <div class="custom-form-group">
                        {{ html()->checkbox('is_instagram')->class('form-check-input ' . ($errors->has('is_instagram') ? 'is-invalid' : ''))->id('is_instagram')->checked(true)}}
                        {{ html()->label(__('Instagram'))->for('is_instagram') }}
                        <x-validation-error :errors="$errors->first('is_instagram')" />
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="custom-form-group">
                        {{ html()->label(__('Status'))->for('status') }}
                        <x-required />
                        {{ html()->select('status', $status)->class('form-select ' . ($errors->has('status') ? 'is-invalid' : ''))->placeholder(__('Select Status') )}}
                        <x-validation-error :errors="$errors->first('status')" />
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
                
                    @isset($banner->photo->photo)
                        <img src="{{ get_image($banner?->photo?->photo) }}" alt="image" class="img-thumbnail">
                    @endisset
                </div>
            </div>               
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#is_post_immediate').change(function () {
                if ($(this).is(':checked')) {
                    $('#time-div').hide();
                } else {
                    $('#time-div').show();
                }
            });
        });
    </script>
@endpush