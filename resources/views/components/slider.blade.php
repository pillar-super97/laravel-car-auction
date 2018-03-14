<div class="allcontain">
    <div id="carousel-up" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner " role="listbox">
            @isset($slider)
                @foreach($slider as $photo)
                    <div class="item {{$loop->index == 0 ? "active" : ""}}">
                        <img src="{{asset('/')}}{{$photo->path}}" alt="{{$photo->name}}">
                        <div class="carousel-caption">
                        <h2>{{$photo->name}}</h2>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
        <nav class="navbar navbar-default midle-nav">

        </nav>
    </div>
</div>