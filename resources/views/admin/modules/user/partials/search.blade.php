{{html()->form('get',route('user.index'))->id('search_form')->open()}}
{{html()->hidden('per_page')->value($search['per_page'] ?? \App\Manager\Constants\GlobalConstant::DEFAULT_PAGINATION)}}
<div class="row justify-content-center mb-4 align-items-end">
    <div class="col-md-4 mb-4">
        {{html()->label(__('Enter name'), 'name')}}
        {{html()->text('name', $search['name'] ?? null)->class('form-control ')->placeholder(__('Ex. John Doe'))}}
    </div>
    <div class="col-md-4 mb-4">
        {{html()->label( __('Role'), 'role') }}
        {{html()->select('role',$roles, $search['role'] ?? null)->class('form-select ')->placeholder(__('Select role')) }}
    </div>
    <div class="col-md-4 mb-4">
        {{html()->label( __('Order by'), 'sort_order') }}
        {{html()->select('sort_order',$columns, $search['sort_order'] ?? null)->class('form-select ')->placeholder(__('Select order by')) }}
    </div>
    <div class="col-md-4 mb-4">
        {{html()->label( __('ASC/DESC'), 'order_by')}}
        {{html()->select('order_by',['asc' => __('ASC'), 'desc' => __('DESC')], $search['order_by'] ?? null)->placeholder(__('Select ASC/DESC'))->class('form-select ') }}
    </div>
    <div class="col-md-4 mb-4">
        <div class="row">
            <div class="col-md-6">
                <div class="d-grid">
                    <button id="reset_fields" class="btn  btn-warning " type="reset">
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
{{html()->form()->close()}}

