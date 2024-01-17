<div class="row col-slide" data-scroll-index="0">
    <div id="owl-slider" class="owl-carousel owl-theme">
        @foreach($data_banner as $banner)
        <div class="item"><img src="{{ asset($banner->file_banner) }}" alt="Slide-{{ $banner->id }}"></div>
        @endforeach
    </div>
</div>