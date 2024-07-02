<div class="row">
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{html()->label('Meta Title', 'meta_title')}}
            {{html()->text('meta_title')->class('form-control '. ($errors->has('meta_title') ? 'is-invalid' : ''))->placeholder(__('Enter Meta Title'))->value(old('meta_title', isset($seo->title) ? $seo->title : ''))}}
            <x-validation-error :errors="$errors->first('meta_title')" />
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{html()->label('Meta Keywords', 'meta_keywords')}}
            {{html()->textarea('meta_keywords')->class('tom-select-seo'. ($errors->has('meta_keywords') ? 'is-invalid' : ''))->placeholder(__('Enter Meta Keywords'))->value(old('meta_keywords', isset($seo->keywords) ? $seo->keywords : ''))}}
            <x-validation-error :errors="$errors->first('meta_keywords')" />
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="custom-form-group">
            {{html()->label('Meta Description', 'meta_description')}}
            {{html()->textarea('meta_description')->class('form-control '. ($errors->has('meta_description') ? 'is-invalid' : ''))->placeholder(__('Enter Meta Description'))->value(old('meta_description', isset($seo->description) ? $seo->description : ''))}}  
            <x-validation-error :errors="$errors->first('meta_description')" />
        </div>
    </div>
</div>
<div class="row">
    <div class="row justify-content-center">
        <div class="col-md-6">
            {{html()->label('OG Image', 'og_image')}}
            <x-media-library
                :inputname="'og_image'"
                :multiple="false"
                :displaycolumn="12"
                :uniqueid="99"
            />
            @php
                $photo = isset($seo->photo->photo) ? \Illuminate\Support\Facades\Storage::url($seo->photo->photo) : null;
            @endphp
            @if($photo)
                <img src="{{url($photo)}}" alt="image" class="img-thumbnail">
            @endif
        </div>
    </div>
</div>


@push('scripts')
<script>
        const settings = {
        plugins: ['remove_button'],
        persist: false,
        createOnBlur: true,
        create: true,
        delete:true
    };
    let tom_select = new TomSelect(".tom-select", settings);
    let select_seo = new TomSelect(".tom-select-seo", settings);


    
    try{
        let select = new TomSelect(".meta-keywords", {
            ...settings,
            onItemAdd: function (value) {
                select_seo.createItem(value);
            },
            onItemRemove: function (value) {
                select_seo.removeItem(value);
            }
        });
    }catch(e){
    }

    $('.meta-title').on('keyup', function () {
        $('#meta_title').val($(this).val());
    });

    $('.meta-description').on('change', function () {
        $('#meta_description').val($(this).val());
    });
</script>
@endpush