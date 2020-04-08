<div id="welcomeCarouselTitle" class="carousel slide" data-interval="false">
    <div class="carousel-inner">
        @foreach($welcomeVideos->getAllPublic() as $video)
            <div class="item carousel-item{{ $loop->first ? ' active' : '' }}" data-slide-number="{{ $loop->index }}">
                <h3>{{ $video->description }}</h3>
            </div>
        @endforeach
    </div>
</div>
