<div class="row" data-scroll-index="5" style="margin-top: 5%;">
    <div class="col-md-12">
        <div class="">
            <div>
                
                <div id="providers" class="owl-carousel owl-theme button-slide">
                    @foreach($data_link_app as $link_app)
                    <div class="item">
                        <a href="{{ $link_app->link_url }}" target="_blank" data-bs-original-title="{{ $link_app->nama_app }}" data-bs-placement="top" data-bs-toggle="tooltip">
                            <img class="img-responsive" src="{{ asset($link_app->logo_app) }}" width="30px">
                        </a>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
