<div id="carousel-{{$id}}" class="carousel slide"
     data-ride="carousel" data-interval="false"
     data-keyboard="false">
    <ol class="carousel-indicators">
        {{$indicators}}
    </ol>
    <div class="carousel-inner">
        {{$slot}}
    </div>
    <a class="carousel-control-prev"
       href="#carousel-{{$id}}" role="button"
       data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next"
       href="#carousel-{{$id}}" role="button"
       data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
