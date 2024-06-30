<div class="card body-card pt-5">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <table class="table table-striped table-hover table-bordered">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{$seo?->id}}</td>
                        </tr>
                        <tr>
                            <th>Seo title</th>
                            <td>{{$seo?->title}}</td>
                        </tr>
                        <tr>
                            <th>Seo Description</th>
                            <td>{{$seo?->description}}</td>
                        </tr>
                        <tr>
                            <th>Seo keywords</th>
                            <td>{{$seo?->keywords}}</td>
                        </tr> 
                    </tbody>
                </table>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <img src="{{get_image($seo?->photo?->photo)}}" alt="image" class="img-thumbnail">
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <x-activity-log :logs="$seo->activity_logs" />
            </div>
        </div>

    </div>
</div>
