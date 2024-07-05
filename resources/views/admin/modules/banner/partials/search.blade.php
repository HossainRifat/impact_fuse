
{{ html()->form('get', route('blog.index'))->id('search_form')->open() }}
{{ html()->hidden('per_page', $search['per_page'] ?? 10)}}
<div class="row justify-content-center mb-4 align-items-end">
    <div class="col-md-3 mb-4">
        {{ html()->text('title', $search['title'] ?? null)->class('form-control ')->placeholder(__('Enter Title')) }}
    </div>
    <div class="col-md-3 mb-4">
        {{ html()->select('status', $status, $search['status'] ?? null)->class('form-select ')->placeholder(__('Select Status')) }}
    </div>
    <div class="col-md-3 mb-4">
        {{ html()->select('type', $types, $search['type'] ?? null)->class('form-select ')->placeholder(__('Select Type')) }}
    </div>
    <div class="col-md-3 mb-4">
        {{ html()->select('location', $locations, $search['location'] ?? null)->class('form-select ')->placeholder(__('Select Location')) }}
    </div>
    <div class="col-md-3 mb-4">
        {{ html()->select('order_by_column', $columns, $search['order_by_column'] ?? null)->class('form-select ')->placeholder(__('Select Order By')) }}
    </div>
    <div class="col-md-3 mb-4">
        {{ html()->select('order_by', ['asc' => 'ASC', 'desc' => 'DESC'], $search['order_by'] ?? null)->class('form-select ')->placeholder(__('Select ASC/DESC')) }}
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

