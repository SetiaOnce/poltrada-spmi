<div class="row scroll-row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="section-title-heading text-center">
                    <h3 class="wow fadeInDown" data-wow-delay=".3s">LINK SURVEY EXTERNAL</h3>
                </div>
            </div>
            <div class="panel-body wow fadeIn text-center" data-wow-delay=".3s">

                <div class="row">
                    <div class="col-md-12 ">
                        <div class="text-center">
                        <!-- <div id="link_survey" class="owl-carousel owl-theme button-slide">
                            @foreach($data_link_survey as $link_survey)
                            <div class="item">
                                <div class="single-blog-post">
                                    <div class="col-md-12 col-sm-12 box-content text-center">
                                        <img src="{{ asset($link_survey->logo) }}" alt="logo_ptdi_sttd" class="img-circle img-responsive" width="72" height="50">
                                    </div>
                                    <div class="">
                                        <h3 class="">{{ $link_survey->nama_link_survey }}</h3>
                                    </div>
                                    <div class="white-box">
                                        <div class=" text-center">
                                            <a href="{{ $link_survey->link_url }}" class="btn btn-info btn-sm" target="_blank">
                                            buka link
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div> -->
                            @foreach($data_link_survey as $link_survey)
                            <div class="col-md-2 col-sm-2 wow fadeIn" data-wow-delay=".3s">
                                <div class="white-box box-border">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 box-content text-center">
                                            <img src="{{ asset($link_survey->logo) }}" alt="logo_ptdi_sttd" class="img-circle img-responsive" width="72" height="50">
                                        </div>
                                        <div class="col-md-12 col-sm-12 text-center">
                                            <h5 class="box-title m-b-6 p-t-3">{{ strtoupper($link_survey->nama_link_survey) }}</h5>
                                            <a href="{{ $link_survey->link_url }}" class="btn btn-info btn-sm" target="_blank">
                                            buka link
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @if(empty($link_survey))
                                <div class="card">
                                    <div class="alert alert-warning" role="alert">
                                        <p>Saat ini link survey External masih kosong...</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>