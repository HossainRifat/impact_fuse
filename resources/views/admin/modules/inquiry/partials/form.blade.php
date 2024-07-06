<div class="card body-card mb-5">
    <div class="card-body">
        <div class="row justify-content-center align-items-end">
            <div class="row align-items-center justify-content-center">
                {{ html()->hidden('route', request()->url()) }}
                <div class="col-md-6 mb-4">
                    <div class="custom-form-group">
                        {{ html()->label(__('Full Name'))->for('name') }}
                        <x-required />
                        {{ html()->text('name')->class('form-control ' . ($errors->has('name') ? 'is-invalid' : ''))->placeholder(__('Enter Name') ) }}
                        <x-validation-error :errors="$errors->first('name')" />
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="custom-form-group">
                        {{ html()->label(__('Email'))->for('email') }}
                        <x-required />
                        {{ html()->text('email')->class('form-control ' . ($errors->has('email') ? 'is-invalid' : ''))->placeholder(__('Enter Email') ) }}
                        <x-validation-error :errors="$errors->first('email')" />
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="custom-form-group">
                        {{ html()->label(__('Subject'))->for('subject') }}
                        {{ html()->text('subject')->class('form-control ' . ($errors->has('subject') ? 'is-invalid' : ''))->placeholder(__('Enter Subject') ) }}
                        <x-validation-error :errors="$errors->first('subject')" />
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="custom-form-group">
                        {{ html()->label(__('Message'))->for('message') }}
                        <x-required />
                        {{ html()->textarea('message')->class('form-control ' . ($errors->has('message') ? 'is-invalid' : ''))->placeholder(__('Enter Message') )->rows(5) }}
                        <x-validation-error :errors="$errors->first('message')" />
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
            </div>   
        </div>
    </div>
</div>