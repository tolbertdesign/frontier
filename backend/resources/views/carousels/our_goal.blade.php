<div
    id="ourGoalCarousel"
    class="carousel slide"
    data-ride="carousel">

    @if($program->microsite->fundsRaisedImageUrls()->count() > 1)
        <ol class="carousel-indicators dots">
            @foreach($program->microsite->fundsRaisedImageUrls() as $image)
                <li data-target="#ourGoalCarousel" data-slide-to="{{ $loop->index }}"{{ $loop->first ? ' class="active"' : '' }}></li>
            @endforeach
        </ol>
    @endif

    <div class="carousel-inner">
        @foreach($program->microsite->fundsRaisedImageUrls() as $image)
            <div class="carousel-item{{ $loop->first ? ' active' : '' }}">
                <div class="image">
                    <div class="position-relative">
                        <img src="{{ $image }}" width="100%" height="100%" frameborder="0" scrolling="auto">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
