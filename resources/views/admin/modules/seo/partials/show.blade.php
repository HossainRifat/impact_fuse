<div class="row justify-content-center align-items-end">
    <div class="col-md-12">
        <table class="table table-striped table-hover table-bordered">
            <tbody>
                <tr>
                    <th>Meta Title</th>
                    <td>{{$seo?->title}}</td>
                </tr>
                <tr>
                    <th>Meta Description</th>
                    <td>{{$seo?->description}}</td>
                </tr>
                <tr>
                    <th>Meta Keywords</th>
                    <td>{{$seo?->keywords}}</td>
                </tr>
                <tr>
                    <th>Og Image</th>
                    <td class="d-flex justify-content-center">
                        <a href="{{get_image($seo?->photo?->photo)}}">
                            <img src="{{get_image($seo?->photo?->photo)}}" alt="{{$seo->title}}"
                            class="img-fluid shadow-sm rounded border" style="max-width: 100px;">
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>