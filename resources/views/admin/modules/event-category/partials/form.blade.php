<div class="card body-card mb-5">
    <div class="card-body">
        <div class="nav-tab mb-4">
            <ul>
                <li class="nav-tab-item active">
                    <a href="#nav-basic">
                        Basic information
                    </a>
                </li>
                <li class="nav-tab-item">
                    <a href="#nav-seo">
                        Meta information
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-pane-custom" id="nav-basic">
            <div class="row justify-content-center align-items-end">
                @include('admin.modules.event-category.partials.basic')
            </div>        
        </div>
        <div class="tab-pane-custom d-none" id="nav-seo">
            <div class="row justify-content-center align-items-end">
                @include('admin.modules.seo.partials.form')
            </div>
        </div>
    </div>
</div>