<div class="row">
    <div class="col-lg-12" id="slider">
        <div id="welcomeCarousel" class="carousel slide dark-side-arrows" data-interval="false">
            <div class="carousel-inner">
                @foreach($welcomeVideos->getAllPublic() as $video)
                    <div class="item carousel-item{{ $loop->first ? ' active' : '' }}" data-slide-number="{{ $loop->index }}">
                        <div class="video"
                            data-hash="{{ $video->hash }}" data-source="{{ $video->source }}"
                            data-embed="{{ $video->embed_uri . '?rel=0&wmode=transparent&showinfo=0' }}">
                            <div style="position:relative; padding-bottom:56.25%; overflow:hidden;">
                                <iframe src="{{ $video->embed_uri . '?rel=0&wmode=transparent&showinfo=0' }}"
                                    width="100%"
                                    height="100%"
                                    frameborder="0"
                                    scrolling="auto"
                                    allowfullscreen
                                    style="position:absolute;"></iframe>
                            </div>
                            <div class="d-md-none dark-title-bg lh-2 text-center ellipsis px-15"><strong>{{ $video->description }}</strong></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev nav-multiple-targets" data-target="#welcomeCarousel, #welcomeCarouselTitle" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next nav-multiple-targets" data-target="#welcomeCarousel, #welcomeCarouselTitle" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
