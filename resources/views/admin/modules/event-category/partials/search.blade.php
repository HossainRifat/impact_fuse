

{{ html()->form('GET', route('event-category.index'))->id('search_form')->open() }}
{{ html()->hidden('per_page', $search['per_page'] ?? \App\Manager\Constants\GlobalConstant::DEFAULT_PAGINATION)}}
<div class="row justify-content-center mb-4 align-items-end">
    <div class="col-md-3 mb-4">
        {{html()->text('name', $search['name'] ?? null)->class('form-control ')->placeholder(trans('Ex. Category'))}}
    </div>
    <div class="col-md-3 mb-4">
        {{html()->select('status', $status, $search['status'] ?? null)->class('form-select')->placeholder(trans('Select Status'))}}
    </div>
    <div class="col-md-3 mb-4">
        {{ html()->select('order_by_column',$columns, $search['order_by_column'] ?? null)->class('form-select')->placeholder(trans('Sort Order By')) }}
    </div>
    <div class="col-md-3 mb-4">
        {{ html()->select('order_by',['asc' => trans('ASC'), 'desc' => trans('DESC')], $search['order_by'] ?? null)->placeholder(trans('Select ASC/DESC'))->class('form-select') }}
    </div>
    <div class="col-md-4 mb-4">
        <div class="row">
            <div class="col-md-6">
                <div class="d-grid">
                    <button id="reset_fields" class="btn  btn-warning" type="reset">
                        <i class="fa-solid fa-rotate"></i> @lang('Reset')
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-grid">
                    <button class="btn btn-success" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i> @lang('Search')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{ html()->form()->close() }}


