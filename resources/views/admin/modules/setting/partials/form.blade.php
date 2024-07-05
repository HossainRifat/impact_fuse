<div class="card body-card mb-5">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <div class="custom-form-group">
                    <label for="key">{{ __('Key') }}</label>
                    <x-required />
                    {{ html()->text('key')->class('form-control ' . ($errors->has('key') ? 'is-invalid' : ''))->placeholder('key') }}
                    <x-validation-error :errors="$errors->first('key')" />
                </div>
            </div>
            <div class="col-md-12 mb-4">
                <div class="custom-form-group">
                    <label for="value">{{ __('Value') }}</label>
                    <x-required />
                    {{ html()->textarea('value')->class('form-control ' . ($errors->has('value') ? 'is-invalid' : ''))->placeholder('Enter Category Description')->rows(10) }}
                    <x-validation-error :errors="$errors->first('value')" />
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="custom-form-group">
                    <label for="type">{{ __('Type') }}</label>
                    <x-required />
                    {{ html()->select('type', $types)->class('form-select ' . ($errors->has('type') ? 'is-invalid' : ''))->placeholder('Select Type')}}
                    <x-validation-error :errors="$errors->first('type')" />
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="custom-form-group">
                    <label for="status">{{ __('Status') }}</label>
                    <x-required />
                    {{ html()->select('status', $status)->class('form-select ' . ($errors->has('status') ? 'is-invalid' : ''))->placeholder('Select Status')}}
                    <x-validation-error :errors="$errors->first('status')" />
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        $('#key').on('change', function() {
            $(this).val(formatSlug($(this).val()));
        });
    });
</script>
@endpush